<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\DestinacaoRecurso;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EspecificacaoDestinacaoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/destinacao-recursos/especificacao-destinacao-recurso/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Recursos Ordinários', $this->client->getResponse()->getContent());
    }
}
