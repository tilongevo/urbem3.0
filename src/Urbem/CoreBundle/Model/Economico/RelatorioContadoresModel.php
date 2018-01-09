<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;

/**
 * Class RelatorioContadoresModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class RelatorioContadoresModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository;

    /**
     * RelatorioContadoresModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ResponsavelTecnico::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaContadores($filter)
    {
        $sql = "
            SELECT                                                                      
             RT.num_registro,                                                        
             CGM.numcgm||' '||CGM.nom_cgm AS contador,                               
             CGM.nom_cgm,                                                            
             CGM.logradouro||', '||CGM.numero||' '||CGM.complemento AS endereco,     
             CGM.fone_comercial,                                                     
             CE.inscricao_economica,                                                 
             L.endereco_cadastro                                                     
         FROM                                                                        
             economico.responsavel_tecnico RT                                        
             INNER JOIN economico.cadastro_econ_resp_contabil CER ON                 
                 CER.numcgm          = RT.numcgm                                     
             LEFT JOIN economico.cadastro_economico CE ON                            
                 CE.inscricao_economica = CER.inscricao_economica                    
             LEFT JOIN economico.domicilio_fiscal DF ON                              
                 DF.inscricao_economica = CE.inscricao_economica                     
             LEFT JOIN (                                                             
                 SELECT                                                              
                     I.inscricao_municipal,                                          
                     TL.nom_tipo||' '||NL.nom_logradouro AS endereco_cadastro        
                 FROM                                                                
                     imobiliario.imovel               I,                             
                     imobiliario.imovel_confrontacao IC,                             
                     imobiliario.confrontacao_trecho CT,                             
                     sw_logradouro                    L,                             
                     sw_nome_logradouro              NL,                             
                     sw_tipo_logradouro              TL                              
                 WHERE                                                               
                     I.inscricao_municipal = IC.inscricao_municipal AND              
                     IC.cod_lote           = CT.cod_lote            AND              
                     CT.cod_logradouro     = L.cod_logradouro       AND              
                     L.cod_logradouro      = NL.cod_logradouro      AND              
                     NL.cod_tipo           = TL.cod_tipo                             
             ) AS L ON                                                               
                 L.inscricao_municipal = DF.inscricao_municipal,                     
             sw_cgm CGM                                                              
         WHERE                                                                       
             RT.numcgm = CGM.numcgm AND                                              
             RT.cod_profissao IN (
                                              SELECT valor::integer
                                              FROM administracao.configuracao
                                              WHERE (   parametro = 'cod_contador' OR
                                                        parametro = 'cod_tec_contabil'))";

        if (isset($filter['nomcgm'])) {
            $sql.= " AND CGM.nom_cgm ILIKE :nom_cgm";
        }

        if (isset($filter['numcgm']) or isset($filter['numcgmFinal'])) {
            $sql.= " AND CGM.numcgm BETWEEN :numcgm_inicial AND :numcgm_final ";
        }

        if (isset($filter['inscricaoEconomicaInicial']) or isset($filter['inscricaoEconomicaFinal'])) {
            $sql.= " AND CE.inscricao_economica BETWEEN :inscricao_economica_inicial AND :inscricao_economica_final ";
        }

        $sql.=" ORDER BY CGM.{$filter['ordenacao']};";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if (isset($filter['nomcgm'])) {
            $query->bindValue(':nom_cgm', '%' . $filter['nomcgm'] . '%', \PDO::PARAM_STR);
        }

        if (isset($filter['numcgm']) or isset($filter['numcgmFinal'])) {
            $query->bindValue(':numcgm_inicial', isset($filter['numcgm']) ? $filter['numcgm'] : $filter['numcgmFinal'], \PDO::PARAM_INT);
            $query->bindValue(':numcgm_final', isset($filter['numcgmFinal']) ? $filter['numcgmFinal'] : $filter['numcgm'], \PDO::PARAM_INT);
        }

        if (isset($filter['inscricaoEconomicaInicial']) or isset($filter['inscricaoEconomicaFinal'])) {
            $query->bindValue(':inscricao_economica_inicial', isset($filter['inscricaoEconomicaInicial']) ? $filter['inscricaoEconomicaInicial'] : $filter['inscricaoEconomicaFinal'], \PDO::PARAM_INT);
            $query->bindValue(':inscricao_economica_final', isset($filter['inscricaoEconomicaFinal']) ? $filter['inscricaoEconomicaFinal'] : $filter['inscricaoEconomicaInicial'], \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll();
    }
}
