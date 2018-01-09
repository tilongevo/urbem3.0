<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Tesouraria\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SaldoTesourariaTest extends DefaultWebTestCase
{
    public function testPaginaCreate()
    {


        $crawler = $this->client->request('GET', '/financeiro/tesouraria/configuracao/implantar-saldo-inicial/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ALMOXARIFADO CENTRAL', $this->client->getResponse()->getContent());
    }
}