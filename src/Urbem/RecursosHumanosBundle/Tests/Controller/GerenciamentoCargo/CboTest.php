<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\GerenciamentoCargo;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CboTest extends DefaultWebTestCase
{
    public function testRegimeList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cbo/list');
        $this->assertContains('Brigadeiro Sinônimo', $this->client->getResponse()->getContent());
    }

    public function testCboCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cbo/create');
        $this->assertContains('Cbo', $this->client->getResponse()->getContent());
    }

    public function testCboEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cbo/2/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Brigadeiro Sinônimo', $this->client->getResponse()->getContent());
    }

    public function testCboDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cbo/2/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Brigadeiro Sinônimo', $this->client->getResponse()->getContent());
    }

    public function testCboShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cbo/2/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Brigadeiro Sinônimo', $this->client->getResponse()->getContent());
    }
}