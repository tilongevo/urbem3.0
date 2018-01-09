<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Estagio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EntidadeIntermediadoraTest extends DefaultWebTestCase
{
    public function testEntidadeIntermediadoraList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }

    public function testEntidadeIntermediadoraCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/entidade-intermediadora/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Entidade Intermediadora', $this->client->getResponse()->getContent());
    }

    public function testEntidadeIntermediadoraEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ALMOXARIFADO CENTRAL', $this->client->getResponse()->getContent());
    }

    public function testEntidadeIntermediadoraShow()
    {


        $crawler = $this->client->request('GET', 'recursos-humanos/estagio/entidade-intermediadora/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('3778 - ALMOXARIFADO CENTRAL', $this->client->getResponse()->getContent());
    }

    public function testEntidadeIntermediadoraDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/entidade-intermediadora/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ALMOXARIFADO CENTRAL', $this->client->getResponse()->getContent());
    }
}
