<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\GerenciamentoCargo;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CargoTest extends DefaultWebTestCase
{
    public function testCargoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cargo/list');
        $this->assertContains('Operário', $this->client->getResponse()->getContent());
    }

    public function testCargoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cargo/create');
        $this->assertContains('Cargo Confiança', $this->client->getResponse()->getContent());
    }

    public function testCargoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cargo/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Operário', $this->client->getResponse()->getContent());
    }

    public function testCargoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cargo/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Operário', $this->client->getResponse()->getContent());
    }

    public function testCargoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/cargo/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Operário', $this->client->getResponse()->getContent());
    }
}
