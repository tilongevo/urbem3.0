<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use DateTime;
use Exception;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela;
use Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmitirCarneAdmin extends AbstractSonataAdmin
{
    public $filtro = [];

    protected $baseRouteName = 'urbem_tributario_divida_ativa_emitir_carne';
    protected $baseRoutePattern = 'tributario/divida-ativa/emissao-documentos/emitir-carne';
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/emitir-carne/emitir-carne.js'];

    private $numeracaoCarne = 0;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('filtro', 'filtro');

        $routes->clearExcept(['create', 'filtro']);
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'filtro' => $this->getRequest()->get('filtro'),
        ];
    }

    /**
    * @return void
    */
    public function getLegendButtonSave()
    {
        if ($this->getRequest()->get('filtro')) {
            return ['icon' => 'search', 'text' => 'Pesquisar'];
        }

        return ['icon' => 'save', 'text' => 'Emitir Carnê'];
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        if ($this->getRequest()->get('filtro')) {
            $this->createFiltro($formMapper);

            return;
        }

        $this->createCarne($formMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    public function createFiltro(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['numeracao'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirCarne.numeracao'
        ];

        $fieldOptions['cgm'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirCarne.cgm',
        ];

        $fieldOptions['localizacao'] = [
            'class' => Localizacao::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters js-localizacao '
            ],
            'label' => 'label.dividaAtivaEmitirCarne.localizacao',
        ];

        $fieldOptions['inscricaoMunicipal'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                if ($request->get('codLocalizacao')) {
                    $qb->join('o.fkImobiliarioLoteLocalizacao', 'll');

                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Lote $lote) {
                return (int) $lote->getFkImobiliarioImovelLotes()->last()->getInscricaoMunicipal();
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
                'codLocalizacao' => 'varJsCodLocalizacao',
            ],
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaEmitirCarne.lote',
        ];

        $fieldOptions['cadastroEconomico'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'cea');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
                $qb->join(Swcgm::class, 'cgm', 'WITH', 'COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm) = cgm.numcgm');

                $qb->andWhere('(o.inscricaoEconomica = :inscricaoEconomica OR cgm.numcgm = :numcgm OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('inscricaoEconomica', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirCarne.cadastroEconomico',
        ];

        $fieldOptions['inscricaoAno'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirCarne.inscricaoAno'
        ];

        $fieldOptions['cobrancaAno'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirCarne.cobrancaAno'
        ];

        $formMapper
            ->with('label.dividaAtivaEmitirCarne.cabecalhoFiltro')
                ->add('numeracao', 'text', $fieldOptions['numeracao'])
                ->add(
                    'cgm',
                    'autocomplete',
                    $fieldOptions['cgm'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add('localizacao', 'entity', $fieldOptions['localizacao'])
                ->add(
                    'inscricaoMunicipal',
                    'autocomplete',
                    $fieldOptions['inscricaoMunicipal'],
                    [
                        'admin_code' => 'tributario.admin.lote',
                    ]
                )
                ->add(
                    'cadastroEconomico',
                    'autocomplete',
                    $fieldOptions['cadastroEconomico'],
                    [
                        'admin_code' => 'tributario.admin.economico_cadastro_economico_empresa_fato',
                    ]
                )
                ->add('inscricaoAno', 'text', $fieldOptions['inscricaoAno'])
                ->add('cobrancaAno', 'text', $fieldOptions['cobrancaAno'])
            ->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    public function createCarne(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['observacao'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirCarne.observacao'
        ];

        $fieldOptions['modeloCarne'] = [
            'class' => ModeloCarne::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkArrecadacaoAcaoModeloCarnes', 'acao_modelo_carne');

                $qb->where('acao_modelo_carne.codAcao = :codAcao');
                $qb->setParameter('codAcao', 1755);

                return $qb;
            },
            'choice_label' => 'nomModelo',
            'required' => false,
            'label' => 'label.dividaAtivaEmitirCarne.modelo'
        ];

        $fieldOptions['listaParcelasAVencer'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/EmitirCarne/lista_parcelas.html.twig',
            'data' => [
                'tipo' => 'parcelasAVencer',
                'parcelas' => $em->getRepository(Carne::class)->getParcelasAVencer($this->filtro),
            ],
        ];

        $fieldOptions['listaParcelasVencidas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/EmitirCarne/lista_parcelas.html.twig',
            'data' => [
                'tipo' => 'parcelasVencidas',
                'parcelas' => $em->getRepository(Carne::class)->getParcelasVencidas($this->filtro),
            ],
        ];

        $formMapper
            ->tab('label.dividaAtivaEmitirCarne.tabParcelasAVencer')
                ->with('label.dividaAtivaEmitirCarne.cabecalhoParcelasAVencer')
                    ->add('listaParcelasAVencer', 'customField', $fieldOptions['listaParcelasAVencer'])
                    ->add('observacaoParcelasAVencer', 'textarea', $fieldOptions['observacao'])
                    ->add('modeloCarneParcelasAVencer', 'entity', $fieldOptions['modeloCarne'])
                ->end()
            ->end()
            ->tab('label.dividaAtivaEmitirCarne.tabParcelasVencidas')
                ->with('label.dividaAtivaEmitirCarne.cabecalhoParcelasVencidas')
                    ->add('listaParcelasVencidas', 'customField', $fieldOptions['listaParcelasVencidas'])
                    ->add('observacaoParcelasVencidas', 'textarea', $fieldOptions['observacao'])
                    ->add('modeloCarneParcelasVencidas', 'entity', $fieldOptions['modeloCarne'])
                ->end()
            ->end();
    }

    public function reemitirParcelas()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $request = $this->getRequest();

        $form = $this->getForm();

        $em->getConnection()->beginTransaction();

        $numeracao = $em->getConnection()->query('SELECT numeracaodivida(\'-1\') AS numeracao')->fetch();
        $this->numeracaoCarne = $numeracao['numeracao'];

        foreach ((array) $request->get('parcelas') as $parcela) {
            if (empty($parcela['reemitir'])) {
                continue;
            }

            $this->populateObject($parcela);
        }

        $this->saveObject();

        $this->forceRedirect('/tributario/divida-ativa/emissao-documentos/emitir-carne/filtro');
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(array $parcela)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $object = $em->getRepository(Parcela::class)->findOneByCodParcela($parcela['codParcela']);
        if (!$object) {
            return;
        }

        $object->setValor($parcela['valor']);

        $observacao = $form->get(sprintf('observacao%s', ucfirst($parcela['tipo'])))->getData();
        $object->getFkArrecadacaoLancamento()->setObservacao($observacao);

        $parcelaReemissao = new ParcelaReemissao();
        $parcelaReemissao->setVencimento($object->getVencimento());
        $parcelaReemissao->setValor($object->getValor());
        $parcelaReemissao->setFkArrecadacaoParcela($object);
        $object->addFkArrecadacaoParcelaReemissoes($parcelaReemissao);

        $object->setVencimento((new DateTime())->createFromFormat('d/m/Y', $parcela['vencimento']));

        $carne = $object->getFkArrecadacaoCarnes()->last();

        $carneDevolucao = new CarneDevolucao();
        $carneDevolucao->setFkArrecadacaoCarne($carne);
        $carneDevolucao->setCodMotivo(10);
        $carneDevolucao->setDtDevolucao(new DateTime());
        $carne->addFkArrecadacaoCarneDevolucoes($carneDevolucao);

        $novoCarne = new Carne();
        $novoCarne->setNumeracao(++$this->numeracaoCarne);
        $novoCarne->setExercicio($carne->getExercicio());
        $novoCarne->setCodConvenio($carne->getCodConvenio());
        $novoCarne->setImpresso(true);
        $novoCarne->setFkArrecadacaoParcela($object);
        $object->addFkArrecadacaoCarnes($novoCarne);

        $em->persist($object);
    }

    /**
    * @return void
    */
    protected function saveObject()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('label.dividaAtivaEmitirCarne.sucesso')
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.dividaAtivaEmitirCarne.erro'));
        }
    }
}
