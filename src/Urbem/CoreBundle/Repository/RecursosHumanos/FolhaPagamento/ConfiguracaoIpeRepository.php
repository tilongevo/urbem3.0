<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ConfiguracaoIpeRepository extends AbstractRepository
{
    /**
     * @param $vigencia
     *
     * @return int
     */
    public function getNextCodConfiguracao($vigencia)
    {
        return $this->nextVal('cod_configuracao', ['vigencia' => $vigencia]);
    }

    /**
     * @param $codConfiguracao
     * @param $vigencia
     *
     * @return array
     */
    public function removeIpePensionista($codConfiguracao, $vigencia)
    {
        $sql = "
            DELETE FROM folhapagamento.configuracao_ipe_pensionista
            WHERE cod_configuracao = $codConfiguracao AND vigencia = '" . $vigencia . "';
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function montaExportarArquivoIpers($params)
    {
        $stSql = <<<SQL
                SELECT * FROM exportarArquivoIpers(
                 :inCodPeriodoMovimentacao,
                 :entidade,
                 :exercicio,
                 :stTipoFiltro,
                 :stValoresFiltro,
                 :stSituacaoCadastro,
                 :inCodTipoEmissao,
                 :inCodFolha,
                 :stDesdobramento,
                 :inCodComplementar,
                 :boAgruparFolhas) as contrato ORDER BY nom_cgm ;
SQL;

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->bindValue('inCodPeriodoMovimentacao', $params['inCodPeriodoMovimentacao']);
        $query->bindValue('entidade', $params['entidade']);
        $query->bindValue('exercicio', $params['exercicio']);
        $query->bindValue('stTipoFiltro', $params['stTipoFiltro']);
        $query->bindValue('stValoresFiltro', $params['stValoresFiltro']);
        $query->bindValue('stSituacaoCadastro', $params['stSituacaoCadastro']);
        $query->bindValue('inCodTipoEmissao', $params['inCodTipoEmissao']);
        $query->bindValue('inCodFolha', $params['inCodFolha']);
        $query->bindValue('stDesdobramento', $params['stDesdobramento']);
        $query->bindValue('inCodComplementar', $params['inCodComplementar']);
        $query->bindValue('boAgruparFolhas', $params['boAgruparFolhas']);

        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function montaRecuperaTodosVigencia($params)
    {
        $sql = <<<SQL
SELECT configuracao_ipe.*                                                                              
             , configuracao_ipe_pensionista.cod_atributo_data as cod_atributo_data_pen                           
             , configuracao_ipe_pensionista.cod_modulo_data as cod_modulo_data_pen                               
             , configuracao_ipe_pensionista.cod_cadastro_data as cod_cadastro_data_pen                           
             , configuracao_ipe_pensionista.cod_atributo_mat as cod_atributo_mat_pen                             
             , configuracao_ipe_pensionista.cod_modulo_mat as cod_modulo_mat_pen                                 
             , configuracao_ipe_pensionista.cod_cadastro_mat as cod_cadastro_mat_pen                             
            FROM folhapagamento.configuracao_ipe                                       
        LEFT JOIN folhapagamento.configuracao_ipe_pensionista                           
              ON configuracao_ipe.cod_configuracao = configuracao_ipe_pensionista.cod_configuracao               
             AND configuracao_ipe.vigencia = configuracao_ipe_pensionista.vigencia 
SQL;

        if ($params != "") {
            $sql .= <<<SQL
WHERE configuracao_ipe.vigencia <= (SELECT dt_final                                                                  
                                                   FROM folhapagamento.periodo_movimentacao             
                                                  WHERE cod_periodo_movimentacao = :inCodPeriodoMovimentacao)
ORDER BY configuracao_ipe.vigencia DESC, configuracao_ipe.cod_configuracao DESC LIMIT 1 
SQL;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':inCodPeriodoMovimentacao', $params, \PDO::PARAM_INT);
        $query->execute();
        $ret = $query->fetchAll();
        $result = array_shift($ret);

        return $result;
    }
}
