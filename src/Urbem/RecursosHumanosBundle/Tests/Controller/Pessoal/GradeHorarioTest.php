<?php

namespace Urbem\RecursosHumanosBundle\Tests\Controller\Pessoal;

use Urbem\CoreBundle\Tests\Functional\DefaultWebTestCase;

class GradeHorarioTest extends DefaultWebTestCase
{
    public function testGradeHorarioList()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/grade-horario/list');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Turno Integral', $this->client->getResponse()->getContent());
    }

    public function testGradeHorarioCreate()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/grade-horario/create');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Dados da Grade', $this->client->getResponse()->getContent());
    }

    public function testGradeHorarioEdit()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/grade-horario/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Turno Integral', $this->client->getResponse()->getContent());
    }

    public function testGradeHorarioShow()
    {
        

        $crawler = $this->client->request('GET', '/recursos-humanos/pessoal/grade-horario/1/show');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Turno Integral', $this->client->getResponse()->getContent());
    }

    public function testGradeHorarioDelete()
    {
        

        $crawler = $this->client->request('GET', 'recursos-humanos/pessoal/grade-horario/1/delete');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('Turno Integral', $this->client->getResponse()->getContent());
    }
}
