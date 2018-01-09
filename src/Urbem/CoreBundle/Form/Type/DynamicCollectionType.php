<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\CustomDataInterface;

/**
 * Class DynamicCollectionType
 * @package Urbem\CoreBundle\Form\Type
 */
class DynamicCollectionType extends AbstractType
{
    /**
     * @var \Symfony\Component\Form\FormTypeInterface
     */
    protected $dynamicType;

    /**
     * DynamicCollectionType constructor.
     * @param \Symfony\Component\Form\FormTypeInterface $dynamicType
     */
    public function __construct(FormTypeInterface $dynamicType = null)
    {
        $this->dynamicType = $dynamicType;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $classType = null === $this->dynamicType ? $options['dynamic_type'] : $this->dynamicType;

        $builder->add(
            'dynamic_collection',
            CollectionType::class,
            [
                'entry_type'   => true === is_object($classType) ? get_class($classType) : $classType,
                'allow_add'    => $options['allow_add'],
                'allow_delete' => $options['allow_delete'],
                'label'        => false,
                'mapped'       => false,
                'data'         => $classType instanceof CustomDataInterface ? $classType->getData() : []
            ]
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['allow_add'] = $options['allow_add'];
        $view->vars['allow_delete'] = $options['allow_delete'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('dynamic_type', null);
        $resolver->setDefault('allow_add', true);
        $resolver->setDefault('allow_delete', true);

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'urbem_dynamic_collection_type';
    }
}
