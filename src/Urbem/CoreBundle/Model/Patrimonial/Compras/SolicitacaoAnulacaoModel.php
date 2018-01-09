<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class SolicitacaoAnulacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoAnulacao");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function getSolicitacoesParaAnulacao()
    {
        return $this->repository->getSolicitacoesParaAnulacao();
    }

    /**
     * @param $codSolicitacao
     * @param $exercicio
     * @return null|object
     */
    public function getOneSolicitacaoAnulacao($codSolicitacao, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codSolicitacao' => $codSolicitacao,
        ]);
    }
}
