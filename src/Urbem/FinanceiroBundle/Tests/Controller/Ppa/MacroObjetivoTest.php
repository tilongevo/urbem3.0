<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class MacroObjetivoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/macro-objetivo/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('De 2010 até 2013', $this->client->getResponse()->getContent());
    }

}
