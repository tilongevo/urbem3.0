<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PadraoSalarialTest extends DefaultWebTestCase
{
    public function testPadraoSalarialList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/padrao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Padrão 01', $this->client->getResponse()->getContent());
    }

    public function testPadraoSalarialCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/padrao/recursos-humanos/folha-pagamento/padrao/novo');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descrição', $this->client->getResponse()->getContent());
    }

    public function testPadraoSalarialEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/padrao/1/editar');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Padrão 01', $this->client->getResponse()->getContent());
    }

    public function testPadraoSalarialDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/padrao/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Padrão 01', $this->client->getResponse()->getContent());
    }

    public function testPadraoSalarialShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/padrao/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Padrão 01', $this->client->getResponse()->getContent());
    }
}
