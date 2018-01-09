<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class ServidorTest extends DefaultWebTestCase
{
    public function testGestaoServidorList()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/servidor/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('ADRIANO LUIZ KUBIAK', $this->client->getResponse()->getContent());
    }

    public function testGestaoServidorCreate()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/servidor/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados de Identificação', $this->client->getResponse()->getContent());
    }

    public function testGestaoServidorEdit()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/servidor/3/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('LEONIDA TERESA KUBIAK', $this->client->getResponse()->getContent());
    }

    public function testGestaoServidorPerfil()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/servidor/perfil?id=3');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('91594375020', $this->client->getResponse()->getContent());
    }

    public function testGestaoServidorDelete()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/servidor/6/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Você tem certeza que deseja remover o item &quot;6&quot; selecionado?', $this->client->getResponse()->getContent());
    }
}
