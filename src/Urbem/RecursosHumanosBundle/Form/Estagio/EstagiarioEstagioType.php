<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EstagiarioEstagioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'cgmEstagiario',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwCgmPessoaFisica',
                    'choice_label' => function ($cgmEstagiario) {
                        $cgm = $cgmEstagiario->getNumcgm();
                        return $cgmEstagiario->getRg() . " - " . $cgm->getNomCgm();
                    },
                    'label' =>  'cgm',
                    'placeholder' => ''
                )
            )
            ->add(
                'numeroEstagio',
                Type\TextType::class,
                array(
                    'label' => 'label.estagio.numero_estagio'
                )
            )
            ->add('rg', 'text', array('mapped' => false))
            ->add('cpf', 'text', array('mapped' => false))
            ->add('endereco', 'text', array('mapped' => false))
            ->add('telefoneFixo', 'text', array('mapped' => false))
            ->add('telefoneCelular', 'text', array('mapped' => false))
            ->add(
                'vinculoEstagio',
                Type\ChoiceType::class,
                array(
                    'choices' => array(
                        'label.estagio.instituicao_ensino' => 'i',
                        'label.estagio.entidade_intermediadora' => 'e'
                    ),
                    'label' => 'label.estagio.vinculo_estagio',
                    'expanded' => true,
                    'data' => 'i',
                    'multiple' => false
                )
            )
            ->add(
                'cgmInstituicaoEnsino',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Estagio\InstituicaoEnsino',
                    'choice_label' => function ($cgmInstituicaoEnsino) {
                        $pessoaJuridica = $cgmInstituicaoEnsino->getNumcgm();
                        return $pessoaJuridica->getNomFantasia();
                    },
                    'label' => 'label.estagio.instituicao_ensino',
                    'placeholder' => 'label.estagio.cod_grau_choice'
                )
            )
            ->add(
                'codGrau',
                Type\ChoiceType::class,
                array(
                    'choices' => array(),
                    'label' => 'label.estagio.cod_grau',
                    'placeholder' => 'label.estagio.cod_grau_choice',
                    'mapped' => false
                )
            )
            ->add(
                'codCurso',
                Type\ChoiceType::class,
                array(
                    /*'class' => 'CoreBundle:Estagio\Curso',
                    'choice_label' => 'nom_curso',*/
                    'choices' => [],
                    'label' => 'label.estagio.curso',
                    'placeholder' => 'Selecione um Grau do Curso'
                )
            )
            ->add(
                'anoSemestre',
                Type\NumberType::class,
                array(
                    'attr' => array(
                        'min' => 2000
                    ),
                    'label' => 'label.estagio.ano_semestre'
                )
            )
            ->add(
                'dtInicio',
                Type\DateType::class,
                array(
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ),
                    'label' => 'label.estagio.dt_inicial'
                )
            )
            ->add(
                'dtFinal',
                Type\DateType::class,
                array(
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ),
                    'label' => 'label.estagio.dt_final'
                )
            )
            ->add(
                'dtRenovacao',
                Type\DateType::class,
                array(
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ),
                    'label' => 'label.estagio.dt_renovacao'
                )
            )
            ->add(
                'funcao',
                Type\TextType::class,
                array(
                    'label' => 'label.estagio.funcao'
                )
            )
            ->add(
                'objetivos',
                Type\TextareaType::class,
                array(
                    'label' => 'label.estagio.objetivos'
                )
            )
            ->add(
                'codGrade',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Pessoal\GradeHorario',
                    'choice_label' => 'descricao',
                    'label' => 'label.gradeHorario.modulo',
                    'placeholder' => ''
                )
            )
            ->add(
                'estagiarioEstagioBolsa',
                Type\CollectionType::class,
                array(
                    'entry_type' => EstagiarioEstagioBolsaType::class,
                    'allow_add' => true,
                    'prototype' => true,
                    'label' => false,
                    'by_reference' => false,
                    'prototype_name' => 0
                )
            )
            ->add(
                'estagiarioEstagioConta',
                EstagiarioEstagioContaType::class,
                array(
                    'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta',
                    'label' => false
                )
            )
            ->add(
                'classificacao',
                null,
                array(
                    'data' => '0.00.00',
                    'label' => 'Classificação',
                    'mapped' => false,
                    //'disabled' => true,
                    'attr' => [
                        'readonly' => true,
                    ]
                )
            )
            ->add(
                'codOrgao',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Organograma\Orgao',
                    'choice_label' => 'siglaOrgao',
                    'label' => 'Orgão',
                    'placeholder' => ''
                )
            )
            ->add(
                'codSecretaria',
                Type\ChoiceType::class,
                array(
                    /*'class' => 'CoreBundle:Organograma\Orgao',
                    'choice_label' => 'siglaOrgao',*/
                    'choices' => [],
                    'label' => 'Secretarias',
                    'placeholder' => 'Selecione um orgão',
                    'mapped' => false,
                )
            )
            ->add(
                'estagiarioEstagioLocal',
                EstagiarioEstagioLocalType::class,
                array(
                    'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal',
                    'label' => false
                )
            )
            ->add(
                'codEntitidadeIntermediadora',
                EntityType::class,
                array(
                    'class' => 'Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora',
                    'label' => 'label.estagio.entidade_intermediadora',
                    'choice_label' => function ($codEntitidadeIntermediadora) {
                        $swCgmPessoaJuridica = $codEntitidadeIntermediadora->getNumcgm();
                        return $swCgmPessoaJuridica->getNomFantasia();
                    },
                    'placeholder' => 'label.estagio.entidade_intermediadora_choice'
                )
            );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                $form->add(
                    'codGrau',
                    EntityType::class,
                    array(
                        'class' => 'CoreBundle:Estagio\Grau',
                        'choice_label' => 'descricao',
                        'label' => 'label.estagio.curso',
                        'mapped' => false
                    )
                );
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio',
            'cascade_validation' => true
        ));
    }
}
