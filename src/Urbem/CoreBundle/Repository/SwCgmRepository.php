<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\QueryBuilder;

class SwCgmRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function nextNumCgm()
    {
        return $this->nextVal('numcgm');
    }

    /*
     * Reescrito para que não traga o administrador do sistema na query
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->_em->createQueryBuilder()
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy)
            ->where("{$alias}.numcgm > 0");
    }

    public function recuperaRelacionamentoVinculado($stTabelaVinculo = false, $stCampoVinculo = false, $filtroVinculo = false, $stcondicao = false)
    {
        $sql = "SELECT
            CGM.numcgm
            ,CGM.nom_cgm ";

        if ($stTabelaVinculo) {
            $sql .= "
                ,PF.cpf
                ,PJ.cnpj
                ,CASE WHEN PF.cpf IS NOT NULL THEN PF.cpf ELSE PJ.cnpj END AS documento";
        }
        $sql .= " FROM
            SW_CGM AS CGM";

        if ($stTabelaVinculo) {
            $sql .= " LEFT JOIN
                sw_cgm_pessoa_fisica AS PF
            ON
                CGM.numcgm = PF.numcgm
            LEFT JOIN
                sw_cgm_pessoa_juridica AS PJ
            ON
                CGM.numcgm = PJ.numcgm";
        }
        $sql .= " WHERE
            CGM.numcgm <> 0 ";
        if ($stTabelaVinculo) {
            $sql .= " and exists ( select 1 from  $stTabelaVinculo  as tabela_vinculo
                                 where tabela_vinculo.$stCampoVinculo = CGM.numcgm ) " . $filtroVinculo;
        }
        if ($stcondicao) {
            $sql .= $stcondicao;
        }

        $sql .= " order by lower(cgm.nom_cgm)";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getCgmImprensa()
    {
        $sql = "
            SELECT
                CGM.numcgm,
                CGM.nom_cgm
            FROM
            SW_CGM AS CGM
            LEFT JOIN sw_cgm_pessoa_fisica AS PF
                ON CGM.numcgm = PF.numcgm
            LEFT JOIN sw_cgm_pessoa_juridica AS PJ
                ON CGM.numcgm = PJ.numcgm
            WHERE
                CGM.numcgm <> 0
            AND EXISTS (
                SELECT 1 FROM licitacao.veiculos_publicidade  AS tabela_vinculo
                    WHERE tabela_vinculo.numcgm = CGM.numcgm
            )
            ORDER BY LOWER(cgm.nom_cgm)
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getEntidadesConfiguracaoEmpenhoList($codModulo, $exercicio)
    {
        $sql = sprintf(
            "
            SELECT
                c.numcgm,
                c.nom_cgm,
                e.cod_entidade,
                ce.parametro,
                ce.valor
            FROM orcamento.entidade e LEFT JOIN administracao.configuracao_entidade ce ON (e.cod_entidade = ce.cod_entidade)
            join public.sw_cgm c on (c.numcgm = e.numcgm)
            WHERE ce.cod_modulo = %d AND ce.exercicio = '%s' AND ce.parametro LIKE 'data_fixa_%%'
            GROUP BY
                c.numcgm,
                c.nom_cgm,
                e.cod_entidade,
                ce.parametro,
                ce.valor
            ORDER BY C.nom_cgm",
            $codModulo,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getSwCgmFiltro()
    {
        $sql = "
            SELECT
                CGM.numcgm,
                CGM.nom_cgm,
                PF.cpf,
                PJ.cnpj,
              CASE WHEN PF.cpf IS NOT NULL THEN PF.cpf ELSE PJ.cnpj END AS documento
            FROM SW_CGM AS CGM LEFT JOIN sw_cgm_pessoa_fisica AS PF ON CGM.numcgm = PF.numcgm
            LEFT JOIN sw_cgm_pessoa_juridica AS PJ ON CGM.numcgm = PJ.numcgm
            WHERE CGM.numcgm <> 0 AND pf.numcgm is not null
            ORDER BY lower(cgm.nom_cgm)";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getSwCgmsJson($paramsWhere)
    {
        $sql = sprintf(
            "select * from sw_cgm WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getSwCgmsPessoaJuridicaJson($paramsWhere)
    {
        $sql = sprintf(
            "select * from sw_cgm_pessoa_juridica WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $term
     * @return array
     */
    public function getCgmPessoaFisicaByNumcgmAndNomCgm($term)
    {
        $sql ="SELECT cgm.numcgm, cgm.nom_cgm FROM public.sw_cgm cgm
            LEFT JOIN public.sw_cgm_pessoa_fisica pf on pf.numcgm = cgm.numcgm
            WHERE CAST(cgm.numcgm as text) LIKE :term OR LOWER(cgm.nom_cgm) LIKE :term";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(":term", "%" . strtolower($term) . "%", \PDO::PARAM_STR);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Busca para autocomplete de cgm que não é servidor por numcgm e pelo nome do cgm
     * @param  string|integer $term
     * @return QueryBuilder
     */
    public function getSwCgmPessoaJuridicaQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('cgm');
        $qb->innerJoin('cgm.fkSwCgmPessoaJuridica', 'pj');
        $qb->where('cgm.numcgm != 0');

        if (is_numeric($term)) {
            $qb->andWhere('cgm.numcgm = :numcgm');
            $qb->setParameter('numcgm', "{$term}");
        } else {
            $term = strtolower($term);
            $qb->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm');
            $qb->setParameter('nomCgm', "%{$term}%");
        }

        $qb->orderBy('cgm.nomCgm', 'ASC');

        return $qb;
    }

    /**
     * @param string $term converte para lowercase
     * @return QueryBuilder
     */
    public function getByTermAsQueryBuilder($term)
    {
        $term = strtolower($term);

        $qb = $this->createQueryBuilder('SwCgm');
        $orx = $qb->expr()->orX();

        $orx->add($qb->expr()->like('STRING(SwCgm.numcgm)', ':term'));
        $orx->add($qb->expr()->like('LOWER(SwCgm.nomCgm)', ':term'));

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);
        $qb->orderBy('SwCgm.numcgm');
        $qb->setMaxResults(10);

        return $qb;
    }
}
