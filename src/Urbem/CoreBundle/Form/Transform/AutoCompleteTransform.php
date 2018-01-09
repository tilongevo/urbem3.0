<?php

namespace Urbem\CoreBundle\Form\Transform;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class AutoCompleteTransform implements DataTransformerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var boolean
     */
    protected $multiple;

    /**
     * @var \Closure
     */
    protected $toString;

    /**
     * @var boolean
     */
    protected $fromMapping;

    public function __construct(EntityManager $em, $class = null, $multiple = false, \Closure $toString = null, $fromMapping = true)
    {
        $this->em = $em;
        $this->class = $class;
        $this->multiple = $multiple;
        $this->toString = true === is_callable($toString) ? $toString : function ($entity) {
            return (string) $entity;
        };
        $this->fromMapping = $fromMapping;
    }

    /**
     * Convert $value to view format
     *
     * $response = [
     *      0 => 'ID 1',
     *      1 => 'ID 2',
     *      '_labels' => [
     *          'ITEM 1'
     *          'ITEM 2'
     *      ]
     * ];
     *
     * @param mixed $value
     * @return array|null
     */
    public function transform($value)
    {
        $value = $this->convertValue($value);

        if (true === empty($value)) {
            return null;
        }

        if (true === is_array($value) && null === reset($value)) {
            return null;
        }

        if (null !== $this->class) {
            if (true === $this->fromMapping) {
                $values = true === is_array($value) ? $value : [$value];

            } else {
                $values = (new EntityTransform($this->em->getRepository($this->class), $this->em->getClassMetadata($this->class)))->reverseTransform($value);
                $values = null !== $values ? $values->toArray() : [];
            }

            $transformer = new EntityTransform(
                $this->em->getRepository($this->class),
                $this->em->getClassMetadata($this->class),
                $this->toString
            );

            $response = [];

            foreach ($values as $value) {
                if (empty($value)) {
                    continue;
                }
                $response+= $transformer->transform($value);
            }

        } else {
            $value = true === $value instanceof ArrayCollection ? $value->toArray() : $value;
            $value = true === is_array($value) ? $value : [$value];

            $response = array_combine(array_values($value), array_values($value));
        }

        if (0 === count($response)) {
            return null;
        }

        return array_keys($response) + ['_labels' => array_values($response)];
    }

    /**
     * Convert $value to expected data format
     *
     * @param mixed $value
     * @return array|null
     */
    public function reverseTransform($value)
    {
        $value = $this->convertValue($value);

        if (true === empty($value)) {
            return null;
        }

        if (true === is_array($value) && null === reset($value)) {
            return null;
        }

        if (null !== $this->class) {
            if (true === $this->fromMapping) {
                $response = (new EntityTransform($this->em->getRepository($this->class), $this->em->getClassMetadata($this->class)))->reverseTransform($value);
                $response = null !== $response ? $response->toArray() : [];

            } else {
                $response = is_array($value) ? $value : [$value];
            }

        } else {
            $value = true === $value instanceof ArrayCollection ? $value->toArray() : $value;
            $value = true === is_array($value) ? $value : [$value];

            $response = array_combine(array_values($value), array_values($value));
        }

        if (0 === count($response)) {
            return null;
        }

        if (false === $this->multiple) {
            $response = reset($response);
        }

        return $response;
    }

    /**
     * Convert a array to single value
     *
     * @param $value
     * @return mixed
     */
    private function convertValue($value)
    {
        if (false === $this->multiple && (true === is_array($value) || true === $value instanceof ArrayCollection)) {
            $value = reset($value);
        }

        return $value;
    }
}
