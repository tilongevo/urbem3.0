<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Repository\Contabilidade\ConfiguracaoLancamentoDebitoRepository;

/**
 * Class ConfiguracaoLancamentoDebitoModel
 */
class ConfiguracaoLancamentoDebitoModel extends AbstractModel
{
    /** @var ConfiguracaoLancamentoDebitoRepository $repository */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(ConfiguracaoLancamentoDebito::class);
    }

    /**
     * @param ContaDespesa $contaDespesa
     * @return array
     */
    public function getContasDebitoCredito(ContaDespesa $contaDespesa)
    {
        return $this->repository->getContasDebitoCredito($contaDespesa->getCodConta());
    }
}
