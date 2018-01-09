<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoComplementarRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoPeriodoRepository;

class RegistroEventoComplementarModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoComplementarRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEventoComplementar");
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $codComplementar
     * @return array
     */
    public function recuperaContratosComRegistroDeEventoReduzido($codPeriodoMovimentacao, $codComplementar)
    {
        return $this->repository->recuperaContratosComRegistroDeEventoReduzido($codPeriodoMovimentacao, $codComplementar);
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @return array
     */
    public function montaDeletarRegistro($codRegistro, $codEvento, $desdobramento, $timestamp)
    {
        return $this->repository->montaDeletarRegistro($codRegistro, $codEvento, $desdobramento, $timestamp);
    }

    /**
     * @param integer $codEvento
     * @param integer $codConfiguracao
     * @return int
     */
    public function getNextCodRegistro($codEvento, $codConfiguracao)
    {
        return $this->repository->getNextCodRegistro($codEvento, $codConfiguracao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $codComplementar
     * @param $codContrato
     * @return array
     */
    public function montaRecuperaRegistrosEventoDoContrato($codPeriodoMovimentacao, $codComplementar, $codContrato)
    {
        return $this->repository->montaRecuperaRegistrosEventoDoContrato($codPeriodoMovimentacao, $codComplementar, $codContrato);
    }

    /**
     * @param integer $codPeriodoMovimentacao
     * @param integer $codContrato
     * @param null|integer $codComplementar
     * @return ContratoServidorComplementar
     */
    public function recuperarContratoServidorComplementar($codPeriodoMovimentacao, $codComplementar, $codContrato)
    {
        if ($codComplementar) {
            $contratoServidorComplementar = $this->entityManager->getRepository(ContratoServidorComplementar::class)->findOneBy([
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'codComplementar' => $codComplementar,
                'codContrato' => $codContrato
            ]);
        } else {
            /** @var Contrato $contrato */
            $contrato = $this->entityManager->getRepository(Contrato::class)->find($codContrato);
            /** @var PeriodoMovimentacao $periodoMovimentacao */
            $periodoMovimentacao = $this->entityManager->getRepository(PeriodoMovimentacao::class)->find($codPeriodoMovimentacao);

            $contratoServidorComplementar = new ContratoServidorComplementar();
            $contratoServidorComplementar->setFkPessoalContrato($contrato);
            $contratoServidorComplementar->setFkFolhapagamentoComplementar($periodoMovimentacao->getFkFolhapagamentoComplementares()->current());

            $this->entityManager->persist($contratoServidorComplementar);
        }
        return $contratoServidorComplementar;
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     * @param null|integer $parcela
     * @return UltimoRegistroEventoComplementar
     */
    public function manterUltimoRegistroEventoComplementar($registroEventoComplementar, $parcela)
    {
        if (!$registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar()) {
            $timestamp = $registroEventoComplementar->getTimestamp();
            $ultimoRegistroEventoComplementar = new UltimoRegistroEventoComplementar();
            $ultimoRegistroEventoComplementar->setTimestamp($timestamp);
            $ultimoRegistroEventoComplementar->setFkFolhapagamentoRegistroEventoComplementar($registroEventoComplementar);

            if ($parcela) {
                $registroEventoComplementarParcela = new RegistroEventoComplementarParcela();
                $registroEventoComplementarParcela->setTimestamp($timestamp);
                $registroEventoComplementarParcela->setParcela($parcela);
                $ultimoRegistroEventoComplementar->setFkFolhapagamentoRegistroEventoComplementarParcela($registroEventoComplementarParcela);
            }

            $registroEventoComplementar->setFkFolhapagamentoUltimoRegistroEventoComplementar($ultimoRegistroEventoComplementar);
        }
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     * @param $timestamp
     */
    public function manterRegistrosEventoComplementarAnteriores($registroEventoComplementar, $timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = $registroEventoComplementar->getTimestamp();
        }

        $registrosEventoComplementar = $this->montaRecuperaRegistrosEventoDoContrato(
            $registroEventoComplementar->getCodPeriodoMovimentacao(),
            $registroEventoComplementar->getCodComplementar(),
            $registroEventoComplementar->getCodContrato()
        );

        if (count($registrosEventoComplementar)) {
            foreach ($registrosEventoComplementar as $item) {

                /** @var RegistroEventoComplementar $registroEventoComplementarAnterior */
                $registroEventoComplementarAnterior = $this->repository->findOneBy([
                    'codRegistro' => $item['cod_registro'],
                    'timestamp' => $item['timestamp'],
                    'codEvento' => $item['cod_evento'],
                    'codConfiguracao' => $item['cod_configuracao']
                ]);

                if ($registroEventoComplementar->getCodEvento() != $registroEventoComplementarAnterior->getCodEvento()) {
                    $registrosEventoComplementarNovo = new RegistroEventoComplementar();

                    $codRegistro = $this->getNextCodRegistro(
                        $registroEventoComplementarAnterior->getCodEvento(),
                        $registroEventoComplementarAnterior->getCodConfiguracao()
                    );

                    $registrosEventoComplementarNovo->setCodRegistro($codRegistro);
                    $registrosEventoComplementarNovo->setTimestamp($timestamp);
                    $registrosEventoComplementarNovo->setValor($registroEventoComplementarAnterior->getValor());
                    $registrosEventoComplementarNovo->setQuantidade($registroEventoComplementarAnterior->getQuantidade());
                    $registrosEventoComplementarNovo->setFkFolhapagamentoEvento($registroEventoComplementarAnterior->getFkFolhapagamentoEvento());
                    $registrosEventoComplementarNovo->setFkFolhapagamentoContratoServidorComplementar($registroEventoComplementarAnterior->getFkFolhapagamentoContratoServidorComplementar());
                    $registrosEventoComplementarNovo->setFkFolhapagamentoConfiguracaoEvento($registroEventoComplementarAnterior->getFkFolhapagamentoConfiguracaoEvento());

                    $ultimoRegistroEventoComplementarNovo = new UltimoRegistroEventoComplementar();
                    $ultimoRegistroEventoComplementarNovo->setTimestamp($timestamp);
                    $registrosEventoComplementarNovo->setFkFolhapagamentoUltimoRegistroEventoComplementar($ultimoRegistroEventoComplementarNovo);

                    if ($registroEventoComplementarAnterior->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela()) {
                        $registroEventoComplementarParcelaNovo = new RegistroEventoComplementarParcela();
                        $registroEventoComplementarParcelaNovo->setTimestamp($timestamp);
                        $registroEventoComplementarParcelaNovo->setParcela($registroEventoComplementarAnterior->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela()->getParcela());
                        $ultimoRegistroEventoComplementarNovo->setFkFolhapagamentoRegistroEventoComplementarParcela($registroEventoComplementarParcelaNovo);
                    }
                    (new UltimoRegistroEventoModel($this->entityManager))->montaDeletarUltimoRegistro($item['cod_registro'], $item['cod_evento'], '1', $item['timestamp'], 'C');
                    $this->entityManager->persist($registrosEventoComplementarNovo);
                } else {
                    (new UltimoRegistroEventoModel($this->entityManager))->montaDeletarUltimoRegistro($item['cod_registro'], $item['cod_evento'], '1', $item['timestamp'], 'C');
                }
            }
        }
    }
}
