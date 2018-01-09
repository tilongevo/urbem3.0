<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 27/09/16
 * Time: 10:47
 */

namespace PatrimonialBundle\Tests\Controller\Almoxarifado;


use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EntradaControllerTest extends DefaultWebTestCase
{
    public function testHomeEntrada()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/entrada/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Entrada', $client->getResponse()->getContent());
    }
}
