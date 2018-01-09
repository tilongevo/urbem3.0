<?php

namespace Urbem\CoreBundle\Repository\Licitacao;

use Doctrine\ORM;

class ContratoRepository extends ORM\EntityRepository
{
    public function getLicitacaoContrato($exercicio)
    {
        $sql = "
        SELECT contrato.num_contrato
        	, contrato.exercicio
        	, objeto.descricao
        	, to_char(contrato.dt_assinatura, 'dd/mm/yyyy') AS dt_assinatura
        FROM licitacao.contrato
        LEFT JOIN licitacao.contrato_licitacao ON (
        		contrato.num_contrato = contrato_licitacao.num_contrato
        		AND contrato.exercicio = contrato_licitacao.exercicio
        		AND contrato.cod_entidade = contrato_licitacao.cod_entidade
        		)
        LEFT JOIN licitacao.contrato_compra_direta ON (
        		contrato.num_contrato = contrato_compra_direta.num_contrato
        		AND contrato.exercicio = contrato_compra_direta.exercicio
        		AND contrato.cod_entidade = contrato_compra_direta.cod_entidade
        		)
        LEFT JOIN licitacao.licitacao ON (
        		licitacao.cod_licitacao = contrato_licitacao.cod_licitacao
        		AND licitacao.cod_modalidade = contrato_licitacao.cod_modalidade
        		AND licitacao.exercicio = contrato_licitacao.exercicio_licitacao
        		AND licitacao.cod_entidade = contrato_licitacao.cod_entidade
        		)
        LEFT JOIN compras.compra_direta ON (
        		compra_direta.cod_compra_direta = contrato_compra_direta.cod_compra_direta
        		AND compra_direta.cod_modalidade = contrato_compra_direta.cod_modalidade
        		AND compra_direta.exercicio_entidade = contrato_compra_direta.exercicio
        		AND compra_direta.cod_entidade = contrato_compra_direta.cod_entidade
        		)
        LEFT JOIN compras.objeto ON (
        		licitacao.cod_objeto = objeto.cod_objeto
        		OR compra_direta.cod_objeto = objeto.cod_objeto
        		)
        WHERE objeto.cod_objeto IS NOT NULL
        	AND contrato.cod_entidade IS NULL
        	AND contrato.cgm_contratado IS NULL
        	AND contrato.exercicio = :exercicio
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
