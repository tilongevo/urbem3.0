<?php

namespace Urbem\CoreBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Form\Transform\AutoCompleteTransform;

/**
 *  $formMapper->add('my_field', 'autocomplete', [
 *      'class' => '', // If is an entity autocomplete
 *      'route' => ['name' => 'route_name_to_receive_json'], // ['items' => [['id' => 1, 'label' => 'name1'], ['id' => 2, 'label' => 'name2']]]
 *  ]);
 *
 * @package Urbem\CoreBundle\Form\Type
 */
class AutoCompleteType extends AbstractType
{
    const ROUTE_AUTOCOMPLETE_DEFAULT = 'autocomplete';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AutoCompleteType constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('disabled', $options['disabled'] || (array_key_exists('read_only', $options) && $options['read_only']));

        $builder->addViewTransformer(
            new AutoCompleteTransform(
                $this->em,
                $options['class'],
                $options['multiple'],
                $options['json_choice_label'],
                $options['from_mapping']
            ),
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (true === empty($options['route']['parameters']['json_from_admin_field'])) {
            $options['route']['parameters']['json_from_admin_field'] = $form->getName();
        }

        foreach ($options['cascade_fields'] as $i => $field) {
            $options['req_params'][sprintf('cascade_%s', $field['search_column'])] = sprintf('varJs_%s', $field['search_column']);
        }

        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['multiple'] = $options['multiple'];
        $view->vars['disabled'] = $options['disabled'];
        $view->vars['minimum_input_length'] = $options['minimum_input_length'];
        $view->vars['route'] = $options['route'];
        $view->vars['quiet_millis'] = $options['quiet_millis'];
        $view->vars['req_params'] = $options['req_params'];
        $view->vars['req_param_name_search'] = $options['req_param_name_search'];
        $view->vars['template'] = $options['template'];
        $view->vars['cascade_fields'] = $options['cascade_fields'];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'route' => [
                'name' => self::ROUTE_AUTOCOMPLETE_DEFAULT,

                /* The field containing the dynamic parameters
                   src/Urbem/CoreBundle/Controller/AutoCompleteController.php */
                'json_from_admin_field' => null,
            ],

            /* boolean to use on src/Urbem/CoreBundle/Form/Transform/AutoCompleteTransform.php */
            'from_mapping' => true,

            /* Prevent form trying to check entity x array */
            'data_class' => null,

            /* Entity Class */
            'class' => null,
            'attr' => [],
            'compound' => false,
            'placeholder' => '',
            'multiple' => false,
            'minimum_input_length' => 3,
            'quiet_millis' => 250,
            'req_params' => [],
            'req_param_name_search' => 'q',
            'template' => 'CoreBundle:Form/Type:autocomplete.html.twig',

            'cascade_fields' => [],

            /* dynamic parameters */

            /* The Admin where to look for the field */
            'json_from_admin_code' => null,

            /* used when there's no way to write a json_query_builder.
              i.e.: src/Urbem/ConfiguracaoBundle/DependencyInjection/Configuration.php */
            'json_query_builder_fields' => null,

            /* must be a callable(EntityRepository, term, Request) and must return a QueryBuilderInstance */
            'json_query_builder' => null,
            'json_choice_label' => null,
            'json_choice_value' => null,
            'json_get_querybuilder_result' => function (QueryBuilder $queryBuilder) {
                return $queryBuilder->getQuery()->getResult();
            },
        ]);

        $resolver->setAllowedTypes('route', ['array']);
        $resolver->setAllowedTypes('class', ['string', 'null']);
        $resolver->setAllowedTypes('cascade_fields', ['array']);
        $resolver->setAllowedTypes('from_mapping', ['boolean']);
        $resolver->setAllowedTypes('json_from_admin_code', ['string', 'null']);
        $resolver->setAllowedTypes('json_query_builder_fields', ['array', 'null']);
        $resolver->setAllowedTypes('json_choice_label', ['\Closure', 'null']);
        $resolver->setAllowedTypes('json_choice_value', ['\Closure', 'null']);
        $resolver->setAllowedTypes('json_query_builder', ['\Closure', 'null']);

        $resolver->setNormalizer('route', function (Options $options, $value) {
            if (false === array_key_exists('name', $value)) {
                $value['name'] = self::ROUTE_AUTOCOMPLETE_DEFAULT;
            }

            if (false === array_key_exists('parameters', $value)) {
                $value['parameters'] = [];
            }

            $value['name'] = true === is_string($value['name']) ? trim($value['name']) : $value['name'];
            $value['parameters'] = true === is_array($value['parameters']) ? $value['parameters'] : $value['parameters'];

            if (false === is_string($value['name'])) {
                throw new \InvalidArgumentException(sprintf(
                    "`route['name']` must be an string. `%s` was given.",
                    gettype($value['name'])
                ));
            }

            foreach ($value['parameters'] as $name => $v) {
                if (false === is_string($v) && false === is_int($v)) {
                    throw new \InvalidArgumentException(sprintf("`route['parameters'][%s]` must be an string. `%s` was given.", $name, gettype($v)));
                }
            }

            $adminCode = trim($options->offsetGet('json_from_admin_code'));

            if (self::ROUTE_AUTOCOMPLETE_DEFAULT === $value['name'] && true === empty($adminCode)) {
                throw new \InvalidArgumentException(sprintf(
                    "`json_from_admin_code` can't be null when `route['name']` is `%s`",
                    self::ROUTE_AUTOCOMPLETE_DEFAULT
                ));
            }

            if (self::ROUTE_AUTOCOMPLETE_DEFAULT !== $value['name'] && false === empty($adminCode)) {
                throw new \InvalidArgumentException(sprintf(
                    "`route['name']` must be `%s` when `json_from_admin_code` is set. `%s` was given",
                    self::ROUTE_AUTOCOMPLETE_DEFAULT,
                    $value['name']
                ));
            }

            if (0 < strlen($adminCode)) {
                $value['parameters']['json_from_admin_code'] = $adminCode;
            }

            return $value;
        });

        $resolver->setNormalizer('json_choice_value', function (Options $options, $value) {
            $class = trim($options->offsetGet('class'));

            if (0 === strlen($class)) {
                return $value;
            }

            try {
                $classMetadata = $this->em->getClassMetadata($class);
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf(
                    "Entity Repository not found for `class` (%s).",
                    $class
                ));
            }

            return function ($entity) use ($classMetadata) {
                /* by default, if json_get_querybuilder_result returns an array, we try
                   to get entity PK */
                if (true === is_array($entity)) {
                    $keys = array_intersect_key($entity, array_flip($classMetadata->getIdentifierFieldNames()));
                } else {
                    $keys = $classMetadata->getIdentifierValues($entity);
                }

                return implode('~', $keys);
            };
        });

        $resolver->setNormalizer('json_query_builder', function (Options $options, $queryBuilder) {
            $class = trim($options->offsetGet('class'));

            return function (Request $request) use ($options, $queryBuilder, $class) {
                $jsonQueryBuilderFields = $options->offsetGet('json_query_builder_fields');
                $jsonQueryBuilderFields = false === is_array($jsonQueryBuilderFields) ? [] : $jsonQueryBuilderFields;

                if (false === is_callable($queryBuilder) && 0 < count($jsonQueryBuilderFields)) {
                    $queryBuilder = function (EntityRepository $repo, $value, Request $request) use ($jsonQueryBuilderFields) {
                        $value = strtolower($value);

                        $qb = $repo->createQueryBuilder('e');
                        $andX = $qb->expr()->andX();

                        foreach ($jsonQueryBuilderFields as $field) {
                            $andX->add($qb->expr()->orX(sprintf('LOWER(e.%s) LIKE :value', $field)));
                        }

                        $qb->andWhere($andX);
                        $qb->setParameter('value', "%{$value}%");
                        $qb->setMaxResults(10);

                        return $qb;
                    };
                }

                $queryBuilder = call_user_func_array($queryBuilder, [
                    $this->em->getRepository($class),
                    $request->get($options->offsetGet('req_param_name_search')),
                    $request,
                ]);

                if (false === $queryBuilder instanceof QueryBuilder) {
                    throw new \InvalidArgumentException(sprintf(
                        "`json_query_builder` must return a instance of QueryBuilder. `%s` was given.",
                        true === is_object($queryBuilder) ? get_class($queryBuilder) : gettype($queryBuilder)
                    ));
                }

                return $queryBuilder;
            };
        });

        $resolver->setNormalizer('json_choice_label', function (Options $options, $value) {
            if (true === is_callable($value)) {
                return function ($entity) use ($value) {
                    return call_user_func_array($value, [$entity]);
                };
            }

            return function ($entity) use ($value) {
                if (true === is_array($entity)) {
                    return reset($entity);
                }

                return (string) $entity;
            };
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'autocomplete';
    }
}
