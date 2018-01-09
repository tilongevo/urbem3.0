<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ResumoDespesasProgramasReportTest extends DefaultWebTestCase
{
    public function testQueryRelatorioOneFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();
        $params = [4];
        $result = $entityManager->getRepository('CoreBundle:Ppa\ResumoDespesasProgramasReport')
            ->queryRelatorioOne($params);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryRelatorioTwoFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [1,4];
        $result = $entityManager->getRepository('CoreBundle:Ppa\ResumoDespesasProgramasReport')
            ->queryRelatorioTwo($params);

        $this->assertGreaterThan(-1, count($result));
    }
}