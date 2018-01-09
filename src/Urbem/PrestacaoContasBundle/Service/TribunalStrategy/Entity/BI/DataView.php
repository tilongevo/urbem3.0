<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI;

/**
 * Class DataView
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI
 */
class DataView
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $value;

    /**
     * @var
     */
    protected $label;

    /**
     * @var
     */
    protected $text;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function exportToArray()
    {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'label' => $this->getLabel(),
            'text' => $this->getText()
        ];
    }
}
