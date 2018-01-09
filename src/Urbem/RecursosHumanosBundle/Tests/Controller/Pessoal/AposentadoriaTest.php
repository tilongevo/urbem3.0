<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class AposentadoriaTest extends DefaultWebTestCase
{
    public function testAposentadoriaList()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/aposentadoria/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ADRIANA PINZON', $this->client->getResponse()->getContent());
    }

    public function testAposentadoriaCreate()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/aposentadoria/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Data de Requerimento da Aposentadoria', $this->client->getResponse()->getContent());
    }

    public function testAposentadoriaEdit()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/aposentadoria/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('07/10/2016', $this->client->getResponse()->getContent());
    }

    public function testAposentadoriaPerfil()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/aposentadoria/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Na mesma data do RGPS', $this->client->getResponse()->getContent());
    }

    public function testAposentadoriaDelete()
    {


        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/aposentadoria/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;1095&quot; selecionado', $this->client->getResponse()->getContent());
    }
}
