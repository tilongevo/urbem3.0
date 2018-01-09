<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 27/09/16
 * Time: 11:14
 */

namespace PatrimonialBundle\Tests\Controller\Almoxarifado;


use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class DevolucaoRequisicaoControllerTest extends DefaultWebTestCase
{
    public function testListDevolucaoRequisicao()
    {
        /**
         * @var \Symfony\Bundle\FrameworkBundle\Client $client
         */
        $client = $this->client;



        $crawler = $client->request('GET', '/patrimonial/almoxarifado/entrada/requisicao/devolucao/list');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}