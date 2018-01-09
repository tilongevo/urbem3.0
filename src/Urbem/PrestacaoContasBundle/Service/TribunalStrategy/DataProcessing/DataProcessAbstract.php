<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing;

use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection;

/**
 * Class DataProcessAbstract
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy\DataProcessing
 */
abstract class DataProcessAbstract
{
    /**
     * @var \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory
     */
    protected $factory;

    /**
     * @var \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory
     */
    protected $dataCollection;

    /**
     * DataProcessAbstract constructor.
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoFactory $factory
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection $dataCollection
     */
    public function __construct(ConfiguracaoFactory $factory, DataCollection $dataCollection)
    {
        $this->factory = $factory;
        $this->dataCollection = $dataCollection;
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @return null|object
     */
    protected function getEntidade($codEntidade, $exercicio)
    {
        $entidadeModel = new EntidadeModel($this->factory->getEntityManager());

        return $entidadeModel->findOneByCodEntidadeAndExercicio($codEntidade, $exercicio);
    }

    // HotFix
    protected function getValueWhenArray($value) {
        if (is_array($value)) {
            return key($value);
        }

        return $value;
    }

}
