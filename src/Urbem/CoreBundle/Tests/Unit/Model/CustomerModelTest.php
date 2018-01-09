<?php

namespace Urbem\CoreBundle\Tests\Unit\Model;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerModelTest extends \PHPUnit_Framework_TestCase
{
    public function testFirstCommit()
    {
        $this->assertCount(2, [1,2]);
    }
}
