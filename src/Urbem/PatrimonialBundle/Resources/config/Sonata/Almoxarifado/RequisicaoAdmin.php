<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\SwCgm;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class RequisicaoAdmin
 */
class RequisicaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_requisicao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/requisicao';

    protected $datagridValues = [
        '_page'         => 1,
        '_sort_order'   => 'DESC',
        '_sort_by'      => 'exercicio'
    ];

    protected $model = RequisicaoModel::class;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'delete', 'show', 'list']);

        // Gera Relatorio
        $collection->add('gerar_relatorio', '{id}/gerar/relatorio');

        // Acoes relacionadas a homologacao de requisicao
        $collection->add('homologar', '{id}/homologar');
        $collection->add('anular_homologacao', '{id}/anular/homologacao');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(['codRequisicao']);

        $datagridMapper
            ->add('exercicio', null, ['label' =>'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add('dtRequisicao', null, [
                'label' => 'label.almoxarifado.requisicao.dtRequisicao'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio', null, ['label' => 'label.almoxarifado.requisicao.exercicio'])
            ->add('codRequisicao', null, ['label' => 'label.almoxarifado.requisicao.codRequisicao'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.requisicao.almoxarifado'])
            ->add('dtRequisicao', null, ['label' => 'label.almoxarifado.requisicao.dtRequisicao'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'PatrimonialBundle:Sonata/Requisicao/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Requisicao $requisicao */
        $requisicao = $this->getSubject();

        $requisicaoItens = $requisicao->getFkAlmoxarifadoRequisicaoItens();

        /** @var RequisicaoItem $requisicaoItem */
        foreach ($requisicaoItens as $requisicaoItem) {
            $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());
            $centroCusto = $this->modelManager->find(CentroCusto::class, $requisicaoItem->getCodCentro());
            $marca = $this->modelManager->find(Marca::class, $requisicaoItem->getCodMarca());

            $requisicaoItem->fkAlmoxarifadoCatalogoItem = $catalogoItem;
            $requisicaoItem->fkAlmoxarifadoCentroCusto = $centroCusto;
            $requisicaoItem->fkAlmoxarifadoMarca = $marca;
        }

        $requisicao->isPassivelHomologacao = false;
        $requisicao->isPassivelAnularRequisicao = false;
        $requisicao->isPossivelManipularItens = true;

        $requisicao->requisicoesHomologadasAnuladas = $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->filter(
            function (RequisicaoHomologada $requisicaoHomologada) {
                if (true == $requisicaoHomologada->getHomologada()) {
                    return $requisicaoHomologada;
                }
            }
        );

        if (true == (new RequisicaoModel($em))->isPassivelHomologacao($requisicao)
            && true == $requisicao->requisicoesHomologadasAnuladas->isEmpty()) {
            $requisicao->isPassivelHomologacao = true;
        }

        $requisicao->isPassivelAnulacaoHomologacao = false == $requisicao->requisicoesHomologadasAnuladas->isEmpty();

        if (true == $requisicao->getFkAlmoxarifadoRequisicaoAnulacoes()->isEmpty()
            && true == $requisicao->requisicoesHomologadasAnuladas->isEmpty()) {
            $requisicao->isPassivelAnularRequisicao = true;
        }

        if (false == $requisicao->getFkAlmoxarifadoRequisicaoAnulacoes()->isEmpty()
            || false == $requisicao->requisicoesHomologadasAnuladas->isEmpty()) {
            $requisicao->isPossivelManipularItens = false;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $usuario = $this->getCurrentUser();

        $this->setIncludeJs([
            '/patrimonial/javascripts/almoxarifado/requisicao.js',
        ]);

        $formMapperOptions = [];
        $formMapperOptions['exercicio'] = [
            'data' => $this->getExercicio(),
            'disabled' => true,
            'label' => 'label.almoxarifado.requisicao.exercicio'
        ];

        $formMapperOptions['fkAlmoxarifadoAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.requisicao.almoxarifado',
            'required' => true
        ];

        $formMapperOptions['fkAdministracaoUsuario'] = [
            'attr' => ['class' => 'select2-parameters '],
            'data' => $usuario,
            'disabled' => true,
            'label' => 'label.almoxarifado.requisicao.requisitante',
            'mapped' => false
        ];

        $formMapperOptions['fkSwCgm'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => SwCgm::class,
            'label' => 'label.almoxarifado.requisicao.solicitante',
            'required' => true,
            'route' => ['name' => 'urbem_administrativo_cgm_pessoa_fisica_autocomplete']
        ];

        $formMapperOptions['observacao'] = [
            'label' => 'label.almoxarifado.requisicao.observacao',
            'required' => false
        ];

        $formMapper
            ->add('exercicio', null, $formMapperOptions['exercicio'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, $formMapperOptions['fkAlmoxarifadoAlmoxarifado'])
            ->add('fkAdministracaoUsuario', null, $formMapperOptions['fkAdministracaoUsuario'], [
                'admin_code' => 'administrativo.admin.usuario'
            ])
            ->add('fkSwCgm', 'autocomplete', $formMapperOptions['fkSwCgm'])
            ->add('observacao', 'textarea', $formMapperOptions['observacao'])
        ;

        $admin = $this;
        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::POST_SET_DATA,
                function (FormEvent $event) use ($formMapper, $admin) {
                    /** @var Requisicao $requisicao */
                    $requisicao = $admin->getSubject();
                    $requisicao->setFkAdministracaoUsuario($admin->getCurrentUser());
                    $requisicao->setExercicio($admin->getExercicio());
                }
            );
    }

    /**
     * @param Requisicao $requisicao
     */
    public function prePersist($requisicao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codRequisicao = (new RequisicaoModel($em))
            ->buildCodRequisicao($requisicao->getExercicio(), $requisicao->getCodAlmoxarifado());

        $requisicao->setCodRequisicao($codRequisicao);
        $requisicao->setStatus(Requisicao::STATUS_ABERTO);
    }


    public function postPersist($object)
    {
        $this->forceRedirect(
            "/patrimonial/almoxarifado/requisicao/{$this->getObjectKey($object)}/show"
        );
    }

    public function postUpdate($object)
    {
        $this->forceRedirect(
            "/patrimonial/almoxarifado/requisicao/{$this->getObjectKey($object)}/show"
        );
    }
}
