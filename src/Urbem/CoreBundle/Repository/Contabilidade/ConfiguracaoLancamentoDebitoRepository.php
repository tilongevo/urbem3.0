<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ConfiguracaoLancamentoDebitoRepository
 */
class ConfiguracaoLancamentoDebitoRepository extends AbstractRepository
{
    /**
     * @param string|integer $codContaDespesa
     * @return array
     */
    public function getContasDebitoCredito($codContaDespesa)
    {
        $sql = <<<SQL
SELECT
  contabilidade_configuracao_lancamento_debito.cod_conta         AS conta_debito,
  contabilidade_configuracao_lancamento_credito.cod_conta        AS conta_credito,
  contabilidade_configuracao_lancamento_debito.cod_conta_despesa AS conta_despesa,
  orcamento_conta_despesa.cod_estrutural

FROM contabilidade.configuracao_lancamento_debito contabilidade_configuracao_lancamento_debito
  
  INNER JOIN contabilidade.configuracao_lancamento_credito contabilidade_configuracao_lancamento_credito
    ON contabilidade_configuracao_lancamento_debito.cod_conta_despesa = contabilidade_configuracao_lancamento_credito.cod_conta_despesa
       AND contabilidade_configuracao_lancamento_debito.exercicio = contabilidade_configuracao_lancamento_credito.exercicio
       AND contabilidade_configuracao_lancamento_debito.estorno = contabilidade_configuracao_lancamento_credito.estorno
       AND contabilidade_configuracao_lancamento_debito.tipo = contabilidade_configuracao_lancamento_credito.tipo
  
  INNER JOIN orcamento.conta_despesa orcamento_conta_despesa
    ON contabilidade_configuracao_lancamento_credito.cod_conta_despesa = orcamento_conta_despesa.cod_conta
       AND contabilidade_configuracao_lancamento_credito.exercicio = orcamento_conta_despesa.exercicio

WHERE contabilidade_configuracao_lancamento_debito.estorno = FALSE
      AND contabilidade_configuracao_lancamento_debito.tipo = 'almoxarifado'
      AND contabilidade_configuracao_lancamento_debito.cod_conta_despesa = :cod_conta_despesa
  
GROUP BY 
  contabilidade_configuracao_lancamento_debito.cod_conta,
  contabilidade_configuracao_lancamento_credito.cod_conta,
  contabilidade_configuracao_lancamento_debito.cod_conta_despesa,
  orcamento_conta_despesa.cod_estrutural;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'cod_conta_despesa' => $codContaDespesa
        ]);

        return $stmt->fetchAll();
    }
}
