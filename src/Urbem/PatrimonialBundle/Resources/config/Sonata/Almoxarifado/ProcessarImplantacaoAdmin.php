<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\LancamentoMaterialRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ProcessarImplantacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class ProcessarImplantacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_processar_implantacao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/processar-implantacao';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/processar-implantacao.js',
    ];


    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/create');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('_action', 'actions', [
            'actions' => [
                'edit' => ['template' => 'PatrimonialBundle:Sonata/ProcessarImportacao/CRUD:list__action_perfil.html.twig'],
            ]
        ]);
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/create');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        /** @var EntityManager $em */
        $em = $this->modelManager
            ->getEntityManager($this->getClass());

        $nextCodLancamento = $em
            ->getRepository('CoreBundle:Almoxarifado\LancamentoMaterial')
            ->getNextCodLancamento();

        $fieldOptions = [];
        $fieldOptions['exercicio'] = [
            'attr' => ['readonly' => true],
            'mapped' => false,
            'data' => $this->getExercicio()
        ];

        $fieldOptions['codAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Almoxarifado::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'label' => 'label.almoxarifado.modulo'
        ];

        $fieldOptions['codLancamento']['data'] = $nextCodLancamento;

        $fieldOptions['codItem'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\CatalogoItem::class,
            'label' => 'label.almoxarifado.item',
            'required' => true,
            'route' => ['name' => 'patrimonio_almoxarifado_processar_importacao_busca_catalogo_item'],
        ];

        $fieldOptions['codTipo'] = [
            'data' => [],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Almoxarifado/ProcessarImplantacao/CRUD:field_codTipo.html.twig'
        ];

        $fieldOptions['codUnidade'] = [
            'data' => [],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Almoxarifado/ProcessarImplantacao/CRUD:field_codMedida.html.twig'
        ];

        $fieldOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\Marca::class,
            'label' => 'label.patrimonial.almoxarifado.processarImplantacao.marca',
            'json_query_builder' =>  function (EntityRepository $repo, $term, Request $request) {
                $queryBuilder = $repo->createQueryBuilder("marca");
                return $queryBuilder
                    ->where("LOWER(marca.descricao) LIKE LOWER(:descricao)")
                    ->setParameter('descricao', "%{$term}%");
            },
            'json_from_admin_code' => $this->code
        ];

        $usuario = $this->getCurrentUser();
        $fieldOptions['codCentro'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado\CentroCusto::class,
            'json_query_builder' =>  function (EntityRepository $repo, $term, Request $request) use ($usuario) {
                $queryBuilder = $repo->createQueryBuilder("centroCusto");
                return $queryBuilder
                    ->join("centroCusto.fkAlmoxarifadoCentroCustoPermissoes", "permissoes")
                    ->where("permissoes.numcgm = :numcgm")
                    ->setParameter('numcgm', $usuario->getNumcgm());
            },
            'label' => 'label.patrimonial.compras.solicitacao.centrocusto',
            'json_from_admin_code' => $this->code
        ];

        $fieldOptions['quantidade'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.quantidade',
            'attr' => ['class' => 'quantity ']
        ];
        $fieldOptions['valorMercado'] = [
            'label' => 'label.patrimonial.almoxarifado.implantacao.valorMercado',
            'attr' => ['class' => 'money ']
        ];

        $formMapper
            ->with('label.patrimonial.almoxarifado.implantacao.dadosImplantacao')
            ->add('exercicio', 'text', $fieldOptions['exercicio'])
            ->add(
                'codAlmoxarifado',
                'entity',
                $fieldOptions['codAlmoxarifado']
            )
            ->end()
            ->with('Dados do Item')
            ->add('codLancamento', 'hidden', $fieldOptions['codLancamento'])
            ->add('codItem', 'autocomplete', $fieldOptions['codItem'])
            ->add('codUnidade', 'customField', $fieldOptions['codUnidade'])
            ->add('codTipo', 'customField', $fieldOptions['codTipo'])
            ->add(
                'codMarca',
                'autocomplete',
                $fieldOptions['codMarca']
            )
            ->add(
                'codCentro',
                'autocomplete',
                $fieldOptions['codCentro']
            )
            ->end()
            ->with('Saldos')
            ->add('quantidade', null, $fieldOptions['quantidade'])
            ->add('valorMercado', null, $fieldOptions['valorMercado'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var LancamentoMaterial $lancamentoMaterial */
        $lancamentoMaterial = $this->getSubject();

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var Almoxarifado\Perecivel $almoxarifadoPereciveis */
        $almoxarifadoPerecivel = $lancamentoMaterial->getFkAlmoxarifadoEstoqueMaterial()->getFkAlmoxarifadoPereciveis();
        $lancamentoMaterial->lancamentoMaterial = $lancamentoMaterial;
        $lancamentoMaterial->almoxarifadoPerecivel = $almoxarifadoPerecivel;
    }

    /**
     * @param ErrorElement $errorElement
     * @param LancamentoMaterial $lancamentoMaterial
     */
    public function validate(ErrorElement $errorElement, $lancamentoMaterial)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codAlmoxarifado = $this->getForm()->get("codAlmoxarifado")->getData()->getCodAlmoxarifado();
        $codMarca = $this->getForm()->get("codMarca")->getData()->getCodMarca();
        $codItem = $this->getForm()->get("codItem")->getData()->getCodItem();
        $codCentro = $this->getForm()->get("codCentro")->getData()->getCodCentro();
        /** @var CatalogoItemRepository $catalogoItemRepository */
        $catalogoItemRepository = $em->getRepository(Almoxarifado\CatalogoItem::class);
        $catalogoItens = $catalogoItemRepository->getCatalogoItemByInventarioItens(
            $codItem,
            $codMarca,
            $codAlmoxarifado,
            $codCentro,
            $this->getExercicio()
        );

        if (!empty($catalogoItens)) {
            $message = $this->trans('processar_implantacao.errors.item_em_processo', [], 'validators');
            $errorElement->with('codItem')->addViolation($message)->end();
        }

        /** @var LancamentoMaterialRepository $lancamentoMaterialRepository */
        $lancamentoMaterialRepository = $em->getRepository(Almoxarifado\LancamentoMaterial::class);
        $movimentacao = $lancamentoMaterialRepository->getMovimentacaoEstoque(
            $codItem,
            $codMarca,
            $codAlmoxarifado,
            $codCentro
        );

        if ($movimentacao) {
            $message = $this->trans('processar_implantacao.errors.possui_movimentacao', [], 'validators');
            $errorElement->with('codItem')->addViolation($message)->end();
        }
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     */
    public function prePersist($lancamentoMaterial)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $usuario = $this->getCurrentUser();

        $natureza = (new NaturezaModel($entityManager))
            ->getOneNaturezaByCodNaturezaAndTipoNatureza('6', 'E');

        $almoxarife = (new AlmoxarifeModel($entityManager))
            ->findByUsuario($usuario);

        $naturezaLancamento = (new NaturezaLancamentoModel($entityManager))
            ->create($natureza, $almoxarife, $exercicio);

        $catalogoItem = (new CatalogoItemModel($entityManager))
            ->getOneByCodItem($lancamentoMaterial->getCodItem());

        $almoxarifado = $this->getForm()->get('codAlmoxarifado');
        $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
            ->findOrCreateEstoqueMaterial(
                $lancamentoMaterial->getCodItem()->getCodItem(),
                $lancamentoMaterial->getCodMarca()->getCodMarca(),
                $lancamentoMaterial->getCodCentro()->getCodCentro(),
                $almoxarifado->getViewData()
            );
        $lancamentoMaterial->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
        $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
    }

    /**
     * @param LancamentoMaterial $object
     */
    public function postPersist($object)
    {
        if ($object->getFkAlmoxarifadoCatalogoItem()->isPerecivel()) {
            $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/' . implode('~', $this->getId($object)).'/show');
        }
    }

    /**
     * @param LancamentoMaterial $lm
     * @return array
     */
    public function getId(LancamentoMaterial $lm)
    {
        return [
            $lm->getCodLancamento(),
            $lm->getCodItem(),
            $lm->getCodMarca(),
            $lm->getCodAlmoxarifado(),
            $lm->getCodCentro(),
        ];
    }
}
