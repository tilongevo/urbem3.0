<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Empenho;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AutorizacaoAnuladaTest extends DefaultWebTestCase
{
    public function testCreate()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/anular-autorizacao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Anular Autorização', $this->client->getResponse()->getContent());
    }
}
