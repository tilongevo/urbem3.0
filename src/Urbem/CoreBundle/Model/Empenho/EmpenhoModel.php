<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;
use Urbem\CoreBundle\Entity\Orcamento\VwClassificacaoDespesaView;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Diarias\TipoDiariaModel;

class EmpenhoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;
    const TIPO_EMISSAO_EMPENHO = 'E';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Empenho::class);
    }

    public function recuperaUltimaDataEmpenho($exercicio, $codEntidade)
    {
        $empenhoModel = $this->repository->recuperaUltimaDataEmpenho($exercicio, $codEntidade);
        return $empenhoModel;
    }

    public function getSaldoAnterior($object)
    {
        $preEmpenhoDespesa = $this->entityManager->getRepository(PreEmpenhoDespesa::class)
            ->findOneBy(
                array(
                    'exercicio' => $object->getExercicio(),
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                )
            );

        return $this->entityManager->getRepository(PreEmpenho::class)
            ->getSaldoDotacao(
                $object->getExercicio(),
                $preEmpenhoDespesa->getCodDespesa(),
                (!empty($object->getFkEmpenhoEmpenho()) ? $object->getFkEmpenhoEmpenho()->getDtEmpenho()->format("d/m/Y") : null),
                (!empty($object->getFkEmpenhoEmpenho()) ? $object->getFkEmpenhoEmpenho()->getCodEntidade() : null)
            );
    }

    public function filterPreEmpenho($filter)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->filterPreEmpenho($filter);

        return $res;
    }

    public function filterEmpenho($filter, $numcgm)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->filterEmpenho($filter, $numcgm);

        return $res;
    }

    /**
     * @param $filter
     * @param $numcgm
     * @return mixed
     */
    public function filterListaReemitirAutorizacao($filter, $numcgm)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->filterListaReemitirAutorizacao($filter, $numcgm);

        return $res;
    }

    /**
     * Filtra Empenho especificamente para o ConsultarEmpenhoAdmin
     * @param  array $filter
     * @param  string $exercicio
     *
     * @return array
     */
    public function filterConsultarEmpenho($filter, $exercicio)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->filterConsultarEmpenho($filter, $exercicio);

        return $res;
    }

    public function findListaAnularEmpenho($filter, $exercicio, $numcgm)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->findListaAnularEmpenho($filter, $exercicio, $numcgm);

        return $res;
    }

    public function canRemove($object)
    {
    }

    /**
     * @param $formData
     * @param PreEmpenho $object
     */
    public function save($formData, $object)
    {
        $empenho = $this->entityManager->getRepository(Empenho::class)
            ->findOneBy(
                array(
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                    'exercicio' => $object->getExercicio()
                )
            );

        if (!$empenho) {
            $codEmpenho = $this->entityManager->getRepository(Empenho::class)
                ->getProximoCodEmpenho();

            $empenho = new \Urbem\CoreBundle\Entity\Empenho\Empenho();
            $empenho->setCodEmpenho($codEmpenho);
            $empenho->setFkOrcamentoEntidade($object->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getFkOrcamentoEntidade());

            /** @var CategoriaEmpenho $categoriaEmpenho */
            $categoriaEmpenho = $this->entityManager->getRepository(CategoriaEmpenho::class)->find($empenho->getCodCategoria());
            $empenho->setFkEmpenhoCategoriaEmpenho($categoriaEmpenho);
        }

        $vlSaldoAnterior = (float) $this->getSaldoAnterior($object)->saldo_anterior;
        if ($this->getSaldoAnterior($object)->saldo_anterior < 0) {
            $vlSaldoAnterior = (float) $this->getSaldoAnterior($object)->saldo_anterior * -1;
        }

        $empenho->setFkEmpenhoPreEmpenho($object);
        $empenho->setFkOrcamentoEntidade($empenho->getFkOrcamentoEntidade());
        $empenho->setDtEmpenho(new DateTimeMicrosecondPK($formData->get('dtEmpenho')->getData()->format("Y-m-d")));
        $empenho->setDtVencimento(new DateTimeMicrosecondPK($formData->get('dtVencimento')->getData()->format("Y-m-d")));
        $empenho->setVlSaldoAnterior($vlSaldoAnterior);
        $empenho->setFkEmpenhoCategoriaEmpenho($empenho->getFkEmpenhoCategoriaEmpenho());

        $this->entityManager->persist($empenho);
        $this->entityManager->flush();
        $stNomeLote = "Emissão de Empenho n° " . $empenho->getCodEmpenho() . "/" . $object->getExercicio();

        $codLote = $this->entityManager->getRepository(Empenho::class)
            ->fnInsereLote(
                $object->getExercicio(),
                $empenho->getCodEntidade(),
                'E',
                $stNomeLote,
                $formData->get('dtEmpenho')->getData()->format("d/m/Y")
            );

        $itensPreEmpenho = $this->entityManager->getRepository(ItemPreEmpenho::class)
            ->findBy(
                array(
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                    'exercicio' => $object->getExercicio(),
                )
            );

        $valor = 0.00;
        foreach ($itensPreEmpenho as $itemPreEmpenho) {
            $valor += (float) $itemPreEmpenho->getVlTotal();
        }

        $codDespesa = $this->entityManager->getRepository(PreEmpenhoDespesa::class)
            ->findOneBy(
                array(
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                    'exercicio' => $object->getExercicio(),
                )
            );

        $contaDespesa = $this->entityManager->getRepository(ContaDespesa::class)
            ->findOneBy(
                array(
                    'exercicio' => $object->getExercicio(),
                    'codConta' => $codDespesa->getCodConta()
                )
            );

        $sequencia = $this->entityManager->getRepository(Empenho::class)
            ->empenhoEmissao(
                $object->getExercicio(),
                $valor,
                $empenho->getCodEmpenho() . "/" . $object->getExercicio(),
                $codLote,
                "E",
                $empenho->getCodEntidade(),
                $object->getCodPreEmpenho(),
                $codDespesa->getCodDespesa(),
                $contaDespesa->getCodEstrutural()
            );

        $joinContabilidadeLancamento = $this->entityManager->getRepository(Lancamento::class)
            ->findOneBy(
                array(
                    'codLote' => $codLote,
                    'tipo' => 'E',
                    'exercicio' => $object->getExercicio(),
                    'codEntidade' => $empenho->getCodEntidade(),
                    'sequencia' => $sequencia,
                )
            );

        $lancamentoEmpenho = new \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho();
        $lancamentoEmpenho->setFkContabilidadeLancamento($joinContabilidadeLancamento);
        $this->entityManager->persist($lancamentoEmpenho);

        $empenhamento = new \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento();
        $empenhamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
        $empenhamento->setFkEmpenhoEmpenho($empenho);
        $this->entityManager->persist($empenhamento);

        $empenhoAutorizacao = $this->entityManager->getRepository(EmpenhoAutorizacao::class)
            ->findOneBy(
                array(
                    'exercicio' => $object->getExercicio(),
                    'codEmpenho' => $empenho->getCodEmpenho(),
                    'codEntidade' => $empenho->getCodEntidade()
                )
            );

        if (!$empenhoAutorizacao) {
            $empenhoAutorizacao = new \Urbem\CoreBundle\Entity\Empenho\EmpenhoAutorizacao();
        }

        $empenhoAutorizacao->setFkEmpenhoEmpenho($empenho);
        $empenhoAutorizacao->setFkEmpenhoAutorizacaoEmpenho($object->getFkEmpenhoAutorizacaoEmpenhos()->last());
        $this->entityManager->persist($empenhoAutorizacao);

        $preEmpenhoDespesa = $this->entityManager->getRepository(PreEmpenhoDespesa::class)
            ->findOneBy(
                array(
                    'exercicio' => $object->getExercicio(),
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                )
            );

        $reservaSaldos = $this->entityManager->getRepository(PreEmpenho::class)
            ->getReservaSaldo($preEmpenhoDespesa->getCodDespesa(), $object->getExercicio());

        $fkReservaSaldos = $this->entityManager->getRepository(ReservaSaldos::class)
            ->findOneBy(
                array(
                    'codReserva' => $reservaSaldos->cod_reserva,
                    'exercicio' => $object->getExercicio(),
                )
            );

        $reservaSaldosAnulada = $this->entityManager->getRepository(ReservaSaldosAnulada::class)
            ->findOneBy(
                array(
                    'codReserva' => $reservaSaldos->cod_reserva,
                    'exercicio' => $object->getExercicio(),
                )
            );

        if (!$reservaSaldosAnulada) {
            $reservaSaldosAnulada = new \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada();
        }

        $reservaSaldosAnulada->setFkOrcamentoReservaSaldos($fkReservaSaldos);
        $reservaSaldosAnulada->setMotivoAnulacao("Empenho " . $empenho->getCodEmpenho() . "/" . $object->getExercicio());
        $this->entityManager->persist($reservaSaldosAnulada);

        $this->entityManager->flush();
    }

    public function getEmpenho($params)
    {
        $empenho = $this->entityManager->getRepository(Empenho::class)
            ->findOneBy([
                'codEmpenho' => $params['codEmpenho'],
                'exercicio' => $params['exercicio'],
                'codEntidade' => $params['codEntidade']
            ]);

        return $empenho;
    }

    public function getAllEmpenhoPreEmpenho()
    {
        $empenhoPreEmpenho = $this->entityManager->getRepository(Empenho::class)
            ->getAllEmpenhoPreEmpenho();

        $codPreEmpenhoList = array();
        foreach ($empenhoPreEmpenho as $empenho) {
            $codPreEmpenhoList[] = $empenho->cod_pre_empenho;
        }

        return $codPreEmpenhoList;
    }

    public function fnInsereLote($stExercicio, $inCodEntidade, $stTipo, $stNomeLote, $stDataLote)
    {
        return $this->repository->fnInsereLote($stExercicio, $inCodEntidade, $stTipo, $stNomeLote, $stDataLote);
    }

    public function consultarValorItemLiquidacaoEmpenho($codEmpenho, $exercicio, $codEntidade)
    {
        return $this->repository->consultarValorItemLiquidacaoEmpenho($codEmpenho, $exercicio, $codEntidade);
    }

    /**
     * Realiza o parse do array que é o retorno da função consultarValorItemLiquidacaoEmpenho.
     * Necessário pois a query não retorna todas as informações.
     *
     * @param $itensArray
     * @return array
     */
    public function parseItensLiquidacaoEmpenho($itensArray, $errors)
    {
        $itens = [];
        $valorTotalItens = 0;
        $totalLiquidar = 0;
        $totalLiquidado = 0;
        foreach ($itensArray as $item) {
            $item['error'] = '';
            if (count($errors) && array_key_exists($item['num_item'], $errors)) {
                $item['error'] = 'errorLiquidacao ';
            }

            $item['quantidade'] = (int) $item['quantidade'];
            $item['vl_unitario'] = number_format($item['vl_unitario'], 2, ',', '.');
            $nuValorEmpenhadoReal = $item['vl_total'] - $item['vl_empenhado_anulado'];
            $nuValorLiquidadoReal = $item['vl_liquidado'] - $item['vl_liquidado_anulado'];
            $item['valor_restante_anular'] = $nuValorLiquidadoReal;
            $nuValorALiquidar = $nuValorEmpenhadoReal - $nuValorLiquidadoReal;
            $item['vl_a_liquidar'] = $nuValorALiquidar;
            $valorTotalItens += $item['vl_total'];
            $totalLiquidar += $nuValorALiquidar;
            $totalLiquidado += $nuValorLiquidadoReal;
            $itens[] = $item;
        }

        $saldoALiquidar = $valorTotalItens - $totalLiquidar;

        return [
            'itens' => $itens,
            'totalEmpenho' => $valorTotalItens,
            'totalLiquidar' => $totalLiquidar,
            'saldoALiquidar' => $saldoALiquidar,
            'totalLiquidado' => $totalLiquidado
        ];
    }

    /**
     * Retorna a lista de Dotação Orçamentárias por exercicio
     *
     * @param  string $exercicio
     * @param  boolean $sonata
     * @return array
     */
    public function getDotacaoOrcamentaria($exercicio, $sonata = false)
    {
        $res = $this->entityManager->getRepository(ContaDespesa::class)
            ->getDotacaoOrcamentaria($exercicio);

        $dotacaoArray = array();
        foreach ($res as $dotacao) {
            $choiceLabel = $dotacao['mascara_classificacao'] . " - " . $dotacao['descricao'];
            if ($sonata) {
                $dotacaoArray[$choiceLabel] = $dotacao['mascara_classificacao'];
            } else {
                $dotacaoArray[$dotacao['mascara_classificacao']] = $choiceLabel;
            }
        }

        return $dotacaoArray;
    }


    /**
     * Retorna a lista de Dotação Orçamentárias por exercicio, com a chave como cod_despesa
     *
     * @param  string $exercicio
     * @param  boolean $sonata
     * @return array
     */
    public function getDotacaoOrcamentariaKeyCodDespesa($exercicio, $sonata = false)
    {
        $res = $this->entityManager->getRepository(ContaDespesa::class)
            ->getDotacaoOrcamentaria($exercicio);

        $dotacaoArray = array();
        foreach ($res as $dotacao) {
            $choiceLabel = $dotacao['mascara_classificacao'] . " - " . $dotacao['descricao'];
            if ($sonata) {
                $dotacaoArray[$choiceLabel] = $dotacao['cod_despesa'];
            } else {
                $dotacaoArray[$dotacao['cod_despesa']] = $choiceLabel;
            }
        }

        return $dotacaoArray;
    }

    /**
     * Retorna a lista de Elemento Despesa por exercicio
     *
     * @param  string $exercicio
     * @param  boolean $sonata
     * @return array
     */
    public function getElementoDespesa($exercicio, $sonata = false)
    {
        $res = $this->entityManager->getRepository(VwClassificacaoDespesaView::class)
            ->findByExercicio($exercicio);

        $elementoDespesaArray = array();
        foreach ($res as $elementoDespesa) {
            $choiceLabel = $elementoDespesa->getMascaraClassificacao() . " - " . $elementoDespesa->getDescricao();
            if ($sonata) {
                $elementoDespesaArray[$choiceLabel] = $elementoDespesa->getCodConta();
            } else {
                $elementoDespesaArray[$elementoDespesa->getCodConta()] = $choiceLabel;
            }
        }

        return $elementoDespesaArray;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function filterEmpenhoLiquidacao($filter)
    {
        return $this->entityManager->getRepository(Empenho::class)
            ->filterEmpenhoLiquidacao($filter);
    }

    /**
     * Engloba todos o processo de anulação de empenho
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $object
     * @param $formData
     * @param $saldos
     * @return bool|mixed
     */
    public function anularEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $object, $formData, $saldos)
    {
        try {
            $empenhoAnulado = new \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado();
            $empenhoAnulado->setMotivo($formData->get('motivo')->getData());
            $empenhoAnulado->setFkEmpenhoEmpenho($object);
            $this->entityManager->persist($empenhoAnulado);
            $itensPreEmpenho = $this->entityManager->getRepository(ItemPreEmpenho::class)
                ->findBy(
                    array(
                        'exercicio' => $object->getExercicio(),
                        'codPreEmpenho' => $object->getCodPreEmpenho(),
                        'fkEmpenhoPreEmpenho' => $object->getFkEmpenhoPreEmpenho()
                    )
                );

            foreach ($itensPreEmpenho as $itemPreEmpenho) {
                $empenhoAnuladoItem = new \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem();
                $empenhoAnuladoItem->setFkEmpenhoItemPreEmpenho($itemPreEmpenho);
                $empenhoAnuladoItem->setFkEmpenhoEmpenhoAnulado($empenhoAnulado);
                $empenhoAnuladoItem->setVlAnulado($itemPreEmpenho->getVlTotal());
                $this->entityManager->persist($empenhoAnuladoItem);
            }

            $stNomeLote = "Anulação de Empenho n° " . $object->getCodEmpenho() . "/" . $object->getExercicio();
            $codLote = $this->repository->fnInsereLote(
                $empenhoAnulado->getExercicio(),
                $empenhoAnulado->getCodEntidade(),
                'E',
                $stNomeLote,
                $formData->get('timestamp')->getData()->format("d/m/Y")
            );

            $complemento = $object->getCodEmpenho() . "/" . $object->getExercicio();

            $sequencia = $this->repository->empenhoEmissaoAnulacao(
                $empenhoAnulado->getExercicio(),
                $saldos->vl_empenhado,
                $complemento,
                $codLote,
                'E',
                $empenhoAnulado->getCodEntidade(),
                $object->getFkEmpenhoPreEmpenho()->getCodPreEmpenho(),
                $saldos->cod_despesa,
                $saldos->cod_estrutural
            );

            $joinContabilidadeLancamento = $this->entityManager->getRepository(Lancamento::class)
                ->findOneBy(
                    array(
                        'codLote' => $codLote,
                        'tipo' => 'E',
                        'exercicio' => $object->getExercicio(),
                        'codEntidade' => $empenhoAnulado->getCodEntidade(),
                        'sequencia' => $sequencia,
                    )
                );

            $lancamentoEmpenho = new \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho();
            $lancamentoEmpenho->setFkContabilidadeLancamento($joinContabilidadeLancamento);
            $this->entityManager->persist($lancamentoEmpenho);
            $empenhamento = new \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento();
            $empenhamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
            $empenhamento->setFkEmpenhoEmpenho($object);
            $this->entityManager->persist($empenhamento);
            $lancamentoEmpenhoAnulado = new \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenhoAnulado();
            $lancamentoEmpenhoAnulado->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
            $lancamentoEmpenhoAnulado->setFkEmpenhoEmpenhoAnulado($empenhoAnulado);
            $this->entityManager->persist($lancamentoEmpenhoAnulado);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getEmpenhoAnulado($codPreEmpenho, $exercicio)
    {
        $empenho = $this->repository->findOneBy(
            array(
                'codPreEmpenho' => $codPreEmpenho,
                'exercicio' => $exercicio
            )
        );

        return $this->entityManager->getRepository(EmpenhoAnulado::class)
            ->findOneBy(
                array(
                    'exercicio' => $empenho->getExercicio(),
                    'codEntidade' => $empenho->getCodEntidade(),
                    'codEmpenho' => $empenho->getCodEmpenho()
                )
            );
    }

    public function getValorEmpenhoAnulado($empenhoAnulado)
    {
        $empenhoAnuladoItens = $this->entityManager->getRepository(EmpenhoAnuladoItem::class)
            ->findBy(
                array(
                    'exercicio' => $empenhoAnulado->getExercicio(),
                    'timestamp' => $empenhoAnulado->getTimestamp(),
                    'codEmpenho' => $empenhoAnulado->getCodEmpenho(),
                    'codEntidade' => $empenhoAnulado->getCodEntidade(),
                )
            );

        $valorEmpenhoAnulado = 0;
        foreach ($empenhoAnuladoItens as $empenhoAnuladoItem) {
            $valorEmpenhoAnulado += (float) $empenhoAnuladoItem->getVlAnulado();
        }

        return $valorEmpenhoAnulado;
    }

    /**
     * @param $params
     * @param $limit
     * @return array
     */
    public function carregaEmpenhoEmpenho($params, $limit = '')
    {
        return $this->repository->carregaEmpenhoEmpenho($params, $limit);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getFnSaldoDotacaoDataAtualEmpenho($params)
    {
        return $this->repository->getFnSaldoDotacaoDataAtualEmpenho($params);
    }

    /**
     * @param $exercicio
     * @param $inCodEntidade
     * @return false|string
     */
    public function recuperaUltimaDataContabil($exercicio, $inCodEntidade)
    {
        $liberaData = false;
        $configuracaoEntidadeModel = new Model\Administracao\ConfiguracaoEntidadeModel($this->entityManager);
        $getDataFixaCompraDireta = $configuracaoEntidadeModel->getDataFixaCompraDireta($exercicio, $inCodEntidade);

        if (!is_null($getDataFixaCompraDireta)) {
            $stDtCompraDiretaFixa = $getDataFixaCompraDireta->getValor();
            if (isset($stDtCompraDiretaFixa) && $stDtCompraDiretaFixa != '') {
                $response = ['liberaData' => $liberaData, 'date' => $stDtCompraDiretaFixa];
                return $response;
            }
        }

        $liberaData = true;
        $recuperaUltimaDataEmpenho = $this->repository->recuperaUltimaDataEmpenho($exercicio, $inCodEntidade);
        $dataUltimoEmpenho = '';
        if (isset($recuperaUltimaDataEmpenho->dt_empenho) && $recuperaUltimaDataEmpenho->dt_empenho != '') {
            $dataUltimoEmpenho = $recuperaUltimaDataEmpenho->dt_empenho;
        }

        $autorizacaoEmpenhoModel = new AutorizacaoEmpenhoModel($this->entityManager);
        $listarMaiorData = $autorizacaoEmpenhoModel->listarMaiorData($exercicio, $inCodEntidade);

        if ($listarMaiorData) {
            $stDtAutorizacao = $listarMaiorData->dt_autorizacao;
        } elseif ($dataUltimoEmpenho != "") {
            $stDtAutorizacao = $dataUltimoEmpenho;
        } else {
            $stDtAutorizacao = "01/01/" . $exercicio;
        }
        $old_date = $stDtAutorizacao;
        $old_date_timestamp = strtotime($old_date);
        $date = date('d/m/Y', $old_date_timestamp);
        $response = ['liberaData' => $liberaData, 'date' => $date];
        return $response;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function getRazaoEmpenhoLancamentos($filter)
    {
        $res = $this->entityManager->getRepository(Empenho::class)
            ->getRazaoEmpenhoLancamentos($filter);

        return $res;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function getRazaoEmpenho($filter)
    {
        $res = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
            ->getRazaoEmpenho($filter);

        return $res;
    }
}
