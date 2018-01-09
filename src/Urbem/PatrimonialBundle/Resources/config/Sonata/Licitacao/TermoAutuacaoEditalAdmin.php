<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Licitacao\Comissao;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\EditalModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;

class TermoAutuacaoEditalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_termo_autuacao_edital';
    protected $baseRoutePattern = 'patrimonial/licitacao/termo-autuacao-edital';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar'];
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    const COD_TIPO_COMISSAO = 4;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('geraTermoAutuacao', 'geraTermoAutuacao');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $query = parent::createQuery($context);
        $filtro = $this->getRequest()->query->get('filter');

        $editais = [];
        if ($filtro['exercicio']['value']) {
            // Filtro para campos mapped = false
            $codProcesso = '';
            if ($filtro['fkLicitacaoLicitacao__fkSwProcesso']['value']) {
                $codProcessoArray = explode("~", $filtro['fkLicitacaoLicitacao__fkSwProcesso']['value']);
                $codProcesso = reset($codProcessoArray);
            }

            $codMapa = '';
            if ($filtro['fkLicitacaoLicitacao__fkComprasMapa']['value']) {
                $codMapaArray = explode("~", $filtro['fkLicitacaoLicitacao__fkComprasMapa']['value']);
                $codMapa = end($codMapaArray);
            }

            $editais = (new EditalModel($em))->getEditalELicitacaoNaoAnulados([
                'exercicio' => $filtro['exercicio']['value'],
                'processo' => $codProcesso,
                'mapa' => $codMapa,
            ]);

            $ids = array();
        }

        if (count($editais) > 0) {
            foreach ($editais as $edital) {
                $ids[] = $edital->num_edital;
            }

            $query->andWhere('o.numEdital in (:ids)');
            $query->setParameters(['ids' => $ids]);
        } else {
            $query->andWhere('1 = 0');
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridOptions['fkOrcamentoEntidade'] = [
            'class' => Entidade::class,
            'choice_label' => function (Entidade $entidade) {
                return $entidade->getCodEntidade() . ' - ' .
                    $entidade->getFkSwCgm()->getNomCgm();
            },
            'attr' => ['class' => 'select2-parameters ',],
            'query_builder' => function (EntidadeRepository $em) use ($exercicio) {
                return $em->findAllByExercicioAsQueryBuilder($exercicio);
            },
            'placeholder' => 'label.selecione',
        ];

        $datagridOptions['fkSwProcesso'] = [
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'Selecione',
            'mapped' => false,
            'property' => 'codProcesso',
        ];

        $datagridOptions['fkComprasMapa'] = [
            'attr' => ['class' => 'select2-parameters ',],
            'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                $datagrid = $admin->getDatagrid();

                /** @var QueryBuilder|ProxyQueryInterface $qb */
                $qb = $datagrid->getQuery();

                $rootAlias = $qb->getRootAlias();

                $qb->where("{$rootAlias}.codMapa = :codMapa");
                $qb->orWhere("{$rootAlias}.exercicio = :exercicio");
                $qb->setParameter('codMapa', (int) $value);
                $qb->setParameter('exercicio', (string) $value);
            },
            'placeholder' => 'Selecione',
            'property' => 'codMapa',
            'mapped' => false,
            'to_string_callback' => function (Mapa $mapa, $property) {
                if (null === $mapa) {
                    return false;
                }
                return sprintf('mapa: %s - data: %s', $mapa->getCodMapaExercicio(), $mapa->getTimestamp()->format('d/m/Y'));
            },
        ];

        $datagridOptions['fkLicitacaoComissao'] = [
            'placeholder' => 'label.selecione',
            'choice_label' => function (Comissao $comissao, $property) {
                if (null === $comissao) {
                    return false;
                }
                return sprintf('%s | Vigência: %s 31/12/%s', $comissao->getFkLicitacaoTipoComissao()->getDescricao(), $comissao->getFkNormasNorma()->getDtPublicacao()->format('d/m/Y'), $comissao->getFkNormasNorma()->getExercicio());
            },
            'choice_value' => 'codComissao',
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codTipoComissao <> :codTipoComissao');
                $qb->setParameter('codTipoComissao', self::COD_TIPO_COMISSAO);
                return $qb;
            },
        ];

        $datagridMapper
            ->add('exercicio', null, ['label' => 'label.patrimonial.compras.solicitacao.exercicio'], null, ['attr' => ['required' => true]])
            ->add('fkLicitacaoLicitacao.fkOrcamentoEntidade', 'composite_filter', ['label' => 'label.patrimonial.licitacao.autorizacaoEmpenho.codEntidade'], null, $datagridOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('fkLicitacaoLicitacao.fkComprasModalidade', null, ['label' => 'label.comprasDireta.codModalidade', 'choice_label' => 'descricao'], null, ['placeholder' => 'label.selecione'])
            ->add('codLicitacao', null, ['label' => 'label.patrimonial.licitacao.edital.codLicitacao', 'placeholder' => 'label.selecione'])
            ->add('fkLicitacaoLicitacao.fkSwProcesso', 'doctrine_orm_model_autocomplete', ['label' => 'label.comprasDireta.codProcesso', 'mapped' => false], 'sonata_type_model_autocomplete', $datagridOptions['fkSwProcesso'], ['admin_code' => 'core.admin.filter.sw_processo'])
            ->add('numEdital', null, ['label' => 'label.patrimonial.licitacao.edital.numEdital'])
            ->add('fkLicitacaoLicitacao.fkComprasMapa', 'doctrine_orm_model_autocomplete', ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.mapaCompras', 'mapped' => false], 'sonata_type_model_autocomplete', $datagridOptions['fkComprasMapa'], ['admin_code' => 'core.admin.filter.compras_mapa'])
            ->add('fkLicitacaoLicitacao.fkComprasTipoLicitacao', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.tipoLicitacao', 'choice_label' => 'descricao'], null, ['placeholder' => 'label.selecione'])
            ->add('fkLicitacaoLicitacao.fkLicitacaoCriterioJulgamento', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.criterioJulgamento', 'choice_label' => 'descricao'], null, ['placeholder' => 'label.selecione'])
            ->add('fkLicitacaoLicitacao.fkComprasTipoObjeto', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.tipoObjeto', 'choice_label' => 'descricao'], null, ['placeholder' => 'label.selecione'])
            ->add('fkLicitacaoLicitacao.fkComprasObjeto', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.objeto', 'choice_label' => 'descricao'], null, ['placeholder' => 'label.selecione'])
            ->add('fkLicitacaoLicitacao.fkLicitacaoComissaoLicitacoes.fkLicitacaoComissao', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.comissaoLicitacao'], null, $datagridOptions['fkLicitacaoComissao']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkLicitacaoLicitacao', null, ['label' => 'Licitacao', 'admin_code' => 'patrimonial.admin.licitacao'])
            ->add('fkLicitacaoLicitacao.fkOrcamentoEntidade', null, ['label' => 'label.patrimonial.licitacao.edital.codEntidade', 'admin_code' => 'financeiro.admin.entidade'])
            ->add('numEdital', 'text', ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.edital',
                'associated_property' => function (Edital $edital) {
                    return sprintf('%s/%s', $edital->getNumEdital(), $edital->getExercicio());
                }
            ])
            ->add('fkLicitacaoLicitacao.fkSwProcesso', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.processo', 'admin_code' => 'administrativo.admin.processo'])
            ->add('fkLicitacaoLicitacao.fkComprasModalidade', null, ['label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.modalidade'])
            ->add('_action', 'actions', [
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig')
                )
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $assinaturaModel = new AssinaturaModel($em);
        $assinaturas = $assinaturaModel->carregaAssinaturas($this->getExercicio(), $this->getEntidade()->getCodEntidade(), Modulo::MODULO_PATRIMONIAL_LICITACAO);

        $edital = $this->getRequest()->query->get('numEditalExercicio');
        $entidade = $this->getRequest()->query->get('entidade');
        $licitacao = $this->getRequest()->query->get('codLicitacaoExercicio');
        $modalidade = $this->getRequest()->query->get('modalidade');
        $objeto = $this->getRequest()->query->get('objeto');

        $fieldOptions = [];

        $fieldOptions['edital'] = [
            'label' => 'label.patrimonial.licitacao.edital.numEdital',
            'mapped' => false,
            'required' => false,
            'data' => $edital,
            'attr' => ['class' => 'select2-parameters', 'readOnly' => 'readOnly'],
        ];

        $fieldOptions['entidade'] = [
            'label' => 'label.lote.codEntidade',
            'mapped' => false,
            'required' => false,
            'data' => $entidade,
            'attr' => ['class' => 'select2-parameters', 'readOnly' => 'readOnly'],
        ];

        $fieldOptions['licitacao'] = [
            'label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.numLicitacao',
            'mapped' => false,
            'required' => false,
            'data' => $licitacao,
            'attr' => ['class' => 'select2-parameters', 'readOnly' => 'readOnly'],
        ];

        $fieldOptions['modalidade'] = [
            'label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.modalidade',
            'mapped' => false,
            'required' => false,
            'data' => $modalidade,
            'attr' => ['class' => 'select2-parameters', 'readOnly' => 'readOnly'],
        ];

        $fieldOptions['objeto'] = [
            'label' => 'label.patrimonial.licitacao.termoAutuacaoEdital.objeto',
            'mapped' => false,
            'required' => false,
            'data' => $objeto,
            'attr' => ['class' => 'select2-parameters', 'readOnly' => 'readOnly'],
        ];

        $fieldOptions['assinaturas'] = [
            'label' => false,
            'mapped' => false,
            'multiple' => false,
            'required' => true,
            'placeholder' => 'label.selecione',
            'choice_value' => 'numcgm',
            'choice_label' => function ($assinaturas) {
                if (empty($assinaturas)) {
                    return;
                }
                return "{$assinaturas->nom_cgm} - {$assinaturas->cargo}";
            },
            'choices' => $assinaturas,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $formMapper
            ->with('label.patrimonial.licitacao.termoAutuacaoEdital.modulo')
            ->add('edital', 'text', $fieldOptions['edital'])
            ->add('entidade', 'text', $fieldOptions['entidade'])
            ->add('licitacao', 'text', $fieldOptions['licitacao'])
            ->add('modalidade', 'text', $fieldOptions['modalidade'])
            ->add('objeto', 'text', $fieldOptions['objeto'])
            ->end()
            ->with('label.patrimonial.licitacao.termoAutuacaoEdital.assinaturas')
            ->add('assinaturas', 'choice', $fieldOptions['assinaturas'])
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $request = $this->getRequest();
        $redirectUrl = $this->generateObjectUrl('geraTermoAutuacao', $object, ['uniqid' => $request->get('uniqid')]);
        (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $assinatura = $this->getForm()->get('assinaturas')->getData();

        $swCgm = new SwCgm();
        $swCgm->setNumcgm($assinatura->numcgm);
        $swCgm->setNomCgm($assinatura->nom_cgm);

        $isMembro = $em->getRepository(ComissaoMembros::class)->findOneBy(['fkSwCgm' => $swCgm]);

        // Verifica se o servidor participa da comissão de membros, caso não gera erro
        if (!$isMembro) {
            $errorElement->with('linha')->addViolation(
                $this->trans('label.patrimonial.licitacao.termoAutuacaoEdital.erro.comissaoMembro')
            )->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNumEdital()) ? (string) $object : $this->getTranslator()->trans('label.patrimonial.licitacao.termoAutuacaoEdital.modulo');
    }
}
