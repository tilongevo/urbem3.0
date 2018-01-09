<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo;
use Urbem\CoreBundle\Entity\Divida\FormaInscricao;
use Urbem\CoreBundle\Entity\Divida\TipoModalidade;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ModalidadeRepository
 * @package Urbem\CoreBundle\Repository\Tributario
 */
class ModalidadeRepository extends AbstractRepository
{

    /**
     * @return int
     */
    public function lastCodModalidade()
    {
        return $this->nextVal('cod_modalidade');
    }

    /**
     * @param $codModalidade
     * @param $descricao
     * @param $codTipoModalidade
     * @param $queryBuilder
     * @param $alias
     */
    public function findModalidadesBusca($codModalidade, $descricao, $codTipoModalidade, $ativa, $queryBuilder, $alias)
    {
        $queryBuilder->resetDQLPart('join');
        $queryBuilder->innerJoin("{$alias}.fkDividaModalidadeVigencias", 'dmv', 'WITH', "dmv.codModalidade = {$alias}.codModalidade")
                     ->where("{$alias}.ultimoTimestamp = dmv.timestamp");
        if (!empty($codTipoModalidade)) {
            $queryBuilder
                ->andWhere('dmv.codTipoModalidade = :codTipoModalidade')
                ->setParameter('codTipoModalidade', $codTipoModalidade);
            ;
        }
        if (!empty($ativa)) {
            $queryBuilder
                ->andWhere("{$alias}.ativa = :ativa")
                ->setParameter('ativa', $ativa);
            ;
        }
        if (!empty($descricao)) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like("{$alias}.descricao", ":descricao"))
                ->setParameter('descricao', "%{$descricao}%");
            ;
        }
        if (!empty($codModalidade)) {
            $queryBuilder
                ->andWhere("{$alias}.codModalidade = :codModalidade")
                ->setParameter('codModalidade', $codModalidade);
            ;
        }

        $queryBuilder->orderBy("{$alias}.codModalidade", 'ASC');
    }

    /**
     * @return array
     */
    public function findAllModalidadeCreditos()
    {
        $sql = $this->queryCredito(null);
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codCredito
     * @return mixed
     */
    public function findModalidadeCredito($codCredito)
    {
        $sql = $this->queryCredito(' WHERE mc.cod_credito = :cod_credito');
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_credito', $codCredito);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $bloco
     * @return string
     */
    protected function queryCredito($bloco)
    {
        $sql = " SELECT                                                
                     mc.cod_credito,                                   
                     mn.cod_natureza,                                  
                     mn.nom_natureza,                                  
                     mg.cod_genero,                                    
                     mg.nom_genero,                                    
                     me.cod_especie,                                   
                     me.nom_especie,                                   
                     mc.descricao_credito                              
                 FROM                                                  
                     monetario.credito as mc                           
                 INNER JOIN                                            
                     monetario.especie_credito as me                   
                 ON                                                    
                     mc.cod_natureza = me.cod_natureza and             
                     mc.cod_genero = me.cod_genero and                 
                     mc.cod_especie = me.cod_especie                   
                 INNER JOIN                                            
                     monetario.genero_credito as mg                    
                 ON                                                    
                     me.cod_natureza = mg.cod_natureza and             
                     me.cod_genero = mg.cod_genero                     
                 INNER JOIN                                            
                     monetario.natureza_credito as mn                  
                 ON                                                    
                     mg.cod_natureza = mn.cod_natureza ";

        $sql .= $bloco;

        $sql .= " ORDER BY mc.cod_credito ";
        return $sql;
    }

    /**
     * @param $codAcao
     * @return array
     */
    public function findDocumentos($codAcao)
    {
        return  $this->queryBuilderDocumentos($codAcao)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $codAcao
     * @param $codDocumento
     * @param $codTipoDocumento
     * @return mixed
     */
    public function findOneDocumento($codAcao, $codDocumento, $codTipoDocumento)
    {
        return  $this->queryBuilderDocumentos($codAcao)
            ->andWhere("d.codDocumento = :codDocumento")
            ->andWhere("d.codTipoDocumento = :codTipoDocumento")
            ->setParameter('codDocumento', $codDocumento)
            ->setParameter('codTipoDocumento', $codTipoDocumento)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param $codAcao
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function queryBuilderDocumentos($codAcao)
    {
        return $this->_em->createQueryBuilder()
            ->select(['d.codDocumento', 'd.nomeDocumento', 'd.codTipoDocumento'])
            ->from(ModeloDocumento::class, 'd')
            ->join(
                ModeloArquivosDocumento::class,
                'ma',
                'WITH',
                'd.codDocumento = ma.codDocumento '
            )
            ->andWhere("ma.codAcao = :codAcao")
            ->setParameter('codAcao', $codAcao);
    }

    /**
     * @return array
     */
    public function findAllAcrescimos()
    {
        $sql = " SELECT
                    ma.cod_acrescimo,
                    ma.descricao_acrescimo,
                    ma.cod_tipo,
                    mta.nom_tipo,
                    to_char(mfa.timestamp,'dd/mm/YYYY') as inicio_vigencia,
                    FUNCAO.cod_funcao,
                    FUNCAO.nom_funcao,
                    FUNCAO.cod_modulo,
                    FUNCAO.cod_biblioteca
                    FROM
                    monetario.acrescimo as ma
                
                    INNER JOIN
                    monetario.tipo_acrescimo as mta
                    ON
                    ma.cod_tipo = mta.cod_tipo
                
                    LEFT JOIN
                        (
                            SELECT
                                BAL.*
                            FROM
                                monetario.formula_acrescimo AS BAL,
                                (
                                    SELECT
                                        MAX(TIMESTAMP) AS TIMESTAMP,
                                        cod_acrescimo
                                    FROM
                                        monetario.formula_acrescimo
                                    GROUP BY
                                        cod_acrescimo
                                ) AS BT
                            WHERE
                                BAL.cod_acrescimo = BT.cod_acrescimo AND
                                BAL.timestamp = BT.timestamp
                        )as mfa
                    ON
                        mfa.cod_acrescimo = ma.cod_acrescimo
                
                    LEFT JOIN
                    administracao.funcao as FUNCAO
                    ON
                    FUNCAO.cod_modulo = mfa.cod_modulo
                    AND
                    FUNCAO.cod_biblioteca = mfa.cod_biblioteca
                    AND
                    FUNCAO.cod_funcao = mfa.cod_funcao
                     ORDER BY ma.cod_acrescimo";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codModulo
     * @param $codBiblioteca
     * @return array
     */
    public function findRegraUtilizacao($codModulo, $codBiblioteca)
    {
        return $this->_em->createQueryBuilder()
            ->select(['f.codModulo', 'f.codBiblioteca', 'f.codFuncao', 'f.nomFuncao'])
            ->from(TipoPrimitivo::class, 'tp')
            ->join(
                Funcao::class,
                'f',
                'WITH',
                'f.codTipoRetorno = tp.codTipo '
            )
            ->andWhere("f.codModulo = :codModulo")
            ->andWhere("f.codBiblioteca = :codBiblioteca")
            ->setParameter('codModulo', $codModulo)
            ->setParameter('codBiblioteca', $codBiblioteca)
            ->orderBy('f.nomFuncao')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return array
     */
    public function findAllFormaInscricao()
    {
        return $this->_em->createQueryBuilder()
                ->select(['f.codFormaInscricao', 'f.descricao'])
                ->from(FormaInscricao::class, 'f')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }

    /**
     * @return array
     */
    public function findAllTipoModalidade()
    {
        return $this->_em->createQueryBuilder()
            ->select(['tm.codTipoModalidade', 'tm.descricao'])
            ->from(TipoModalidade::class, 'tm')
            ->andWhere("tm.codTipoModalidade != :codTipoModalidade")
            ->setParameter('codTipoModalidade', 0)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }
}
