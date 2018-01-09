<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class VinculoTest extends DefaultWebTestCase
{
    public function testVinculoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/vinculo/list');
        $this->assertContains('Ativo', $this->client->getResponse()->getContent());
    }

    public function testVinculoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/vinculo/create');
        $this->assertContains('Descrição', $this->client->getResponse()->getContent());
    }

    public function testVinculoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/vinculo/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Ativo', $this->client->getResponse()->getContent());
    }

    public function testVinculoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/vinculo/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Ativo', $this->client->getResponse()->getContent());
    }

    public function testVinculoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/vinculo/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Ativo', $this->client->getResponse()->getContent());
    }
}