<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SalarioFamiliaTest extends DefaultWebTestCase
{
    public function testSalarioFamiliaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/salario-familia/list');
        $this->assertContains('RPPS', $this->client->getResponse()->getContent());
    }

    public function testSalarioFamiliaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/salario-familia/create');
        $this->assertContains('Dados do Salário-Família', $this->client->getResponse()->getContent());
    }

    public function testSalarioFamiliaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/salario-familia/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RPPS', $this->client->getResponse()->getContent());
    }

    public function testSalarioFamiliaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/salario-familia/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('11/10/2016', $this->client->getResponse()->getContent());
    }

    public function testSalarioFamiliaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/salario-familia/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('RPPS', $this->client->getResponse()->getContent());
    }
}
