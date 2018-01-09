<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita;

/**
 * Class ConfiguracaoLancamentoReceitaModel
 * @package Urbem\CoreBundle\Model\Contabilidade
 */
class ConfiguracaoLancamentoReceitaModel extends AbstractModel
{
    /**
     * ConfiguracaoLancamentoReceitaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoLancamentoReceita::class);
    }

    /**
     * @param $contaReceita
     * @param $exercicio
     * @return bool
     */
    public function isCheckConfiguracaoReceita($contaReceita, $exercicio)
    {
        $result = $this->repository->getConfiguracaoReceita($contaReceita, $exercicio);
        return ($result && $result['bo_arrecadacao']) ? true : false;
    }

    /**
     * @param $contaReceita
     * @param $exercicio
     * @return mixed
     */
    public function getLancamentoAndCredito($contaReceita, $exercicio)
    {
        return $this->repository->getConfiguracaoReceita($contaReceita, $exercicio);
    }
}
