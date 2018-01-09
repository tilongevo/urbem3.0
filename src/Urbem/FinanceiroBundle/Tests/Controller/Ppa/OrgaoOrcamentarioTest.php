<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class OrgaoOrcamentarioTest extends DefaultWebTestCase
{
    public function testOrgaoOrcamentarioList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/orgao-orcamentario/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('CAMARA MUNICIPAL DE VEREADORES', $this->client->getResponse()->getContent());
    }

}
