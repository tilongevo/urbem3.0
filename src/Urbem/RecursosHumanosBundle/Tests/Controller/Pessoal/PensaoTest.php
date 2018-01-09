<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PensaoTest extends DefaultWebTestCase
{
    public function testPensaoList()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('NOEMIA', $this->client->getResponse()->getContent());
    }

    public function testPensaoCreate()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Matrícula', $this->client->getResponse()->getContent());
    }

    public function testPensaoEdit()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/5/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('20/10/2016', $this->client->getResponse()->getContent());
    }

    public function testPensaoShow()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/5/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('341', $this->client->getResponse()->getContent());
    }

    public function testPensaoDelete()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/5/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;5&quot; selecionado', $this->client->getResponse()->getContent());
    }
}
