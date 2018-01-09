<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Model\Orcamento\DestinacaoRecursoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Orcamento\DestinacaoRecurso;

class DestinacaoRecursoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_destinacao_recurso';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/destinacao-recurso';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codDestinacao', null, ['label' => 'label.destinacaoRecurso.codDestinacao'])
            ->add('descricao', null, ['label' => 'label.destinacaoRecurso.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codDestinacao', null, ['label' => 'label.destinacaoRecurso.codDestinacao', 'sortable' => true])
            ->add('descricao', null, ['label' => 'label.destinacaoRecurso.descricao', 'sortable' => true])
        ;

        $this->addActionsGrid($listMapper);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere($query->expr()->eq('o.exercicio', ':exercicio'));
        $query->setParameter('exercicio', $this->getExercicio());

        return $query;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();
        $fieldOptions['codDestinacao'] = array(
            'label' => 'label.destinacaoRecurso.codDestinacao',
            'mapped' => false
        );
        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $fieldOptions['codDestinacao']['attr'] = array('readonly' => true);
                $fieldOptions['codDestinacao']['data'] = $this->getSubject()->getCodDestinacao();
            } else {
                $fieldOptions['codDestinacao']['data'] = $this->newCodDestinacaoRecurso();
            }
        }

        $formMapper
            ->add('codDestinacao', null, $fieldOptions['codDestinacao'])
            ->add('descricao', null, array('label' => 'label.destinacaoRecurso.descricao'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codDestinacao', null, array('label' => 'label.destinacaoRecurso.codDestinacao'))
            ->add('descricao', null, array('label' => 'label.destinacaoRecurso.descricao'))
        ;
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $form = $this->getForm()->all();
        $model = $this->getModel();
        if (preg_replace('/.*(::)/', '', $this->getRequest()->attributes->get('_controller')) == $model::CREATE_ACTION) {
            $destinacao = $this->getDoctrine()->getRepository($this->getClass())->findOneBy(['codDestinacao' => $form['codDestinacao']->getViewData(), 'exercicio' => $this->getExercicio()]);
            if (!empty($destinacao)) {
                $newCodDestinacaoRecurso = $this->getDoctrine()->getRepository($this->getClass())->getNewDestinacaoRecurso($this->getExercicio());
                $error = $this->getContainer()->get(('translator'))->transChoice('label.ppa.codDestinacaoRecurso.duplicado', 0, ['newCodDestinacao' => $newCodDestinacaoRecurso], 'messages');
                $errorElement->with('codDestinacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("destinacao_existente", $error);
            }
        }
    }

    public function prePersist($object)
    {
        $form = $this->getForm()->all();
        $object->setExercicio($this->getExercicio());
        $object->setCodDestinacao($form['codDestinacao']->getViewData());
    }

    public function postPersist($object)
    {
        $model = $this->getModel();
        $model->salvarProximosAnos($object, $model::CREATE);
    }

    public function postUpdate($object)
    {
        $model = $this->getModel();
        $model->salvarProximosAnos($object, $model::EDIT);
    }

    /**
     * @return DestinacaoRecursoModel
     */
    protected function getModel()
    {
        return new DestinacaoRecursoModel($this->getDoctrine());
    }

    /**
     * Retorna um novo codDestinacao a partir do exercicio
     * @return mixed
     */
    protected function newCodDestinacaoRecurso()
    {
        return $this->getDoctrine()->getRepository(DestinacaoRecurso::class)->getNewDestinacaoRecurso($this->getExercicio());
    }
}
