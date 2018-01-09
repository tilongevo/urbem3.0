<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\SwProcessoConfidencial;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ProcessoConfidencialAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_confidencial';
    protected $baseRoutePattern = 'administrativo/protocolo/processo-confidencial';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codProcesso')
            ->add('anoExercicio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codProcesso')
            ->add('anoExercicio')
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

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codProcesso'];
        }

        $entityManager = $this->modelManager->getEntityManager('CoreBundle:SwProcessoConfidencial');

        $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->find($id);

        # processo
        $fieldOptions['processo'] = array(
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'class' => 'CoreBundle:SwProcesso',
            'choice_label' => 'codigoExercicio',
            'disabled' => true,
            'data' => $processo,
            'label' => 'label.processo.codigo',
            'mapped' => false
        );

        $fieldOptions['codProcesso'] = array(
            'data' => $processo
        );

        # cgm
        $fieldOptions['numcgm'] = array(
            'class' => 'CoreBundle:SwCgm',
            'choice_label' => 'nomcgm',
            'label' => 'Cgm',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        );

        $formMapper
            ->add('processo', 'entity', $fieldOptions['processo'])
            ->add('codProcesso', 'hidden', $fieldOptions['codProcesso'])
            ->add('numcgm', 'entity', $fieldOptions['numcgm'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('codProcesso')
            ->add('anoExercicio')
        ;
    }


    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:SwProcessoConfidencial');
        $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->find($object->getCodProcesso());

        $object->setAnoExercicio($processo->getAnoExercicio());
    }

    public function redirect(SwProcessoConfidencial $processo)
    {
        $codProcesso = $processo->getCodProcesso();

        $this->forceRedirect("/administrativo/protocolo/processo/perfil?id=" . $codProcesso);
    }

    public function postPersist($object)
    {
        $this->redirect($object);
    }

    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    public function postRemove($object)
    {
        $this->redirect($object);
    }
}
