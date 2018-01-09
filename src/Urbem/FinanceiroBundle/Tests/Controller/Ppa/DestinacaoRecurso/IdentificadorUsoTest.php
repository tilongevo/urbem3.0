<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\DestinacaoRecurso;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class IdentificadorUsoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/destinacao-recursos/identificador-uso/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Contrapartida - Banco Internacional para a Reconstrução e o Desenvolvimento - BIRD', $this->client->getResponse()->getContent());
    }
}
