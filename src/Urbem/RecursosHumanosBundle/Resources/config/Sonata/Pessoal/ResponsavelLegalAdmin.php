<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ResponsavelLegalAdmin extends AbstractSonataAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codResponsavelLegal')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codResponsavelLegal')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formMapper
            ->add(
                'codResponsavelLegal',
                'entity',
                [
                    'class' => 'CoreBundle:SwCgm',
                    'choice_label' => 'nom_cgm',
                    'label' => 'label.pensao.codResponsavelLegal',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
        ;

        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $formMapper
                    ->add(
                        'codResponsavelLegal',
                        'entity',
                        [
                            'class' => 'CoreBundle:SwCgm',
                            'choice_label' => 'nom_cgm',
                            'label' => 'label.pensao.codResponsavelLegal',
                            'placeholder' => 'label.selecione',
                            'data' => $this->getSubject()->getNumCgm()->getNumCgm()
                        ]
                    )
                ;
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codResponsavelLegal')
        ;
    }
}
