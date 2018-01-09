<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;

/**
 * Class Entidade
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
class Entidade extends DataProcessAbstract implements DataProcessingInterface
{
    /**
     * @void
     */
    public function process()
    {
        if ($entidades = $this->dataCollection->findObjectByName(FieldsAndData::ENTIDADE_NAME)) {
            $text = null;
            $value = [];
            $entidadesList = $entidades->getValue();

            if (false === is_array($entidadesList)) {
                return null;
            }

            foreach($entidadesList as $key => $entidade) {
                $entidade = strpos($key, "~") !== false?$key:$entidade;

                list($exercicio, $codEntidade) = explode("~", $entidade);
                $entidade = $this->getEntidade($codEntidade, $exercicio);

                if (!empty($entidade)) {
                    $text .= sprintf(", %s - %s", $codEntidade, $entidade->getFkSwCgm()->getNomCgm());
                    $value[] = $codEntidade;
                }
            }

            $entidades->setText(substr($text, 1));
            $entidades->setValue(implode(",", $value));
        }
    }
}