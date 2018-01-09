<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EconomicoCategoriaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_categoria';
    protected $baseRoutePattern = 'tributario/cadastro-economico/categoria';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCategoria', null, array(
                'label' => 'label.codigo'
            ))
            ->add('nomCategoria', null, array(
                'label' => 'label.nome'
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codCategoria', null, array('label' => 'label.codigo'))
            ->add('nomCategoria', 'string', array('label' => 'label.nome'))
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

        $fieldOptions['codCategoria'] = array(
            'label' => 'label.codigo'
        );

        $formMapper->with('label.economicoCategoria.dados');

        if ($this->id($this->getSubject())) {
            $fieldOptions['codCategoria']['disabled'] = true;
            $formMapper->add('codCategoria', null, $fieldOptions['codCategoria']);
        }

        $formMapper->add('nomCategoria', null, array(
            'label' => 'label.nome',
        ));

        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.economicoCategoria.registroCategoria')
                ->add('codCategoria', 'string', array('label' => 'label.codigo'))
                ->add('nomCategoria', 'string', array('label' => 'label.nome'))
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNomCategoria())
            ? (string) $object
            : $this->getTranslator()->trans('label.economicoCategoria.modulo');
    }
}
