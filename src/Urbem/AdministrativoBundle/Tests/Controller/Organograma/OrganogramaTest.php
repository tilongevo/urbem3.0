<?php

namespace Urbem\AdministrativoBundle\Tests\Controller\Organograma;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class OrganogramaTest extends DefaultWebTestCase
{
    public function testOrganogramaList()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/organograma/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('14/06/2005', $this->client->getResponse()->getContent());
    }

    public function testOrganogramaCreate()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/organograma/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Data de implantação', $this->client->getResponse()->getContent());
    }

    public function testOrganogramaEdit()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/organograma/2/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Órgão', $this->client->getResponse()->getContent());
    }

    public function testOrganogramaShow()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/organograma/2/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('14/06/2005', $this->client->getResponse()->getContent());
    }

    public function testOrganogramaDelete()
    {


        $crawler = $this->client->request('GET', '/administrativo/organograma/organograma/2/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('14/06/2005', $this->client->getResponse()->getContent());
    }
}
