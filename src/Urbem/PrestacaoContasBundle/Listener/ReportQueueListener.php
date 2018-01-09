<?php

namespace Urbem\PrestacaoContasBundle\Listener;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;
use Zechim\QueueBundle\Service\Producer\CommandProducer;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;

/**
 * Class ReportQueueListener
 * @package Urbem\PrestacaoContasBundle\Listener
 */
class ReportQueueListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Zechim\QueueBundle\Service\Producer\CommandProducer
     */
    protected $producer;

    /**
     * @var Usuario
     */
    protected $user;

    /**
     * ReportQueueListener constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Zechim\QueueBundle\Service\Producer\CommandProducer $producer
     */
    public function __construct(EntityManager $entityManager, CommandProducer $producer, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->producer = $producer;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    /**
     * @param $hash
     * @throws \Exception
     */
    public function checkReportList($hash)
    {
        if (empty($hash)) {
            throw new \Exception(Error::INVALID_TEXT_EMPTY);
        }

        $filaRelatorioModel = new FilaRelatorioModel($this->entityManager);
        $reports = $filaRelatorioModel->getReportByUser($hash, $this->user);

        foreach($reports as $filaRelatorio) {
            $this->checkFilaRelatorio($filaRelatorio, $filaRelatorioModel);
        }
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel $filaRelatorioModel
     */
    public function checkFilaRelatorio(FilaRelatorio $filaRelatorio, FilaRelatorioModel $filaRelatorioModel)
    {
        $this->checkStatusCriado($filaRelatorio, $filaRelatorioModel);
        $this->checkStatusEnviando($filaRelatorio, $filaRelatorioModel);
        $this->checkStatusEnviado($filaRelatorio, $filaRelatorioModel);
        $this->checkStatusPronto($filaRelatorio, $filaRelatorioModel);
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @return array
     */
    private function getMomentCreatedReport(FilaRelatorio $filaRelatorio)
    {
        $minutesResposta = null;
        $minutesCriado = $minutesCriado = 0;
        $dataResposta = $filaRelatorio->getDataResposta();
        $dataCriacao = $filaRelatorio->getDataCriacao();
        $currentDateTime = new \DateTime('now');

        if ($dataCriacao instanceof \DateTime) {
            $minutesCriado = abs($dataCriacao->getTimestamp() - $currentDateTime->getTimestamp()) / 60;
        }

        if ($dataResposta instanceof \DateTime) {
            $minutesResposta = abs($dataResposta->getTimestamp() - $currentDateTime->getTimestamp()) / 60;
        }

        return [$minutesCriado, $minutesResposta];
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel $filaRelatorioModel
     * @return \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio|void
     */
    private function checkStatusEnviando(FilaRelatorio $filaRelatorio, FilaRelatorioModel $filaRelatorioModel)
    {
        if ($filaRelatorio->getStatus() != FilaRelatorio::STATUS_ENVIANDO) {
            return;
        }

        list($minutesCriado, $minutesResposta) = $this->getMomentCreatedReport($filaRelatorio);

        /*mais de 1 minutos sem resposta*/
        if (empty($minutesCriado) || $minutesCriado > 1) {
            return $filaRelatorioModel->updateStatusToError($filaRelatorio, "Sem comunicação com o servidor de relatórios");
        }
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel $filaRelatorioModel
     * @return \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio|void
     */
    private function checkStatusEnviado(FilaRelatorio $filaRelatorio, FilaRelatorioModel $filaRelatorioModel)
    {
        if ($filaRelatorio->getStatus() != FilaRelatorio::STATUS_ENVIADO) {
            return;
        }

        if (empty($filaRelatorio->getIdentificadorExterno())) {
            return $filaRelatorioModel->updateStatusToError($filaRelatorio, "Relatório enviado, mas sem ID de comunicação");
        }
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel $filaRelatorioModel
     * @return \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio|void
     */
    private function checkStatusCriado(FilaRelatorio $filaRelatorio, FilaRelatorioModel $filaRelatorioModel)
    {
        if ($filaRelatorio->getStatus() != FilaRelatorio::STATUS_CRIADO) {
            return;
        }

        list($minutesCriado, $minutesResposta) = $this->getMomentCreatedReport($filaRelatorio);

        /*se criado e sem ID e com menos de 5 minutos de criacao devemos enviar novamente, senão abortaremos processo*/
        if (empty($filaRelatorio->getIdentificadorExterno()) && in_array($minutesCriado, range(1, 3))) {
            return $filaRelatorioModel->updateStatusToCreated($filaRelatorio, $this->producer);
        }

        /*mais de 10 minutos sem resposta*/
        if (empty($minutesResposta) && $minutesCriado > 10) {
            return $filaRelatorioModel->updateStatusToError($filaRelatorio, "Não foi possível enviar relatório para fila");
        }
    }

    /**
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel $filaRelatorioModel
     * @return \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio|void
     */
    private function checkStatusPronto(FilaRelatorio $filaRelatorio, FilaRelatorioModel $filaRelatorioModel)
    {
        if ($filaRelatorio->getStatus() != FilaRelatorio::STATUS_PRONTO) {
            return;
        }

        list($minutesCriado, $minutesResposta) = $this->getMomentCreatedReport($filaRelatorio);

        /*Relatório pronto a mais de 5 minutos*/
        if ($minutesResposta > 5) {
            return $filaRelatorioModel->updateStatusToReady($filaRelatorio, $this->producer);
        }
    }
}
