<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
/**
 * Class StCnpjSetor
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class StCnpjSetor extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        if ($setor = $this->dataCollection->findObjectByName(FieldsAndData::ST_CNPJ_SETOR_NAME)) {
            list($exercicio, $codEntidade) = explode("~", $this->getValueWhenArray($setor->getValue()));

            if ($entidade = $this->getEntidade($codEntidade, $exercicio)) {
                $setor->setValue($entidade->getFkSwCgm()->getNomCgm());
                $setor->setText($setor->getValue());
            }
        }
    }
}