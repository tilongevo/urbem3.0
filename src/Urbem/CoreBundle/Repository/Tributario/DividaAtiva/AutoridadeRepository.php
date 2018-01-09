<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AutoridadeRepository
 * @package Urbem\CoreBundle\Repository\Tributario
 */
class AutoridadeRepository extends AbstractRepository
{

    /**
     * @param $filter
     * @return array
     */
    public function findMatriculas($filter)
    {
        $sql = "SELECT * FROM (                                                             
                    SELECT sw_cgm.numcgm                                                        
                         , sw_cgm.nom_cgm                                                       
                         , contrato.*                                                           
                         , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '') as situacao 
                      FROM pessoal.contrato                                                     
                         , pessoal.servidor_contrato_servidor                                   
                         , pessoal.servidor                                                     
                         , sw_cgm                                                               
                     WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato      
                       AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor      
                       AND servidor.numcgm = sw_cgm.numcgm                                      
                    UNION                                                                       
                    SELECT sw_cgm.numcgm                                                        
                         , sw_cgm.nom_cgm                                                       
                         , contrato.*                                                           
                         , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '') as situacao 
                      FROM pessoal.contrato                                                     
                         , pessoal.contrato_pensionista                                         
                         , pessoal.pensionista                                                  
                         , sw_cgm                                                               
                     WHERE contrato.cod_contrato = contrato_pensionista.cod_contrato            
                       AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista   
                       AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente   
                       AND pensionista.numcgm = sw_cgm.numcgm                                   
                       ) as contrato WHERE registro is not null                                 
                 ";

        if (is_numeric($filter)) {
            $sql .= "AND contrato.registro = :filter ";
        } else {
            $sql .= "AND lower(nom_cgm) like lower(:filter)||'%' ";
            $filter = $filter . '%';
        }
        $sql .= " ORDER BY  nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('filter', $filter);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $registro
     * @return mixed
     */
    public function findFuncaoCargo($registro)
    {
        $sql = "SELECT contrato_servidor_funcao.cod_cargo as cod_funcao
                     , cargo.descricao
                     , to_char(contrato_servidor_nomeacao_posse.dt_posse,'dd/mm/yyyy') as dt_posse
                     , to_char(contrato_servidor_nomeacao_posse.dt_nomeacao,'dd/mm/yyyy') as dt_nomeacao
                     , to_char(contrato_servidor_nomeacao_posse.dt_admissao,'dd/mm/yyyy') as dt_admissao
                     , contrato.cod_contrato
                  FROM pessoal.contrato_servidor
                     , pessoal.contrato
                     , pessoal.cargo
                     , pessoal.contrato_servidor_nomeacao_posse
                     , (  SELECT cod_contrato
                               , max(timestamp) as timestamp
                            FROM pessoal.contrato_servidor_nomeacao_posse
                        GROUP BY cod_contrato) as max_contrato_servidor_nomeacao_posse
                     , pessoal.contrato_servidor_funcao
                     , (  SELECT cod_contrato
                               , max(timestamp) as timestamp
                            FROM pessoal.contrato_servidor_funcao
                        GROUP BY cod_contrato) as max_contrato_servidor_funcao
                 WHERE contrato_servidor.cod_contrato = contrato_servidor_funcao.cod_contrato
                AND contrato_servidor_funcao.cod_contrato = max_contrato_servidor_funcao.cod_contrato
                AND contrato_servidor_funcao.timestamp = max_contrato_servidor_funcao.timestamp
                AND contrato_servidor.cod_contrato = contrato.cod_contrato
                AND contrato_servidor_funcao.cod_cargo = cargo.cod_cargo
                AND contrato_servidor.cod_contrato = contrato_servidor_nomeacao_posse.cod_contrato
                AND contrato_servidor_nomeacao_posse.cod_contrato = max_contrato_servidor_nomeacao_posse.cod_contrato
                AND contrato_servidor_nomeacao_posse.timestamp    = max_contrato_servidor_nomeacao_posse.timestamp
                AND registro = :registro                 
                 ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('registro', $registro);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $codTipoNorma
     * @return mixed
     */
    public function findFundamentacaoLegal($codTipoNorma = null)
    {
        $sql = "SELECT
                  N.cod_norma
                 ,N.cod_tipo_norma
                 ,TN.nom_tipo_norma
                 ,to_char( N.dt_publicacao, 'dd/mm/yyyy' )  as dt_publicacao
                 ,to_char( N.dt_assinatura, 'dd/mm/yyyy' )  as dt_assinatura
                 ,N.nom_norma
                 ,N.descricao
                 ,N.exercicio
                 ,lpad(num_norma,6,'0') as num_norma
                 ,link
                 , ( (num_norma,6,'0')||'/'||N.exercicio ) as num_norma_exercicio
                 FROM
                     normas.norma AS N
                 LEFT JOIN
                     normas.tipo_norma AS TN
                 ON  TN.cod_tipo_norma = N.cod_tipo_norma
                 WHERE cod_norma IS NOT NULL             
                 ";

        if (!empty($codTipoNorma)) {
            $sql .= " AND N.cod_tipo_norma = :cod_tipo_norma ";
        }
        $sql .= " ORDER BY N.num_norma,N.exercicio ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (!empty($codTipoNorma)) {
            $query->bindValue('cod_tipo_norma', $codTipoNorma);
        }
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $tipoAutoridade
     * @param $servidor
     * @param $queryBuilder
     * @param $alias
     */
    public function findAutoridadeBusca($tipoAutoridade, $servidor, $queryBuilder, $alias)
    {
        $queryBuilder->leftJoin("{$alias}.fkDividaProcurador", 'p');
        $queryBuilder->andWhere('p.codAutoridade ' . ($tipoAutoridade == 'procurador' ? 'IS NOT NULL' : 'IS NULL'));
        if (!empty($servidor)) {
            $queryBuilder
                ->andWhere("{$alias}.numcgm = :numcgm")
                ->setParameter('numcgm', $servidor);
            ;
        }
    }
}
