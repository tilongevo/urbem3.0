<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\Beneficio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class LayoutFornecedorTest extends DefaultWebTestCase
{
    public function testLayoutFornecedorList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/layout-fornecedor/list');
        $this->assertContains('JOEL GHISIO', $this->client->getResponse()->getContent());
    }

    public function testLayoutFornecedorCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/layout-fornecedor/create');
        $this->assertContains('Layout de importação do Plano de Saúde', $this->client->getResponse()->getContent());
    }

    public function testLayoutFornecedorEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/layout-fornecedor/2/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Medial', $this->client->getResponse()->getContent());
    }

    public function testLayoutFornecedorDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/layout-fornecedor/2/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Medial', $this->client->getResponse()->getContent());
    }

    public function testLayoutFornecedorShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/beneficio/layout-fornecedor/2/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('JOEL GHISIO', $this->client->getResponse()->getContent());
    }
}
