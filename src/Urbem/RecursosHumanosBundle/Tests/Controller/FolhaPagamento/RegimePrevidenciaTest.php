<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class RegimePrevidenciaTest extends DefaultWebTestCase
{
    public function testRegimePrevidenciaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/regime-previdencia/list');
        $this->assertContains('RGPS', $this->client->getResponse()->getContent());
    }

    public function testRegimePrevidenciaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/regime-previdencia/create');
        $this->assertContains('Regime Previdência', $this->client->getResponse()->getContent());
    }

    public function testRegimePrevidenciaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/regime-previdencia/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RGPS', $this->client->getResponse()->getContent());
    }

    public function testRegimePrevidenciaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/regime-previdencia/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RGPS', $this->client->getResponse()->getContent());
    }

    public function testRegimePrevidenciaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/regime-previdencia/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RGPS', $this->client->getResponse()->getContent());
    }
}