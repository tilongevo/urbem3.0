<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Orcamento\FuncaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FuncaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_funcao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/configuracao-funcional-programatica/funcao';
    protected $model = FuncaoModel::class;
    protected $includeJs = array(
        '/financeiro/javascripts/validate/input-number-validate.js'
    );
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'codFuncao',
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codFuncao'));

        $datagridMapper
            ->add('codFuncao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('getCodigoFuncao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['codFuncao'] = [
            'label' => 'label.codigo',
            'mapped' => false,
            'attr' => ['min' => 1, 'max' => 99,
                'class' => 'validateNumber '
            ],
        ];

        if ($this->id($this->getSubject())) {
            $funcao = $this->getSubject();

            $fieldOptions['codFuncao']['mapped'] = false;
            $fieldOptions['codFuncao']['disabled'] = true;
            $fieldOptions['codFuncao']['data'] = $funcao->getCodFuncao();
        }

        $formMapper
            ->with('label.orcamentoFuncao.dadosFuncao')
            ->add('codFuncao', null, $fieldOptions['codFuncao'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->end()
        ;
    }




    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();
        $object->setExercicio($exercicio);
        $object->setCodFuncao($this->getForm()->get('codFuncao')->getData());

        $funcaoModel = new FuncaoModel($em);
        if ($exception = $funcaoModel->salvarFuncaoPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $funcaoModel = new FuncaoModel($em);
        if ($exception = $funcaoModel->editarFuncaoPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function postRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $funcaoModel = new FuncaoModel($em);
        if ($exception = $funcaoModel->removerFuncaoPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function toString($object)
    {
        return $object->getCodFuncao()
            ? $object
            : $this->getTranslator()->trans('label.orcamentoFuncao.modulo');
    }
}
