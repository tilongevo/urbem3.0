<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Estagio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CursoTest extends DefaultWebTestCase
{
    public function testItensCursoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/curso/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Jovem Aprendiz', $this->client->getResponse()->getContent());
    }

    public function testItensCursoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/curso/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Grau de instrução', $this->client->getResponse()->getContent());
    }

    public function testItensCursoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/curso/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Análise e Desenv de Sistemas', $this->client->getResponse()->getContent());
    }

    public function testItensCursoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/curso/4/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;Design e programação Web&quot; selecionado?', $this->client->getResponse()->getContent());
    }

    public function testItensCursoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/curso/2/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Analista Financeiro I', $this->client->getResponse()->getContent());
    }
}
