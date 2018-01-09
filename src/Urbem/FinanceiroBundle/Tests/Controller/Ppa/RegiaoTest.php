<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RegiaoTest extends DefaultWebTestCase
{
    public function testOrgaoOrcamentarioList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/regiao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Linha Dr. Inácio', $this->client->getResponse()->getContent());
    }

}
