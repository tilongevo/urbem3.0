<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Folhapagamento\ComplementarSituacaoRepository;

class ComplementarSituacaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ComplementarSituacaoRepository|object  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ComplementarSituacao");
    }

    /**
     * @param Entity\Folhapagamento\Complementar $complementar
     * @param                                    $situacao
     * @param                                    $exercicio
     *
     * @return Entity\Folhapagamento\ComplementarSituacao
     */
    public function buildOneBasedComplementar(Entity\Folhapagamento\Complementar $complementar, $situacao, $exercicio)
    {
        $complementarSituacao = new Entity\Folhapagamento\ComplementarSituacao();
        $complementarSituacao->setFkFolhapagamentoComplementar($complementar);
        $complementarSituacao->setSituacao($situacao);

        if ($situacao == 'f') {
            try {
                $this->fechaFolhaComplementar($complementar, $exercicio);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        if ($situacao == 'e') {
            $this->excluiFolhaComplementar($complementar, $exercicio);
            return $complementarSituacao;
        }

        $this->save($complementarSituacao);
        return $complementarSituacao;
    }

    /**
     * @param Entity\Folhapagamento\Complementar $complementar
     * @param                                    $exercicio
     */
    public function fechaFolhaComplementar(Entity\Folhapagamento\Complementar $complementar, $exercicio)
    {
        if ($complementar->getFkFolhapagamentoComplementarSituacoes()->last()->getSituacao() == 'a') {
            $registroEventoComplementarModel = new RegistroEventoComplementarModel($this->entityManager);
            $registros = $registroEventoComplementarModel->recuperaContratosComRegistroDeEventoReduzido(
                $complementar->getCodPeriodoMovimentacao(),
                $complementar->getCodComplementar()
            );

            $stCodContratos = "";
            foreach ($registros as $registro) {
                $stCodContratos .= $registro["cod_contrato"] . ",";
            }
             $stCodContratos = substr($stCodContratos, 0, strlen($stCodContratos) - 1);
            if (trim($stCodContratos) != "") {
                $registroEventoModel = new RegistroEventoModel($this->entityManager);
                $rsRegistroEventoPeriodo = $registroEventoModel->recuperaRegistrosDeEventos(
                    $complementar->getCodPeriodoMovimentacao(),
                    $stCodContratos,
                    false
                );
            }

            if (!empty($rsRegistroEventoPeriodo)) {
                foreach ($rsRegistroEventoPeriodo as $registroEvento) {
                    $eventoCalculadoDependente = $this->entityManager->getRepository(Entity\Folhapagamento\EventoCalculadoDependente::class)
                        ->findOneBy(
                            [
                                'codEvento' => $registroEvento['cod_evento'],
                                'codRegistro' => $registroEvento['cod_registro'],
                                'timestampRegistro' => $registroEvento['timestamp'],
                            ]
                        );
                    if (is_object($eventoCalculadoDependente)) {
                        $this->remove($eventoCalculadoDependente);
                    }

                    $eventoCalculadoModel = new EventoCalculadoModel($this->entityManager);
                    $eventoCalculadoModel->excluirEventoCalculado(
                        $registroEvento['cod_evento'],
                        $registroEvento['cod_registro'],
                        $registroEvento['timestamp']
                    );

                    $logErroCalculoModel = new LogErroCalculoModel($this->entityManager);
                    $logErroCalculoModel->excluirLogErroCalculo(
                        $registroEvento['cod_evento'],
                        $registroEvento['cod_registro'],
                        $registroEvento['timestamp']
                    );
                }

                foreach ($registros as $rsContratos) {
                    $arCGMs[] = $rsContratos["numcgm"];
                }

                $arCGMs = array_unique($arCGMs);
                $stCGMs = implode(",", $arCGMs);
                $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($this->entityManager);
                if (trim($stCGMs) != "") {
                    $rsContratosAutomaticos = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos(
                        $complementar->getCodPeriodoMovimentacao(),
                        $stCGMs
                    );
                }
                
                if (!empty($rsContratosAutomaticos)) {
                    foreach ($rsContratosAutomaticos as $contratosAutomatico) {
                        $registroEventoPeriodoModel->calculaFolha($contratosAutomatico['cod_contrato'], '1', 'f', '', $exercicio);
                    }
                }
            }
        }
    }

    /**
     * @param Entity\Folhapagamento\Complementar $complementar
     * @param                                    $exercicio
     */
    public function excluiFolhaComplementar(Entity\Folhapagamento\Complementar $complementar, $exercicio)
    {
        $rsRegistroEventoComplementar = $this->entityManager->getRepository(Entity\Folhapagamento\RegistroEventoComplementar::class)
            ->findBy(
                [
                    'codPeriodoMovimentacao' => $complementar->getCodPeriodoMovimentacao(),
                    'codComplementar' => $complementar->getCodComplementar()
                ]
            );
        $arContratos = [];
        if (!empty($rsRegistroEventoComplementar)) {
            /** @var Entity\Folhapagamento\RegistroEventoComplementar $eventoComplementar */
            foreach ($rsRegistroEventoComplementar as $eventoComplementar) {
                $arContratos[] = ["cod_contrato" => $eventoComplementar->getCodContrato()];

                $registroEventoComplementarModel = new RegistroEventoComplementarModel($this->entityManager);
                $registroEventoComplementarModel->montaDeletarRegistro(
                    $eventoComplementar->getCodRegistro(),
                    $eventoComplementar->getCodEvento(),
                    $eventoComplementar->getCodConfiguracao(),
                    $eventoComplementar->getTimestamp()
                );
            }
        }

        $arContratos = array_unique($arContratos);
        $rsDeducaoDependenteComplementar = $this->entityManager->getRepository(Entity\Folhapagamento\DeducaoDependenteComplementar::class)
            ->findBy(
                [
                    'codPeriodoMovimentacao' => $complementar->getCodPeriodoMovimentacao(),
                    'codComplementar' => $complementar->getCodComplementar()
                ]
            );
        if (!empty($rsDeducaoDependenteComplementar)) {
            foreach ($rsDeducaoDependenteComplementar as $deducaoDependenteComplementar) {
                $rsDeducaoDependente = $this->entityManager->getRepository(Entity\Folhapagamento\DeducaoDependente::class)
                    ->findOneBy(
                        [
                            'codPeriodoMovimentacao' => $deducaoDependenteComplementar->getNumcgm(),
                            'codComplementar' => $deducaoDependenteComplementar->getCodPeriodoMovimentacao(),
                            'codTipo' => $deducaoDependenteComplementar->getCodTipo()
                        ]
                    );

                if (is_object($rsDeducaoDependente)) {
                    $this->remove($rsDeducaoDependente);
                }

                $this->remove($deducaoDependenteComplementar);
            }
        }

        /** @var Entity\Folhapagamento\ContratoServidorComplementar $contratoServidorComplementar */
        $contratoServidorComplementar = $this->entityManager->getRepository(Entity\Folhapagamento\ContratoServidorComplementar::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $complementar->getCodPeriodoMovimentacao(),
                    'codComplementar' => $complementar->getCodComplementar(),
                ]
            );

        if (is_object($contratoServidorComplementar)) {
            $this->remove($contratoServidorComplementar);
        }

        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($this->entityManager);
        foreach ($arContratos as $contrato) {
            $stFiltro = " AND registro_evento_periodo.cod_periodo_movimentacao = " . $complementar->getCodPeriodoMovimentacao();
            $stFiltro .= " AND registro_evento_periodo.cod_contrato = " . $contrato["cod_contrato"];
            $rsRegistroEvento = $registroEventoPeriodoModel->montaRecuperaRegistrosDeEventos($stFiltro);
            if (count($rsRegistroEvento) > 0) {
                $tipo = 1;
                $erro = 'f';
                $entidade = "";
                $registroEventoPeriodoModel->calculaFolha($contrato['cod_contrato'], $tipo, $erro, $entidade, $exercicio);
            }
        }

        /** @var Entity\Folhapagamento\ComplementarSituacao $situacao */
        foreach ($complementar->getFkFolhapagamentoComplementarSituacoes() as $situacao) {
            /** @var Entity\Folhapagamento\ComplementarSituacaoFechada $fechada */
            foreach ($situacao->getFkFolhapagamentoComplementarSituacaoFechadas() as $fechada) {
                $this->remove($fechada);
            }
            $this->remove($situacao);
        }

        if (is_object($complementar) && ($complementar->getCodComplementar())) {
            $this->remove($complementar);
        }
    }

    /**
     * @return object
     */
    public function recuperaUltimaFolhaComplementarSituacao()
    {
        return $this->repository->recuperaUltimaFolhaComplementarSituacao();
    }
}
