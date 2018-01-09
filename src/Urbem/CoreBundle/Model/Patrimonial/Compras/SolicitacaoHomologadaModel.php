<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

class SolicitacaoHomologadaModel extends AbstractModel
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

    public function salvaSolicitacaoHomologada($exercicio, $solicitacao)
    {
        $solicitacaoHomologacao = $this->repository
            ->findOneBy([
                'exercicio' => $solicitacao->getExercicio(),
                'codEntidade' => $solicitacao->getCodEntidade(),
                'codSolicitacao' => $solicitacao->getCodSolicitacao()
            ]);

        if (is_null($solicitacaoHomologacao)) {
            $solicitacaoHomologacao = new SolicitacaoHomologada();
            $solicitacaoHomologacao->setExercicio($exercicio);
            $solicitacaoHomologacao->setCodEntidade($solicitacao->getCodEntidade());
            $solicitacaoHomologacao->setCodSolicitacao($solicitacao);
            $solicitacaoHomologacao->setNumcgm($solicitacao->getCgmRequisitante());
            $solicitacaoHomologacao->setFkComprasSolicitacao($solicitacao);
            $this->save($solicitacaoHomologacao);
        }

        return $solicitacaoHomologacao;
    }
}
