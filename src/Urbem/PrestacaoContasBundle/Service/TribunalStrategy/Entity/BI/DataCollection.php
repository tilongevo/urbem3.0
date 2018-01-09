<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Exception\Error;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;

/**
 * Class DataCollection
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI
 */
class DataCollection extends ArrayCollection
{
    /**
     * @return array
     */
    public function exportDataAndValueToArray()
    {
        $data = [];
        $value = [];

        foreach ($this->getIterator() as $dataView) {
            $data[] = $dataView->exportToArray();
            $value[$dataView->getName()] = $dataView->getValue();
        }

        return [ConfiguracaoAbstract::DATA_KEY => $data, ConfiguracaoAbstract::VALUE_KEY => $value];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function checkContentIsValid()
    {
        if (!$this->count()) {
            throw new \Exception(Error::INVALID_PARAMETER_ZERO);
        }

        return true;
    }

    /**
     * @param $value
     * @return bool|mixed
     */
    public function findObjectByName($value)
    {
        foreach ($this->getIterator() as $dataView) {
            if ($dataView->getName() == $value) {
                return $dataView;
            }
        }

        return false;
    }

    /**
     * Reorganiza chaves
     */
    public function orderByKey()
    {
        $items = [];
        foreach ($this->getIterator() as $element) {
            $items[] = $element;
        }
        $this->clear();
        $this->__construct($items);
    }
}
