<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AutorizacaoEmpenhoTest extends DefaultWebTestCase
{
    public function testAutorizacaoEmpenhoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('07/10/2016', $this->client->getResponse()->getContent());
    }

    public function testAutorizacaoEmpenhoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Vigência da Configuração', $this->client->getResponse()->getContent());
    }

    public function testAutorizacaoEmpenhoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('07/10/2016', $this->client->getResponse()->getContent());
    }

    public function testAutorizacaoEmpenhoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1', $this->client->getResponse()->getContent());
    }

    public function testAutorizacaoEmpenhoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/configuracao-autorizacao-empenho/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('07/10/2016', $this->client->getResponse()->getContent());
    }
}
