<?php

namespace Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata\Requisicao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class RequisicaoAdmin
 * @package Urbem\ComprasGovernamentaisBundle\Resources\config\Sonata\Requisicao
 */

class RequisicaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_compras_governamentais_requisicao';
    protected $baseRoutePattern = 'compras-governamentais/requisicoes';
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'codRequisicao',
    ];
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Requisitar'];

    /**
     * @param $code
     * @param $class
     * @param $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, Requisicao::class, $baseControllerName);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $request = $this->getRequest();
        $formArray = $request->get($request->get('uniqid'));

        if (empty($formArray['fkAlmoxarifadoRequisicaoItens'])) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(Requisicao::class) ->createQueryBuilder('r');

        $qb->join('r.fkAlmoxarifadoRequisicaoItens', 'ri');

        $catalogoItens = array_column($formArray['fkAlmoxarifadoRequisicaoItens'], 'item');
        $qb->andWhere(sprintf('ri.codItem IN (%s)', implode(',', $catalogoItens)));

        $qb->andWhere('r.cgmSolicitante = :cgmSolicitante');
        $qb->setParameter('cgmSolicitante', $this->getCurrentUser()->getNumcgm());

        $qb->andWhere(sprintf('r.status IN (\'%s\', \'%s\')', Requisicao::STATUS_PENDENTE_HOMOLOGACAO, Requisicao::STATUS_PENDENTE_AUTORIZACAO));

        $requisicoes = $qb->getQuery()->getResult();
        if (!$requisicoes) {
            return;
        }

        $requisicoesList = [];
        foreach ($requisicoes as $requisicao) {
            $requisicoesList[] = sprintf(
                '%d/%d',
                $requisicao->getCodRequisicao(),
                $requisicao->getExercicio()
            );
        }

        $error = $this->getTranslator()->transChoice('label.comprasGovernamentaisRequisicao.erroCatalogoItemRequisitado', 0, ['requisicoes' => implode(', ', $requisicoesList)]);
        $errorElement->addViolation($error)->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $request = $this->getRequest();
        $formData = $request->get($request->get('uniqid'));

        $object->setObservacao($formData['observacao']);
        $object->setCgmSolicitante($formData['solicitante']);

        if (empty($formData['fkAlmoxarifadoRequisicaoItens'])) {
            return;
        }

        foreach ((array) $formData['fkAlmoxarifadoRequisicaoItens'] as $requisicaoItemData) {
            $this->updateRequisicaoItem($object, $requisicaoItemData);
        }
    }

    public function update($object)
    {
        $result = $this->getModelManager()->update($object);

        return $object;
    }

    /**
     * @param mixed $object
     */
    public function homologarRequisicao($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new RequisicaoModel($em))->homologarRequisicao($object, $this->getCurrentUser());

        $this->update($object);
    }

    /**
     * @param mixed $object
     */
    public function anularRequisicao($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $request = $this->getRequest();

        (new RequisicaoModel($em))->anularRequisicao($object, $request->get('motivo'));

        $this->update($object);
    }

    /**
     * @param mixed $object
     */
    public function anularHomologacao($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new RequisicaoModel($em))->anularHomologacao($object);

        $this->update($object);
    }

    /**
     * @return array
     */
    public function getlegendBtnCatalogue()
    {
        parent::getlegendBtnCatalogue();

        $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Item'], 'incluirRequisiçãoItemButton');

        return $this->legendBtnCatalogue;
    }

    /**
     * return @array
     */
    public function getIncludeJs()
    {
        $includeJs = [];

        if ($this->isCurrentRoute('create') || $this->isCurrentRoute('edit')) {
            $includeJs[] = '/comprasgovernamentais/javascripts/requisicao-item.js';
        }

        if ($this->isCurrentRoute('create') || $this->isCurrentRoute('show')) {
            $includeJs[] = '/comprasgovernamentais/javascripts/requisicao.js';
        }

        return $includeJs;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->andWhere(sprintf('%s.cgmRequisitante = :numcgm', $qb->getRootAlias()));
        $qb->setParameter('numcgm', $this->getCurrentUser()->getNumcgm());

        return $qb;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('update', sprintf('update/%s', $this->getRouterIdParameter()));
        $collection->add('homologar', sprintf('homologar/%s', $this->getRouterIdParameter()));
        $collection->add('anular', sprintf('anular/%s', $this->getRouterIdParameter()));
        $collection->add('anular_homologacao', sprintf('anular-homologacao/%s', $this->getRouterIdParameter()));
        $collection->add('api_requisitante', 'api/requisitante');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add(
                'dtRequisicao',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->andWhere(sprintf('DATE(%s.dtRequisicao) = :dtRequisicao', $alias));
                        $qb->setParameter('dtRequisicao', $value['value']->format('Y-m-d'));

                        return true;
                    },
                    'label' => 'label.almoxarifado.requisicao.dtRequisicao',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'status',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (empty($value['value'])) {
                            return false;
                        }

                        $qb->andWhere(sprintf('%s.status = :status', $alias));
                        $qb->setParameter('status', $value['value']);

                        return true;
                    },
                    'label' => 'label.almoxarifado.requisicao.status',
                ],
                'choice',
                [
                    'choices' => array_flip(Requisicao::STATUS_LIST),
                    'placeholder' => 'Todos',
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add(
                'dtRequisicao',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\Requisicao\CRUD:list__dtRequisicao.html.twig',
                    'label' => 'label.almoxarifado.requisicao.dtRequisicao',
                ]
            )
            ->add(
                'status',
                null,
                [
                    'template' => 'ComprasGovernamentaisBundle:Sonata\Requisicao\CRUD:list__status.html.twig',
                    'label' => 'label.almoxarifado.requisicao.status',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'edit' => [
                            'template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'
                        ],
                        'copiar' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/Requisicao/CRUD:list__action_copiar.html.twig',
                        ],
                        'show' => [
                            'template' => 'ComprasGovernamentaisBundle:Sonata/Requisicao/CRUD:list__action_profile.html.twig',
                        ],
                        'delete' => [
                            'template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig',
                        ],
                    ],
                ]
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisicao = $this->getSubject();
        $request = $this->getRequest();

        $fieldOptions = [];
        $fieldOptions['exercicio'] = [
            'mapped' => false,
            'data' => $this->getExercicio(),
            'attr' => [
                'readonly' => 'readonly',
            ],
            'label' => 'label.almoxarifado.requisicao.exercicio'
        ];

        $fieldOptions['almoxarifado'] = [
            'class' => Almoxarifado::class ,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.almoxarifado.requisicao.almoxarifado',
        ];

        $fieldOptions['observacao'] = [
            'required' => false,
            'label' => 'label.almoxarifado.requisicao.observacao',
        ];

        $fieldOptions['solicitante'] = [
            'class' => SwCgm::class ,
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
            'data' => $this->getCurrentUser()->getFkSwCgm(),
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.comprasGovernamentaisRequisicao.solicitante',
        ];

        $fieldOptions['fkAlmoxarifadoRequisicaoItens'] = [
            'by_reference' => true,
            'label' => false,
        ];

        $fieldOptions['fkAlmoxarifadoRequisicaoItensOptions'] = [
            'edit' => 'inline',
            'inline' => 'table',
            'delete' => false,
            'extra_fields_message' => [
                'name_button' => 'incluirRequisiçãoItemButton'
            ],
            'admin_code' => 'compras_governamentais.admin.requisicao_item',
        ];

        $fieldOptions['dadosItem'] = [
            'mapped' => false,
        ];

        $fieldOptions['dadosMarca'] = [
            'mapped' => false,
        ];

        $fieldOptions['dadosCentroCusto'] = [
            'mapped' => false,
        ];

        $requisicaoBase = $this->getObject($request->get('requisicaoId'));
        if ($requisicaoBase && $this->isCurrentRoute('create')) {
            $requisicao->setObservacao($requisicaoBase->getObservacao());
            $requisicao->setFkAlmoxarifadoAlmoxarifado($requisicaoBase->getFkAlmoxarifadoAlmoxarifado());

            foreach ($requisicaoBase->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItemBase) {
                $requisicaoItem = clone$requisicaoItemBase;

                $requisicaoItem->setFkAlmoxarifadoRequisicao($requisicao);
                $requisicao->addFkAlmoxarifadoRequisicaoItens($requisicaoItem);
            }
        }

        if ($request->get('codAlmoxarifado') && $this->isCurrentRoute('create')) {
            $fieldOptions['almoxarifado']['data'] = $em->getRepository(Almoxarifado::class)->find($request->get('codAlmoxarifado'));
        }

        if ($request->get('codItem') && $this->isCurrentRoute('create')) {
            $requisicaoItem = new RequisicaoItem();
            $requisicao->addFkAlmoxarifadoRequisicaoItens($requisicaoItem);

            $catalogoItem = $em->getRepository(CatalogoItem::class)->find($request->get('codItem'));
            $fieldOptions['dadosItem']['data'] = json_encode(['id' => $catalogoItem->getCodItem(), 'label' => (string) $catalogoItem]);
        }

        if ($request->get('codMarca') && $this->isCurrentRoute('create')) {
            $marca = $em->getRepository(Marca::class)->find($request->get('codMarca'));
            $fieldOptions['dadosMarca']['data'] = json_encode(['id' => $marca->getCodMarca(), 'label' => (string) $marca]);
        }

        if ($request->get('codCentro') && $this->isCurrentRoute('create')) {
            $centroCusto = $em->getRepository(CentroCusto::class)->find($request->get('codCentro'));
            $fieldOptions['dadosCentroCusto']['data'] = json_encode(['id' => $centroCusto->getCodCentro(), 'label' => (string) $centroCusto]);
        }

        if ($this->isCurrentRoute('edit') && $requisicao->getStatus() == Requisicao::STATUS_PENDENTE_HOMOLOGACAO) {
            $fieldOptions['almoxarifado']['disabled'] = true;
            $fieldOptions['solicitante']['data'] = $requisicao->getFkSwCgm();
            $formMapper->getFormBuilder()->setAction('update');
        }

        if ($this->isCurrentRoute('edit') && $requisicao->getStatus() != Requisicao::STATUS_PENDENTE_HOMOLOGACAO) {
            $fieldOptions['almoxarifado']['disabled'] = true;
            $fieldOptions['observacao']['disabled'] = true;
            $fieldOptions['solicitante']['data'] = $requisicao->getFkSwCgm();
            $fieldOptions['solicitante']['disabled'] = true;
            $formMapper->getFormBuilder()->setAction('list');
        }

        $formMapper
            ->with('label.comprasGovernamentaisRequisicao.cabecalhoRequisicao')
                ->add('exercicio', 'text', $fieldOptions['exercicio'])
                ->add('fkAlmoxarifadoAlmoxarifado', 'entity', $fieldOptions['almoxarifado'])
                ->add('observacao', 'textarea', $fieldOptions['observacao'])
                ->add(
                    'solicitante',
                    'autocomplete',
                    $fieldOptions['solicitante'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add('dadosItem', 'hidden', $fieldOptions['dadosItem'])
                ->add('dadosMarca', 'hidden', $fieldOptions['dadosMarca'])
                ->add('dadosCentroCusto', 'hidden', $fieldOptions['dadosCentroCusto'])
            ->end()
            ->with('label.comprasGovernamentaisRequisicao.cabecalhoItem')
                ->add(
                    'fkAlmoxarifadoRequisicaoItens',
                    'sonata_type_collection',
                    $fieldOptions['fkAlmoxarifadoRequisicaoItens'],
                    $fieldOptions['fkAlmoxarifadoRequisicaoItensOptions']
                )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $requisicao = $this->getSubject();

        foreach ($requisicao->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());
            $centroCusto = $this->modelManager->find(CentroCusto::class, $requisicaoItem->getCodCentro());
            $marca = $this->modelManager->find(Marca::class, $requisicaoItem->getCodMarca());

            $requisicaoItem->fkAlmoxarifadoCatalogoItem = $catalogoItem;
            $requisicaoItem->fkAlmoxarifadoCentroCusto = $centroCusto;
            $requisicaoItem->fkAlmoxarifadoMarca = $marca;
        }

        $requisicao->homologar = false;
        $requisicao->anular = false;
        $requisicao->anularHomologacao = false;

        if ($this->checkAccess('homologar', $requisicao) &&
            $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->isEmpty()
            && $requisicao->getFkAlmoxarifadoRequisicaoAnulacoes()->isEmpty()) {
            $requisicao->homologar = true;
        }

        if ($this->checkAccess('anular', $requisicao) &&
            $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->isEmpty()
            && $requisicao->getFkAlmoxarifadoRequisicaoAnulacoes()->isEmpty()) {
            $requisicao->anular = true;
        }

        if ($this->checkAccess('anular_homologacao', $requisicao) && !$requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->isEmpty()
            && $requisicao->getStatus() == Requisicao::STATUS_PENDENTE_AUTORIZACAO) {
            $requisicao->anularHomologacao = true;
        }
    }

    /**
     * @param Requisicao $object
     * @return void
     */
    protected function populateObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $request = $this->getRequest();
        $form = $this->getForm();
        $formArray = $request->get($request->get('uniqid'));

        $ultimaRequisicao = $em->getRepository(Requisicao::class)->findOneBy([], ['codRequisicao' => 'DESC']);
        $codRequisicao = $ultimaRequisicao?$ultimaRequisicao->getCodRequisicao():0;
        $object->setCodRequisicao(++$codRequisicao);

        $object->setExercicio($form->get('exercicio')->getData());
        $object->setStatus(Requisicao::STATUS_PENDENTE_HOMOLOGACAO);
        $object->setFkSwCgm($form->get('solicitante')->getData());
        $object->setFkAdministracaoUsuario($this->getCurrentUser());

        foreach ($object->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            $object->removeFkAlmoxarifadoRequisicaoItens($requisicaoItem);
        }

        if (empty($formArray['fkAlmoxarifadoRequisicaoItens'])) {
            return;
        }

        foreach ((array) $formArray['fkAlmoxarifadoRequisicaoItens'] as $requisicaoItemData) {
            $requisicaoItem = new RequisicaoItem();
            $estoqueMaterial = $em->getRepository(EstoqueMaterial::class)->findOneBy([
                    'codAlmoxarifado' => $object->getCodAlmoxarifado(),
                    'codItem' => $requisicaoItemData['item'],
                    'codMarca' => $requisicaoItemData['marca'],
                    'codCentro' => $requisicaoItemData['centroCusto'],
                ]);

            if (!$estoqueMaterial) {
                $estoqueMaterial = new EstoqueMaterial();
                $estoqueMaterial->setCodAlmoxarifado($object->getCodAlmoxarifado());
                $estoqueMaterial->setCodItem($requisicaoItemData['item']);
                $estoqueMaterial->setCodMarca($requisicaoItemData['marca']);
                $estoqueMaterial->setCodCentro($requisicaoItemData['centroCusto']);

                $em->persist($estoqueMaterial);
                $em->flush();
            }

            $quantidade = strtr($requisicaoItemData['quantidade'], '.,', "\0.");
            $requisicaoItem->setQuantidade($quantidade);
            $requisicaoItem->setQuantidadePendente($quantidade);

            $requisicaoItem->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);

            $requisicaoItem->setFkAlmoxarifadoRequisicao($object);
            $object->addFkAlmoxarifadoRequisicaoItens($requisicaoItem);
        }
    }

    /**
     * @param Requisicao $object
     * @param array $requisicaoItemData
     * @return void
     */
    protected function updateRequisicaoItem($object, array $requisicaoItemData = [])
    {
        foreach ($object->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            if ($requisicaoItem->getCodItem() != (int) $requisicaoItemData['item']
                 && $requisicaoItem->getCodMarca != (int) $requisicaoItemData['marca']
                 && $requisicaoItem->getCodCentro != (int) $requisicaoItemData['centroCusto']) {
                continue;
            }

            if (!empty($requisicaoItemData['_delete'])) {
                $object->removeFkAlmoxarifadoRequisicaoItens($requisicaoItem);

                continue;
            }

            $quantidade = strtr($requisicaoItemData['quantidade'], '.,', "\0.");
            $requisicaoItem->setQuantidade($quantidade);
            $requisicaoItem->setQuantidadePendente($quantidade);
        }
    }
}
