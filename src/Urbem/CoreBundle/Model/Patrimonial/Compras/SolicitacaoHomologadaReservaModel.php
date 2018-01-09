<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

class SolicitacaoHomologadaReservaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoHomologada");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function findByCodSolicitacao($codSolicitacao)
    {
        return $this->repository->findByCodSolicitacao($codSolicitacao);
    }

    public function salvaSolicitacaoHomologadaReserva($exercicio, $solicitacao, $object, $orcamentoReservaSaldo, $comprasSolicitacaoItemDotacao, $despesa)
    {
        $solicitacaoHomologadaReserva = new SolicitacaoHomologadaReserva();
        $solicitacaoHomologadaReserva->setExercicio($exercicio);
        $solicitacaoHomologadaReserva->setCodEntidade($solicitacao->getCodEntidade());
        $solicitacaoHomologadaReserva->setCodSolicitacao($solicitacao->getCodSolicitacao());
        $solicitacaoHomologadaReserva->setCodItem($object->getCodItem());
        $solicitacaoHomologadaReserva->setCodCentro($object->getCodCentro());

        if ($orcamentoReservaSaldo->getFkComprasSolicitacaoHomologadaReservas()->first() != false) {
            $solicitacaoHomologadaReserva->setCodReserva($orcamentoReservaSaldo->getFkComprasSolicitacaoHomologadaReservas()->first()->getCodReserva());
        } else {
            $solicitacaoHomologadaReserva->setCodReserva(null);
        }

        $solicitacaoHomologadaReserva->setCodConta($comprasSolicitacaoItemDotacao->getCodConta());
        $solicitacaoHomologadaReserva->setCodDespesa($despesa);
        $this->save($solicitacaoHomologadaReserva);

        return $solicitacaoHomologadaReserva;
    }

    /**
     * @param SolicitacaoHomologada $solicitacaoHomologada
     * @param SolicitacaoItemDotacao $solicitacaoItemDotacao
     * @param ReservaSaldos $reservaSaldos
     * @return SolicitacaoHomologadaReserva
     */
    public function saveReservaSaldosObject(SolicitacaoHomologada $solicitacaoHomologada, SolicitacaoItemDotacao $solicitacaoItemDotacao, ReservaSaldos $reservaSaldos)
    {
        $solicitacaoHomologadaReserva = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoHomologadaReserva")
            ->findOneBy([
                'exercicio' => $solicitacaoItemDotacao->getExercicio(),
                'codEntidade' => $solicitacaoItemDotacao->getCodEntidade(),
                'codSolicitacao' => $solicitacaoItemDotacao->getCodSolicitacao(),
                'codCentro' => $solicitacaoItemDotacao->getCodCentro(),
                'codItem' => $solicitacaoItemDotacao->getCodItem(),
                'codConta' => $solicitacaoItemDotacao->getCodConta(),
                'codDespesa' => $solicitacaoItemDotacao->getCodDespesa(),
            ]);

        if (is_null($solicitacaoHomologadaReserva)) {
            $solicitacaoHomologadaReserva = new SolicitacaoHomologadaReserva();
            $solicitacaoHomologadaReserva->setFkComprasSolicitacaoHomologada($solicitacaoHomologada);
            $solicitacaoHomologadaReserva->setFkComprasSolicitacaoItemDotacao($solicitacaoItemDotacao);
            $solicitacaoHomologadaReserva->setFkOrcamentoReservaSaldos($reservaSaldos);
            $this->save($solicitacaoHomologadaReserva);
        }
        return $solicitacaoHomologadaReserva;
    }
}
