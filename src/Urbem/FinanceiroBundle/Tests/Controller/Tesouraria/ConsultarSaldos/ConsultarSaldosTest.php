<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Tesouraria\ConsultarSaldos;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConsultarSaldosTest extends DefaultWebTestCase
{
    public function testPaginaConsultar()
    {


        $crawler = $this->client->request('GET', '/financeiro/tesouraria/saldos/consultar-saldos');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ELISANDRA A. GOMES', $this->client->getResponse()->getContent());
    }
}