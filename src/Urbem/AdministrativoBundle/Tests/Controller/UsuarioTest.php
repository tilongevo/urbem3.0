<?php

namespace Urbem\AdministrativoBundle\Tests\Controller;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class UsuarioTest extends DefaultWebTestCase
{
    public function testChangePassword()
    {
        /*
         * @TODO o Rafa vai verificar esse teste
         */

        $crawler = $this->client->request('GET', '/administrativo/administracao/usuarios/1/change-password');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Confirmação Senha', $this->client->getResponse()->getContent());
    }
}
