<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\ClassificacaoFuncionalProgramatica;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class SubfuncaoTest extends DefaultWebTestCase
{
    public function testSubfuncaoList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/configuracao-funcional-programatica/subfuncao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('REFORMA AGRARIA', $this->client->getResponse()->getContent());
    }
}
