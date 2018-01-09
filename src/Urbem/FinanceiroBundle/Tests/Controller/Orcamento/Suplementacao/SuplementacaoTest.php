<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Orcamento\Suplementacao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SuplementacaoTest extends DefaultWebTestCase
{
    public function testRecuperaRegistroDaListaSuplementacao()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/suplementacao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('23/09/2016', $this->client->getResponse()->getContent());
    }

    public function testValidaPaginaCriacaoSuplementacao()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/suplementacao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados para Crédito Suplementar', $this->client->getResponse()->getContent());
    }
}
