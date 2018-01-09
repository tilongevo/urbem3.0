<?php

namespace Urbem\CoreBundle\ChainOfResponsability\Folhapagamento\ValidarFerias;

use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaSituacaoModel;

class ValidarFolhaSalario implements IValidarFerias
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
        if ($tipoFolha == TipoFolha::TIPO_SALARIO) {
            $folhaSituacaoModel = new folhaSituacaoModel($em);
            $situacao = $folhaSituacaoModel->montaRecuperaRelacionamento($codPeriodoMovimentacao);

            if (!empty($situacao)) {
                return "rh.pessoal.ferias.error.folhaSalario";
            }
        } else {
            return $this->proximo->validar($tipoFolha, $codPeriodoMovimentacao, $em);
        }
    }
}
