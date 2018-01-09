<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AcaoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/acao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Operação Especial', $this->client->getResponse()->getContent());
    }

    public function testLancarMetas()
    {


        $crawler = $this->client->request('GET', '/financeiro/ppa/acao/lancar');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Lista de Ações - Recursos', $this->client->getResponse()->getContent());
    }
}
