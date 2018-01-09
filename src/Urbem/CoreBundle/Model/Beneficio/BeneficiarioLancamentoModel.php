<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Repository\Beneficio\BeneficiarioRepository;

class BeneficiarioLancamentoModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var BeneficiarioRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\\BeneficiarioLancamento");
    }

    /**
     * @param Entity\Beneficio\Beneficiario $beneficiarioOld
     * @param                               $valor
     *
     * @return Entity\Beneficio\BeneficiarioLancamento
     */
    public function buildOneBeneficiarioLancamentoBasedBaneficiario(Entity\Beneficio\Beneficiario $beneficiarioOld, $valor)
    {
        $beneficiarioLancamento = new Entity\Beneficio\BeneficiarioLancamento();
        $beneficiarioLancamento->setFkFolhapagamentoPeriodoMovimentacao($beneficiarioOld->getFkFolhapagamentoPeriodoMovimentacao());
        $beneficiarioLancamento->setFkBeneficioBeneficiario($beneficiarioOld);
        $beneficiarioLancamento->setValor(trim($valor));

        return $beneficiarioLancamento;
    }
}
