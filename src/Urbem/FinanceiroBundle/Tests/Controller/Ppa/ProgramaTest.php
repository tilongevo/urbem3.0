<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ProgramaTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/programa/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PLANEJAMENTO URBANO', $this->client->getResponse()->getContent());
    }

}
