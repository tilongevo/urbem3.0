<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

class SolicitacaoItemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoItem");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function findByCodSolicitacao($codSolicitacao)
    {
        return $this->repository->findByCodSolicitacao($codSolicitacao);
    }

    /**
     * @param SolicitacaoItem $solicitacaoItemOriginal
     * @param Solicitacao $solicitacao
     * @return SolicitacaoItem
     */
    public function buildOneBasedOnSolicitacaoItem(SolicitacaoItem $solicitacaoItemOriginal, Solicitacao $solicitacao)
    {
        $solicitacaoItem = $this->repository
            ->findOneBy([
                'exercicio' => $solicitacao->getExercicio(),
                'codSolicitacao' => $solicitacao->getCodSolicitacao(),
                'codEntidade' => $solicitacao->getCodEntidade(),
                'codCentro' => $solicitacaoItemOriginal->getCodCentro(),
                'codItem' => $solicitacaoItemOriginal->getCodItem()
            ]);

        if (is_null($solicitacaoItem)) {
            $solicitacaoItem = new SolicitacaoItem();
            $solicitacaoItem->setFkComprasSolicitacao($solicitacao);
            $solicitacaoItem->setFkAlmoxarifadoCatalogoItem($solicitacaoItemOriginal->getFkAlmoxarifadoCatalogoItem());
            $solicitacaoItem->setFkAlmoxarifadoCentroCusto($solicitacaoItemOriginal->getFkAlmoxarifadoCentroCusto());
            $solicitacaoItem->setVlTotal($solicitacaoItemOriginal->getVlTotal());
            $solicitacaoItem->setQuantidade($solicitacaoItemOriginal->getQuantidade());
            $solicitacaoItem->setComplemento($solicitacaoItemOriginal->getComplemento());
            $this->save($solicitacaoItem);
        }

        return $solicitacaoItem;
    }
}
