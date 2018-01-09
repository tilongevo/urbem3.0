<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Estagio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class InstituicaoEnsinoTest extends DefaultWebTestCase
{
    public function testInstituicaoEnsinoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }

    public function testInstituicaoEnsinoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Instituição de Ensino', $this->client->getResponse()->getContent());
    }

    public function testInstituicaoEnsinoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Analista Financeiro I', $this->client->getResponse()->getContent());
    }

    public function testInstituicaoEnsinoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }

    public function testInstituicaoEnsinoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/instituicao-ensino/2/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CAMARA MUNICIPAL DE VEREADORES', $this->client->getResponse()->getContent());
    }
}
