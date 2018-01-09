<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Orcamento\SubfuncaoModel;

class SubfuncaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_subfuncao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/configuracao-funcional-programatica/subfuncao';
    protected $model = SubfuncaoModel::class;
    protected $includeJs = array(
        '/financeiro/javascripts/validate/input-number-validate.js'
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
        $pager->setCountColumn(array('codSubfuncao'));

        $datagridMapper
            ->add('codSubfuncao', null, ['label' => 'label.codigo'])
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
            ->add('getCodigoSubfuncao', null, ['label' => 'label.codigo'])
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

        $fieldOptions['codSubfuncao'] = [
            'label' => 'label.codigo',
            'mapped' => false,
            'attr' => ['min' => 1, 'max' => 999,
                'class' => 'validateNumber '
            ],
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codSubfuncao']['disabled'] = true;
            $fieldOptions['codSubfuncao']['data'] = $this->getSubject()->getCodSubfuncao();
        }

        $formMapper
            ->with('label.orcamentoSubfuncao.dadosSubfuncao')
                ->add('codSubfuncao', null, $fieldOptions['codSubfuncao'])
                ->add('descricao', null, ['label' => 'label.descricao'])
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if (!$this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $codSubfuncao = $this->getForm()->get('codSubfuncao')->getData();

            $parameters = array(
                'exercicio' => $this->getExercicio(),
                'codSubfuncao' => $codSubfuncao
            );

            if ($em->getRepository('CoreBundle:Orcamento\Subfuncao')->findOneBy($parameters)) {
                $error = $this->getTranslator()->trans('label.orcamentoSubfuncao.codEmUso');
                $errorElement->with('codSubfuncao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }

            if (strlen($codSubfuncao) > 3) {
                $error = $this->getTranslator()->trans('label.orcamentoSubfuncao.erroCodTamanho');
                $errorElement->with('codSubfuncao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    public function prePersist($object)
    {
        $object->setExercicio($this->getExercicio());
        $object->setCodSubfuncao($this->getForm()->get('codSubfuncao')->getData());

        $em = $this->modelManager->getEntityManager($this->getClass());
        $subfuncaoModel = new SubfuncaoModel($em);

        if ($exception = $subfuncaoModel->salvarSubfuncaoPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $subfuncaoModel = new SubfuncaoModel($em);

        if ($exception = $subfuncaoModel->editarSubfuncaoPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $subfuncaoModel = new SubfuncaoModel($em);
        if ($subfuncaoModel->canRemove($object)) {
            if ($exception = $subfuncaoModel->removerSubfuncaoPorPeriodo($object)) {
                $container = $this->getConfigurationPool()->getContainer();
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
                $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
                $this->forceRedirect($this->generateUrl('list'));
            }
        }
    }

    public function toString($object)
    {
        return $object->getCodSubfuncao()
            ? $object
            : $this->getTranslator()->trans('label.orcamentoSubfuncao.modulo');
    }
}
