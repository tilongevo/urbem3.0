<?php

namespace Urbem\ReGrausHumanosBundle\Tests\Controller\Estagio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class GrauTest extends DefaultWebTestCase
{
    public function testItensGrauList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/grau/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Técnico', $this->client->getResponse()->getContent());
    }

    public function testItensGrauCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/grau/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descrição', $this->client->getResponse()->getContent());
    }

    public function testItensGrauEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/grau/3/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descrição', $this->client->getResponse()->getContent());
    }

    public function testItensGrauDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/grau/4/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;Tecnólogo&quot; selecionado?', $this->client->getResponse()->getContent());
    }

    public function testItensGrauShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/grau/5/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Superior', $this->client->getResponse()->getContent());
    }
}
