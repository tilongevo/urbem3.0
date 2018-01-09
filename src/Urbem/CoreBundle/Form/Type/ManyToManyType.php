<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *  $formMapper->add('fkPatrimonioBemProcessos', 'manytomany', [ // Bem.fkPatrimonioBemProcessos
 *      'label' => 'label.bem.procAdministrativo',
 *      'parent_data' => $object, // Urbem\CoreBundle\Entity\Patrimonio\Bem instance or NULL
 *      'class' => 'Urbem\CoreBundle\Entity\SwProcesso', //BemProcesso.fkSwProcesso
 *      'many_to_many_entity' => 'Urbem\CoreBundle\Entity\Patrimonio\BemProcesso', // "ManyToMany" table
 *      'many_to_many_child_property' => 'fkSwProcesso', // BemProcesso.fkSwProcesso
 *  ]);
 *
 * @package Urbem\CoreBundle\Form\Type
 */
class ManyToManyType extends AbstractManyToManyType
{
    public function getParent()
    {
        return 'entity';
    }

    public function addViewTransform(FormBuilderInterface $builder)
    {
        $class = $builder->getForm()->getConfig()->getOption('class');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setNormalizer('choice_value', function (Options $options) {
            $classMetadata = $this->em->getClassMetadata($options['class']);

            return function ($entity) use ($classMetadata) {
                if (null === $entity) {
                    return null;
                }

                if (true === is_array($entity)) {
                    $entity = array_keys($entity);

                    return reset($entity);
                }

                return implode('~', $classMetadata->getIdentifierValues($entity));
            };
        });
    }
}
