<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ProdutoTest extends DefaultWebTestCase
{
    public function testProdutoList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/produto/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Equipamentos  adquirido', $this->client->getResponse()->getContent());
    }

}
