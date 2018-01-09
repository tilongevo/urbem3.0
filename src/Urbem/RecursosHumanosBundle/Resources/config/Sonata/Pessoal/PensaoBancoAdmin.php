<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PensaoBancoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_pensao_banco';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/pensao-banco';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codPensao')
            ->add('codBanco')
            ->add('codAgencia')
            ->add('contaCorrente')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codPensao')
            ->add('codBanco')
            ->add('codAgencia')
            ->add('contaCorrente')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $admin = $this;

        $formMapper
            ->add(
                'codBanco',
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\Banco',
                    'choice_label' => 'nomBanco',
                    'label' => 'label.pensao.banco',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'data-sonata-select2' => 'false',
                    ),
                    'required' => true
                ]
            )
            ->add(
                'codAgencia',
                'choice',
                [
                    'label' => 'label.pensao.agencia',
                    'attr' => array(
                        'data-sonata-select2' => 'false',
                    ),
                    'required' => true
                ]
            )
            ->add('contaCorrente')
        ;

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $form->add(
                    'codAgencia',
                    'entity',
                    [
                        'class' => 'CoreBundle:Monetario\Agencia',
                        'choice_label' => function ($value, $key, $index) {
                            return $value->getNumAgencia() . " - " . $value->getNomAgencia();
                        },
                        'choice_value' => 'codAgencia',
                    ]
                );
            }
        );

        if ($this->getSubject()) {
            if ($this->id($this->getSubject())) {
                $entityManager = $this->modelManager->getEntityManager($this->getClass());
                $codBanco = $this->getSubject()->getCodBanco()->getCodBanco();
                $agenciasList = $entityManager->getRepository('CoreBundle:Monetario\Agencia')
                ->findAll();

                $agencias = array();
                foreach ($agenciasList as $agenciaKey => $agencia) {
                    $agencias[$agencia->getNumAgencia() . " - " . $agencia->getNomAgencia()] = $agencia->getCodAgencia();
                }

                $formMapper
                ->add(
                    'codAgencia',
                    'choice',
                    [
                        'label' => 'label.pensao.agencia',
                        'attr' => array(
                            'data-sonata-select2' => 'false',
                        ),
                        'required' => true,
                        'choices' => $agencias,
                        'choice_attr' => function ($agencia, $key, $index) {
                            if ($index == $this->getSubject()->getCodAgencia()) {
                                return ['selected' => 'selected'];
                            } else {
                                return ['selected' => false];
                            }
                        },
                    ]
                );
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codPensaoBanco')
            ->add('codPensao')
            ->add('codAgencia')
            ->add('codBanco')
            ->add('contaCorrente')
        ;
    }
}
