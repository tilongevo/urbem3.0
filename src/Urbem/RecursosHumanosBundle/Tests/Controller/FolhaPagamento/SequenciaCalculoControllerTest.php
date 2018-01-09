<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SequenciaCalculoControllerTest extends DefaultWebTestCase
{
    public function testSequenciaCalculoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/sequencia-calculo/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descontos de Previdência', $this->client->getResponse()->getContent());
    }

    public function testSequenciaCalculoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/sequencia-calculo/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Complemento', $this->client->getResponse()->getContent());
    }

    public function testSequenciaCalculoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/sequencia-calculo/3/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descontos de Previdência', $this->client->getResponse()->getContent());
    }

    public function testSequenciaCalculoDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/sequencia-calculo/3/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descontos de Previdência', $this->client->getResponse()->getContent());
    }

    public function testSequenciaCalculoShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/sequencia-calculo/3/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Descontos de Previdência', $this->client->getResponse()->getContent());
    }
}
