<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Orcamento\ReservaSaldos;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ReservaSaldosTest extends DefaultWebTestCase
{
    public function testReservaSaldosList()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/reserva-saldos/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dotação', $this->client->getResponse()->getContent());
    }
    public function testReservaSaldosCreate()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/reserva-saldos/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados para Reserva de Saldos', $this->client->getResponse()->getContent());
    }
    public function testReservaSaldosEdit()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/reserva-saldos/1~2016/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Data da Anulação', $this->client->getResponse()->getContent());
    }
    public function testReservaSaldosShow()
    {


        $crawler = $this->client->request('GET', '/financeiro/orcamento/reserva-saldos/1~2016/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Número da Reserva', $this->client->getResponse()->getContent());
    }
}
