<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Empenho;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ContrapartidaResponsavelTest extends DefaultWebTestCase
{
    public function testContrapartidaResponsavelList()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/contrapartida/responsavel/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('14864 - DEPÓSITOS JUDICIAIS', $this->client->getResponse()->getContent());
    }

    public function testContrapartidaResponsavelCreate()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/contrapartida/responsavel/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Prazo máximo p/ Prestação de Contas', $this->client->getResponse()->getContent());
    }

    public function testContrapartidaResponsavelEdit()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/contrapartida/responsavel/2016~9942/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Contrapartida Contábil', $this->client->getResponse()->getContent());
    }

    public function testContrapartidaResponsavelShow()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/contrapartida/responsavel/2016~9942/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('90', $this->client->getResponse()->getContent());
    }

    public function testContrapartidaResponsavelDelete()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/contrapartida/responsavel/2016~9942/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('item', $this->client->getResponse()->getContent());
    }
}
