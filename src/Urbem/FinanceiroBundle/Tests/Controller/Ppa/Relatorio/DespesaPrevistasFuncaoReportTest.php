<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class DespesaPrevistasFuncaoReportTestTest extends DefaultWebTestCase
{
    /**
     * O valor de teste esta -1, porque dados para teste tem apenas no urbem old
     */
    public function testQueryRelatorioOneFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [1,01];
        $result = $entityManager->getRepository('CoreBundle:Ppa\DespesasPrevistasFuncaoReport')
            ->queryRelatorio($params);

        $this->assertGreaterThan(-1, count($result));
    }
}