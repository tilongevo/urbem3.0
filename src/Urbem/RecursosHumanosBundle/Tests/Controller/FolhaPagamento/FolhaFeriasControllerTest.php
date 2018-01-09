<?php

namespace RecursosHumanosBundle\Tests\Controller\Folhapagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class FolhaFeriasControllerTest extends DefaultWebTestCase
{
    public function testeEmitirAvisoFeriasCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/relatorios/emitir-aviso-ferias/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('JOEL GHISIO', $this->client->getResponse()->getContent());
    }

    public function testeQueryRelatorioEmitirAvisoFerias()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $avisoFeriasFunction = $entityManager->getRepository('CoreBundle:Folhapagamento\EmitirAvisoFeriasReport')
            ->relatorioAvisoDeFerias(2016);

        $this->assertGreaterThan(-1, count($avisoFeriasFunction));
    }

    public function testeQueryRelatorioEmitirAvisoFeriasPj()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $avisoFeriasPjFunction = $entityManager->getRepository('CoreBundle:Folhapagamento\EmitirAvisoFeriasReport')
            ->relatorioEmitirAvisoFeriasPj();

        $this->assertGreaterThan(0, count($avisoFeriasPjFunction));
    }
}