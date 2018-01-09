<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\DestinacaoRecurso;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class GrupoDestinacaoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/destinacao-recurso/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Recursos do Tesouro - Exercício Corrente', $this->client->getResponse()->getContent());
    }
}
