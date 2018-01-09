<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class CompensacaoRenunciaModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * CompensacaoRenunciaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ldo\CompensacaoRenuncia");
    }


    /**
     * Retorna Array com exercicios de acordo com o PPA informado
     * @param $ppa
     * @param bool $sonata
     * @return array
     */
    public function getExercicioLdo($ppa, $sonata = false)
    {
        $sql = "
        SELECT
            ano_ldo,
            cod_ppa,
            ano
        FROM (SELECT
            (CAST(ppa.ano_inicio AS integer) + CAST(ldo.ano AS integer)) - 1 AS ano_ldo,
            ppa.cod_ppa,
            ldo.ano
        FROM ldo.ldo
        INNER JOIN ppa.ppa
            ON ppa.cod_ppa = ldo.cod_ppa) AS ldo
        WHERE ldo.cod_ppa = :cod_ppa";
        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_ppa', $ppa);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $ldos = array();
        foreach ($result as $key => $ldo) {
            if ($sonata) {
                $ldos[$ldo->ano_ldo] = $ldo->ano;
            } else {
                $ldos[$ldo->ano] = $ldo->ano_ldo;
            }
        }

        return $ldos;
    }

    /**
     * Retorna próximo codCompensacao a ser salvo
     * @param $codPpa
     * @param $ano
     * @return mixed
     */
    public function getLastCodCompensacao($codPpa, $ano)
    {
        return $this->repository->getLastCodCompensacao(
            $codPpa,
            $ano
        );
    }
}
