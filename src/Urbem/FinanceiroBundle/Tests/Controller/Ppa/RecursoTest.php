<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RecursoTest extends DefaultWebTestCase
{
    public function testRecursoList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/recursos/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Recurso Livre', $this->client->getResponse()->getContent());
    }

}
