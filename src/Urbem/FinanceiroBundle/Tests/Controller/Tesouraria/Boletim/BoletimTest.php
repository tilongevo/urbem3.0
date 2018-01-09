<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Tesouraria\Boletim;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class BoletimTest extends DefaultWebTestCase
{
    public function testAbrirBoletimCreate()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/boletim/abrir-boletim/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ALMOXARIFADO CENTRAL', $this->client->getResponse()->getContent());
    }

    public function testPerfilBoletim()
    {
        $crawler = $this->client->request('GET', '/financeiro/tesouraria/boletim/1/1/2016/profile');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('05/10/2016', $this->client->getResponse()->getContent());
    }
}