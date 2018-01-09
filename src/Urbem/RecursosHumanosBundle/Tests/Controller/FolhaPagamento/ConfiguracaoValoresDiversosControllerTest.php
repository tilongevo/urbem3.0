<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConfiguracaoValoresDiversosControllerTest extends DefaultWebTestCase
{
    public function testValoresDiversosList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Valor diverso I', $this->client->getResponse()->getContent());
    }

    public function testValoresDiversosCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Data de Vigência', $this->client->getResponse()->getContent());
    }

    public function testValoresDiversosEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Valor diverso I', $this->client->getResponse()->getContent());
    }

    public function testValoresDiversosDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Valor diverso I', $this->client->getResponse()->getContent());
    }

    public function testValoresDiversosShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Valor diverso I', $this->client->getResponse()->getContent());
    }
}
