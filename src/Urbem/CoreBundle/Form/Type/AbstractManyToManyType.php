<?php

namespace Urbem\CoreBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Form\Transform\EntityTransform;

abstract class AbstractManyToManyType extends AbstractType
{
    /**
     * @var $em EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    abstract function addViewTransform(FormBuilderInterface $builder);

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addViewTransform($builder);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
            $parent = $options['parent_data'];

            if (null === $parent) {
                return;
            }

            $propertyName = $event->getForm()->getName();

            $collection = new ArrayCollection();

            $getManyToMany = sprintf('get%s', ucfirst($propertyName));
            $getManyToManyChild = sprintf('get%s', ucfirst($options['many_to_many_child_property']));

            foreach (call_user_func([$parent, $getManyToMany]) as $manyToMany) {
                $collection->add(call_user_func([$manyToMany, $getManyToManyChild]));
            }

            $event->setData($collection);
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($builder, $options) {
            $parentForm = $event->getForm()->getParent();
            $parent = $parentForm->getData();

            $propertyName = $event->getForm()->getName();

            $collection = (new EntityTransform(
                $this->em->getRepository($options['class']),
                $this->em->getClassMetadata($options['class']),
                $options['multiple']
            ))->reverseTransform($event->getData());

            if (0 === $collection->count()) {
                return;
            }

            $getManyToMany = sprintf('get%s', ucfirst($propertyName));
            $addManyToMany = sprintf('add%s', ucfirst($propertyName));
            $removeManyToMany = sprintf('remove%s', ucfirst($propertyName));
            $getManyToManyChild = sprintf('get%s', ucfirst($options['many_to_many_child_property']));
            $setManyToManyChild = sprintf('set%s', ucfirst($options['many_to_many_child_property']));

            $classMetadata = $this->em->getClassMetadata(ClassUtils::getClass($collection->first()));

            $filter = function ($manyToManyChild, $manyToMany) use ($getManyToManyChild, $classMetadata) {
                return 0 === count(array_diff(
                    $classMetadata->getIdentifierValues($manyToManyChild),
                    $classMetadata->getIdentifierValues(call_user_func([$manyToMany, $getManyToManyChild]))
                ));
            };

            // removed on form
            // loop on Parent.ManyToMany
            foreach (call_user_func([$parent, $getManyToMany]) as $manyToMany) {
                // $collection is an ArrayCollection of Parent.ManyToMany.Child

                $isSetOnForm = $collection->filter(function ($manyToManyChild) use ($filter, $getManyToManyChild, $manyToMany) {
                    return call_user_func_array($filter, [$manyToManyChild, $manyToMany]);
                })->count() >= 1;

                // was setted again on form
                if (true === $isSetOnForm) {
                    continue;
                }

                // Remove Parent.ManyToMany
                call_user_func([$parent, $removeManyToMany], $manyToMany);
            }

            // setted on form
            // loop on Parent.ManyToMany.Child
            foreach ($collection as $manyToManyChild) {
                // $children is an ArrayCollection of Parent.ManyToMany
                $children = call_user_func([$parent, $getManyToMany]);

                $isOnParent = $children->filter(function ($manyToMany) use ($filter, $getManyToManyChild, $manyToManyChild) {
                    return call_user_func_array($filter, [$manyToManyChild, $manyToMany]);
                })->count() >= 1;

                // already on Parent.ManyToMany
                if (true === $isOnParent) {
                    continue;
                }

                $manyToMany = new $options['many_to_many_entity'];

                // Set ManyToMany.Child
                call_user_func([$manyToMany, $setManyToManyChild], $manyToManyChild);

                // Add Parent.ManyToMany
                call_user_func([$parent, $addManyToMany], $manyToMany);
            }

            $event->getForm()->setData($parent);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'class',
            'parent_data',
            'many_to_many_child_property',
            'many_to_many_entity'
        ]);

        $resolver->setDefault('mapped', false);
        $resolver->setDefault('multiple', true);
        $resolver->setAllowedTypes('parent_data', ['object', 'null']);
        $resolver->setAllowedTypes('many_to_many_child_property', ['string']);
        $resolver->setAllowedTypes('many_to_many_entity', ['string']);
    }
}
