<?php

namespace PatrimonialBundle\Tests\Controller\Compras;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class InventarioHistoricoBemControllerTest extends DefaultWebTestCase
{
    public function testInventarioHistoricoBemPersist()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario-historico-bem/create?idInventario=1&exercicio=2016');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Inventário - Alterar Item', $client->getResponse()->getContent());
    }
}
