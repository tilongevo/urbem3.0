<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal\Assentamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ClassificacaoAssentamentoTest extends DefaultWebTestCase
{
    public function testClassificacaoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/classificacao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Afastamento Permanente', $this->client->getResponse()->getContent());
    }

    public function testClassificacaoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/classificacao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descrição da Classificação', $this->client->getResponse()->getContent());
    }

    public function testClassificacaoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/classificacao/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Licenças/Afast.(RPPS)', $this->client->getResponse()->getContent());
    }

    public function testClassificacaoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/classificacao/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Afastamento Temporário', $this->client->getResponse()->getContent());
    }

    public function testClassificacaoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/assentamento/classificacao/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;Licenças/Afast.(RPPS)&quot; selecionado', $this->client->getResponse()->getContent());
    }
}
