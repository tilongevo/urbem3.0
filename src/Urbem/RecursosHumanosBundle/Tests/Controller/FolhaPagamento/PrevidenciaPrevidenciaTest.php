<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PrevidenciaPrevidenciaTest extends DefaultWebTestCase
{
    public function testPrevidenciaPrevidenciaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/previdencia-previdencia/list');
        $this->assertContains('Previdência 01', $this->client->getResponse()->getContent());
    }

    public function testPrevidenciaPrevidenciaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/previdencia-previdencia/create');
        $this->assertContains('Regime Previdência', $this->client->getResponse()->getContent());
    }

    public function testPrevidenciaPrevidenciaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/previdencia-previdencia/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('08/09/2016', $this->client->getResponse()->getContent());
    }

    public function testPrevidenciaPrevidenciaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/previdencia-previdencia/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Previdência 01', $this->client->getResponse()->getContent());
    }

    public function testPrevidenciaPrevidenciaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/previdencia-previdencia/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Previdência 01', $this->client->getResponse()->getContent());
    }
}