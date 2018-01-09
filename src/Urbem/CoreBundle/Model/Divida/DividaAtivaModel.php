<?php

namespace Urbem\CoreBundle\Model\Divida;

use DateTime;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\Modalidade;

/**
 * Class ConsultaInscricaoDividaModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class DividaAtivaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository;

    /**
     * ConsultaInscricaoDividaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DividaAtiva::class);
    }

    /**
     * @param $params
     * @return array
     */
    public function filtraInscricaoDividaAtiva($params)
    {
        return $this->repository->filtraInscricaoDividaAtiva($params);
    }

    /**
     * @param int
     * @param int
     * @param array
     * @return true | int
     */
    public function validateModalidadeParcelas($codModalidade, $qtdParcelas, array $dividas)
    {
        $modalidade = $this->entityManager->getRepository(Modalidade::class)
            ->findOneByCodModalidade($codModalidade);

        if (!$modalidade) {
            return false;
        }

        $modalidadeVigencia = $modalidade->getFkDividaModalidadeVigencias();

        $criteria = Criteria::create()
            ->where(Criteria::expr()->lte('vigenciaInicial', new DateTime()))
            ->andWhere(Criteria::expr()->gte('vigenciaFinal', new DateTime()))
        ;

        $modalidadeVigenciaCriteria = $modalidadeVigencia->matching($criteria);
        $modalidadeParcela = $modalidadeVigenciaCriteria->last()->getFkDividaModalidadeParcelas()->last();

        if ($modalidadeParcela) {
            foreach ($dividas as $divida) {
                $dividaTotal = $divida;

                if ($dividaTotal >= $modalidadeParcela->getVlrLimiteInicial() && $dividaTotal <= $modalidadeParcela->getVlrLimiteFinal()) {
                    if ($qtdParcelas <= $modalidadeParcela->getQtdParcela()) {
                        return true;
                    }

                    return $modalidadeParcela->getQtdParcela();
                }
            }
        }
    }
}
