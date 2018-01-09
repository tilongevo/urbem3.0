<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 05/10/16
 * Time: 17:44
 */

namespace PatrimonialBundle\Tests\Controller\Almoxarifado;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class InventarioItensControllerTest extends DefaultWebTestCase
{
    public function testListInventarioItens()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/2016~1~1/show');

        $this->assertTrue($client->getResponse()->isSuccessful());

        // Colunas
        $this->assertContains('Quantidade Apurada', $client->getResponse()->getContent());
        $this->assertContains('Unidade de Medida', $client->getResponse()->getContent());
        $this->assertContains('Centro de Custo', $client->getResponse()->getContent());
        $this->assertContains('Classificação', $client->getResponse()->getContent());
        $this->assertContains('Saldo', $client->getResponse()->getContent());
        $this->assertContains('Ações', $client->getResponse()->getContent());
        $this->assertContains('Item', $client->getResponse()->getContent());

        // Valores das Colunas
        $this->assertContains('1', $client->getResponse()->getContent());
        $this->assertContains('AQUISIÇÃO DE MÓVEIS', $client->getResponse()->getContent());
        $this->assertContains("CAKES ATOMIC POWER - 25 TUBOS DE ", $client->getResponse()->getContent());
        $this->assertContains('Unidade', $client->getResponse()->getContent());
        $this->assertContains('ABBOTT', $client->getResponse()->getContent());
        $this->assertContains('GABINETE DO PREFEITO', $client->getResponse()->getContent());
        $this->assertContains('0,0000', $client->getResponse()->getContent());
        $this->assertContains('50,0000', $client->getResponse()->getContent());
    }

    /**
     * @TODO Gabriel irá arrumar esse teste
     */
    public function testEditInventarioItens()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/item/2016-10-05%2017:18:24/edit?cod_almoxarifado=2016~1~1');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertContains("Dados do Item", $client->getResponse()->getContent());
        $this->assertContains('Quantidade', $client->getResponse()->getContent());
        $this->assertContains('Salvar', $client->getResponse()->getContent());
        $this->assertContains('Justificativa', $client->getResponse()->getContent());
        $this->assertContains('Centro de Custo', $client->getResponse()->getContent());
        $this->assertContains('Entidade', $client->getResponse()->getContent());
        $this->assertContains('Marca', $client->getResponse()->getContent());
        $this->assertContains('Item', $client->getResponse()->getContent());

        $this->assertNotContains("Dados da Classificação", $client->getResponse()->getContent());
        $this->assertNotContains("Classificação", $client->getResponse()->getContent());
        $this->assertNotContains("Catálogo", $client->getResponse()->getContent());
    }

    public function testCreateInventarioItens()
    {
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/inventario/item/create?cod_almoxarifado=2016~1~1');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertContains("Dados do Item", $client->getResponse()->getContent());
        $this->assertContains('Quantidade', $client->getResponse()->getContent());
        $this->assertContains('Salvar', $client->getResponse()->getContent());
        $this->assertContains('Justificativa', $client->getResponse()->getContent());
        $this->assertContains('Centro de Custo', $client->getResponse()->getContent());
        $this->assertContains('Entidade', $client->getResponse()->getContent());
        $this->assertContains('Marca', $client->getResponse()->getContent());
        $this->assertContains('Item', $client->getResponse()->getContent());

        $this->assertContains("Dados da Classificação", $client->getResponse()->getContent());
        $this->assertContains("Classificação", $client->getResponse()->getContent());
        $this->assertContains("Catálogo", $client->getResponse()->getContent());
    }
}
