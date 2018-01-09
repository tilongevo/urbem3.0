<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Contabilidade\Lote;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class LoteTest extends DefaultWebTestCase
{
    public function testLoteList()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/lancamento-contabil/lancamento/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Pagamento de Empenho n° 2/2016', $this->client->getResponse()->getContent());
    }
    public function testLoteCreate()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/lancamento-contabil/lancamento/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Nome do Lote', $this->client->getResponse()->getContent());
    }
    public function testLoteEdit()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/lancamento-contabil/lancamento/2~2016~P~1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Emitir nota após efetuar o lançamento', $this->client->getResponse()->getContent());
    }
}
