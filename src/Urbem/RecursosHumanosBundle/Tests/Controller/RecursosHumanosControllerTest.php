<?php

namespace RecursosHumanosBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RecursosHumanosControllerTest extends DefaultWebTestCase
{
    public function testHomeRecursosHumanos()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Recursos Humanos', $this->client->getResponse()->getContent());
    }
}
