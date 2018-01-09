<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model;

class MacroObjetivoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_macro_objetivo';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/macro-objetivo';
    protected $model = Model\Ppa\MacroObjetivoModel::class;
    protected $includeJs = ['/financeiro/javascripts/ppa/macro-objetivo.js'];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codPpa',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.macroObjetivos.codPpa'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'choice_label' => function ($ppa) {
                        if (!empty($ppa)) {
                            return $ppa;
                        }
                    },
                    'choice_value' => function ($ppa) {
                        if (!empty($ppa)) {
                            return $ppa->getCodPpa();
                        }
                    }
                )
            )
            ->add(
                'codMacro',
                null,
                array(
                    'label' => 'label.macroObjetivos.codMacro'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.macroObjetivos.descricao'
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkPpaPpa',
                'text',
                array(
                    'label' => 'label.macroObjetivos.codPpa'
                )
            )
            ->add(
                'codMacro',
                null,
                array(
                    'label' => 'label.macroObjetivos.codMacro'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.macroObjetivos.descricao'
                )
            )
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

        $formOptions = array();

        $formOptions['fkPpaPpa'] = array(
            'class' => 'CoreBundle:Ppa\Ppa',
            'label' => 'label.macroObjetivos.codPpa',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['descricao'] = array(
            'label' => 'label.macroObjetivos.descricao',
            'attr' => [
                'wrap' => 'soft',
                'maxlength' => '400'
            ]
        );

        if ($this->id($this->getSubject())) {
            $formMapper
                ->with('label.macroObjetivos.dadosMacroObjetivos')
                    ->add(
                        'codMacro',
                        null,
                        [
                            'label' => 'label.macroObjetivos.codMacro',
                            'attr' => ['disabled' => true]
                        ]
                    )
                ->end()
            ;
            $formOptions['fkPpaPpa']['disabled'] = true;
        }

        $formMapper
            ->with('label.macroObjetivos.dadosMacroObjetivos')
                ->add(
                    'fkPpaPpa',
                    'entity',
                    $formOptions['fkPpaPpa']
                )
                ->add(
                    'descricao',
                    'textarea',
                    $formOptions['descricao']
                )
            ->end()
        ;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }
}
