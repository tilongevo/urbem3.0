<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SwCgmPessoaFisicaTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/administrativo/cgm_pessoa_fisica/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CPF', $this->client->getResponse()->getContent());
    }

    public function testCreate()
    {


        $crawler = $this->client->request('GET', '/administrativo/cgm_pessoa_fisica/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados do CGM', $this->client->getResponse()->getContent());
    }
}
