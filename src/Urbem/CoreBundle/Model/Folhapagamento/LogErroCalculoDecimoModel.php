<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\LogErroCalculoDecimoRepository;

class LogErroCalculoDecimoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var LogErroCalculoDecimoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\LogErroCalculoDecimo");
    }

    /**
     * @param $codEvento
     * @param $codRegistro
     * @param $timestamp
     */
    public function excluirLogErroCalculo($codEvento, $codRegistro, $timestamp)
    {
        /** @var Entity\Folhapagamento\LogErroCalculo $logErroCalculo */
        $logErroCalculo = $this->entityManager->getRepository(Entity\Folhapagamento\LogErroCalculoDecimo::class)
            ->findOneBy(
                [
                    'codEvento' => $codEvento,
                    'codRegistro' => $codRegistro,
                    'timestamp' => $timestamp
                ]
            );

        if (is_object($logErroCalculo)) {
            $this->remove($logErroCalculo);
        }
    }

    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaLogErroCalculo($stFiltro)
    {
        return $this->repository->recuperaLogErroCalculo($stFiltro);
    }

    /**
     * @param bool $stFiltro
     * @param bool $orderBy
     *
     * @return array
     */
    public function recuperaContratosComErro($stFiltro = false, $orderBy = false)
    {
        $orderBy = ($orderBy) ? $orderBy : " ultimo_registro_evento.cod_registro";
        return $this->repository->recuperaContratosComErro($stFiltro, $orderBy);
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function recuperaRelacionamento($stFiltro = false)
    {
        return $this->repository->recuperaRelacionamento($stFiltro);
    }
}
