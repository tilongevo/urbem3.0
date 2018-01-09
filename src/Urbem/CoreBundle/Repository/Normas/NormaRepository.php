<?php

namespace Urbem\CoreBundle\Repository\Normas;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM;

class NormaRepository extends ORM\EntityRepository
{
    /**
     * @param string|null $exercicio
     * @param string|null $nomNorma
     * @return ORM\QueryBuilder
     */
    public function getNormasPorExercicio($exercicio = null, $term = null)
    {
        $exercicio = empty($exercicio) ? date('Y') : $exercicio;

        $qb = $this->createQueryBuilder('n');
        $qb->innerJoin('Urbem\CoreBundle\Entity\Normas\TipoNorma', 'tn', 'WITH', 'n.codTipoNorma = tn.codTipoNorma');
        $qb->where('n.exercicio = :exercicio');
        $qb->orderBy("tn.nomTipoNorma", "ASC");
        $qb->addOrderBy("n.nomNorma", "ASC");

        $qb->setParameter('exercicio', $exercicio);

        if ($term) {
            if (is_numeric($term)) {
                $qb->andWhere('n.numNorma = :term');
                $qb->setParameter('term', $term);
            } else {
                $qb->andWhere('LOWER(n.nomNorma) LIKE :term');
                $qb->setParameter('term', "%" . strtolower($term) . "%");
            }
        }

        return $qb;
    }

    public function getNormas($exercicio = null)
    {
        $exercicio = empty($exercicio) ? date('Y') : $exercicio;

        $sql = sprintf("
        SELECT
            n.cod_norma, tn.nom_tipo_norma, n.nom_norma
        FROM
            normas.norma AS n
        INNER JOIN normas.tipo_norma AS tn
            ON tn.cod_tipo_norma = n.cod_tipo_norma
        WHERE n.exercicio = '%s'
        ", $exercicio);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getNormaAndTipoByCodContrato($codContrato)
    {
        $sql = "
            SELECT
                n.cod_norma,
                CONCAT(tn.nom_tipo_norma, ' - ', n.nom_norma) AS descricao
            FROM pessoal.contrato_servidor_caso_causa_norma cn
            INNER JOIN normas.norma n
                ON n.cod_norma = cn.cod_norma
            INNER JOIN normas.tipo_norma tn
                ON tn.cod_tipo_norma = n.cod_tipo_norma
            WHERE cn.cod_contrato = $codContrato

            UNION ALL

            SELECT DISTINCT
                n.cod_norma,
                CONCAT(tn.nom_tipo_norma, ' - ', n.nom_norma) AS descricao
            FROM normas.norma n
            INNER JOIN normas.tipo_norma tn
                ON tn.cod_tipo_norma = n.cod_tipo_norma
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * Retorna os resultados
     * TODO: Adicionar exercicio no filtro
     * Busca as norma por tipo da norma
     * @return array
     */
    public function findAllNormasPorTipo($tipo, $nomNorma = null, $exercicio = null)
    {
        $qb = $this->qbNormasPorTipo($tipo, $nomNorma, $exercicio)
                   ->select('n.nomNorma, n.codNorma');
        return $qb->getQuery()->getResult();
    }

    /**
     * Retorna a query builder
     * @param $tipo
     * @return ORM\QueryBuilder
     */
    public function qbNormasPorTipo($tipo, $nomNorma = null, $exercicio = null)
    {
        $normas = $this->createQueryBuilder("n")
            ->where('n.codTipoNorma = :tipo')
            ->setParameter('tipo', $tipo)
            ->orderBy('n.nomNorma', 'ASC')
        ;

        if ($nomNorma) {
            $normas->andWhere($normas->expr()->like('LOWER(n.nomNorma)', ':nomNorma'))
            ->setParameter('nomNorma', "%" . strtolower($nomNorma) . "%");
        }

        return $normas;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getNormaByLicitacao(array $params)
    {
        $sql = <<<SQL
SELECT
  norma.*
FROM
  normas.norma AS norma
  INNER JOIN licitacao.comissao AS comissao ON norma.cod_norma = comissao.cod_norma
  INNER JOIN licitacao.comissao_licitacao AS comissaoLicitacao ON comissao.cod_comissao = comissaoLicitacao.cod_comissao
WHERE
  comissaoLicitacao.cod_licitacao = :cod_licitacao
  AND comissaoLicitacao.cod_entidade = :cod_entidade
  AND comissaoLicitacao.exercicio = :exercicio
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function getAtributosDinamicosByNorma($norma)
    {
        try {
            $sql = 'SELECT
                  ad.nom_atributo,
                  anv.valor
                FROM
                  normas.norma n
                LEFT JOIN normas.atributo_norma_valor anv
                  ON n.cod_norma = anv.cod_norma
                LEFT JOIN administracao.atributo_dinamico ad
                  ON ad.cod_atributo = anv.cod_atributo
                WHERE
                  n.cod_norma = :norma_id;';

            $stmt = $this->_em->getConnection()->prepare($sql);
            $stmt->bindValue('norma_id', $norma, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function getNormasJson($paramsWhere)
    {
        $sql = sprintf(
            "select * from normas.norma WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param string $term converte para lowercase
     * @return ORM\QueryBuilder
     *
     */
    public function getByExercicioAnTermAsQueryBuilder($exercicio, $term)
    {
        $term = strtolower($term);

        $qb = $this->createQueryBuilder('norma');
        $orx = $qb->expr()->orX();

        $orx->add($qb->expr()->like('LOWER(norma.numNorma)', ':term'));
        $orx->add($qb->expr()->like('LOWER(norma.nomNorma)', ':term'));

        $qb->andWhere('norma.exercicio = :exercicio');
        $qb->andWhere($orx);

        $qb->setParameter('exercicio', $exercicio, Type::STRING);
        $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);
        $qb->orderBy('norma.numNorma');
        $qb->setMaxResults(10);

        return $qb;
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withExercicioQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->where('n.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @return ORM\QueryBuilder
     */
    public function findDecretoTcemg($exercicio, $entidade)
    {
        $result = $this->createQueryBuilder('n')
            ->select('n.codNorma', 'n.codTipoNorma', 'n.dtPublicacao', 'n.dtAssinatura', 'n.numNorma', 'n.nomNorma', 't.codTipoDecreto')
            ->leftJoin('Urbem\CoreBundle\Entity\Tcemg\TipoRegistroPreco', 't', 'WITH', 'n.codNorma = t.codNorma')
            ->where('n.exercicio = :exercicio')
            ->andWhere('t.codEntidade = :entidade')
            ->setParameter('exercicio', $exercicio)
            ->setParameter('entidade', $entidade)
            ->orderBy('n.numNorma');

        return $result;
    }
}