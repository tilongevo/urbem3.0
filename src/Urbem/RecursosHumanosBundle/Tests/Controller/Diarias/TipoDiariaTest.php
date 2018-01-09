<?php
namespace Urbem\RecursosHumanosBundle\Tests\Controller\Beneficio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class TipoDiariaTest extends DefaultWebTestCase
{
    public function testTipoDiariaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/tipo-diaria/list');
        $this->assertContains('852/2013', $this->client->getResponse()->getContent());
    }

    public function testTipoDiariaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/tipo-diaria/create');
        $this->assertContains('Tipo de Diária', $this->client->getResponse()->getContent());
    }

    public function testTipoDiariaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/tipo-diaria/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Abre Crédito Suplementar', $this->client->getResponse()->getContent());
    }

    public function testTipoDiariaDelete()
    {


        $crawler = $this->client->request('GET', 'recursos-humanos/diarias/tipo-diaria/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Diária', $this->client->getResponse()->getContent());
    }

    public function testTipoDiariaShow()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/diarias/tipo-diaria/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('852/2013', $this->client->getResponse()->getContent());
    }
}
