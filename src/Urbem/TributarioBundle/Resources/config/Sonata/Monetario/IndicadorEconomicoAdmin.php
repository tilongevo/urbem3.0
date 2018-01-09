<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class IndicadorEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_indicador_economico';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/indicador-economico';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('definir_valor', 'definir-valor/' . $this->getRouterIdParameter());
        $collection->add('salvar_valor', 'salvar-valor');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codIndicador', null, ['label' => 'label.monetarioIndicadorEconomico.codIndicador'])
            ->add('descricao', null, ['label' => 'label.monetarioIndicadorEconomico.descricao'])
            ->add('abreviatura', null, ['label' => 'label.monetarioIndicadorEconomico.abreviatura'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codIndicador', null, ['label' => 'label.monetarioIndicadorEconomico.codIndicador'])
            ->add('descricao', null, ['label' => 'label.monetarioIndicadorEconomico.descricao'])
            ->add('abreviatura', null, ['label' => 'label.monetarioIndicadorEconomico.abreviatura'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'definir_valor' => array('template' => 'TributarioBundle:Sonata/Monetario/IndicadorEconomico/CRUD:list__action_definir_valor.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('label.monetarioIndicadorEconomico.dados')
            ->add('descricao', null, ['label' => 'label.monetarioIndicadorEconomico.descricao'])
            ->add('abreviatura', null, ['label' => 'label.monetarioIndicadorEconomico.abreviatura'])
            ->add('precisao', null, ['label' => 'label.monetarioIndicadorEconomico.precisao', 'help' => 'casas decimais ']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.monetarioIndicadorEconomico.dados')
            ->add('codIndicador', null, ['label' => 'label.monetarioIndicadorEconomico.codIndicador'])
            ->add('descricao', null, ['label' => 'label.monetarioIndicadorEconomico.descricao'])
            ->add('abreviatura', null, ['label' => 'label.monetarioIndicadorEconomico.abreviatura'])
            ->add('precisao', null, ['label' => 'label.monetarioIndicadorEconomico.precisao']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $descricao = $em->getRepository(IndicadorEconomico::class)
            ->findOneBy(['descricao' => $object->getDescricao()]);

        if ($descricao && $descricao->getDescricao()) {
            $error = $this->getTranslator()->trans('label.monetarioIndicadorEconomico.erroDescricao');
            $errorElement->with('descricao')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodIndicador())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioIndicadorEconomico.modulo');
    }
}
