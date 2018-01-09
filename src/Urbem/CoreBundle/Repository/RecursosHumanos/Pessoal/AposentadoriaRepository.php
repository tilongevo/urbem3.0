<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class AposentadoriaRepository extends ORM\EntityRepository
{

    public function getEnquadramentosCodClassificacao($codClassificacao)
    {
        $sql = "
            SELECT enquadramento.*                                                                   
              FROM pessoal.enquadramento                                                             
                 , pessoal.classificacao_enquadramento                                               
              WHERE enquadramento.cod_enquadramento = classificacao_enquadramento.cod_enquadramento   
              AND classificacao_enquadramento.cod_classificacao = $codClassificacao;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $find
     * @return array
     */
    public function getAposentadoriaValida($find)
    {
        $sql = "
            select cgm.nom_cgm,* from pessoal.aposentadoria pa
            inner join pessoal.servidor_contrato_servidor pscs
            on pscs.cod_contrato = pa.cod_contrato
            inner join pessoal.servidor ps 
            on ps.cod_servidor = pscs.cod_servidor
            inner join sw_cgm cgm
            on cgm.numcgm = ps.numcgm
            where (((select COUNT(DISTINCT u) val from pessoal.aposentadoria u where u.cod_contrato = pa.cod_contrato group by u.cod_contrato) < 2) 
            or CONCAT(pa.cod_contrato,'~',pa.timestamp) = (select CONCAT(ap.cod_contrato,'~',ap.timestamp) from pessoal.aposentadoria ap where ap.cod_contrato = pa.cod_contrato and ap.timestamp = (select aa.\"timestamp\" from pessoal.aposentadoria aa where aa.cod_contrato = ap.cod_contrato order by aa.timestamp DESC limit 1)))
            and pa.cod_contrato not in (select cod_contrato from pessoal.aposentadoria_excluida)";
        if (is_numeric($find)) {
            $sql .= " and cgm.numcgm = " . $find;
        } else {
            $sql .= " and LOWER(cgm.nom_cgm) like LOWER('%" . $find . "%')";
        }
        $sql .= " order by pa.cod_contrato ASC;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @return array
     */
    public function getMaxAposentadorias()
    {
        $sql = <<<SQL
      SELECT aposentadoria.*                                               
	     , to_char(aposentadoria.dt_requirimento,'dd/mm/yyyy') as data_requirimento                                               
	     , to_char(aposentadoria.dt_concessao,'dd/mm/yyyy') as data_concessao                                               
	     , to_char(aposentadoria.dt_publicacao,'dd/mm/yyyy') as data_publicacao                                               
	  FROM pessoal.aposentadoria                                         
	     , (SELECT cod_contrato                                          
	             , max(timestamp) as timestamp                           
	          FROM pessoal.aposentadoria                                 
	        GROUP BY cod_contrato) as max_aposentadoria                  
	 WHERE aposentadoria.cod_contrato = max_aposentadoria.cod_contrato   
	   AND aposentadoria.timestamp = max_aposentadoria.timestamp         
	   AND aposentadoria.cod_contrato::varchar||aposentadoria.timestamp NOT IN (SELECT cod_contrato::varchar||max(timestamp_aposentadoria)
	                                                                                    FROM pessoal.aposentadoria_excluida
	                                                                                  GROUP BY cod_contrato)
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
