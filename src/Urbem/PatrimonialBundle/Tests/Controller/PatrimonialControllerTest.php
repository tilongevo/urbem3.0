<?php

namespace PatrimonialBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PatrimonialControllerTest extends DefaultWebTestCase
{
    public function testHomePatrimonial()
    {


        $crawler = $this->client->request('GET', '/patrimonial/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Módulo Patrimonial', $this->client->getResponse()->getContent());
    }
}
