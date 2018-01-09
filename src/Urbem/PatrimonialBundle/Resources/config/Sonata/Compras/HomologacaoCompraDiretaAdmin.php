<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\HomologacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JustificativaRazaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaModel;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;

class HomologacaoCompraDiretaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_homologacao_compra_direta';
    protected $baseRoutePattern = 'patrimonial/compras/homologacao-compra-direta';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/compra-direta.js'
    ];

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $compraDiretaModel = new CompraDiretaModel($entityManager);

        $query = parent::createQuery($context);
        $query = $compraDiretaModel->getRecuperaNaoHomologados($query, $this->getExercicio());

        return $query;
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $compraDiretaModel = new CompraDiretaModel($entityManager);
        $homologacaoModel = new HomologacaoModel($entityManager);
        $justificativaModel = new JustificativaRazaoModel($entityManager);

        /**
         * Conform linha 149 do arquivo /licitacao/instancias/homologacao/PRManterHomologacao.php
         */
        $documento = $entityManager
            ->getRepository(ModeloDocumento::class)
            ->findOneBy([
                'codDocumento' => 0
            ]);

        $compraDireta = $entityManager
            ->getRepository(Compras\CompraDireta::class)
            ->findOneBy([
                'codCompraDireta' => $formData['hcodCompraDireta'],
                'codEntidade' => $formData['hcodEntidade'],
                'exercicioEntidade' => $formData['hexercicio'],
                'codModalidade' => $formData['hcodModalidade']
            ]);


        if (!is_object($compraDireta)) {
            $message = $this->trans('patrimonial.compraDireta.homologacao.naoEncontrado', [], 'flashes');
            $this->redirect($message, 'error');
        }

        $itens = $compraDiretaModel->montaRecuperaItensComStatus(
            $compraDireta->getExercicioEntidade(),
            $compraDireta->getFkOrcamentoEntidade()->getCodEntidade(),
            $compraDireta->getFkComprasModalidade()->getCodModalidade(),
            $compraDireta->getCodCompraDireta()
        );

        if (count($itens) <= 0) {
            $message = $this->trans('patrimonial.compraDireta.homologacao.error', [], 'flashes');
            $this->redirect($message, 'error');
        }

        /**
         * Salva Justificativa Razao
         */
        $justificativaModel->saveJustificativaRazao($compraDireta, $formData);

        foreach ($itens as $item) {
            $homologacaoModel->saveHomologacao($item, $formData, $documento);
        }

        $message = $this->trans('patrimonial.licitacao.homologacao.success', [], 'flashes');
        $this->redirect($message, 'success');
    }

    public function redirect($message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/compras/homologacao-compra-direta/list");
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codCompraDireta'));

        $datagridMapper
            ->add('fkOrcamentoEntidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codEntidade',
                'admin_code' => 'financeiro.admin.entidade',
            ], null, [
                'choice_label' => 'fkSwCgm.nomCgm',
                'class' => Entidade::class,
                'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                    $qb = $entityManager->createQueryBuilder('entidade');
                    $result = $qb->where('entidade.exercicio = :exercicio')
                        ->setParameter(':exercicio', $exercicio);

                    return $result;
                },
                'placeholder' => 'label.selecione'
            ])
            ->add('fkComprasModalidade', 'composite_filter', [
                'label' => 'label.comprasDireta.codModalidade'
            ], null, [
                'choice_label' => 'descricao',
                'class' => Compras\Modalidade::class,
                'placeholder' => 'label.selecione'
            ])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'doctrine_orm_callback', [
                'callback' => function ($queryBuilder, $alias, $field, $value) {
                    if (!$value['value']) {
                        return;
                    }

                    $date = $value['value']->format('Y-m-d');

                    $queryBuilder
                        ->andWhere("DATE({$alias}.timestamp) = :timestamp")
                        ->setParameter('timestamp', $date);

                    return true;
                },
                'label' => 'label.comprasDireta.timestamp'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
            ])
            ->add('fkComprasMapa', 'composite_filter', [
                'label' => 'label.comprasDireta.codMapa'
            ], null, [
                'class' => Compras\Mapa::class,
                'choice_label' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'placeholder' => 'label.selecione',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.comprasDireta.codEntidade'])
            ->add('fkComprasModalidade.descricao', null, ['label' => 'label.comprasDireta.codModalidade'])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'date', [
                'label' => 'label.comprasDireta.timestamp',
                'format' => 'd/m/Y',
            ])
            ->add('fkComprasMapa', null, [
                'associated_property' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'label' => 'label.comprasDireta.codMapa'
            ]);

        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'create' => ['template' => 'PatrimonialBundle:Sonata/Compras/HomologacaoCompraDireta/CRUD:list__action_homologacao_create.html.twig']
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codCompraDireta = $formData['hcodCompraDireta'];
            $codEntidade = $formData['hcodEntidade'];
            $exercicioEntidade = $formData['hexercicio'];
            $codModalidade = $formData['hcodModalidade'];
        } else {
            list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode("~", $id);
        }

        $compraDireta = $entityManager
            ->getRepository(Compras\CompraDireta::class)
            ->findOneBy([
                'codCompraDireta' => $codCompraDireta,
                'codEntidade' => $codEntidade,
                'exercicioEntidade' => $exercicioEntidade,
                'codModalidade' => $codModalidade
            ]);

        $fieldOptions = [];
        $fieldOptions['codEntidade'] = [
            'label' => 'label.comprasDireta.codEntidade',
            'data' => $compraDireta->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm(),
        ];

        $fieldOptions['dtEntregaProposta']['data'] = $compraDireta->getDtEntregaProposta()->format('d/m/Y');
        $fieldOptions['dtEntregaProposta']['label'] = 'label.comprasDireta.dtEntregaProposta';

        $fieldOptions['dtValidadeProposta']['data'] = $compraDireta->getDtValidadeProposta()->format('d/m/Y');
        $fieldOptions['dtValidadeProposta']['label'] = 'label.comprasDireta.dtValidadeProposta';

        $fieldOptions['timestamp']['data'] = $compraDireta->getTimestamp()->format('d/m/Y');
        $fieldOptions['timestamp']['label'] = 'label.comprasDireta.timestamp';

        $fieldOptions['codModalidade'] = [
            'label' => 'label.comprasDireta.codModalidade',
            'data' => $compraDireta->getFkComprasModalidade()->getDescricao(),
        ];

        $fieldOptions['codTipoObjeto']['data'] = $compraDireta->getFkComprasTipoObjeto()->getDescricao();
        $fieldOptions['codTipoObjeto']['label'] = 'label.comprasDireta.codTipoObjeto';

        $fieldOptions['codObjeto']['data'] = $compraDireta->getFkComprasTipoObjeto()->getDescricao();
        $fieldOptions['codObjeto']['label'] = 'label.comprasDireta.codObjeto';
        $fieldOptions['codObjeto']['attr']['data-value-from'] = '_codMapa';

        $fieldOptions['condicoesPagamento'] = [
            'label' => 'label.comprasDireta.condicoesPagamento',
            'data' => $compraDireta->getCondicoesPagamento(),
        ];
        $fieldOptions['prazoEntrega'] = [
            'label' => 'label.comprasDireta.prazoEntrega',
            'data' => $compraDireta->getPrazoEntrega(),
        ];
        $fieldOptions['codMapa'] = [
            'mapped' => false,
            'data' => $compraDireta->getFkComprasMapa()->getCodMapa()
        ];

        $fieldOptions['hcodEntidade']['data'] = $compraDireta->getFkOrcamentoEntidade()->getCodEntidade();
        $fieldOptions['hcodEntidade']['mapped'] = false;

        $fieldOptions['hcodModalidade']['data'] = $compraDireta->getFkComprasModalidade()->getCodModalidade();
        $fieldOptions['hcodModalidade']['mapped'] = false;

        $fieldOptions['hexercicio']['data'] = $compraDireta->getExercicioEntidade();
        $fieldOptions['hexercicio']['mapped'] = false;

        $fieldOptions['hcodCompraDireta']['data'] = $compraDireta->getCodCompraDireta();
        $fieldOptions['hcodCompraDireta']['mapped'] = false;
        $fieldOptions['justificativa']['mapped'] = false;
        $fieldOptions['justificativa']['required'] = false;
        $fieldOptions['razao']['mapped'] = false;
        $fieldOptions['razao']['required'] = false;
        $fieldOptions['fundamentacao_legal']['mapped'] = false;

        if (!is_null($id)) {
            /** @var  $compraDireta Compras\CompraDireta */
            $compraDireta = $entityManager->getRepository(Compras\CompraDireta::class)->findOneBy([
                'codCompraDireta' => $codCompraDireta,
                'codEntidade' => $codEntidade,
                'exercicioEntidade' => $exercicioEntidade,
                'codModalidade' => $codModalidade
            ]);
            // Desabilita campos que não podem ser alterados durante a edição
            $fieldOptions['codModalidade']['disabled'] = true;
            $fieldOptions['codEntidade']['disabled'] = true;
            $fieldOptions['timestamp']['disabled'] = true;
            $fieldOptions['codObjeto']['disabled'] = true;
            $fieldOptions['codTipoObjeto']['disabled'] = true;
            $fieldOptions['dtEntregaProposta']['disabled'] = true;
            $fieldOptions['dtValidadeProposta']['disabled'] = true;
            $fieldOptions['condicoesPagamento']['disabled'] = true;
            $fieldOptions['prazoEntrega']['disabled'] = true;

            $justificativa = $compraDireta->getFkComprasJustificativaRazao();
            $fieldOptions['justificativa']['data'] = is_object($justificativa) ? $justificativa->getJustificativa() : null;
            $fieldOptions['razao']['data'] = is_object($justificativa) ? $justificativa->getRazao() : null;
            $fieldOptions['fundamentacao_legal']['data'] = is_object($justificativa) ? $justificativa->getFundamentacaoLegal() : null;
        }

        $formMapper
            ->with('label.comprasDireta.compraDireta')
            ->add('codEntidade', 'text', $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('hcodEntidade', 'hidden', $fieldOptions['hcodEntidade'])
            ->add('hexercicio', 'hidden', $fieldOptions['hexercicio'])
            ->add('hcodCompraDireta', 'hidden', $fieldOptions['hcodCompraDireta'])
            ->add('hcodModalidade', 'hidden', $fieldOptions['hcodModalidade'])
            ->add('timestamp', 'text', $fieldOptions['timestamp'])
            ->end()
            ->with('label.comprasDireta.codObjeto')
            ->add('codMapa', 'hidden', $fieldOptions['codMapa'])
            ->add('codModalidade', 'text', $fieldOptions['codModalidade'])
            ->add('codTipoObjeto', 'text', $fieldOptions['codTipoObjeto'])
            ->add('codObjeto', 'text', $fieldOptions['codObjeto'])
            ->end()
            ->with('label.comprasDireta.proposta')
            ->add('dtEntregaProposta', 'text', $fieldOptions['dtEntregaProposta'])
            ->add('dtValidadeProposta', 'text', $fieldOptions['dtValidadeProposta'])
            ->add('condicoesPagamento', 'text', $fieldOptions['condicoesPagamento'])
            ->add('prazoEntrega', 'text', $fieldOptions['prazoEntrega'])
            ->add('justificativa', 'textarea', $fieldOptions['justificativa'])
            ->add('razao', 'textarea', $fieldOptions['razao'])
            ->add('fundamentacao_legal', 'textarea', $fieldOptions['fundamentacao_legal'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 comprasdireta-items'
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codCompraDireta')
            ->add('exercicioEntidade')
            ->add('exercicioMapa')
            ->add('dtEntregaProposta')
            ->add('dtValidadeProposta')
            ->add('condicoesPagamento')
            ->add('prazoEntrega')
            ->add('timestamp');
    }
}
