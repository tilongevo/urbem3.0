<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Contabilidade\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SistemaContabilTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/contabilidade/configuracao/sistema-contabil/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Patrimonial', $this->client->getResponse()->getContent());
    }
}
