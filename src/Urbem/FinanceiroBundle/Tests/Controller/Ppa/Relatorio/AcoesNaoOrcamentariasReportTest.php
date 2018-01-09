<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AcoesNaoOrcamentariasReportTest extends DefaultWebTestCase
{
    public function testQueryOneRelatorio()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [74,4];
        $result = $entityManager->getRepository('CoreBundle:Ppa\AcoesNaoOrcamentariasReport')
            ->testQueryOneRelatorio($params);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryTwoRelatorio()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [74,4,1];
        $result = $entityManager->getRepository('CoreBundle:Ppa\AcoesNaoOrcamentariasReport')
            ->testQueryTwoRelatorio($params);

        $this->assertGreaterThan(-1, count($result));
    }


    public function testQueryThreeRelatorio()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $params = [74,4];
        $result = $entityManager->getRepository('CoreBundle:Ppa\AcoesNaoOrcamentariasReport')
            ->testQueryThreeRelatorio($params);

        $this->assertGreaterThan(-1, count($result));
    }
}