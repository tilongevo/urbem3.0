<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Orcamento\ClassificacaoEconomica;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RubricaDespesaTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/classificacao-economica/rubrica-despesa/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('TRANSFERENCIAS A MUNICIPIOS', $this->client->getResponse()->getContent());
    }
}
