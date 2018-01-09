<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\Diarias;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class DiariaTest extends DefaultWebTestCase
{
    public function testDiariaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/diaria/list');
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }

    public function testDiariaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/diaria/create');
        $this->assertContains('Dados do Servidor', $this->client->getResponse()->getContent());
    }

    public function testDiariaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/diaria/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }

    public function testDiariaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/diaria/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Teste Diárias concessão I', $this->client->getResponse()->getContent());
    }

    public function testDiariaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/diaria/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('PREFEITURA MUNICIPAL DE MARIANA PIMENTEL', $this->client->getResponse()->getContent());
    }
}
