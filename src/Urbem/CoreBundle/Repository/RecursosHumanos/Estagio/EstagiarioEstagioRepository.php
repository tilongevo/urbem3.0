<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Estagio;

use Urbem\CoreBundle\Repository\AbstractRepository;

class EstagiarioEstagioRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function montaRecuperaRelacionamento()
    {
        $sql = "SELECT sw_cgm_pessoa_juridica.numcgm                                                                             
        , sw_cgm.nom_cgm                                                                                            
        , sw_cgm_pessoa_juridica.cnpj                                                                               
        , sw_cgm.tipo_logradouro||' '||sw_cgm.logradouro||', '||sw_cgm.numero||' '||sw_cgm.complemento AS endereco  
        , sw_cgm.bairro                                                                                             
        , sw_municipio.nom_municipio                                                                                
        , sw_cgm.fone_comercial                                                                                     
        FROM sw_cgm_pessoa_juridica                                                                                    
        , sw_cgm                                                                                                    
        , sw_municipio                                                                                              
        , estagio.instituicao_ensino                                                                                
        WHERE sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm                                                             
        AND sw_cgm.cod_uf = sw_municipio.cod_uf                                                                       
        AND sw_cgm.cod_municipio = sw_municipio.cod_municipio                                                         
        AND sw_cgm.numcgm = instituicao_ensino.numcgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function montaRecuperaInstituicoesDaEntidade($numcgm)
    {
        $sql = "SELECT sw_cgm.numcgm                                                                                              
            , sw_cgm.nom_cgm                                                                                             
        FROM sw_cgm                                                                                                     
        , estagio.entidade_intermediadora                                                                            
        , estagio.instituicao_entidade                                                                                 
        WHERE entidade_intermediadora.numcgm = instituicao_entidade.cgm_entidade
        AND instituicao_entidade.cgm_instituicao = sw_cgm.numcgm
        AND entidade_intermediadora.numcgm = $numcgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numCgm
     * @return array
     */
    public function montaRecuperaGrausDeInstituicaoEnsino($numCgm)
    {
        $sql = "SELECT grau.*
         FROM estagio.curso_instituicao_ensino
             , estagio.curso
             , estagio.grau
         WHERE curso_instituicao_ensino.cod_curso = curso.cod_curso
           AND curso.cod_grau = grau.cod_grau 
           AND curso_instituicao_ensino.numcgm = $numCgm
        GROUP BY grau.cod_grau,grau.descricao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numCgm
     * @param $codGrau
     * @return array
     */
    public function montaRecuperarCursos($numCgm, $codGrau)
    {
        $sql = "SELECT curso.nom_curso,
	      curso_instituicao_ensino.*, 
	      curso_instituicao_ensino_mes.cod_mes,
	      mes.descricao
        FROM estagio.curso_instituicao_ensino
        LEFT JOIN estagio.curso_instituicao_ensino_mes
        ON curso_instituicao_ensino.cod_curso = curso_instituicao_ensino_mes.cod_curso
        left join administracao.mes
        on mes.cod_mes = curso_instituicao_ensino_mes.cod_mes
        AND curso_instituicao_ensino.numcgm = curso_instituicao_ensino_mes.numcgm, estagio.curso
        WHERE curso_instituicao_ensino.cod_curso = curso.cod_curso
        AND cod_grau = $codGrau
        AND curso_instituicao_ensino.numcgm = $numCgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $param
     * @return int
     */
    public function getNextCodConfiguracao(array $param)
    {
        return $this->nextVal('cod_estagio', $param);
    }
}
