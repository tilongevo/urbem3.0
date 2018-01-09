<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Empenho;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PreEmpenhoTest extends DefaultWebTestCase
{
    public function testList()
    {


        $crawler = $this->client->request('GET', '/financeiro/empenho/autorizacao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('10/10/2016', $this->client->getResponse()->getContent());
    }
}
