<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AposentadoriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'codContrato',
                EntityType::class,
                [
                    'class' => 'CoreBundle:Pessoal\Contrato',
                    'choice_label' => 'registro',
                    'label' => 'label.matricula',
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'dtRequirimento',
                Type\DateType::class,
                [
                    "label" => "label.aposentadoria.dtRequerimento",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'numProcessoTce',
                Type\TextType::class,
                [
                    'label' => 'label.aposentadoria.numProcessoTce'
                ]
            )
            ->add(
                'dtConcessao',
                Type\DateType::class,
                [
                    "label" => "label.aposentadoria.dtConcessao",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'codClassificacao',
                EntityType::class,
                [
                    'choice_label' => 'descricao',
                    'class' => 'CoreBundle:Pessoal\Classificacao',
                    'label' => 'label.aposentadoria.classificacao',
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'codEnquadramento',
                Type\ChoiceType::class,
                [
                    'label' => 'label.aposentadoria.enquadramento',
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'percentual',
                Type\NumberType::class,
                [
                    'label' => 'label.aposentadoria.percentual'
                ]
            )
            ->add(
                'dtPublicacao',
                Type\DateType::class,
                [
                    "label" => "label.dtPublicacao",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy'
                ]
            )
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                $form->add(
                    'codEnquadramento',
                    EntityType::class,
                    [
                        'choice_label' => 'descricao',
                        'class' => 'CoreBundle:Pessoal\Enquadramento',
                        'label' => 'label.aposentadoria.enquadramento',
                    ]
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Aposentadoria'
        ));
    }
}
