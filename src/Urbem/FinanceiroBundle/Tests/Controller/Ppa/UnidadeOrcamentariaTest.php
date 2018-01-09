<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class UnidadeOrcamentariaTest extends DefaultWebTestCase
{
    public function testUnidadeOrcamentariaList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/unidade-orcamentaria/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('UNIDADE SUBORDINADA', $this->client->getResponse()->getContent());
    }

}
