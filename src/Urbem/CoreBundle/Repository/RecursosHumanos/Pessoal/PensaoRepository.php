<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PensaoRepository extends AbstractRepository
{
    public function listarDependentes($codContrato)
    {

        $sql = "SELECT                                                                                       
	    PD.*,                                                                                     
	    PS.cod_servidor,                                                                          
	    to_char(PD.dt_inicio_sal_familia,'dd/mm/yyyy')       as dt_inicio_sal_familia,       
	    PDC.cod_cid,                                                                              
	    sw_cgm.nom_cgm,                                                                           
	    CASE WHEN sw_cgm_pessoa_fisica.sexo = 'f'                                                 
	         THEN 'Feminino'                                                                      
	         ELSE 'Masculino'                                                                     
	          END as sexo,                                                                        
	    to_char(sw_cgm_pessoa_fisica.dt_nascimento,'dd/mm/yyyy') as dt_nascimento                 
	    , vinculo_irrf.descricao as descricao_vinculo                                             
	    , cid.descricao as descricao_cid                                                          
	    , sw_escolaridade.descricao as escolaridade                                               
	FROM                                                                                          
	   pessoal.servidor             PS,                                                           
	   pessoal.servidor_dependente PSD,                                                           
	   folhapagamento.vinculo_irrf,                                                               
	   pessoal.dependente          PD                                                        
	   left join pessoal.dependente_cid as  PDC                                                   
	   on(PD.cod_dependente  = PDC.cod_dependente)                                                
	   left join pessoal.cid                                                                      
	   on(PDC.cod_cid  = cid.cod_cid)                                                             
	LEFT JOIN sw_cgm                                                                              
	       ON PD.numcgm = sw_cgm.numcgm                                                           
	LEFT JOIN sw_cgm_pessoa_fisica                                                                
	       ON PD.numcgm = sw_cgm_pessoa_fisica.numcgm                                             
	LEFT JOIN sw_escolaridade                                                                     
	       ON sw_escolaridade.cod_escolaridade = sw_cgm_pessoa_fisica.cod_escolaridade            
	WHERE                                                                                         
	   PS.cod_servidor    = PSD.cod_servidor         and                                          
	   PSD.cod_dependente = PD.cod_dependente                                                     
	   and PD.cod_vinculo = vinculo_irrf.cod_vinculo                                              
	   AND PSD.cod_dependente::varchar||PSD.cod_servidor::varchar NOT IN (                        
	   SELECT cod_dependente::varchar||cod_servidor::varchar FROM pessoal.dependente_excluido )   
	 AND PS.cod_servidor = (select cod_servidor from pessoal.contrato_servidor where cod_contrato =". $codContrato .") ORDER BY nom_cgm;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        /*dump($result);
        exit();*/

        return $result;
    }
}
