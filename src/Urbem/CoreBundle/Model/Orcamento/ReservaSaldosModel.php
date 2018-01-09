<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Repository;

class ReservaSaldosModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var Repository\Orcamento\ReservaSaldosRepository|null */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\ReservaSaldos");
    }

    public function saveReservaSaldos($exercicio, $despesa, $solicitacao, $motivo, $nuVlReserva, $dataInicial, $dataFinal)
    {
        $dataFinal = new \DateTime();
        $reservaSaldos = new Entity\Orcamento\ReservaSaldos();
        $reservaSaldos->setCodReserva($this->getProximoCodReserva($despesa->getExercicio()));
        $reservaSaldos->setExercicio($despesa->getExercicio());
        if (is_object($despesa)) {
            $reservaSaldos->setFkOrcamentoDespesa($despesa);
        } else {
            $reservaSaldos->setCodDespesa($despesa);
        }
        $reservaSaldos->setDtValidadeInicial($dataInicial);
        $reservaSaldos->setMotivo($motivo);
        $reservaSaldos->setVlReserva($nuVlReserva);
        $reservaSaldos->setDtValidadeFinal($dataFinal);
        $this->save($reservaSaldos);

        return $reservaSaldos;
    }

    /**
     * @param string $exercicio
     * @return int
     */
    public function getProximoCodReserva($exercicio)
    {
        return $this->repository->getProximoCodReserva($exercicio);
    }

    /**
     * @param $exercicio
     * @param $codDespesa
     * @param $dataEmpenho
     * @param $codEntidade
     * @param $tipo
     * @return bool|string
     */
    public function getSaldoDotacao($exercicio, $codDespesa, $dataEmpenho, $codEntidade, $tipo)
    {
        return $this->repository->getSaldoDotacao($exercicio, $codDespesa, $dataEmpenho, $codEntidade, $tipo);
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @param $codDespesa
     * @param $dtValidadeInicial
     * @param $dtValidadeFinal
     * @param $vlReserva
     * @param $tipo
     * @param $motivo
     * @return mixed
     */
    public function montaincluiReservaSaldo($codReserva, $exercicio, $codDespesa, $dtValidadeInicial, $dtValidadeFinal, $vlReserva, $tipo, $motivo)
    {
        return $this->repository->montaincluiReservaSaldo($codReserva, $exercicio, $codDespesa, $dtValidadeInicial, $dtValidadeFinal, $vlReserva, $tipo, $motivo);
    }

    /**
     * @param $codReserva
     * @param $exercicio
     *
     * @return ReservaSaldos
     */
    public function getOneReservaSaldos($codReserva, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codReserva' => $codReserva
        ]);
    }

    /**
     * @param int        $codReserva
     * @param string|int $exercicio
     * @param float|int  $vlReserva
     *
     * @return array
     */
    public function alteraReservaSaldo($codReserva, $exercicio, $vlReserva)
    {
        return $this->repository->alteraReservaSaldo($codReserva, $exercicio, $vlReserva);
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @return mixed
     */
    public function getValueAvaiableDotacao($codReserva, $exercicio)
    {
        return $this->repository->getValueAvaiableDotacao($codReserva, $exercicio);
    }

    /**
     * @param int    $codReserva
     * @param string $exercicio
     */
    public function removeOneByCodReservaAndExercicio($codReserva, $exercicio)
    {
        /** @var ReservaSaldos $reservaSaldos */
        $reservaSaldos = $this->repository->findOneBy([
            'exercicio'  => $exercicio,
            'codReserva' => $codReserva,
        ]);

        if (!is_null($reservaSaldos)) {
            $this->entityManager->remove($reservaSaldos);
        }
    }
}
