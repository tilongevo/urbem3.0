<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConfiguracaoLancamentoReceitaRepository
 * @package Urbem\CoreBundle\Repository\Contabilidade
 */
class ConfiguracaoLancamentoReceitaRepository extends AbstractRepository
{

    /**
     * @param $codContaReceita
     * @param $exercicio
     * @return mixed
     */
    public function getConfiguracaoReceita($codContaReceita, $exercicio)
    {
        $sql = "
        SELECT configuracao_lancamento_receita.cod_conta,
		    CASE 
		 			WHEN plano_conta.cod_estrutural LIKE '2.1.2.%' THEN 'operacoesCredito'
					WHEN plano_conta.cod_estrutural LIKE '1.2.3.%' THEN 'alienacaoBens'
				    WHEN plano_conta.cod_estrutural LIKE '1.1.2.3.%' 
					OR plano_conta.cod_estrutural LIKE '1.1.2.4.%' 
					OR plano_conta.cod_estrutural LIKE '1.1.2.5.1.%' THEN 'dividaAtiva'
		   			ELSE 'arrecadacaoDireta'
		    END AS tipo_arrecadacao,
		 	configuracao_lancamento_receita.cod_conta_receita,
		 	CASE 
					WHEN conta_receita.vl_arrecadacao > 0 THEN TRUE
				    ELSE FALSE
		   END AS bo_arrecadacao
        FROM contabilidade.configuracao_lancamento_receita
        INNER JOIN contabilidade.plano_conta
        ON configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
        AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
        LEFT JOIN ( 
                            SELECT 
                                conta_receita.exercicio,
                                conta_receita.cod_conta,
                                SUM(arrecadacao_receita.vl_arrecadacao) AS vl_arrecadacao
                            FROM orcamento.conta_receita
                            INNER JOIN orcamento.receita
                            ON receita.exercicio = conta_receita.exercicio
                            AND receita.cod_conta = conta_receita.cod_conta
                            INNER JOIN tesouraria.arrecadacao_receita
                            ON arrecadacao_receita.exercicio = receita.exercicio
                            AND arrecadacao_receita.cod_receita = receita.cod_receita
                            WHERE conta_receita.exercicio = :exercicio
                            GROUP BY conta_receita.exercicio, conta_receita.cod_conta
        ) AS conta_receita
        ON conta_receita.exercicio = configuracao_lancamento_receita.exercicio
        AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita
        WHERE configuracao_lancamento_receita.cod_conta_receita = :codContaReceita
        AND configuracao_lancamento_receita.estorno = FALSE
        AND configuracao_lancamento_receita.exercicio = :exercicio ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codContaReceita', $codContaReceita);
        $query->execute();

        return $query->fetch();
    }
}
