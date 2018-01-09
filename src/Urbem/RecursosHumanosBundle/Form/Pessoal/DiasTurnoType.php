<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Doctrine\DBAL\Types\TimeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Urbem\CoreBundle\Entity\Pessoal\GradeHorario;

class DiasTurnoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];

        $builder->add('codDia', EntityType::class, [
            'em' => $em,
            'class' => 'Urbem\CoreBundle\Entity\Pessoal\DiasTurno',
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('d')->orderBy('d.codDia', 'ASC');
            },
            'choice_label' => 'nomDia',
            'multiple' => true
        ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\FaixaTurno',
            'em' => null,
            'type' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recursos_humanos_pessoal_faixa_turno';
    }
}
