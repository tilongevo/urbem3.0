<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento\RotinaMensal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PeriodoMovimentacaoTest extends DefaultWebTestCase
{
    public function testPeriodoMovimentacaoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/periodo-movimentacao/list');
        $this->assertContains('1970', $this->client->getResponse()->getContent());
    }

    public function testPeriodoMovimentacaoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/periodo-movimentacao/create');
        $this->assertContains('Período Movimentação', $this->client->getResponse()->getContent());
    }

    public function testPeriodoMovimentacaoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/periodo-movimentacao/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1970', $this->client->getResponse()->getContent());
    }

    public function testPeriodoMovimentacaoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/periodo-movimentacao/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1970', $this->client->getResponse()->getContent());
    }
}
