<?php

namespace Urbem\AdministrativoBundle\Tests\Controller\Organograma;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class OrgaoTest extends DefaultWebTestCase
{
    public function testOrgaoList()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/orgao/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('1.00.00', $this->client->getResponse()->getContent());
    }

    public function testOrgaoCreate()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/orgao/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Sigla', $this->client->getResponse()->getContent());
    }

    public function testOrgaoEdit()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/orgao/12/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Inativar Órgão', $this->client->getResponse()->getContent());
    }

    public function testOrgaoShow()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/orgao/12/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('14/06/2005', $this->client->getResponse()->getContent());
    }

    public function testOrgaoDelete()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/orgao/12/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('12', $this->client->getResponse()->getContent());
    }
}
