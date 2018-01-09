<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\FolhaPagamento;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class CalculoPensaoAlimenticiaTest extends DefaultWebTestCase
{
    public function testCalculoPensaoAlimenticiaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/folha-pagamento/pensao-funcao-padrao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('pega1QtdDependentesPensaoAlimenticia', $this->client->getResponse()->getContent());
    }
}
