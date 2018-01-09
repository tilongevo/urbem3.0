<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConfiguracaoTotaisFolhaTest extends DefaultWebTestCase
{
    public function testConfiguracaoTotaisFolhaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/totais-folha/list');
        $this->assertContains('Totais Folha I', $this->client->getResponse()->getContent());
    }

    public function testConfiguracaoTotaisFolhaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/totais-folha/create');
        $this->assertContains('Configuração Totais Folha', $this->client->getResponse()->getContent());
    }

    public function testConfiguracaoTotaisFolhaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/totais-folha/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Totais Folha I', $this->client->getResponse()->getContent());
    }

    public function testConfiguracaoTotaisFolhaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/totais-folha/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Totais Folha I', $this->client->getResponse()->getContent());
    }

    public function testConfiguracaoTotaisFolhaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/totais-folha/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Totais Folha I', $this->client->getResponse()->getContent());
    }
}
