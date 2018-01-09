<?php

namespace Urbem\CoreBundle\Admin\Filter;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\Type\Filter\DefaultType;
use Sonata\DoctrineORMAdminBundle\Filter\Filter;
use Sonata\CoreBundle\Form\Type\EqualType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Class CompositeFilter
 * @package Urbem\CoreBundle\Admin\Filter
 */
class CompositeFilter extends Filter
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CompositeFilter constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        if (true === empty($data) || false === is_array($data) || false === array_key_exists('type', $data) || false === array_key_exists('value', $data)) {
            return;
        }

        if ($data['value'] instanceof Collection) {
            $data['value'] = $data['value']->toArray();
        }

        $this->handle($queryBuilder, $alias, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return [
            'field_name' => false,
            'field_type' => EntityType::class,
            'field_options' => [],
            'operator_type' => EqualType::class,
            'operator_options' => [],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRenderSettings()
    {
        return [DefaultType::class, [
            'field_type' => $this->getFieldType(),
            'field_options' => $this->getFieldOptions(),
            'operator_type' => $this->getOption('operator_type'),
            'operator_options' => $this->getOption('operator_options'),
            'label' => $this->getLabel(),
        ]];
    }

    /**
     * @param ProxyQueryInterface|QueryBuilder $queryBuilder
     * @param string                           $alias
     * @param mixed                            $data
     */
    protected function handle(ProxyQueryInterface $queryBuilder, $alias, $data)
    {
        if (true === empty($data['value'])) {
            return;
        }

        if (false === is_array($data['value'])) {
            $data['value'] = [$data['value']];
        }

        $orx = $queryBuilder->expr()->orX();
        try {
            $classMetadata = $this->em->getClassMetadata(get_class(reset($data['value'])));
        } catch (\Exception $e) {
            throw new \Exception("Verifique se o campo $alias tem o atributo `class` definido.");
        }

        foreach ($data['value'] as $value) {
            $andX = $queryBuilder->expr()->andX();

            foreach ($classMetadata->getIdentifierValues($value) as $column => $identifier) {
                $parameter = $this->getNewParameterName($queryBuilder);

                $andX->add(sprintf('%s.%s = :%s', $alias, $column, $parameter));
                $queryBuilder->setParameter($parameter, $identifier);
            }

            $orx->add($andX);
        }

        $this->applyWhere($queryBuilder, $orx);
    }

    /**
     * {@inheritdoc}
     */
    protected function association(ProxyQueryInterface $queryBuilder, $data)
    {
        $associationMappings = $this->getParentAssociationMappings();
        $associationMappings[] = $this->getAssociationMapping();

        return [$queryBuilder->entityJoin($associationMappings), false];
    }
}
