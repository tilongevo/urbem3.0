<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Estagio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AreaConhecimentoTest extends DefaultWebTestCase
{
    public function testItensAreaConhecimentoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/area-conhecimento/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Areas não Constantes na Res. CNE 04/99', $this->client->getResponse()->getContent());
    }

    public function testItensAreaConhecimentoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/area-conhecimento/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descrição', $this->client->getResponse()->getContent());
    }

    public function testItensAreaConhecimentoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/area-conhecimento/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Não Informado', $this->client->getResponse()->getContent());
    }

    public function testItensAreaConhecimentoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/area-conhecimento/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;Não Informado&quot; selecionado?', $this->client->getResponse()->getContent());
    }

    public function testItensAreaConhecimentoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/estagio/area-conhecimento/7/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Construção Civil', $this->client->getResponse()->getContent());
    }
}
