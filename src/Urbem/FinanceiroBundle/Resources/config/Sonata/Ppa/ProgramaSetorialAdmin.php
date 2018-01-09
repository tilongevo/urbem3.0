<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProgramaSetorialAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_programa_setorial';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/programa-setorial';
    protected $includeJs = array(
        '/financeiro/javascripts/ppa/programa-setorial.js'
    );
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'codSetorial'
    ];
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
        $collection->add('get_macro_objetivo', 'get-macro-objetivo', array(), array(), array(), '', array(), array('POST'));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();
        if (!empty($request->query->get('filter')['codMacro']['value'])) {
            $codMacro = $request->query->get('filter')['codMacro']['value'];
        }

        $query = parent::createQuery($context);

        if (!empty($codMacro)) {
            $query->andWhere(
                $query->expr()->in($query->getRootAliases()[0] . '.codMacro', ':codMacro')
            );
            $query->setParameter('codMacro', $codMacro);
        }
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codPpa',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.macroObjetivos.codPpa',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                )
            )
            ->add(
                'codMacro',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.programaSetorial.codMacro'
                ),
                'choice',
                array(
                    'choices' => array(),
                )
            )
            ->add(
                'codSetorial',
                null,
                array(
                    'label' => 'label.programaSetorial.codSetorial'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.programaSetorial.descricao'
                )
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');
        $queryBuilder->innerJoin("CoreBundle:Ppa\MacroObjetivo", "mo", "WITH", "mo.codMacro = {$alias}.codMacro");
        $queryBuilder->innerJoin("CoreBundle:Ppa\Ppa", "ppa", "WITH", "ppa.codPpa = mo.codPpa");

        if ($filter['codPpa']['value'] != '') {
            $queryBuilder->andWhere("ppa.codPpa = :codPpa");
            $queryBuilder->setParameter("codPpa", $filter['codPpa']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codPpa',
                'customField',
                array(
                    'label' => 'label.macroObjetivos.codPpa',
                    'template' => 'FinanceiroBundle:Ppa\ProgramaSetorial:macroObjetivoPpa.html.twig',
                )
            )
            ->add(
                'fkPpaMacroObjetivo.descricao',
                null,
                array(
                    'label' => 'label.programaSetorial.codMacro'
                )
            )
            ->add(
                'codSetorial',
                null,
                array(
                    'label' => 'label.codigo'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.programaSetorial.descricao'
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
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['inCodMacro'] = array(
            'mapped' => false
        );

        $fieldOptions['codPpa'] = array(
            'class' => 'CoreBundle:Ppa\Ppa',
            'label' => 'label.macroObjetivos.codPpa',
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $fieldOptions['fkPpaMacroObjetivo'] = array(
            'choices' => array(),
            'label' => 'label.programaSetorial.codMacro',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $fieldOptions['descricao'] = array(
            'label' => 'label.programaSetorial.descricao',
            'attr' => [
                'maxlength' => '449'
            ]
        );

        if ($this->id($this->getSubject())) {
            $fieldOptions['codPpa']['disabled'] = 'disabled';

            $programaSetorial = (new \Urbem\CoreBundle\Model\Ppa\ProgramaSetorialModel($entityManager))
            ->getEditProgramaSetorial($this->getSubject()->getCodSetorial());
            $fieldOptions['codPpa']['data'] = $entityManager->getRepository('CoreBundle:Ppa\Ppa')
            ->findOneByCodPpa($programaSetorial->cod_ppa);

            $fieldOptions['inCodMacro']['data'] = $programaSetorial->cod_macro;
        }

        $formMapper
            ->with('label.programaSetorial.dadosProgramaSetorial')
                ->add(
                    'inCodMacro',
                    'hidden',
                    $fieldOptions['inCodMacro']
                )
                ->add(
                    'codPpa',
                    'entity',
                    $fieldOptions['codPpa']
                )
                ->add(
                    'fkPpaMacroObjetivo',
                    'choice',
                    $fieldOptions['fkPpaMacroObjetivo']
                )
                ->add(
                    'descricao',
                    'textarea',
                    $fieldOptions['descricao']
                )
            ->end()
        ;

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $subject = $admin->getSubject($event->getData());

                if ($form->has('fkPpaMacroObjetivo')) {
                    $form->remove('fkPpaMacroObjetivo');
                }

                $codMacro = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                    'fkPpaMacroObjetivo',
                    'entity',
                    null,
                    array(
                        'class' => 'CoreBundle:Ppa\MacroObjetivo',
                        'auto_initialize' => false,
                    )
                );

                $form->add($codMacro);
            }
        );
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
    
    public function getPpa($object)
    {
        return $object->getFkPpaMacroObjetivo();
    }
}
