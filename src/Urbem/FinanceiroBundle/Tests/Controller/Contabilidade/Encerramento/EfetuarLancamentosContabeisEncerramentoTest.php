<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Contabilidade\Encerramento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class EfetuarLancamentosContabeisEncerramentoTest extends DefaultWebTestCase
{
    public function testFezEncerramentoAnualLancamentosVariacoesPatrimoniais2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->fezEncerramentoAnualLancamentosVariacoesPatrimoniais2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testFezEncerramentoAnualLancamentosOrcamentario2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->fezEncerramentoAnualLancamentosOrcamentario2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testFezEncerramentoAnualLancamentosControle2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->fezEncerramentoAnualLancamentosControle2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testEncerramentoAnualLancamentosVariacoesPatrimoniais2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->encerramentoAnualLancamentosVariacoesPatrimoniais2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testEncerramentoAnualLancamentosOrcamentario2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->encerramentoAnualLancamentosOrcamentario2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testEncerramentoAnualLancamentosControle2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->encerramentoAnualLancamentosControle2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testExcluiEncerramentoAnualLancamentosVariacoesPatrimoniais2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->excluiEncerramentoAnualLancamentosVariacoesPatrimoniais2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testExcluiEncerramentoAnualLancamentosOrcamentario2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->excluiEncerramentoAnualLancamentosOrcamentario2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }

    public function testExcluiencerramentoanuallancamentoscontrole2013()
    {


        $entityManager = $this->container->get('doctrine')->getManager();

        $result = $entityManager->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->excluiencerramentoanuallancamentoscontrole2013('2016', '1');

        $this->assertGreaterThan(0, count($result));
    }
}
