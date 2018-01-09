<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Doctrine\ORM\Query\ResultSetMapping;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcemg\Uniorcam;
use Urbem\CoreBundle\Repository\AbstractRepository;

class UniorcamRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalAtualByExercicio($exercicio)
    {
        $qb = $this->createQueryBuilder('Uniorcam');
        $qb->select('COUNT(Uniorcam)');
        $qb->andWhere('Uniorcam.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @see gestaoFinanceira/fontes/PHP/exportacao/classes/negocio/RExportacaoTCEMGUniOrcam.class.php:
     */
    public function getAtualByExercicio($exercicio, $limit, $offset)
    {
        return $this->findBy(
            [
                'exercicio' => $exercicio
            ],
            [
                'numOrgao' => 'ASC',
                'numUnidade' => 'ASC'
            ],
            $limit,
            $offset
        );
    }

    /**
     * see gestaoFinanceira/fontes/PHP/exportacao/classes/mapeamento/TExportacaoTCEMGUniOrcam.class.php:142
     * @param $exercicio
     * @return string
     */
    protected function getSQLConversaoByExercicio($exercicio)
    {
        $sql = <<<SQL
SELECT DISTINCT                                                  
     ee.exercicio,                                               
     ee.num_orgao,                                               
     ee.num_unidade,                                             
     tu.identificador,                                           
     tu.cgm_ordenador AS swcgm_cgm_ordenador,                    
     tu.cgm_ordenador,                                           
     tu.num_unidade_atual AS unidade_atual_num_unidade,              
     tu.num_unidade_atual,                                       
     tu.num_orgao_atual AS unidade_atual_num_orgao,                  
     tu.num_orgao_atual,                                         
     tu.exercicio_atual AS unidade_atual_exercicio,              
     tu.exercicio_atual,                                         
     sw_cgm.nom_cgm AS nom_cgm_responsavel,
     unidade_atual.nom_unidade AS unidade_atual_nom_unidade,
     orgao_atual.exercicio AS orgao_atual_exercicio,
     orgao_atual.num_orgao AS orgao_atual_num_orgao,
     orgao_atual.nom_orgao AS orgao_atual_nom_orgao
                            
FROM empenho.restos_pre_empenho as ee

                            
LEFT JOIN tcemg.uniorcam as tu ON                                                               
          ee.exercicio = tu.exercicio AND 
          ee.num_unidade = tu.num_unidade AND
          ee.num_orgao = tu.num_orgao
                           
LEFT JOIN sw_cgm ON 
          sw_cgm.numcgm = tu.cgm_ordenador

LEFT JOIN orcamento.unidade AS unidade_atual ON
          unidade_atual.exercicio = tu.exercicio_atual AND
          unidade_atual.num_unidade = tu.num_unidade_atual AND
          unidade_atual.num_orgao = tu.num_orgao_atual
          
LEFT JOIN orcamento.orgao AS orgao_atual ON
          orgao_atual.exercicio = tu.exercicio_atual AND
          orgao_atual.num_orgao = tu.num_orgao_atual 

UNION
                                                     
SELECT                                                           
     '2004' as exercicio,                                        
     oo.num_orgao,                                               
     ou.num_unidade,                                             
     tu.identificador,                                           
     tu.cgm_ordenador AS swcgm_cgm_ordenador,                    
     tu.cgm_ordenador,                                           
     tu.num_unidade_atual AS unidade_atual_num_unidade,              
     tu.num_unidade_atual,                                       
     tu.num_orgao_atual AS unidade_atual_num_orgao,                  
     tu.num_orgao_atual,                                         
     tu.exercicio_atual AS unidade_atual_exercicio,              
     tu.exercicio_atual,                                         
     sw_cgm.nom_cgm AS nom_cgm_responsavel,
     unidade_atual.nom_unidade AS unidade_atual_nom_unidade,
     orgao_atual.exercicio AS orgao_atual_exercicio,
     orgao_atual.num_orgao AS orgao_atual_num_orgao,
     orgao_atual.nom_orgao AS orgao_atual_nom_orgao
                         
FROM orcamento.orgao as oo, orcamento.unidade as ou
                                       
LEFT JOIN tcemg.uniorcam as tu ON                                                               
          ou.exercicio = tu.exercicio AND 
          ou.num_unidade = tu.num_unidade AND 
          ou.num_orgao = tu.num_orgao
                           
LEFT JOIN sw_cgm ON 
          sw_cgm.numcgm = tu.cgm_ordenador

LEFT JOIN orcamento.unidade AS unidade_atual ON
          unidade_atual.exercicio = tu.exercicio_atual AND
          unidade_atual.num_unidade = tu.num_unidade_atual AND
          unidade_atual.num_orgao = tu.num_orgao_atual
                          
LEFT JOIN orcamento.orgao AS orgao_atual ON
          orgao_atual.exercicio = tu.exercicio_atual AND
          orgao_atual.num_orgao = tu.num_orgao_atual 

WHERE oo.num_orgao = ou.num_orgao AND 
      oo.exercicio = ou.exercicio AND
      oo.exercicio = '2005'
                                         
UNION 
                                                           
SELECT                                                           
     oo.exercicio,                                               
     oo.num_orgao,                                               
     ou.num_unidade,                                             
     tu.identificador,                                           
     tu.cgm_ordenador AS swcgm_cgm_ordenador,                    
     tu.cgm_ordenador,                                           
     tu.num_unidade_atual AS unidade_atual_num_unidade,              
     tu.num_unidade_atual,                                       
     tu.num_orgao_atual AS unidade_atual_num_orgao,                  
     tu.num_orgao_atual,                                         
     tu.exercicio_atual AS unidade_atual_exercicio,              
     tu.exercicio_atual,                                         
     sw_cgm.nom_cgm AS nom_cgm_responsavel,
     unidade_atual.nom_unidade AS unidade_atual_nom_unidade,
     orgao_atual.exercicio AS orgao_atual_exercicio,
     orgao_atual.num_orgao AS orgao_atual_num_orgao,
     orgao_atual.nom_orgao AS orgao_atual_nom_orgao
                         
FROM orcamento.orgao as oo, orcamento.unidade as ou
                                
LEFT JOIN tcemg.uniorcam as tu ON                                                               
          ou.exercicio = tu.exercicio AND 
          ou.num_unidade = tu.num_unidade AND 
          ou.num_orgao = tu.num_orgao
                           
LEFT JOIN sw_cgm ON 
          sw_cgm.numcgm = tu.cgm_ordenador

LEFT JOIN orcamento.unidade AS unidade_atual ON
          unidade_atual.exercicio = tu.exercicio_atual AND
          unidade_atual.num_unidade = tu.num_unidade_atual AND
          unidade_atual.num_orgao = tu.num_orgao_atual
          
LEFT JOIN orcamento.orgao AS orgao_atual ON
          orgao_atual.exercicio = tu.exercicio_atual AND
          orgao_atual.num_orgao = tu.num_orgao_atual       
          
WHERE oo.num_orgao = ou.num_orgao AND 
      oo.exercicio = ou.exercicio AND
      oo.exercicio < '$exercicio'
        
ORDER BY exercicio,num_orgao,num_unidade                         

SQL;
        return $sql;
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getTotalConversaoByExercicio($exercicio)
    {
        $sql = sprintf("SELECT COUNT(count_uniorcam.*) FROM (%s) as count_uniorcam", $this->getSQLConversaoByExercicio($exercicio));

        $query = $this->_em->getConnection()->fetchAssoc($sql);

        return (int) array_shift($query);
    }

    /**
     * see gestaoFinanceira/fontes/PHP/exportacao/classes/mapeamento/TExportacaoTCEMGUniOrcam.class.php:142
     *
     * @param $exercicio
     * @param $limit
     * @param $offset
     * @return array|Uniorcam
     */
    public function getConversaoByExercicio($exercicio, $limit, $offset)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(Uniorcam::class, 'Uniorcam');

        // addFieldResult(Entity alis, field on query, property on entity)

        $rsm->addFieldResult('Uniorcam', 'exercicio', 'exercicio');
        $rsm->addFieldResult('Uniorcam', 'num_unidade','numUnidade');
        $rsm->addFieldResult('Uniorcam', 'num_orgao','numOrgao');
        $rsm->addFieldResult('Uniorcam', 'identificador','identificador');
        $rsm->addFieldResult('Uniorcam', 'cgm_ordenador','cgmOrdenador');
        $rsm->addFieldResult('Uniorcam', 'exercicio_atual','exercicioAtual');
        $rsm->addFieldResult('Uniorcam', 'num_orgao_atual','numOrgaoAtual');
        $rsm->addFieldResult('Uniorcam', 'num_unidade_atual','numUnidadeAtual');

        // addJoinedEntityResult(Entity Class Name, Entity alias, Parent Entity alias, Child Name);

        $rsm->addJoinedEntityResult(SwCgm::class, 'SwCgm', 'Uniorcam', 'fkSwCgm');
        $rsm->addFieldResult('SwCgm', 'swcgm_cgm_ordenador', 'numcgm', SwCgm::class);
        $rsm->addFieldResult('SwCgm', 'nom_cgm_responsavel', 'nomCgm', SwCgm::class);

        $rsm->addJoinedEntityResult(Unidade::class, 'UnidadeAtual', 'Uniorcam', 'fkOrcamentoUnidadeAtual');
        $rsm->addFieldResult('UnidadeAtual', 'unidade_atual_exercicio', 'exercicio', Unidade::class);
        $rsm->addFieldResult('UnidadeAtual', 'unidade_atual_num_unidade', 'numUnidade', Unidade::class);
        $rsm->addFieldResult('UnidadeAtual', 'unidade_atual_num_orgao', 'numOrgao', Unidade::class);
        $rsm->addFieldResult('UnidadeAtual', 'unidade_atual_nom_unidade', 'nomUnidade', Unidade::class);

        $rsm->addJoinedEntityResult(Orgao::class, 'OrgaoAtual', 'Uniorcam', 'fkOrcamentoOrgaoAtual');
        $rsm->addFieldResult('OrgaoAtual', 'orgao_atual_exercicio', 'exercicio', Orgao::class);
        $rsm->addFieldResult('OrgaoAtual', 'orgao_atual_num_orgao', 'numOrgao', Orgao::class);
        $rsm->addFieldResult('OrgaoAtual', 'orgao_atual_nom_orgao', 'nomOrgao', Orgao::class);

        $sql = $this->getSQLConversaoByExercicio($exercicio);
        $sql.= "LIMIT ". $limit ." OFFSET ". $offset;

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->execute();

        return $query->getResult();
    }
}
