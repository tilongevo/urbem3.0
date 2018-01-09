<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ConfiguracaoTest extends DefaultWebTestCase
{
    public function testConfiguracaoId22()
    {


        $crawler = $this->client->request('GET', '/administrativo/administracao/configuracao/create?id=22');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('999999', $this->client->getResponse()->getContent());
    }
}
