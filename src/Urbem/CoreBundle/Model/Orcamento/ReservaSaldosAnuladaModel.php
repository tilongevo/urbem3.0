<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;

class ReservaSaldosAnuladaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\ReservaSaldosAnulada");
    }

    public function getProximoCodReserva($exercicio)
    {
        $em = $this->entityManager;
        $reservaSaldos = $em->getRepository('CoreBundle:Orcamento\ReservaSaldos')
            ->findOneBy(['exercicio' => $exercicio], ['codReserva' => 'DESC']);
        if (!$reservaSaldos) {
            $proximoCodReserva = 1;
        } else {
            $proximoCodReserva = $reservaSaldos->getCodReserva() + 1;
        }

        return $proximoCodReserva;
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @param $motivoAnulacao
     * @return null|object
     */
    public function getOneByCodReservaAndExercicioAndMotivoAnulacao($codReserva, $exercicio, $motivoAnulacao)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codReserva' => $codReserva,
            'motivoAnulacao' => $motivoAnulacao
        ]);
    }

    /**
     * @param $codReserva
     * @param $exercicio
     * @return null|object
     */
    public function getOneByCodReservaAndExercicio($codReserva, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codReserva' => $codReserva,
        ]);
    }

    /**
     * @param ReservaSaldos $reservaSaldos
     * @param $formData
     * @param $motivo
     */
    public function saveReservaSaldosAnulada(ReservaSaldos $reservaSaldos, $formData, $motivo = false)
    {
        $rSaldoAnulada = new ReservaSaldosAnulada();
        $motivo = ($motivo) ? $motivo : '';
        $rSaldoAnulada->setFkOrcamentoReservaSaldos($reservaSaldos);
        $rSaldoAnulada->setMotivoAnulacao($motivo);
        $dtAnulacao = new \DateTime(str_replace('/', '-', $formData['dtAutorizacao']));
        $rSaldoAnulada->setDtAnulacao($dtAnulacao);
        $this->save($rSaldoAnulada);
    }

    /**
     * @param ReservaSaldos $reservaSaldos
     * @param \DateTime     $dtAnulacao
     * @param string        $motivoAnulacao
     *
     * @return ReservaSaldosAnulada
     */
    public function buildOne(ReservaSaldos $reservaSaldos, \DateTime $dtAnulacao, $motivoAnulacao)
    {
        $reservaSaldosAnulada = new ReservaSaldosAnulada();

        $reservaSaldosAnulada->setFkOrcamentoReservaSaldos($reservaSaldos);
        $reservaSaldosAnulada->setDtAnulacao($dtAnulacao);
        $reservaSaldosAnulada->setMotivoAnulacao($motivoAnulacao);

        $this->entityManager->persist($reservaSaldosAnulada);

        return $reservaSaldosAnulada;
    }

    /**
     * @param int    $codReserva
     * @param string $exercicio
     */
    public function removeOneByCodReservaAndExercicio($codReserva, $exercicio)
    {
        /** @var ReservaSaldosAnulada $reservaSaldosAnulada */
        $reservaSaldosAnulada = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codReserva' => $codReserva,
        ]);

        if (!is_null($reservaSaldosAnulada)) {
            $this->entityManager->remove($reservaSaldosAnulada);
        }
    }
}
