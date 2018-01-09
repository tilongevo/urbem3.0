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
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\AdjudicacaoRepository;

class AdjudicacaoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null  */
    protected $entityManager = null;
    /** @var AdjudicacaoRepository|ORM\EntityRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Adjudicacao");
    }

    /**
     * @param bool|false $codLicitacao
     * @param bool|false $codModalidade
     * @param bool|false $codEntidade
     * @param bool|false $exercicio
     * @return mixed
     */
    public function montaRecuperaItensComStatus(
        $codLicitacao = false,
        $codModalidade = false,
        $codEntidade = false,
        $exercicio = false
    ) {
        return $this->repository->montaRecuperaItensComStatus(
            $codLicitacao,
            $codModalidade,
            $codEntidade,
            $exercicio
        );
    }

    /**
     * @param Licitacao $licitacao
     * @param CotacaoLicitacao $cotacaoLicitacao
     * @param $formData
     * @param ModeloDocumento $documento
     */
    public function saveAdjudicacao(
        Licitacao $licitacao,
        CotacaoLicitacao $cotacaoLicitacao,
        \DateTime $datetime,
        ModeloDocumento $documento
    ) {
        $obTLicitacaoAdjudicacao = new Adjudicacao();
        $obTLicitacaoAdjudicacao->setFkLicitacaoCotacaoLicitacao($cotacaoLicitacao);
        $obTLicitacaoAdjudicacao->setAdjudicado(true);
        $obTLicitacaoAdjudicacao->setFkAdministracaoModeloDocumento($documento);
        $obTLicitacaoAdjudicacao->setTimestamp($datetime);
        $obTLicitacaoAdjudicacao->setNumAdjudicacao($this->getUltimoNumAdjudicacao());
        $obTLicitacaoAdjudicacao->setFkLicitacaoLicitacao($licitacao);

        $this->entityManager->persist($obTLicitacaoAdjudicacao);
    }

    /**
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getUltimoNumAdjudicacao()
    {
        $sql = "
        SELECT COALESCE(MAX(num_adjudicacao), 0) AS CODIGO
        FROM licitacao.adjudicacao
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }
}
