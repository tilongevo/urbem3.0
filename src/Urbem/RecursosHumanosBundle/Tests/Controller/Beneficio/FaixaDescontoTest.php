<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\Beneficio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class FaixaDescontoTest extends DefaultWebTestCase
{
    public function testFaixaDescontoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/vigencia/list');
        $this->assertContains('Vale Transporte', $this->client->getResponse()->getContent());
    }

    public function testFaixaDescontoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/vigencia/create');
        $this->assertContains('Dados de Faixa', $this->client->getResponse()->getContent());
    }

    public function testFaixaDescontoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/vigencia/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Vale-Transporte', $this->client->getResponse()->getContent());
    }

    public function testFaixaDescontoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/vigencia/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1', $this->client->getResponse()->getContent());
    }

    public function testFaixaDescontoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/vigencia/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Vale-Transporte', $this->client->getResponse()->getContent());
    }
}
