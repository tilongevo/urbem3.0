<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Orcamento\ClassificacaoEconomica;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ClassificacaoReceitaTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/classificacao-economica/classificacao-receita/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('IMPOSTOS SOBRE O PATRIMONIO E A RENDA', $this->client->getResponse()->getContent());
    }
}
