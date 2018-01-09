<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Beneficio;
use Urbem\CoreBundle\Entity\Pessoal;

class ContratoServidorConcessaoValeTransporteModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\ContratoServidorConcessaoValeTransporte");
    }

    public function getCgm($contratoServidor)
    {
        $servidor = $contratoServidor->getCodServidor();
        $cgmPessoaFisica = $servidor->getNumcgm();
        $cgm = $this->entityManager->getRepository("CoreBundle:SwCgm")->find($cgmPessoaFisica);

        return $cgm;
    }
}
