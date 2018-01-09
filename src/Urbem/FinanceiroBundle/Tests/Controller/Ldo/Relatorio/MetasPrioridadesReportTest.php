<?php


namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class MetasPrioridadesReportTest extends DefaultWebTestCase
{
    public function testQueryRelatorioOneFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = ['1','1',1057,'2010','2015'];
        $result = $entityManager->getRepository('CoreBundle:Ldo\MetasPrioridadesReport')
            ->testQueryRelatorioOneFunction($params);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testCreateRelatorioLdo()
    {


        $crawler = $this->client->request('GET', '/financeiro/ldo/metas-prioridades-report/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('De 2010 até 2013', $this->client->getResponse()->getContent());
    }
}