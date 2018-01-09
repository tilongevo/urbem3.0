<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CidTest extends DefaultWebTestCase
{
    public function testCidList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cid/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Colera', $this->client->getResponse()->getContent());
    }

    public function testCidCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cid/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Sigla', $this->client->getResponse()->getContent());
    }

    public function testCidEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cid/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('A00', $this->client->getResponse()->getContent());
    }

    public function testCidShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cid/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Colera', $this->client->getResponse()->getContent());
    }

    public function testCidDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cid/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('&quot;Colera&quot;', $this->client->getResponse()->getContent());
    }
}
