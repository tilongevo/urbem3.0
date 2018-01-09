<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Contabilidade;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PlanoContaTest extends DefaultWebTestCase
{
    public function testRecuperaRegistroDaListaPlanoConta()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/planoconta/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CAIXA', $this->client->getResponse()->getContent());
    }

    public function testValidaPaginaCriacaoPlanoConta()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/planoconta/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Identificação', $this->client->getResponse()->getContent());
    }

    public function testValidaPaginaEncerrarPlanoConta()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/planoconta/encerramento/6~2016');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Encerramento', $this->client->getResponse()->getContent());
    }
}
