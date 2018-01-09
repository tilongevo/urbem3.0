<?php

namespace Urbem\CoreBundle\Tests\Unit\Form;

class MockEntity
{
    public $columnOne;

    public $columnTwo;

    public $name;

    public function __construct($columnOne, $columnTwo, $name)
    {
        $this->columnOne = $columnOne;
        $this->columnTwo = $columnTwo;
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
