<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\AdjudicacaoAnulada;
use Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao;

class AdjudicacaoAnuladaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\AdjudicacaoAnulada");
    }

    /**
     *  @param CotacaoLicitacao $cotacaoLicitacao
     *  @param array $item
     */
    public function saveAdjudicacaoAnulada($cotacaoLicitacao, $item)
    {
        $obTLicitacaoAdjudicacao = new AdjudicacaoAnulada();
        $obTLicitacaoAdjudicacao->setFkLicitacaoAdjudicacao($cotacaoLicitacao->getFkLicitacaoAdjudicacoes()->first());
        $obTLicitacaoAdjudicacao->setTimestamp(new \DateTime());
        $obTLicitacaoAdjudicacao->setMotivo($item->justificativa_anulacao);
        $obTLicitacaoAdjudicacao->setNumAdjudicacao($this->getUltimoNumAdjudicacao());

        $this->entityManager->persist($obTLicitacaoAdjudicacao);
    }

    public function getUltimoNumAdjudicacao()
    {
        $sql = "
        SELECT COALESCE(MAX(num_adjudicacao), 0) AS CODIGO
        FROM licitacao.adjudicacao_anulada
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }
}
