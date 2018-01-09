<?php

namespace RecursosHumanosBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class TributarioControllerTest extends DefaultWebTestCase
{
    public function testHomeTributario()
    {
        

        $crawler = $this->client->request('GET', '/tributario/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Tributário', $this->client->getResponse()->getContent());
    }
}