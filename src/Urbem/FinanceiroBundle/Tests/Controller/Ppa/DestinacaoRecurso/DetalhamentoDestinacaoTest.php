<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\DestinacaoRecurso;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class DetalhamentoDestinacaoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/destinacao-recursos/destinacao-detalhamento/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Sem Detalhamento da Destinação de Recursos', $this->client->getResponse()->getContent());
    }
}
