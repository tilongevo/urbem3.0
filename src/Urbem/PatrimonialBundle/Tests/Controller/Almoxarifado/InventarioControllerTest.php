<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 05/10/16
 * Time: 17:22
 */

namespace PatrimonialBundle\Tests\Controller\Almoxarifado;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class InventarioControllerTest extends DefaultWebTestCase
{
    public function testListInventario()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Exercício', $client->getResponse()->getContent());
        $this->assertContains('Código', $client->getResponse()->getContent());
        $this->assertContains('Almoxarifado', $client->getResponse()->getContent());
        $this->assertContains('ALMOXARIFADO CENTRAL', $client->getResponse()->getContent());
    }

    public function testCreateInventario()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/create');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Dados do Inventário', $client->getResponse()->getContent());
        $this->assertContains('Almoxarifado', $client->getResponse()->getContent());
        $this->assertContains('Observação', $client->getResponse()->getContent());
        $this->assertContains('Exercício', $client->getResponse()->getContent());
        $this->assertContains('Salvar', $client->getResponse()->getContent());
    }

    public function testShowInventario()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/2016~1~1/show');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('1/2016', $client->getResponse()->getContent());
        $this->assertContains('Código', $client->getResponse()->getContent());
        $this->assertContains('Observação', $client->getResponse()->getContent());
        $this->assertContains('Inventário:', $client->getResponse()->getContent());
        $this->assertContains('Almoxarifado', $client->getResponse()->getContent());
        $this->assertContains('ALMOXARIFADO CENTRAL', $client->getResponse()->getContent());
        $this->assertContains('Não obstante, a necessidade de renovação processual estimula a padronização do investimento em reciclagem técnica.', $client->getResponse()->getContent());
    }
}
