<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\PeriodoMovimentacaoRepository;
use \DateTime;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

class PeriodoMovimentacaoModel
{
    private $entityManager = null;
    /** @var PeriodoMovimentacaoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\PeriodoMovimentacao");
    }

    public function getMovimentacaoByCodPeriodoMovimentacao($codigo)
    {
        $return = $this->repository->findOneByCodPeriodoMovimentacao($codigo);
        return $return;
    }

    /**
     * @param array $param
     * @return Entity\Folhapagamento\PeriodoMovimentacao mixed
     */
    public function getOnePeriodo($param)
    {
        $param = reset($param);

        $query = $this->repository->createQueryBuilder('p')
            ->where('p.codPeriodoMovimentacao = :codPeriodo')
            ->setParameter('codPeriodo', $param->cod_periodo_movimentacao)
            ->setMaxResults(1)
            ->orderBy('p.codPeriodoMovimentacao', 'DESC')
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getOnePeriodoSituacao()
    {
        $query = $this->repository->createQueryBuilder('o');
        $query
            ->innerJoin('CoreBundle:Folhapagamento\PeriodoMovimentacaoSituacao', 's', \Doctrine\ORM\Query\Expr\Join::WITH, 'o.codPeriodoMovimentacao = s.codPeriodoMovimentacao');

        $query->andWhere(
            $query->expr()->eq('s.situacao', ':param')
        );

        $query->setParameter('param', 'A');
        $query->setMaxResults(1);
        $periodo = $query->getQuery();

        return $periodo;
    }

    public function verificaPeriodo($dtInicial, $dtFinal)
    {
        return $this->repository->verificaPeriodo($dtInicial, $dtFinal);
    }

    /**
     * @param string $dtInicial
     * @param string $dtFinal
     * @param string $Exercicio
     * @param string $entidade
     * @return array
     */
    public function abrirPeriodoMovimentacao($dtInicial, $dtFinal, $Exercicio, $entidade)
    {
        return $this->repository->abrirPeriodoMovimentacao($dtInicial, $dtFinal, $Exercicio, $entidade);
    }

    /**
     * @param string $codEntidade
     * @return mixed
     */
    public function cancelarPeriodoMovimentacao($codEntidade)
    {
        return $this->repository->cancelarPeriodoMovimentacao($codEntidade);
    }

    public function listPeriodoMovimentacao()
    {
        return $this->repository->listPeriodoMovimentacao();
    }

    public function getCodPeriodoMovimentacao()
    {
        return $this->repository->getCodPeriodoMovimentacao();
    }

    public function findOneByCodPeriodoMovimentacao($codigo)
    {
        return $this->repository->findOneByCodPeriodoMovimentacao($codigo);
    }

    public function montaRecuperaUltimaMovimentacao($entidade = '')
    {
        return $this->repository->montaRecuperaUltimaMovimentacao($entidade);
    }

    public function montaPeriodoMovimentacaoWhitParamns($filtro, $order)
    {
        return $this->repository->montaPeriodoMovimentacaoWhitParamns($filtro, $order);
    }

    public function recuperaPeriodoMovimentacao($dtCompetenciaInicial = null, $dtCompetenciaFinal = null)
    {
        return $this->repository->recuperaPeriodoMovimentacao($dtCompetenciaInicial, $dtCompetenciaFinal);
    }

    /**
     * @param bool $filtro
     *
     * @return \Doctrine\DBAL\Driver\Statement|mixed
     */
    public function recuperaPeriodoMovimentacaoDaCompetencia($filtro = false)
    {
        return $this->repository->recuperaPeriodoMovimentacaoDaCompetencia($filtro);
    }

    /**
     * @return mixed
     */
    public function recuperaUltimaFolhaSituacao()
    {
        return $this->repository->recuperaUltimaFolhaSituacao();
    }

    public function cancelarAdiantamento13MesAniversario($exercicio)
    {
        $obErro = '';

        $rsUltimaMovimentacao = $this->listPeriodoMovimentacao();

        $arDtFinal = explode("/", $rsUltimaMovimentacao[0]->dt_final);

        //Valida configuracao e datas do mes para executar esta rotina
        $boValida = $this->validaAdiantamento13MesAniversario($arDtFinal);
        if (!$boValida) {
            return $obErro;
        }

        $obTPessoalContratoModel = new ContratoModel($this->entityManager);
        //Busca todos os contratos que foram configurados com adiantamento do 13 no mes do aniversario
        $concessaoDecimoModel = new ConcessaoDecimoModel($this->entityManager);
        $rsContratos = $concessaoDecimoModel->montaRecuperaContratosAdiantamentoDecidoMesAniversario($arDtFinal[1], '', $rsUltimaMovimentacao[0]->cod_periodo_movimentacao);
        $arCodContratos = array();
        foreach ($rsContratos as $contrato) {
            $contratoModel = new ContratoModel($this->entityManager);
            $obErro = $contratoModel->montaRecuperaCgmDoRegistro($contrato['cod_contrato'], '');

            $rsDeducaoDependente = $this->entityManager->getRepository(Entity\Folhapagamento\DeducaoDependente::class)
                ->findOneBy(
                    [
                        'codContrato' => $contrato['cod_contrato'],
                        'codPeriodoMovimentacao' => $rsUltimaMovimentacao[0]->cod_periodo_movimentacao,
                        'codTipo' => 4,
                    ]
                );

            if (!empty($rsDeducaoDependente)) {
                $arCodContratos[] = array("cod_contrato" => $contrato['cod_contrato']);
            }

            $obErro = $this->deletarConcessaoDecimo($contrato['cod_contrato'], $rsUltimaMovimentacao[0]->cod_periodo_movimentacao);
        }

        $obErro = $this->recalcularSalario($rsContratos, $exercicio);

        return $obErro;
    }

    /**
     * @param $arDtFinal
     * @return bool
     */
    public function validaAdiantamento13MesAniversario($arDtFinal)
    {
        $configuracaoModel = new ConfiguracaoModel($this->entityManager);
        $boValida = true;
        $inMesSaldo13 = $configuracaoModel->getConfiguracao('mes_calculo_decimo', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        //Não deve ser executada essa ação nos meses de dezembro e novembro
        //só se a configuracao do saldo estiver em dezembro
        if ($arDtFinal[1] == 12) {
            return false;
        } elseif (($arDtFinal[1] == 11) && ($arDtFinal[1] == $inMesSaldo13)) {
            return false;
        }
        return $boValida;
    }


    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @return mixed|string
     */
    public function deletarConcessaoDecimo($codContrato, $codPeriodoMovimentacao)
    {
        $obErro = '';

        $ultimoRegistroEventoDecimoModel = new UltimoRegistroEventoDecimoModel($this->entityManager);
        $rsRegistros = $ultimoRegistroEventoDecimoModel->montaRecuperaRegistrosEventoDecimoDoContrato($codContrato, $codPeriodoMovimentacao);
        if ($obErro->ocorreu()) {
            return $obErro;
        }

        foreach ($rsRegistros as $registro) {
            $obErro = $ultimoRegistroEventoDecimoModel->montaDeletarUltimoRegistro(
                $registro['cod_registro'],
                $registro['cod_evento'],
                $registro['desdobramento'],
                $registro['timestamp'],
                ''
            );
            if ($obErro->ocorreu()) {
                return $obErro;
            }
        }

        //Exclusão dos contratos com pagamento de décimo em salário
        $rsConcessoDecimo = $this->entityManager->getRepository(Entity\Folhapagamento\ConcessaoDecimo::class)
            ->findBy(
                [
                    'codContrato' => $codContrato,
                    'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                    'desdobramento' => 'A',
                    'folhaSalario' => 'TRUE',
                ]
            );

        $configuracaoAdiantamentoModel = new ConfiguracaoAdiantamentoModel($this->entityManager);
        $eventoCalculadoModel = new EventoCalculadoModel($this->entityManager);
        foreach ($rsConcessoDecimo as $concessaoDecimo) {
            $filtro = " AND cod_contrato = $codContrato
            AND cod_periodo_movimentacao = $codPeriodoMovimentacao
            AND desdobramento = 'I'";
            $rsEventosCalculados = $eventoCalculadoModel->montaRecuperaEventosCalculados($filtro);

            foreach ($rsEventosCalculados as $eventosCalculado) {
                $ultimoRegistroEventoDecimoModel->montaDeletarUltimoRegistroEvento(
                    $eventosCalculado['cod_registro'],
                    $eventosCalculado['cod_evento'],
                    $eventosCalculado['desdobramento'],
                    $eventosCalculado['timestamp'],
                    ''
                );
                if ($obErro->ocorreu()) {
                    return $obErro;
                }
            }

            $configuracaoAdiantamentoModel->remove($concessaoDecimo);
        }

        $configuracaoAdiantamento = $this->entityManager->getRepository(Entity\Folhapagamento\ConfiguracaoAdiantamento::class)
            ->findOneBy(
                [
                    'codContrato' => $codContrato,
                    'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                ]
            );

        $configuracaoAdiantamentoModel->remove($configuracaoAdiantamento);

        return $obErro;
    }


    /**
     * @param $rsContratos
     * @param $exercicio
     * @return string
     */
    public function recalcularSalario($rsContratos, $exercicio)
    {
        $obErro = '';
        //Recalcula folha salário de contratos com dependente
        //isso serve para no caso do cancelamento de um décimo onde está
        //sendo incorporado a dedução de dependente, essa dedução passe para
        //a folha salário do contrato
        $stCodContratos = "";
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($this->entityManager);
        foreach ($rsContratos as $contratos) {
            $stCodContratos .= $contratos["cod_contrato"] . ",";
        }

        $stCodContratos = substr($stCodContratos, 0, strlen($stCodContratos) - 1);

        $registroEventoPeriodoModel->deletarInformacoesCalculo($stCodContratos, 'S', 0, '');

        foreach ($rsContratos as $contrato) {
            $registroEventoPeriodoModel->calculaFolha($contrato['cod_contrato'], '1', 'f', '', $exercicio);
        }

        return $obErro;
    }

    /**
     * @param $exercicio
     *
     * @return array
     */
    public function getMesCompetenciaFolhaPagamento($exercicio)
    {
        $entityManager = $this->entityManager;
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno == (int) $exercicio) {
                if ($mes->getCodMes() <= $inCodMes) {
                    $options[trim($mes->getDescricao())] = $mes->getCodMes();
                }
            } elseif ($inAno > (int) $exercicio) {
                $options[trim($mes->getDescricao())] = $mes->getCodMes();
            }
        }

        return $options;
    }

    /**
     * @param DateTime $initialDate
     * @param DateTime $finalDate
     * @return PeriodoMovimentacao
     */
    public function findCodPeriodoByInitialAndFinalDate(DateTime $initialDate, DateTime $finalDate)
    {
        $periodoMovimentacao = new PeriodoMovimentacao();
        $result = $this->repository->findCodPeriodoByInitialAndFinalDate($initialDate, $finalDate);
        if (!empty($result)) {
            $periodoMovimentacao = array_shift($result);

            return $periodoMovimentacao;
        }

        return $periodoMovimentacao;
    }
    
    /**
     * 
     * @param int $codPeriodoMovimentacao
     */
    public function fetchFolhaComplementar($codPeriodoMovimentacao)
    {
        return $this->repository->fetchFolhaComplementar($codPeriodoMovimentacao);
    }
    
    /**
     * @param string $dtFinal
     * @return array
     */
    public function consultaPeriodoMovimentacaoCompetencia($dtFinal)
    {
        return $this->repository->consultaPeriodoMovimentacaoCompetencia($dtFinal);
    }
}
