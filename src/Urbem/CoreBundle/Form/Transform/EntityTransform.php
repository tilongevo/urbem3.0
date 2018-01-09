<?php

namespace Urbem\CoreBundle\Form\Transform;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

class EntityTransform implements DataTransformerInterface
{
    const COMPOSITE_KEY_SEPARATOR = '~';

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repo;

    /**
     * @var ClassMetadata
     */
    protected $classMetadata;

    /**
     * @var \Closure
     */
    protected $toString;

    public function __construct(EntityRepository $repo, ClassMetadata $classMetadata, \Closure $toString = null)
    {
        $this->repo = $repo;
        $this->classMetadata = $classMetadata;

        $toString = true === is_callable($toString) ? $toString : function ($entity) {
            return (string) $entity;
        };

        $this->toString = $toString;
    }

    /**
     * Convert $value to view format
     *
     * $response = [
     *      entity_id => Entity::__toString
     * ];
     *
     * @param mixed $value
     * @return array|null
     */
    public function transform($value)
    {
        if (true === empty($value)) {
            return null;
        }

        $return = [];

        if (true === $value instanceof ArrayCollection || true === is_array($value)) {
            foreach ($value as $collectionItem) {
                $return[implode(
                    self::COMPOSITE_KEY_SEPARATOR,
                    $this->classMetadata->getIdentifierValues($collectionItem)
                )] = call_user_func_array($this->toString, [$collectionItem]);
            }
        } else {
            $return[implode(
                self::COMPOSITE_KEY_SEPARATOR,
                $this->classMetadata->getIdentifierValues($value)
            )] = call_user_func_array($this->toString, [$value]);
        }

        return 0 < count($return) ? $return : null;
    }

    /**
     * Convert $value to expected data format
     *
     * @param mixed $value
     *
     * @return ArrayCollection|null
     */
    public function reverseTransform($value)
    {
        if (true === empty($value)) {
            return null;
        }

        $idFields = array_values($this->classMetadata->getIdentifierFieldNames());

        if (true === is_array($value)) {
            $qb = $this->repo->createQueryBuilder('entity');
            $qb->resetDQLPart('where');

            $key = 0;

            foreach ($value as $ids) {
                $values = explode(self::COMPOSITE_KEY_SEPARATOR, $ids);

                $andX = $qb->expr()->andX();

                foreach ($idFields as $index => $field) {
                    $key++;

                    $andX->add(sprintf('entity.%s = :%s', $field, $parameter = sprintf('k%s', $key)));

                    $qb->setParameter($parameter, $values[$index]);
                }

                $qb->orWhere($andX);
            }

            $query = $qb->getQuery();
            $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

            return new ArrayCollection($query->getResult());
        }

        if (true === $value instanceof ArrayCollection) {
            return $value;
        }

        if (true === is_object($value)) {
            return new ArrayCollection([$value]);
        }

        return new ArrayCollection([$this->repo->find(
            array_combine(
                $idFields,
                explode(self::COMPOSITE_KEY_SEPARATOR, $value)
            )
        )]);
    }
}
