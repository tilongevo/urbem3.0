<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class DespesaFonteRecursoReportTest extends DefaultWebTestCase
{
    public function testQueryRelatorioOneFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [2010,2011,2012,2013,1];
        $result = $entityManager->getRepository('CoreBundle:Ppa\DespesaFonteRecursoReport')
            ->queryRelatorio($params);

        $this->assertGreaterThan(0, count($result));
    }
}