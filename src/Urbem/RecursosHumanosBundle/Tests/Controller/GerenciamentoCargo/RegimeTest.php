<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\GerenciamentoCargo;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RegimeTest extends DefaultWebTestCase
{
    public function testRegimeList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/regime/list');
        $this->assertContains('CLT', $this->client->getResponse()->getContent());
    }

    public function testRegimeCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/regime/create');
        $this->assertContains('Subdivisão', $this->client->getResponse()->getContent());
    }

    public function testRegimeEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/regime/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CLT', $this->client->getResponse()->getContent());
    }

    public function testRegimeDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/regime/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CLT', $this->client->getResponse()->getContent());
    }

    public function testRegimeShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/regime/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CLT', $this->client->getResponse()->getContent());
    }
}