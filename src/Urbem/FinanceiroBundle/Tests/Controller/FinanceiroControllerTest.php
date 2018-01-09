<?php

namespace FinanceiroBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class FinanceiroControllerTest extends DefaultWebTestCase
{
    public function testHomeFinanceiro()
    {


        $crawler = $this->client->request('GET', '/financeiro/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Módulo Financeiro', $this->client->getResponse()->getContent());
    }
}