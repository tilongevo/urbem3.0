<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ProgramaSetorialTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/programa-setorial/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CÂMARA MUNICIPAL DE VEREADORES', $this->client->getResponse()->getContent());
    }

}
