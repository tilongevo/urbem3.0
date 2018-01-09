<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EstimativaReceitaTest extends DefaultWebTestCase
{
    public function testEstimativaReceitaFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $estimativaReceitaFunction = $entityManager->getRepository('CoreBundle:Ppa\Ppa')
            ->getEstimativaReceita(1);

        $this->assertGreaterThan(0, count($estimativaReceitaFunction));
    }
}
