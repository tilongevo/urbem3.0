<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SwCgmPessoaJuridicaTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/administrativo/cgm_pessoa_juridica/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Razão Social', $this->client->getResponse()->getContent());
    }

    public function testCreate()
    {


        $crawler = $this->client->request('GET', '/administrativo/cgm_pessoa_juridica/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados do CGM', $this->client->getResponse()->getContent());
    }
}
