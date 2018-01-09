<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Model;

/**
 * Class HistoricoModel
 * @package Urbem\CoreBundle\Model\Empenho
 */
class HistoricoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * HistoricoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\Historico");
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getMaxByExercicio($exercicio)
    {
        $sql = "
        SELECT coalesce(max(p.cod_historico), 0) AS cod_historico
        FROM empenho.historico p where p.exercicio = '".$exercicio."';
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->cod_historico + 1;
    }

    /**
     * @param $exercicio
     * @param bool $nomHistorico
     * @return Historico
     */
    public function saveHistorico($exercicio, $nomHistorico = false)
    {
        $historico = new Historico();
        $historico->setExercicio($exercicio);
        $nomHistorico = ($nomHistorico) ? $nomHistorico : 'Não Informado';
        $historico->setNomHistorico($nomHistorico);
        $historico->setCodHistorico($this->getMaxByExercicio($exercicio));
        $this->save($historico);
        return $historico;
    }
}
