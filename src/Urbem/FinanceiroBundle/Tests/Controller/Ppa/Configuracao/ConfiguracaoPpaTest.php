<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConfiguracaoPpaTest extends DefaultWebTestCase
{
    public function testConfiguracaoPpa()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/ppa/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('2010', $this->client->getResponse()->getContent());
    }

    public function testElaborarEstimativaPpa()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/ppa/estimativa/1');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RECEITAS CORRENTES', $this->client->getResponse()->getContent());
    }

    public function testHomologarPpa()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/ppa/homologar/2');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('2013', $this->client->getResponse()->getContent());
    }
}
