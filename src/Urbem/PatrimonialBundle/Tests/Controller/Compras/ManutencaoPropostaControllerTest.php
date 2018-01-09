<?php

namespace PatrimonialBundle\Tests\Controller\Compras;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ManutencaoPropostaControllerTest extends DefaultWebTestCase
{
    public function testManutencaoPropostaList()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/manutencao-proposta/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Manutenção Proposta', $client->getResponse()->getContent());
    }

    public function testManutencaoPropostaShow()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/manutencao-proposta/1/show');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Detalhe', $client->getResponse()->getContent());
    }

    public function testManutencaoPropostaEdit()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/compras/manutencao-proposta/1/edit');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Editar', $client->getResponse()->getContent());
    }
}
