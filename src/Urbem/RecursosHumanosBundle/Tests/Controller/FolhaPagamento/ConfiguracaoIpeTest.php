<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Folhapagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConfiguracaoIpeTest extends DefaultWebTestCase
{
    public function testRecuperaRegistroDaListaDeIpers()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/ipers/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('20/09/2016', $this->client->getResponse()->getContent());
    }

    public function testValidaPaginaCriacaoIpers()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/ipers/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dinâmico Cadastro', $this->client->getResponse()->getContent());
    }

    public function testRecuperaRegistroShowDeIpers()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/ipers/2/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Pensao Alimenticia', $this->client->getResponse()->getContent());
    }

    public function testRecuperaRegistroEditDeIpers()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/ipers/2/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('BASE DED. IRRF S/P', $this->client->getResponse()->getContent());
    }

    public function testRecuperaRegistroDeleteDeIpers()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/ipers/2/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('20-09-2016', $this->client->getResponse()->getContent());
    }
}
