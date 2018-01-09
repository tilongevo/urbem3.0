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
use Urbem\CoreBundle\Entity\Licitacao\Homologacao;

class HomologacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Homologacao");
    }

    public function montaRecuperaItensComStatus(
        $cod_licitacao = false,
        $cod_modalidade = false,
        $cod_entidade = false,
        $exercicio = false
    ) {
        return $this->repository->montaRecuperaItensComStatus(
            $cod_licitacao,
            $cod_modalidade,
            $cod_entidade,
            $exercicio
        );
    }

    /**
     *  @param Adjudicacao $adjudicacao
     *  @param \DateTime $datetime
     *  @param ModeloDocumento $documento
     */
    public function saveHomologacao($adjudicacao, $datetime, $documento)
    {
        $obtHomologacao = new Homologacao();
        $obtHomologacao->setFkLicitacaoAdjudicacao($adjudicacao);
        $obtHomologacao->setHomologado(true);
        $obtHomologacao->setFkAdministracaoModeloDocumento($documento);
        $obtHomologacao->setTimestamp($datetime);
        $obtHomologacao->setNumHomologacao($this->getUltimoNumHomologacao());

        $this->entityManager->persist($obtHomologacao);
    }

    /**
     * @return int
     *
     */
    public function getUltimoNumHomologacao()
    {
        $sql = "
        SELECT COALESCE(MAX(num_homologacao), 0) AS CODIGO
        FROM licitacao.homologacao
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }
}
