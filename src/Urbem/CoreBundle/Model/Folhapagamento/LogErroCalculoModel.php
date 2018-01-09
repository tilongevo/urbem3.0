<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\LogErroCalculoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\TabelaIrrfRepository;

class LogErroCalculoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var LogErroCalculoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\LogErroCalculo");
    }

    /**
     * @param $error
     */
    public function buildOneBasedFolhaCalcular($error)
    {
        $logErroCalculo = new LogErroCalculo();
        $logErroCalculo->setErro($error);
    }

    /**
     * @param $codEvento
     * @param $codRegistro
     * @param $timestamp
     */
    public function excluirLogErroCalculo($codEvento, $codRegistro, $timestamp)
    {
        /** @var Entity\Folhapagamento\LogErroCalculo $logErroCalculo */
        $logErroCalculo = $this->entityManager->getRepository(Entity\Folhapagamento\LogErroCalculo::class)
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
    public function recuperaErrosDoContrato($stFiltro = false, $orderBy = false)
    {
        $orderBy = ($orderBy) ? $orderBy : " ultimo_registro_evento.cod_registro";
        return $this->repository->recuperaErrosDoContrato($stFiltro, $orderBy);
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
