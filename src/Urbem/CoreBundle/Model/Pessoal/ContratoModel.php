<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Pessoal\ContratoRepository;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;

/**
 * Class ContratoModel
 *
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class ContratoModel implements Model\InterfaceModel
{
    const TIPO_FOLHA_SALARIO = 'S';
    const TIPO_FOLHA_COMPLEMENTAR = 'C';
    const TIPO_FOLHA_FERIAS = 'F';
    const TIPO_FOLHA_DECIMO = 'D';
    const TIPO_FOLHA_RESCISAO = 'R';
    const IN_COD_CONFIGURACAO = 1;
    const FOLHA_COD_CONFIGURACAO_SALARIO = 1;
    const FOLHA_COD_CONFIGURACAO_FERIAS = 2;
    const FOLHA_COD_CONFIGURACAO_DECIMO = 3;
    const FOLHA_COD_CONFIGURACAO_RESCISAO = 4;

    private $entityManager = null;

    /**
     * @var ContratoRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Contrato::class);
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function inserirServidorContrato($servidor, $contrato)
    {
        return $this->repository->inserirServidorContrato($servidor, $contrato);
    }

    public function listContratosAtivosWithCgm()
    {
        return $this->repository->listContratosAtivosWithCgm();
    }

    public function listAllContratosWithCgm()
    {
        return $this->repository->listAllContratosWithCgm();
    }

    /**
     * @param $codContratos
     *
     * @return array
     */
    public function listContratosByCodContratos($codContratos)
    {
        return $this->repository->listContratosByCodContratos($codContratos);
    }

    /**
     * @param $codContrato
     * @param $entidade
     *
     * @return array
     */
    public function montaRecuperaCgmDoRegistro($codContrato, $entidade)
    {
        return $this->repository->montaRecuperaCgmDoRegistro($codContrato, $entidade);
    }

    /**
     * @param      $tipoFolha
     * @param      $contratos
     * @param      $exercicio
     * @param bool $codComplementar
     *
     * @return array|void
     */
    public function calcularFolha($tipoFolha, $contratos, $exercicio, $codComplementar = false, $recalcular = false)
    {
        $contratosErrors = $contratosSuccess = [];

        if ($tipoFolha == ContratoModel::TIPO_FOLHA_COMPLEMENTAR) {
            $contratoStr = implode($contratos, ',');
            $this->deletarInformacoesCalculo($contratoStr, ContratoModel::TIPO_FOLHA_COMPLEMENTAR, $codComplementar);
        }

        foreach ($contratos as $contrato) {
            switch ($tipoFolha) {
                case ContratoModel::TIPO_FOLHA_SALARIO:
                    $message = $this->calcularFolhaSalario($contrato, $exercicio, $recalcular);
                    if ($message['type'] == 'error') {
                        $contratoErrors[] = $message['codContrato'];
                    } else {
                        $contratosSuccess[] = $message['codContrato'];
                    }
                    break;
                case ContratoModel::TIPO_FOLHA_COMPLEMENTAR:
                    $message = $this->calcularFolhaComplementar($contrato, $exercicio, $codComplementar);
                    if ($message['type'] == 'error') {
                        $contratoErrors[] = $message['codContrato'];
                    } else {
                        $contratosSuccess[] = $message['codContrato'];
                    }
                    break;
                case ContratoModel::TIPO_FOLHA_FERIAS:
                    $message = $this->calcularFolhaFerias($contrato, $exercicio);
                    if ($message['type'] == 'error') {
                        $contratoErrors[] = $message['codContrato'];
                    } else {
                        $contratosSuccess[] = $message['codContrato'];
                    }
                    break;
                case ContratoModel::TIPO_FOLHA_RESCISAO:
                    $message = $this->calcularFolhaRescisao($contrato, $exercicio, $recalcular);
                    if ($message['type'] == 'error') {
                        $contratoErrors[] = $message['codContrato'];
                    } else {
                        $contratosSuccess[] = $message['codContrato'];
                    }
                    break;
                case ContratoModel::TIPO_FOLHA_DECIMO:
                    $message = $this->calcularFolhaDecimo($contrato, $exercicio, $codComplementar, $recalcular);
                    if ($message['type'] == 'error') {
                        $contratoErrors[] = $message['codContrato'];
                    } else {
                        $contratosSuccess[] = $message['codContrato'];
                    }
                    break;
            }
        }
        $retorno['contratoErrors'] = $contratosErrors;
        $retorno['contratosSuccess'] = $contratosSuccess;

        return $retorno;
    }

    /**
     * @param $desdobramentos
     * @param $tipoFolha
     * @param $contratos
     * @param $exercicio
     *
     * @return array|void
     */
    public function calcularFolhaDesdobramento($desdobramentos, $tipoFolha, $contratos, $exercicio)
    {
        foreach ($desdobramentos as $desdobramento) {
            $retorno = $this->calcularFolha($tipoFolha, $contratos, $exercicio, $desdobramento);
        }

        return $retorno;
    }

    /**
     * @param $contrato
     * @param $exercicio
     * @param $recalcular
     *
     * @return array|string
     * @throws \Exception
     */
    public function calcularFolhaRescisao($contrato, $exercicio, $recalcular)
    {
        $calculo = '';
        try {
            /** @var Model\Folhapagamento\RegistroEventoPeriodoModel $registroEventoPeriodoModel */
            $registroEventoPeriodoModel = new Model\Folhapagamento\RegistroEventoPeriodoModel($this->entityManager);
            $registroEventoPeriodoModel->deletarInformacoesCalculo($contrato, 'R', 0, '');

            $boErro = ($recalcular) ? 't' : 'f';

            $retorno = $this->montaCalculaFolhaRescisao($contrato, $boErro, '', $exercicio);
            if ($retorno->retorno) {
                $calculo = ['type' => 'success', 'codContrato' => $contrato];
            } else {
                $calculo = ['type' => 'error', 'codContrato' => $contrato];
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $calculo;
    }

    /**
     * @param $contrato
     * @param $exercicio
     *
     * @throws \Exception
     */
    public function calcularFolhaFerias($contrato, $exercicio)
    {
        try {
            $this->montaCalculaFolhaFerias($contrato, 'f', '', $exercicio);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $contrato
     * @param $exercicio
     * @param $desdobramento
     * @param $recalcular
     *
     * @return array|string
     * @throws \Exception
     */
    public function calcularFolhaDecimo($contrato, $exercicio, $desdobramento, $recalcular)
    {
        $calculo = '';
        try {
            /** @var Model\Folhapagamento\RegistroEventoPeriodoModel $registroEventoPeriodoModel */
            $registroEventoPeriodoModel = new Model\Folhapagamento\RegistroEventoPeriodoModel($this->entityManager);
            $registroEventoPeriodoModel->deletarInformacoesCalculo($contrato, 'D', 0, '');

            $boErro = ($recalcular) ? 't' : 'f';

            $retorno = $this->montaCalculaFolhaDecimo($contrato, $desdobramento, $boErro, '', $exercicio);
            if ($retorno->retorno) {
                $calculo = ['type' => 'success', 'codContrato' => $contrato];
            } else {
                $calculo = ['type' => 'error', 'codContrato' => $contrato];
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $calculo;
    }

    /**
     * @param $contrato
     * @param $exercicio
     * @param $recalcular
     *
     * @return array|string
     * @throws \Exception
     */
    public function calcularFolhaSalario($contrato, $exercicio, $recalcular)
    {
        $calculo = '';
        try {
            /** @var Model\Folhapagamento\RegistroEventoPeriodoModel $registroEventoPeriodoModel */
            $registroEventoPeriodoModel = new Model\Folhapagamento\RegistroEventoPeriodoModel($this->entityManager);
            $registroEventoPeriodoModel->deletarInformacoesCalculo($contrato, 'S', 0, '');

            $boErro = ($recalcular) ? 't' : 'f';

            $retorno = $this->montaCalculaFolha($contrato, ContratoModel::IN_COD_CONFIGURACAO, $boErro, '', $exercicio);
            if ($retorno->retorno) {
                $calculo = ['type' => 'success', 'codContrato' => $contrato];
            } else {
                $calculo = ['type' => 'error', 'codContrato' => $contrato];
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $calculo;
    }

    /**
     * @param $contrato
     * @param $exercicio
     * @param $codComplementar
     *
     * @throws \Exception
     */
    public function calcularFolhaComplementar($contrato, $exercicio, $codComplementar)
    {
        try {
            $this->montaCalculaFolhaComplementar($contrato, $codComplementar, 'f', '', $exercicio, $codComplementar);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $inCodContrato
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaFerias($inCodContrato, $boErro, $stEntidade, $stExercicio)
    {
        return $this->repository->montaCalculaFolhaFerias($inCodContrato, $boErro, $stEntidade, $stExercicio);
    }

    /**
     * @param $inCodContrato
     * @param $desdobramento
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaDecimo($inCodContrato, $desdobramento, $boErro, $stEntidade, $stExercicio)
    {
        return $this->repository->montaCalculaFolhaDecimo($inCodContrato, $desdobramento, $boErro, $stEntidade, $stExercicio);
    }


    /**
     * @param $inCodContrato
     * @param $inCodConfiguracao
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolha($inCodContrato, $inCodConfiguracao, $boErro, $stEntidade, $stExercicio)
    {
        return $this->repository->montaCalculaFolha($inCodContrato, $inCodConfiguracao, $boErro, $stEntidade, $stExercicio);
    }

    /**
     * @param       $paramsBo
     * @param       $inCodPeriodoMovimentacao
     * @param       $entidade
     * @param array $inCodLocal
     * @param array $inCodLotacao
     * @param array $inCodEvento
     * @param bool  $inCodComplementar
     *
     * @return array
     */
    public function montaRecuperaContratosCalculoFolha($paramsBo, $inCodPeriodoMovimentacao, $entidade, $inCodLocal, $inCodLotacao, $inCodEvento, $inCodComplementar = false)
    {
        return $this->repository->montaRecuperaContratosCalculoFolha($paramsBo, $inCodPeriodoMovimentacao, $entidade, $inCodLocal, $inCodLotacao, $inCodEvento, $inCodComplementar);
    }

    /**
     * @param $inCodContrato
     * @param $inCodComplementar
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaComplementar($inCodContrato, $inCodComplementar, $boErro, $stEntidade, $stExercicio)
    {
        return $this->repository->montaCalculaFolhaComplementar($inCodContrato, $inCodComplementar, $boErro, $stEntidade, $stExercicio);
    }

    /**
     * @param $inCodContrato
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaRescisao($inCodContrato, $boErro, $stEntidade, $stExercicio)
    {
        return $this->repository->montaCalculaFolhaRescisao($inCodContrato, $boErro, $stEntidade, $stExercicio);
    }

    public function toStringContratoAutocomplete(Contrato $contrato)
    {
        return $contrato->getRegistro()
            . " - "
            . $contrato->getFkPessoalContratoServidor()
                ->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()
                ->getFkSwCgm()->getNomcgm();
    }

    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosDeLotacao($filtros)
    {
        return $this->repository->recuperaContratosDeLotacao($filtros);
    }

    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosDeLocal($filtros)
    {
        return $this->repository->recuperaContratosDeLocal($filtros);
    }


    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosCalculados($filtros)
    {
        return $this->repository->recuperaContratosCalculados($filtros);
    }

    /**
     * @return array
     */
    public function recuperaContratoGeral()
    {
        return $this->repository->recuperaContratoGeral();
    }

    /**
     * @param bool $filtro
     *
     * @return mixed
     */
    public function recuperaCgmDoRegistro($filtro = false)
    {
        return $this->repository->recuperaCgmDoRegistro($filtro);
    }

    /**
     * @param $registro
     * @return $codContrato|int
     */
    public function recuperaCodContratoPorRegistro($registro)
    {
        $contrato = $this->repository->findOneBy(['registro' => $registro]);
        return $contrato->getCodContrato();
    }

    /**
     * @param      $params
     * @param bool $stFiltro
     * @param bool $stOrder
     *
     * @return array
     */
    public function recuperaContratosAutomaticos($params, $stFiltro = false, $stOrder = false)
    {
        return $this->repository->recuperaContratosAutomaticos($params, $stFiltro, $stOrder);
    }

    /**
     * @param        $params
     * @param        $codPeriodoMovimentacao
     * @param string $entidade
     *
     * @return array
     */
    public function recuperaContratosConcessaoDecimo($params, $codPeriodoMovimentacao, $entidade = '')
    {
        return $this->repository->recuperaContratosConcessaoDecimo($params, $codPeriodoMovimentacao, $entidade);
    }

    /**
     * @param string $tipo
     * @param string $valor
     * @param string $exercicio
     * @return array
     */
    public function filtraContratoServidor($tipo, $valor, $exercicio = '')
    {
        return $this->repository->filtraContratoServidor($tipo, $valor, $exercicio);
    }

    /**
     * @param integer $codContrato
     * @return array
     */
    public function filtraContratoServidorByCodContrato($codContrato)
    {
        return $this->repository->filtraContratoServidorByCodContrato($codContrato);
    }

    /**
     * @param integer $codPeriodoMovimentacao
     * @param integer $codComplementar
     * @param string $tipo
     * @param string $valor
     * @return array
     */
    public function montaRecuperaContratosCalculoComplementar($codPeriodoMovimentacao, $codComplementar, $tipo, $valor)
    {
        return $this->repository->montaRecuperaContratosCalculoComplementar($codPeriodoMovimentacao, $codComplementar, $tipo, $valor);
    }

    /**
     * @param $stCodContrato
     * @param $stTipoFolha
     * @param $inCodComplementar
     * @return mixed
     */
    public function deletarInformacoesCalculo($stCodContrato, $stTipoFolha, $inCodComplementar)
    {
        return $this->repository->deletarInformacoesCalculo($stCodContrato, $stTipoFolha, $inCodComplementar);
    }
}
