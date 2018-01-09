<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 29/11/16
 * Time: 10:37
 */

namespace Urbem\CoreBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\DataTransformer\ArrayToModelTransformer;
use Sonata\AdminBundle\Form\DataTransformer\ModelToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Doctrine\Common\Annotations\AnnotationReader;
use Urbem\CoreBundle\Exception\Error;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class OneToOneType extends AbstractType
{
    const REFERENCE_CLASS_PATNER = '/var\s([\\\\A-Za-z]+\|)([\\\\A-Za-z]+)/';
    const POSITION_REFERENCE_CLASS = '2';
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $admin = clone $this->getAdmin($options);

        if ($admin->hasParentFieldDescription()) {
            $admin->getParentFieldDescription()->setAssociationAdmin($admin);
        }

        $fieldChildName = $this->getFieldDescription($options)->getFieldName();
        $setFieldChildObject = "set" . ucfirst($fieldChildName);
        $getFieldChildObject = "get" . ucfirst($fieldChildName);

        $parentSubject = $admin->getParentFieldDescription()->getAdmin()->getSubject();
        $r = new \ReflectionClass($parentSubject);
        $objectField = $r->getProperty($fieldChildName);

        $class = $this->getClassReferenceByOneToOne($objectField);

        if ($this->isEditPage($admin)) {
            // Find no banco
            $class = $parentSubject->$getFieldChildObject()->last();
        }

        // Aqui alteramos o objeto para ser a classe que queremos
        $parentSubject->$setFieldChildObject($class);

        if ($options['delete'] && $admin->isGranted('DELETE')) {
            if (!array_key_exists('translation_domain', $options['delete_options']['type_options'])) {
                $options['delete_options']['type_options']['translation_domain'] = $admin->getTranslationDomain();
            }

            $builder->add('_delete', $options['delete_options']['type'], $options['delete_options']['type_options']);
        }

        // hack to make sure the subject is correctly set
        // https://github.com/sonata-project/SonataAdminBundle/pull/2076
        if ($builder->getData() === null) {
            $p = new PropertyAccessor(false, true);
            try {
                $parentSubject = $admin->getParentFieldDescription()->getAdmin()->getSubject();

                if ($parentSubject !== null && $parentSubject !== false) {
                    // for PropertyAccessor < 2.5
                    // NEXT_MAJOR: remove this code for old PropertyAccessor after dropping support for Symfony 2.3
                    if (!method_exists($p, 'isReadable')) {echo "Aqui 1";
                        $subjectCollection = $p->getValue(
                            $parentSubject,
                            $this->getFieldDescription($options)->getFieldName()
                        );
                        if ($subjectCollection instanceof Collection) {
                            $subject = $subjectCollection->get(trim($options['property_path'], '[]'));
                        }
                    } else {
                        // for PropertyAccessor >= 2.5
                        $subject = $p->getValue(
                            $parentSubject,
                            $this->getFieldDescription($options)->getFieldName().$options['property_path']
                        );
                    }
                    $builder->setData($subject);
                }
            } catch (NoSuchIndexException $e) {
                // no object here
            }
        }

        $admin->setSubject($builder->getData());

        // Volta a colletion
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use (&$parentSubject, $setFieldChildObject, $builder) {
            $form = $event->getForm();
            $data = $event->getData();
        });

        $admin->defineFormBuilder($builder);

        $builder->addModelTransformer(new ArrayToModelTransformer($admin->getModelManager(), $admin->getClass()));
    }

    protected function isEditPage($admin)
    {
        return !empty($admin->getRequest()->get('id'));
    }

    protected function getClassReferenceByOneToOne($objectField)
    {
        preg_match_all(self::REFERENCE_CLASS_PATNER, $objectField->getDocComment(), $annotationReferenceClass);

        if (!array_key_exists(self::POSITION_REFERENCE_CLASS, $annotationReferenceClass)) {
            throw new \RuntimeException(sprintf("%s: %s", Error::INVALID_REFERENCE_CLASS, print_r($annotationReferenceClass, true)));
        }

        $class = array_shift($annotationReferenceClass[self::POSITION_REFERENCE_CLASS]);
        if (!class_exists($class)) {
            throw new \RuntimeException(sprintf("%s: %s", Error::INVALID_REFERENCE_CLASS_NOT_FOUND, $class));
        }

        return new $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['btn_add'] = $options['btn_add'];
        $view->vars['btn_list'] = $options['btn_list'];
        $view->vars['btn_delete'] = $options['btn_delete'];
        $view->vars['btn_catalogue'] = $options['btn_catalogue'];
    }

    /**
     * NEXT_MAJOR: Remove method, when bumping requirements to SF 2.7+.
     *
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'delete' => function (Options $options) {
                return false;//$options['btn_delete'] !== false;
            },
            'delete_options' => array(
                'type' => 'checkbox',
                'type_options' => array(
                    'required' => false,
                    'mapped' => false,
                ),
            ),
            'auto_initialize' => false,
            'btn_add' => 'link_add',
            'btn_list' => 'link_list',
            'btn_delete' => 'link_delete',
            'btn_catalogue' => 'SonataAdminBundle'
        ));
    }

    /**
     * NEXT_MAJOR: Remove when dropping Symfony <2.8 support.
     *
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'onetoone';
    }

    /**
     * @param array $options
     *
     * @return FieldDescriptionInterface
     *
     * @throws \RuntimeException
     */
    protected function getFieldDescription(array $options)
    {
        if (!isset($options['sonata_field_description'])) {
            throw new \RuntimeException('Please provide a valid `sonata_field_description` option');
        }

        return $options['sonata_field_description'];
    }

    /**
     * @param array $options
     *
     * @return AdminInterface
     */
    protected function getAdmin(array $options)
    {
        return $this->getFieldDescription($options)->getAssociationAdmin();
    }
}
