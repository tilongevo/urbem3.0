<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AssentamentoSefipTest extends DefaultWebTestCase
{
    public function testAssentamentoSefipList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/sefip/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Rescisão, com justa causa, por iniciativa do empregador.', $this->client->getResponse()->getContent());
    }

    public function testAssentamentoSefipCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/sefip/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Movimentação da SEFIP', $this->client->getResponse()->getContent());
    }

    public function testAssentamentoSefipEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/sefip/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Rescisão, com justa causa, por iniciativa do empregador.', $this->client->getResponse()->getContent());
    }

    public function testAssentamentoSefipShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/sefip/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Rescisão, com justa causa, por iniciativa do empregador.', $this->client->getResponse()->getContent());
    }

    public function testAssentamentoSefipDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/sefip/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Rescisão, com justa causa, por iniciativa do empregador.', $this->client->getResponse()->getContent());
    }
}
