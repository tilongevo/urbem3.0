<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;

class ContratoServidorPeriodoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ContratoServidorPeriodo");
    }

    /**
     * @param Entity\Folhapagamento\PeriodoMovimentacao $periodoMovimentacao
     * @param Contrato                                  $contrato
     *
     * @return Entity\Folhapagamento\ContratoServidorPeriodo|ContratoServidorPeriodo
     */
    public function findOrCreateContratoServidorPeriodo(Entity\Folhapagamento\PeriodoMovimentacao $periodoMovimentacao, Contrato $contrato)
    {
        /** @var Entity\Folhapagamento\ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidorPeriodo = $this->repository->findOneBy([
            'codPeriodoMovimentacao' => $periodoMovimentacao->getCodPeriodoMovimentacao(),
            'codContrato' => $contrato->getCodContrato(),
        ]);

        if (is_null($contratoServidorPeriodo)) {
            /** @var Entity\Folhapagamento\ContratoServidorPeriodo $contratoServidorPeriodo */
            $contratoServidorPeriodo = new ContratoServidorPeriodo;
            $contratoServidorPeriodo->setFkFolhapagamentoPeriodoMovimentacao($periodoMovimentacao);
            $contratoServidorPeriodo->setFkPessoalContrato($contrato);
            $this->save($contratoServidorPeriodo);
        }

        return $contratoServidorPeriodo;
    }
}
