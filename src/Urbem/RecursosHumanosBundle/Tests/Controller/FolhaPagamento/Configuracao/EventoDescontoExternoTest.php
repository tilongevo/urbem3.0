<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento\Configuracao;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EventoDescontoExternoTest extends DefaultWebTestCase
{
    public function testEventoDescontoExternoList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao-eventos-desconto-externo/list');
        $this->assertContains('DESDOBRAMENTO', $this->client->getResponse()->getContent());
    }

    public function testEventoDescontoExternoCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao-eventos-desconto-externo/create');
        $this->assertContains('Configuração Desconto Externo', $this->client->getResponse()->getContent());
    }

    public function testEventoDescontoExternoEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao-eventos-desconto-externo/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('DESDOBRAMENTO', $this->client->getResponse()->getContent());
    }
}
