<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConselhoTest extends DefaultWebTestCase
{
    public function testConselhoList()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/conselho/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Não informado', $this->client->getResponse()->getContent());
    }

    public function testConselhoCreate()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/conselho/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Conselho', $this->client->getResponse()->getContent());
    }

    public function testConselhoEdit()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/conselho/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Não informado', $this->client->getResponse()->getContent());
    }

    public function testConselhoShow()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/conselho/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Não informado', $this->client->getResponse()->getContent());
    }

    public function testConselhoDelete()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/conselho/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Não informado', $this->client->getResponse()->getContent());
    }
}
