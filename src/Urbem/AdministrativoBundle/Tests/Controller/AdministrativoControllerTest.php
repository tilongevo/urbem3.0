<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AdministrativoControllerTest extends DefaultWebTestCase
{
    public function testHomeAdministrativo()
    {


        $crawler = $this->client->request('GET', '/administrativo/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Módulo Administrativo', $this->client->getResponse()->getContent());
    }
}