<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoRepository;

class RegistroEventoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoRepository|null */
    protected $repository = null;

    /**
     * RegistroEventoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEvento");
    }

    /**
     * @param      $codPeriodoMovimentacao
     * @param      $contratos
     * @param bool $desdobramento
     *
     * @return array
     */
    public function recuperaRegistrosDeEventos($codPeriodoMovimentacao, $contratos, $desdobramento = false)
    {
        return $this->repository->recuperaRegistrosDeEventos($codPeriodoMovimentacao, $contratos, $desdobramento);
    }

    /**
     * @param Evento                $evento
     * @param RegistroEventoPeriodo $registroEventoPeriodo
     *
     * @return Entity\Folhapagamento\RegistroEvento
     */
    public function buildOneBasedEvento(Evento $evento, RegistroEventoPeriodo $registroEventoPeriodo)
    {
        $registroEvento = new Entity\Folhapagamento\RegistroEvento();
        $registroEvento->setFkFolhapagamentoEvento($evento);
        $registroEvento->setFkFolhapagamentoRegistroEventoPeriodo($registroEventoPeriodo);

        $this->save($registroEvento);

        return $registroEvento;
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $registro
     * @param $codigo
     */
    public function recuperaEventosPorContratoEPeriodo($codPeriodoMovimentacao, $registro, $codigo)
    {
        $this->repository->recuperaEventosPorContratoEPeriodo($codPeriodoMovimentacao, $registro, $codigo);
    }

    /**
     * @param        $stValor
     * @param string $stCasaDecimal
     *
     * @return mixed|string
     */
    public function formataValor($stValor, $stCasaDecimal = "")
    {
        if ($stValor != "") {
            if ($this->validaValor($stValor, $stCasaDecimal) == "") {
                switch ($stCasaDecimal) {
                    case "":
                        if (strlen($stValor) == 2) {
                            $stValor = "0" . $stValor;
                        } elseif (strlen($stValor) == 1) {
                            $stValor = "00" . $stValor;
                        }
                        $stValor = substr($stValor, 0, strlen($stValor) - 2) . "." . substr($stValor, strlen($stValor) - 2, 2);
                        break;
                    case ".":
                        $stValor = str_replace(',', '', $stValor);
                        break;
                    case ",":
                        $stValor = str_replace('.', '', $stValor);
                        $stValor = str_replace(',', '.', $stValor);
                        break;
                }
                $stValor = number_format($stValor, 2, ",", ".");
            }
        } else {
            $stValor = "0,00";
        }

        return $stValor;
    }

    /**
     * @param        $nuValor
     * @param string $stCasaDecimal
     * @param string $mensagem
     *
     * @return string
     */
    public function validaValor($nuValor, $stCasaDecimal = "", $mensagem = "valor informado é inválido")
    {
        $stErro = "";
        if ($stCasaDecimal != "") {
            if ($stCasaDecimal != '.') {
                $nuValor = str_replace('.', '', $nuValor);
            }
            if ($stCasaDecimal != ',') {
                $nuValor = str_replace(',', '', $nuValor);
            }
            $stCasaDecimal = "\\" . $stCasaDecimal;
        }

        //Verifica se o valor possui de 0 a 9 numeros, o separador decimal e 0 a 2 digitos de casa decimal OU se o valor já formado por e somente até 11 números
        if (!((preg_match("^[0-9]{0,9}" . $stCasaDecimal . "[0-9]{0,2}$^", $nuValor, $matriz)) || (preg_match("^[0-9]{0,11}$^", $nuValor, $matriz)))) {
            $stErro = " - $mensagem";
        }

        return $stErro;
    }

    /**
     * @param $inCodigoEvento
     * @param $stMascaraEvento
     *
     * @return string
     */
    public function formataEvento($inCodigoEvento, $stMascaraEvento)
    {
        if ($inCodigoEvento != "") {
            $ate = strlen($stMascaraEvento) - strlen($inCodigoEvento);
            for ($i = 0; $i < $ate; $i++) {
                $inCodigoEvento = "0" . $inCodigoEvento;
            }
        } else {
            $inCodigoEvento = "&nbsp;";
        }

        return $inCodigoEvento;
    }

    /**
     * @param       $inContrato
     * @param       $inCodigoEvento
     * @param       $nuValorEvento
     * @param       $nuQuantidadeEvento
     * @param       $nuQuantidadeParcelasEvento
     * @param       $inMesesCarencia
     * @param       $stFixado
     * @param       $stApresentaParcelas
     * @param       $inCodPeriodoMovimentacao
     * @param       $stMascaraEvento
     * @param array $arEventosCadastrados
     *
     * @return string
     */
    public function validaEventoImportacao($inContrato, $inCodigoEvento, $nuValorEvento, $nuQuantidadeEvento, $nuQuantidadeParcelasEvento, $inMesesCarencia, $stFixado, $stApresentaParcelas, $inCodPeriodoMovimentacao, $stMascaraEvento, $arEventosCadastrados = array())
    {
        $stErro = "";

        /** @var EntityManager $em */
        $em = $this->entityManager;
        /** @var RegistroEventoModel $registroEventoModel */
        $registroEventoModel = new RegistroEventoModel($em);
        $rsRegistroEventos = $registroEventoModel->recuperaEventosPorContratoEPeriodo(
            $inCodPeriodoMovimentacao,
            $inContrato,
            $this->formataEvento($inCodigoEvento, $stMascaraEvento)
        );

        if (count($rsRegistroEventos) > 0) {
            $stErro = " - já existe um evento cadastrado para este contrato";
        } else {
            // Verifica se este evento já foi cadastrado para o contrato
            $ate = count($arEventosCadastrados);
            for ($i = 0; $i < $ate; $i++) {
                if (($inCodigoEvento == $arEventosCadastrados[$i]['inCodigoEvento']) && ($inContrato == $arEventosCadastrados[$i]['inContrato'])) {
                    $stErro = " - já existe um evento cadastrado para este contrato";
                }
            }
        }

        if (!$inContrato) {
            $stErro .= " - contrato não informado";
        }
        if (!$inCodigoEvento) {
            $stErro .= " - evento não informado";
        }
        if (($stFixado != 'Q') && (($nuValorEvento == '') || ($nuValorEvento == '0,00'))) {
            $stErro .= " - valor não informado";
        }
        if (($stFixado == 'Q') && ($nuValorEvento == '')) {
            $stErro .= " - valor não pode ser informado para este evento";
        }
        if (($stFixado == 'Q') && ($nuQuantidadeEvento == '') || ($nuQuantidadeEvento == '0,00')) {
            $stErro .= " - quantidade não informada";
        }
        if (($stApresentaParcelas != 'f') && (($nuQuantidadeParcelasEvento == '') || ($nuQuantidadeParcelasEvento == '0,00'))) {
            $stErro .= " - quantidade de parcelas não informada";
        }
        if (($stApresentaParcelas == 'f') && (!($nuQuantidadeParcelasEvento == '') || ($nuQuantidadeParcelasEvento == '0,00'))) {
            $stErro .= " - quantidade de parcelas não pode ser informada para este evento";
        }
        if (($inMesesCarencia == '') && ($stApresentaParcelas == 't')) {
            $stErro .= " - os meses de carência não podem ser informados para este evento";
        }

        return $stErro;
    }

    /**
     * @param $inCodigoEvento
     * @param $stMascaraEvento
     *
     * @return string
     */
    public function validaCodigoEvento($inCodigoEvento, $stMascaraEvento)
    {
        $stErro = "";

        $ate = strlen($stMascaraEvento) - strlen($inCodigoEvento);
        for ($i = 0; $i < $ate; $i++) {
            $inCodigoEvento = "0" . $inCodigoEvento;
        }

        /** @var EntityManager $em */
        $em = $this->entityManager;
        /** @var EventoModel $eventoModel */
        $eventoModel = new EventoModel($em);
        /** @var Evento $rsEvento */
        $rsEvento = $eventoModel->getEventoByCodEvento($inCodigoEvento);

        if (count($rsEvento) <= 0) {
            $stErro = " - evento informado é inválido";
        }

        return $stErro;
    }

    /**
     * @param $inRegistro
     *
     * @return string
     */
    public function validaRegistroContrato($inRegistro)
    {
        $boErro = false;
        $stErro = "";
        $stValidaInteiro = "";
        $stValidaInteiro = $this->validaInteiro($inRegistro);
        if ($stValidaInteiro == "") {
            /** @var EntityManager $em */
            $em = $this->entityManager;
            /** @var ContratoModel $obRPessoalContrato */
            $obRPessoalContrato = new ContratoModel($em);
            $filtro = " AND contrato.registro = $inRegistro";
            $rsContrato = $obRPessoalContrato->recuperaCgmDoRegistro($filtro);
            if (count($rsContrato) <= 0) {
                $boErro = true;
            }
        } else {
            $boErro = true;
        }

        if ($boErro) {
            $stErro = " - contrato informado já inválido";
        }

        return $stErro;
    }

    /**
     * @param $nuValor
     *
     * @return string
     */
    public function validaInteiro($nuValor)
    {
        $stErro = "";
        if (!preg_match("^[0-9]{0,10}$^", $nuValor, $matriz)) {
            $stErro = " - quantidade de parcelas informada é inválida";
        }

        return $stErro;
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function recuperaRelacionamentoConfiguracao($stFiltro = false)
    {
        return $this->repository->recuperaRelacionamentoConfiguracao($stFiltro);
    }

    /*
     * @param $filtro
     * @return array
     */
    public function recuperaRegistrosEventos($filtro)
    {
        return $this->repository->recuperaRegistrosEventos($filtro);
    }
}
