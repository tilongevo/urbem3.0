<?php

namespace Urbem\AdministrativoBundle\Form\Administrativo\Administracao;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DuplicarFuncaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions['codBiblioteca'] = [
            'label' => 'label.funcao.codBiblioteca',
            'class' => 'CoreBundle:Administracao\Biblioteca',
            'choice_label' => 'nomBiblioteca',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
            'query_builder' => function ($em) {
                /** @var EntityManager $em */
                $qb = $em->createQueryBuilder('b');
                $qb->where('b.codModulo != 0');
                $qb->orderBy('b.codModulo', 'ASC');
                return $qb;
            },
        ];
        $builder
            ->add(
                'codBiblioteca',
                EntityType::class,
                $fieldOptions['codBiblioteca']
            )
            ->add(
                'nomFuncaoNova',
                TextType::class,
                [
                    'label' => 'label.funcao.nomFuncao',
                    'attr' => [
                        'required' => true
                    ],
                ]
            )
            ->add(
                'comentario',
                TextareaType::class,
                [
                    'label' => 'label.funcao.comentario'
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Administracao\Biblioteca',
            'em' => null,
            'type' => null,
        ));
    }
}
