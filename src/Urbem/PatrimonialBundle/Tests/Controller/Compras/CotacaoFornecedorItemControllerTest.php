<?php

namespace PatrimonialBundle\Tests\Controller\Compras;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CotacaoFornecedorItemControllerTest extends DefaultWebTestCase
{
    public function testCotacaoFornecedorItemPersist()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/cotacao-fornecedor-item/create?codCotacao=8&exercicioCotacao=2016');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Fornecedor-Item - Novo', $client->getResponse()->getContent());
    }

    public function testCotacaoFornecedorItemUpdate()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/cotacao-fornecedor-item/1/edit');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Fornecedor-Item - Editar', $client->getResponse()->getContent());
    }

    public function testCotacaoFornecedorItemDelete()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/cotacao-fornecedor-item/1/delete');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Fornecedor-Item - Apagar', $client->getResponse()->getContent());
    }
}
