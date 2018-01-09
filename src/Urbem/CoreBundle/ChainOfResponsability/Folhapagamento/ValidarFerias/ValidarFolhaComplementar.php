<?php

namespace Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias;

use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;
use Urbem\CoreBundle\Model\Folhapagamento\ComplementarSituacaoModel;

class ValidarFolhaComplementar implements IValidarFerias
{
    private $proximo;

    /**
     * @param IValidarFerias $proximo
     */
    public function setProximo(IValidarFerias $proximo)
    {
        $this->proximo = $proximo;
    }

    /**
     * @param $tipoFolha
     * @param $codPeriodoMovimentacao
     * @param $em
     * @return string
     */
    public function validar($tipoFolha, $codPeriodoMovimentacao, $em)
    {
        if ($tipoFolha == TipoFolha::TIPO_COMPLEMENTAR) {
            $complementarSituacaoModel = new ComplementarSituacaoModel($em);
            $situacao = $complementarSituacaoModel->recuperaUltimaFolhaComplementarSituacao();

            if ($situacao->situacao == ComplementarSituacao::SITUACAO_FECHADO) {
                return "rh.pessoal.ferias.error.folhaComplementar";
            }
        } else {
            return $this->proximo->validar($tipoFolha, $codPeriodoMovimentacao, $em);
        }
    }
}
