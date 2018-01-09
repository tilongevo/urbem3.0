<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GrauAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_grau';

    protected $baseRoutePattern = 'recursos-humanos/estagio/grau';

    protected $model = null;
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
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

        $formMapper
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $filterDesc = strlen(trim($object->getDescricao()));

        if($filterDesc == 0){
            $error = "Campo descrição é obrigatório!";
            $errorElement->with('descricao')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
