<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class PensaoControllerTest extends DefaultWebTestCase
{
    public function testListPensao()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ADRIANA PINZON', $this->client->getResponse()->getContent());
    }

    public function testCreatePensao()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/pensao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ADRIANA PINZON', $this->client->getResponse()->getContent());
    }
}
