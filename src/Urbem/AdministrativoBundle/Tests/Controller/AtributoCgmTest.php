<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AtributoCgmTest extends DefaultWebTestCase
{

    public function testHomePage()
    {


        $this->client->request('GET', '/administrativo/atributo/list');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Fax', $this->client->getResponse()->getContent());
    }

    public function testEditPage()
    {


        $this->client->request('GET', '/administrativo/atributo/5/edit');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados para atributo', $this->client->getResponse()->getContent());
    }

    public function testDeletePage()
    {


        $this->client->request('GET', '/administrativo/atributo/5/delete');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains("remover o item", $this->client->getResponse()->getContent());
    }

    public function testCreateePage()
    {


        $this->client->request('GET', '/administrativo/atributo/create');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados para atributo', $this->client->getResponse()->getContent());
    }
}
