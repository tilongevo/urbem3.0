<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\MarcaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class MarcaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class MarcaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_marca';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/marca';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('autocomplete', 'autocomplete');
    }

    /**
     * @param ErrorElement $errorElement
     * @param Marca $marca
     */
    public function validate(ErrorElement $errorElement, $marca)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Almoxarifado\Marca');
        $marcaModel = new MarcaModel($em);
        /** @var Marca $marcaDesricao */
        $marcaDesricao = $marcaModel->getOneByDescricao($marca->getDescricao());

        if ((!empty($marcaDesricao)) && $marca->getCodMarca() != $marcaDesricao->getCodMarca()) {
            $message = $this->trans('marca.errors.descricao', [], 'validators');
            $errorElement->with('descricao')->addViolation($message)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao', null, ['label' => 'label.descricao']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $this->setBreadCrumb();

        $listMapper
            ->add('codMarca', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao']);

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
            ->add('descricao', null, ['label' => 'label.descricao']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codMarca', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao']);
    }
}
