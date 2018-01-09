<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\Relatorio;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ProgramasMacroobjetivoTest extends DefaultWebTestCase
{
    public function testQueryRelatorioOneFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport')
            ->queryRelatorioOne(1);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryRelatorioTwoFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport')
            ->queryRelatorioTwo(1);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryRelatorioThreeFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport')
            ->queryRelatorioThree(1);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryRelatorioFourFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport')
            ->queryRelatorioFour(1);

        $this->assertGreaterThan(-1, count($result));
    }

    public function testQueryRelatorioFiveFunction()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Ppa\ProgramasMacroObjetivoReport')
            ->queryRelatorioFive(1,1,1);

        $this->assertGreaterThan(-1, count($result));
    }
}