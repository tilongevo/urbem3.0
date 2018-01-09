<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Tesouraria\ReciboExtra;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ReciboExtraTest extends DefaultWebTestCase
{
    public function testReciboExtraList()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/recibo-receita-extra/list');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Tipo de Recibo', $this->client->getResponse()->getContent());
        $this->assertNotContains('1/2016', $this->client->getResponse()->getContent());
    }

    public function testReciboExtraCreate()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/recibo-receita-extra/create');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Tipo de Recibo', $this->client->getResponse()->getContent());
    }

    public function testReciboExtraDelete()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/recibo-receita-extra/1~2016~2~R/delete');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1/2016', $this->client->getResponse()->getContent());
    }
    
    public function testReciboExtraShow()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/recibo-receita-extra/1~2016~2~R/show');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('R$331,82', $this->client->getResponse()->getContent());
    }
}