<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch;

use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;

class FieldCollection implements FieldCollectionInterface
{
    /**
     * @var array $fields
     */
    protected $fields;

    /**
     * FieldCollection constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        foreach ($fields as $key => $field) {
            $this->offsetSet($key, $field);
        }
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->fields);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->fields);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->fields[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (false === is_string($offset) && false === is_int($offset)) {
            throw ProtocoloException::expectedType('$value', 'string or integer', $value);
        }

        if (false === is_object($value) || false === is_subclass_of($value, FieldInterface::class)) {
            throw ProtocoloException::expectedArrayKeyType('$fields', $offset, FieldInterface::class, $value);
        }

        $this->fields[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->fields);
    }
}
