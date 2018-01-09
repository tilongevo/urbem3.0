<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoCalculadoRepository;

class EventoCalculadoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var EventoCalculadoRepository|null */
    protected $eventoRepository = null;

    const NATUREZA_BASE = 'B';
    const NATUREZA_DESCONTO = 'D';

    /**
     * EventoCalculadoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\EventoCalculado");
    }

    /**
     * @param bool $filtro
     * @param null $ordem
     * @return array
     */
    public function montaRecuperaEventosCalculados($filtro = false, $ordem = null)
    {
        return $this->eventoRepository->montaRecuperaEventosCalculados($filtro, $ordem);
    }

    /**
     * @param $codConfiguracao
     * @param $codPeriodoMovimentacao
     * @param $codContrato
     * @param $codComplementar
     * @param $entidade
     * @param $ordem
     * @return array
     */
    public function recuperarEventosCalculadosFichaFinanceira($codConfiguracao, $codPeriodoMovimentacao, $codContrato, $codComplementar, $entidade, $ordem)
    {
        return $this->eventoRepository->recuperarEventosCalculadosFichaFinanceira($codConfiguracao, $codPeriodoMovimentacao, $codContrato, $codComplementar, $entidade, $ordem);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return array
     */
    public function montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return array
     */
    public function montaRecuperaValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return array
     */

    public function montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $codConfiguracao
     * @param $codContrato
     * @param $entidade
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function processarEventoFichaFinanceira($codConfiguracao, $codContrato, $entidade, $codPeriodoMovimentacao)
    {
        $rsValoresAcumuladosBase = $rsRotuloValoresAcumuladosBase = $rsValoresAcumuladosDesconto = '';
        $rsRotuloValoresAcumuladosDesconto = $rsValoresAcumuladosBaseSalarioFamilia = '';
        $rsRotuloValoresAcumuladosBaseSalarioFamilia = '';

        $contratoModel = new ContratoModel($this->entityManager);
        $cgm = $contratoModel->montaRecuperaCgmDoRegistro($codContrato, $entidade);

        switch ($codConfiguracao) {
            case 0:
                $eventoComplementarCalculadoModel = new EventoComplementarCalculadoModel($this->entityManager);
                $rsValoresAcumuladosBase = $eventoComplementarCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBase = $eventoComplementarCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsValoresAcumuladosDesconto = $eventoComplementarCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                $rsRotuloValoresAcumuladosDesconto = $eventoComplementarCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                break;
            case 1:
                $eventoCalculadoModel = new EventoCalculadoModel($this->entityManager);
                $rsValoresAcumuladosBase = $eventoCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBase = $eventoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsValoresAcumuladosDesconto = $eventoCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                $rsRotuloValoresAcumuladosDesconto = $eventoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );

                $rsValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                break;
            case 2:
                $eventoFeriasCalculadoModel = new EventoFeriasCalculadoModel($this->entityManager);
                $rsValoresAcumuladosBase = $eventoFeriasCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBase = $eventoFeriasCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );

                $rsValoresAcumuladosDesconto = $eventoFeriasCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                $rsRotuloValoresAcumuladosDesconto = $eventoFeriasCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                break;
            case 3:
                $eventoDecimoCalculadoModel = new EventoDecimoCalculadoModel($this->entityManager);
                $rsValoresAcumuladosBase = $eventoDecimoCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBase = $eventoDecimoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );

                $rsValoresAcumuladosDesconto = $eventoDecimoCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                $rsRotuloValoresAcumuladosDesconto = $eventoDecimoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                break;
            case 4:
                $eventoRescisaoCalculadoModel = new EventoRescisaoCalculadoModel($this->entityManager);
                $eventoCalculadoModel = new EventoCalculadoModel($this->entityManager);
                $rsValoresAcumuladosBase = $eventoRescisaoCalculadoModel->montaRecuperaValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBase = $eventoRescisaoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculo(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );

                $rsValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_BASE,
                    $entidade
                );

                $rsValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                $rsRotuloValoresAcumuladosBaseSalarioFamilia = $eventoCalculadoModel->montaRecuperaRotuloValoresAcumuladosCalculoSalarioFamilia(
                    $codContrato,
                    $codPeriodoMovimentacao,
                    $cgm['numcgm'],
                    EventoCalculadoModel::NATUREZA_DESCONTO,
                    $entidade
                );
                break;
        }

        $retorno['valoresAcumuladosBase'] = $rsValoresAcumuladosBase;
        $retorno['rotuloValoresAcumuladosBase'] = $rsRotuloValoresAcumuladosBase;
        $retorno['valoresAcumuladosDesconto'] = $rsValoresAcumuladosDesconto;
        $retorno['rotuloValoresAcumuladosDesconto'] = $rsRotuloValoresAcumuladosDesconto;
        $retorno['valoresAcumuladosBaseSalarioFamilia'] = $rsValoresAcumuladosBaseSalarioFamilia;
        $retorno['rotuloValoresAcumuladosBaseSalarioFamilia'] = $rsRotuloValoresAcumuladosBaseSalarioFamilia;

        return $retorno;
    }

    /**
     * @param $rsEventos
     * @param $inNatureza
     * @return array
     */
    public function processarEventos($rsEventos, $inNatureza)
    {
        $stNatureza1 = $stNatureza2 = $inCodEvento = $stDesdobramento = '';
        $boTodos = false;
        $arTemp = array();
        switch ($inNatureza) {
            case 1:
                $stNatureza1 = 'P';
                $stNatureza2 = 'D';
                break;
            case 2:
                $stNatureza1 = 'B';
                $stNatureza2 = 'B';
                break;
            case 3:
                $stNatureza1 = 'I';
                $stNatureza2 = 'I';
                break;
            case 4:
                $boTodos = true;
                $nuTotalProventos = 0;
                $nuTotalDescontos = 0;
                break;
        }

        foreach ($rsEventos as $arEvento) {
            if (($arEvento['natureza'] == $stNatureza1 or $arEvento['natureza'] == $stNatureza2)
                and ($arEvento['cod_evento'] != $inCodEvento or $arEvento['desdobramento'] != $stDesdobramento)
            ) {
                if ($arEvento['natureza'] == 'P') {
                    $arEvento['proventos'] = $arEvento['valor'];
                } else {
                    $arEvento['proventos'] = "0,00";
                }
                if ($arEvento['natureza'] == 'D' or $arEvento['natureza'] == 'B' or $arEvento['natureza'] == 'I') {
                    $arEvento['descontos'] = $arEvento['valor'];
                } else {
                    $arEvento['descontos'] = "0,00";
                }
                $arTemp[] = $arEvento;
                $inCodEvento = $arEvento['cod_evento'];
                $stDesdobramento = $arEvento['desdobramento'];
            }
            if ($boTodos) {
                if ($arEvento['natureza'] == 'P') {
                    $nuTotalProventos += $arEvento['valor'];
                }
                if ($arEvento['natureza'] == 'D') {
                    $nuTotalDescontos += $arEvento['valor'];
                }
            }
        }

        if ($boTodos) {
            $arTemp[] = array("descricao" => "Soma dos Proventos", "proventos" => $nuTotalProventos);
            $arTemp[] = array("descricao" => "Soma dos Descontos", "descontos" => $nuTotalDescontos);
            $arTemp[] = array("descricao" => "Líquido", "proventos" => $nuTotalProventos - $nuTotalDescontos);
        }

        $rsEventosProcessados = array_merge($rsEventos, $arTemp);
        return $arTemp;
    }

    /**
     * @param $codEvento
     * @param $codRegistro
     * @param $timestamp
     */
    public function excluirEventoCalculado($codEvento, $codRegistro, $timestamp)
    {
        /** @var Entity\Folhapagamento\EventoCalculado $eventoCalculado */
        $eventoCalculado = $this->entityManager->getRepository(Entity\Folhapagamento\EventoCalculado::class)
            ->findOneBy(
                [
                    'codEvento' => $codEvento,
                    'codRegistro' => $codRegistro,
                    'timestampRegistro' => $timestamp
                ]
            );

        if (is_object($eventoCalculado)) {
            $this->remove($eventoCalculado);
        }
    }

    /**
     * @param      $params
     * @param      $exercicio
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtro = false)
    {
        return $this->eventoRepository->recuperaContratosCalculadosRemessaBancos($params, $exercicio, $filtro);
    }

    /**
     * @param $codEvento
     * @param $codRegistro
     * @return null|object
     */
    public function recuperaEventoPorCodEventoCodRegistro($codEvento, $codRegistro)
    {
        return $this->eventoRepository->findOneBy([
            'codEvento' => $codEvento,
            'codRegistro' => $codRegistro
        ]);
    }
}
