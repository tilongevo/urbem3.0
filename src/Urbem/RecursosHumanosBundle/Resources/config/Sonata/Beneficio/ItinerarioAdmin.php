<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItinerarioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_itinerario';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/itinerario';

    /**
    * @param FormMapper $formMapper
    */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $formOptions['ufOrigem'] = array(
            'class' => 'CoreBundle:SwUf',
            'choice_label' => 'nomUf',
            'label' => 'label.valetransporte.ufOrigem',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false,
        );
        
        $formOptions['municipioOrigem'] = array(
            'choices' => array(),
            'label' => 'label.valetransporte.municipioOrigem',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false
        );
        
        $formOptions['ufDestino'] = array(
            'class' => 'CoreBundle:SwUf',
            'choice_label' => 'nomUf',
            'label' => 'label.valetransporte.ufDestino',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => true,
            'mapped' => false,
        );
        
        $formOptions['municipioDestino'] = array(
            'choices' => array(),
            'label' => 'label.valetransporte.municipioDestino',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false
        );
        
        $formOptions['fkBeneficioLinha1'] = array(
            'class' => 'CoreBundle:Beneficio\Linha',
            'label' => 'label.valetransporte.codLinhaDestino',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        );
        
        $formOptions['fkBeneficioLinha'] = array(
            'class' => 'CoreBundle:Beneficio\Linha',
            'label' => 'label.valetransporte.codLinhaOrigem',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        );
        
        if ($this->id($this->getSubject())) {
            $formOptions['ufOrigem']['disabled'] = true;
            $formOptions['ufDestino']['disabled'] = true;
            $formOptions['municipioOrigem']['disabled'] = true;
            $formOptions['municipioDestino']['disabled'] = true;
            $formOptions['fkBeneficioLinha1']['disabled'] = true;
            $formOptions['fkBeneficioLinha']['disabled'] = true;
            $formOptions['ufOrigem']['data'] = $this->getSubject()->getFkSwMunicipio1()->getFkSwUf();
            $formOptions['ufDestino']['data'] = $this->getSubject()->getFkSwMunicipio()->getFkSwUf();
        }
        
        $formMapper
            ->add(
                'ufOrigem',
                'entity',
                $formOptions['ufOrigem']
            )
            ->add(
                'municipioOrigem',
                'choice',
                $formOptions['municipioOrigem']
            )
            ->add(
                'ufDestino',
                'entity',
                $formOptions['ufDestino']
            )
            ->add(
                'municipioDestino',
                'choice',
                $formOptions['municipioDestino']
            )
            ->add(
                'fkBeneficioLinha1',
                'entity',
                $formOptions['fkBeneficioLinha1']
            )
            ->add(
                'fkBeneficioLinha',
                'entity',
                $formOptions['fkBeneficioLinha']
            )
        ;
        
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);
        
                if (isset($data['ufOrigem']) && $data['ufOrigem'] != "") {
                    $formOptions['municipioOrigem']['auto_initialize'] = false;
                    $formOptions['municipioOrigem']['choices'] = (new \Urbem\CoreBundle\Model\SwMunicipioModel($entityManager))
                    ->getChoicesMunicipioByUf($data['ufOrigem'], true);
                        
                    $municipioOrigem = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'municipioOrigem',
                        'choice',
                        null,
                        $formOptions['municipioOrigem']
                    );
        
                    $form->add($municipioOrigem);
                }

                if (isset($data['ufDestino']) && $data['ufDestino'] != "") {
                    $formOptions['municipioDestino']['auto_initialize'] = false;
                    $formOptions['municipioDestino']['choices'] = (new \Urbem\CoreBundle\Model\SwMunicipioModel($entityManager))
                    ->getChoicesMunicipioByUf($data['ufOrigem'], true);
                        
                    $municipioDestino = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'municipioDestino',
                        'choice',
                        null,
                        $formOptions['municipioDestino']
                    );
        
                    $form->add($municipioDestino);
                }
            }
        );
        
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);
                
                if ($this->id($this->getSubject())) {
                    $formOptions['municipioOrigem']['auto_initialize'] = false;
                    $formOptions['municipioOrigem']['choices'] = (new \Urbem\CoreBundle\Model\SwMunicipioModel($entityManager))
                    ->getChoicesMunicipioByUf($subject->getFkSwMunicipio1()->getFkSwUf()->getCodUf(), true);
                    $formOptions['municipioOrigem']['data'] = $subject->getMunicipioOrigem();
                    
                    $municipioOrigem = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'municipioOrigem',
                        'choice',
                        null,
                        $formOptions['municipioOrigem']
                    );
                    
                    $form->add($municipioOrigem);
                    
                    $formOptions['municipioDestino']['auto_initialize'] = false;
                    $formOptions['municipioDestino']['choices'] = (new \Urbem\CoreBundle\Model\SwMunicipioModel($entityManager))
                    ->getChoicesMunicipioByUf($subject->getFkSwMunicipio()->getFkSwUf()->getCodUf(), true);
                    $formOptions['municipioDestino']['data'] = $subject->getMunicipioDestino();
                    
                    $municipioDestino = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'municipioDestino',
                        'choice',
                        null,
                        $formOptions['municipioDestino']
                    );
                
                    $form->add($municipioDestino);
                }
            }
        );
    }
}
