<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 27/09/16
 * Time: 10:47
 */

namespace PatrimonialBundle\Tests\Controller\Licitacao;


use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class LicitacaoControllerTest extends DefaultWebTestCase
{
    public function testListLicitacao()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', 'patrimonial/licitacao/licitacao/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Licitação :: Processo Licitatório', $client->getResponse()->getContent());
    }

    public function testPerfilLicitacao()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/licitacao/licitacao/perfil?id=1~3~2~2016');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Dados da Licitação: 1', $client->getResponse()->getContent());
    }

    public function testMembroAdicionalLicitacao()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/licitacao/membro-adicional/create?id=1~3~2~2016');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Membro Adicional', $client->getResponse()->getContent());
    }

    public function testDocumentosLicitacao()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/licitacao/licitacao-documentos/create?id=1~3~2~2016');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertContains('Licitação Documentos', $client->getResponse()->getContent());
    }

     public function testParticipantesLicitacao()
     {
         /**
          * @var \Symfony\Bundle\FrameworkBundle\Client $client
          */
         $client = $this->client;



         $crawler = $client->request('GET', '/patrimonial/licitacao/participante/create?id=1~3~2~2016');

         $this->assertTrue($client->getResponse()->isSuccessful());
         $this->assertContains('Participante', $client->getResponse()->getContent());
     }
}
