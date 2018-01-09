<?php

namespace Urbem\RecursosHumanosBundle\Form\Calendario;

use Doctrine\ORM\EntityRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Doctrine\ORM\EntityManager;

class CalendarioCadastroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'descricao',
                Type\TextType::class,
                [
                    'label' => 'Descrição *',
                    'required' => true
                ]
            )
            ->add(
                'codFeriado',
                EntityType::class,
                array(
                    'label' => 'Feriados *',
                    'class' => 'CoreBundle:Calendario\Feriado',
                    'choice_label' => 'dataDescricao',
                    'expanded' => false,
                    'required' => true,
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->where('f.tipoferiado = :tipoferiado')
                            ->setParameter('tipoferiado', 'V');
                    }
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro'
        ));
    }
}
