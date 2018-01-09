<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso;
use Urbem\CoreBundle\Model\Orcamento\DestinacaoRecursoModel;
use Urbem\CoreBundle\Model\Orcamento\DetalhamentoDestinacaoRecursoModel;
use Urbem\CoreBundle\Model\Orcamento\IdentificadorUsoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class DetalhamentoDestinacaoRecursoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_destinacao_detalhamento_recurso';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/destinacao-recursos/destinacao-detalhamento';
    protected $model = DestinacaoRecursoModel::class;

    const PARAMETRO = 'recurso_destinacao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $qb = parent::createQuery($context);
        $qb->where('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        return $qb;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codDetalhamento', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $identificadorUsoModel = new IdentificadorUsoModel($em);
        $identificadorUsoModel->verificarCRUD($this, Modulo::MODULO_ORCAMENTO, self::PARAMETRO);

        $this->setBreadCrumb();

        $listMapper
            ->add('getCodigoComposto', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $identificadorUsoModel = new IdentificadorUsoModel($em);
        $identificadorUsoModel->verificarCRUD($this, Modulo::MODULO_ORCAMENTO, self::PARAMETRO);

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codDetalhamento'] = [
            'label' => 'label.detalhamentoDestinacaoRecurso.codDetalhamento',
            'mapped' => false,
            'attr' => ['min' => "1", 'max' => "999999", 'maxlength' => "6"]
        ];

        if ($this->id($this->getSubject())) {
            $detalhamentoDestinacaoRecurso = $this->getSubject();

            $fieldOptions['codDetalhamento']['mapped'] = false;
            $fieldOptions['codDetalhamento']['disabled'] = true;
            $fieldOptions['codDetalhamento']['data'] = $detalhamentoDestinacaoRecurso->getCodDetalhamento();
        }

        $formMapper
            ->with('label.detalhamentoDestinacaoRecurso.dados')
            ->add('codDetalhamento', null, $fieldOptions['codDetalhamento'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if (!$this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $codDetalhamento = $this->getForm()->get('codDetalhamento')->getData();

            $detalhamentoDestinacaoRecurso = $em->getRepository('CoreBundle:Orcamento\DetalhamentoDestinacaoRecurso')
                ->findOneBy([
                    'codDetalhamento' => $codDetalhamento,
                    'exercicio' => $this->getExercicio()
                ]);

            if ($detalhamentoDestinacaoRecurso) {
                $error = $this->getTranslator()->trans(
                    'label.detalhamentoDestinacaoRecurso.codigoEmUso',
                    array(
                        '%codDetalhamento%' => str_pad($codDetalhamento, 6, '0', STR_PAD_LEFT)
                    )
                );
                $errorElement->with('codDetalhamento')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    public function prePersist($object)
    {
        $object->setExercicio($this->getExercicio());
        $object->setCodDetalhamento($this->getForm()->get('codDetalhamento')->getData());

        $em = $this->modelManager->getEntityManager($this->getClass());
        $detalhamentoDestinacaoRecursoModel = new DetalhamentoDestinacaoRecursoModel($em);
        if ($exception = $detalhamentoDestinacaoRecursoModel->salvarPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        (new DetalhamentoDestinacaoRecursoModel($em))->editarPorPeriodo($object);
        $detalhamentoDestinacaoRecursoModel = new DetalhamentoDestinacaoRecursoModel($em);
        if ($exception = $detalhamentoDestinacaoRecursoModel->editarPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $detalhamentoDestinacaoRecursoModel = new DetalhamentoDestinacaoRecursoModel($em);
        if ($exception = $detalhamentoDestinacaoRecursoModel->removerPorPeriodo($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $exception->getMessage());
            $this->forceRedirect($this->generateUrl('list'));
        }
    }
    
    public function toString($object)
    {
        return $object->getCodDetalhamento()
            ? $object
            : $this->getTranslator()->trans('label.detalhamentoDestinacaoRecurso.modulo');
    }
}
