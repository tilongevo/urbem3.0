<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Empenho;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EmitirEmpenhoAutorizacaoTest extends DefaultWebTestCase
{
    public function testList()
    {
        $crawler = $this->client->request('GET', '/financeiro/empenho/emitir-empenho-autorizacao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('10/10/2016', $this->client->getResponse()->getContent());
    }

    public function testEdit()
    {
        $crawler = $this->client->request('GET', '/financeiro/empenho/emitir-empenho-autorizacao/3~2016/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('3.1.9.0.04.01.03.00.00 - CONTRATAÇÃO POR TEMPO DETERMINADO DE PROFESSORES EFETIVOS 60% FUNDEB', $this->client->getResponse()->getContent());
    }
}
