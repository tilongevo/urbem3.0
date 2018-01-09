<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\InformacoesMensais\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class BanparaTest extends DefaultWebTestCase
{
    public function testBanparaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/informacoes/configuracao/banpara/list');
        $this->assertContains('Banpará config', $this->client->getResponse()->getContent());
    }

    public function testBanparaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/informacoes/configuracao/banpara/create');
        $this->assertContains('Configuração de Orgãos', $this->client->getResponse()->getContent());
    }

    public function testBanparaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/informacoes/configuracao/banpara/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Banpará config', $this->client->getResponse()->getContent());
    }

    public function testBanparaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/informacoes/configuracao/banpara/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Banpará config', $this->client->getResponse()->getContent());
    }

    public function testBanparaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/informacoes/configuracao/banpara/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Banpará config', $this->client->getResponse()->getContent());
    }
}
