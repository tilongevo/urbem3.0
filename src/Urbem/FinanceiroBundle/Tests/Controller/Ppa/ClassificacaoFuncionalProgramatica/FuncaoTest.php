<?php

namespace Urbem\FinanceiroBundle\Tests\Controller\Ppa\ClassificacaoFuncionalProgramatica;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class FuncaoTest extends DefaultWebTestCase
{
    public function testFuncaoList()
    {


        $crawler = $this->client->request('GET', '/financeiro/plano-plurianual/configuracao-funcional-programatica/funcao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('LEGISLATIVA', $this->client->getResponse()->getContent());
    }
}
