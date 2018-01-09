<?php

namespace PatrimonialBundle\Tests\Controller\Compras;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class InventarioControllerTest extends DefaultWebTestCase
{
    public function testInventarioList()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Inventário', $client->getResponse()->getContent());
    }

    public function testInventarioPersist()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario/create');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Novo', $client->getResponse()->getContent());
    }

    public function testInventarioUpdate()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario/1~2016/edit');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Editar', $client->getResponse()->getContent());
    }

    public function testInventarioShow()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario/1~2016/show');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Detalhe', $client->getResponse()->getContent());
    }

    public function testInventarioDelete()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/patrimonio/inventario/1~2016/delete');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Apagar', $client->getResponse()->getContent());
    }
}
