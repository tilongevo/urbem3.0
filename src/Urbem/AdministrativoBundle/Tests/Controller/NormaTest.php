<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class NormaTest extends DefaultWebTestCase
{
    public function testNormaList()
    {


        $this->client->request('GET', '/administrativo/normas/norma/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('adicional suplementar', $this->client->getResponse()->getContent());
    }

    public function testNormaCreate()
    {

        $this->client->request('GET', '/administrativo/normas/norma/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados da Norma', $this->client->getResponse()->getContent());
    }

    public function testNormaEdit()
    {

        $this->client->request('GET', '/administrativo/normas/norma/535/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('adicional suplementar', $this->client->getResponse()->getContent());
    }

    public function testNormaDelete()
    {

        $this->client->request('GET', '/administrativo/normas/norma/535/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('certeza que deseja remover o item', $this->client->getResponse()->getContent());
    }
}
