<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\Parcela;

/**
 * Class DocumentoModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class DocumentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository;

    /**
     * DocumentoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Documento::class);
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosCertidaoDAUrbem(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosCertidaoDAUrbem(['numParcelamento' => $numParcelamento]);

        $valorTotal = 0;
        $valorTotalTributario = 0;
        $valorTotalNaoTributario = 0;
        $valorTotalReducao = 0;
        $creditosTributarios = [];
        $creditosNaoTributarios = [];

        foreach ($dadosArquivo as $dados) {
            $valorOrigem = $dados['valor_origem'];
            $correção = explode(';', $dados['acrescimos_c'])[0];
            $juros = explode(';', $dados['acrescimos_j'])[0];
            $multa = explode(';', $dados['acrescimos_m'])[0];

            $total = $valorOrigem + $correção + $juros + $multa;

            $credito = [
                "credito_origem" => $dados['credito_origem'],
                "valor_origem" => number_format($valorOrigem, 2, ',', '.'),
                "correcao" => number_format($correção, 2, ',', '.'),
                "juros" => number_format($juros, 2, ',', '.'),
                "multa" => number_format($multa, 2, ',', '.'),
                "total_credito" => number_format($total, 2, ',', '.'),
            ];

            $valorTotalReducao += $dados['total_reducao'];
            $valorTotal += $total - $dados['total_reducao'];

            if ($dados['cod_natureza'] == 1) {
                $valorTotalTributario += $total;
                $creditosTributarios[] = $credito;

                continue;
            }

            $valorTotalNaoTributario += $total;
            $creditosNaoTributarios[] = $credito;
        }

        $dat2 = array_shift($dadosArquivo) ?: [];
        $dat2['total_tributoT'] = number_format($valorTotalTributario, 2, ',', '.');
        $dat2['total_tributoNT'] = number_format($valorTotalNaoTributario, 2, ',', '.');
        $dat2['total_reducao'] = number_format($valorTotalReducao, 2, ',', '.');
        $dat2['valor_total'] = number_format($valorTotal, 2, ',', '.');
        $dat2['dt_inscricao_txt'] = strftime('%d de %B de %Y');
        $dat2['num_documento'] = $documento->getFkDividaEmissaoDocumentos()->last()->getNumDocumento();
        array_unshift($dadosArquivo, $dat2);

        $inDocumento = 1;
        if ($nomeArquivo == 'termoInscricaoDAUrbem') {
            $inDocumento = 2;
        }

        $ntributario = 0;
        $tributario = 0;
        $ttributario = 0;
        if ($creditosNaoTributarios && $creditosTributarios) {
            $ntributario = 1;
            $tributario = 1;
            $ttributario = 1;
        }

        if ($creditosNaoTributarios && !$creditosTributarios) {
            $ntributario = 1;
            $tributario = 0;
            $ttributario = 2;
        }

        if (!$creditosNaoTributarios && $creditosTributarios) {
            $ntributario = 0;
            $tributario = 1;
            $ttributario = 3;
        }

        $dadosConfiguracaoUsuario = $this->repository->fetchDadosConfiguracaoUsuario($inDocumento);

        return [
            'blocks' => [
                'Dat' => $dadosConfiguracaoUsuario,
                'Dat2' => $dadosArquivo,
                'Dat3' => $creditosNaoTributarios,
                'Dat4' => $creditosTributarios,
                'Dat5' => $this->repository
                ->fetchDadosAcrescimoFundamentacao(['numParcelamento' => $numParcelamento]),
            ],
            'vars' => [
                'leida' => !empty($dadosConfiguracaoUsuario['util_leida_doc']),
                'ntributario' => $ntributario,
                'tributario' => $tributario,
                'ttributario' => $ttributario,
                'incidenciaval' => !empty($dadosConfiguracaoUsuario['util_incval_doc']),
                'metodologia' => !empty($dadosConfiguracaoUsuario['util_metcalc_doc']),
                'msg' => !empty($dadosConfiguracaoUsuario['util_msg_doc']),
                'responsaveis' => !empty($dadosConfiguracaoUsuario['util_resp2_doc']) ? 2 : 1,
            ],
        ];
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosTermoConsolidacaoDAUrbem(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosTermoConsolidacaoDAUrbem(['numParcelamento' => $numParcelamento]);

        $valorTotal = 0;
        $dadosParcelas = [];

        foreach ($dadosArquivo as $key => $dados) {
            $dadosParcela = [
                "vlr_parcela" => number_format($dados['vlr_parcela'], 2, ',', '.'),
                "valor_corrigido" => number_format($dados['valor_corrigido'], 2, ',', '.'),
                "valor_multa" => number_format($dados['valor_multa'], 2, ',', '.'),
                "valor_correcao" => number_format($dados['valor_correcao'], 2, ',', '.'),
                "valor_juros" => number_format($dados['valor_juros'], 2, ',', '.'),
                "valor_reducao" => number_format($dados['valor_reducao'], 2, ',', '.'),
                "valor_pago" => number_format($dados['valor_pago'], 2, ',', '.'),
            ];

            $valorTotal += $dados['vlr_parcela'];

            $dadosParcelas[] = array_merge($dados, $dadosParcela);
        }

        $acordos = array_column($dadosArquivo, 'nr_acordo_administrativo');
        if ($acordos) {
            $dadosArquivo[0]['nr_acordo_administrativo'] = implode(', ', $acordos);
        }

        $inDocumento = 4;
        if ($nomeArquivo == 'termoParcelamentoDAUrbem') {
            $inDocumento = 5;
        }

        $dadosConfiguracaoUsuario = $this->repository->fetchDadosConfiguracaoUsuario($inDocumento);

        return [
            'blocks' => [
                'Dat' => $dadosArquivo,
                'Dat2' => $dadosParcelas,
                'Dat3' => [0 => ['vlr_total' => number_format($valorTotal, 2, ',', '.')]],
                'Dat4' => $dadosConfiguracaoUsuario,
            ],
            'vars' => [
                'msg' => !empty($dadosConfiguracaoUsuario['util_msg_doc']),
                'responsaveis' => !empty($dadosConfiguracaoUsuario['util_resp2_doc']) ? 2 : 1,
            ],
        ];
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosMemorialCalculoDAUrbem(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosMemorialCalculoDAUrbem(['numParcelamento' => $numParcelamento]);

        $arValorCreditos = [];
        $arValorOrigem = [];
        $arValorOrigemDataAtual = [];

        if ($dadosArquivo) {
            $rsDadosValorCreditos = $dadosArquivo[0];
            $stDtOrigem = $rsDadosValorCreditos['dt_vencimento_origem'];
            $stDtAtual = $rsDadosValorCreditos['dt_notificacao'];
            $arDtOrigem = explode('-', $stDtOrigem);
            $arDtAtual = explode('/', $stDtAtual);
            $arValorOrigem = array();

            while ($arDtOrigem[0].$arDtOrigem[1].$arDtOrigem[2] < $arDtAtual[2].$arDtAtual[1].$arDtAtual[0]) {
                unset($rsListaDA);

                if ($arDtOrigem[1] > 12) {
                    $arDtOrigem[1] = 01;
                    $arDtOrigem[0] = $arDtOrigem[0] + 1;
                }

                $inDiaInicial = $arDtOrigem[2];
                $inDiaSemana  = date('w', mktime(0, 0, 0, sprintf('%02d', $arDtOrigem[1]), sprintf('%02d', $arDtOrigem[2]), sprintf('%04d', $arDtOrigem[0])));
                $inNroDiasMes = date('t', mktime(0, 0, 0, sprintf('%02d', $arDtOrigem[1]), 01, sprintf('%04d', $arDtOrigem[0])));

                if ($inNroDiasMes <= $inDiaInicial) {
                    $inDiaSemana  = date('w', mktime(0, 0, 0, sprintf('%02d', $arDtOrigem[1]), sprintf('%02d', $inNroDiasMes), sprintf('%04d', $arDtOrigem[0])));
                    if ($inDiaSemana == 0) {
                        $dtDiaVencimento = $inNroDiasMes - 2;
                    } elseif ($inDiaSemana == 6) {
                        $dtDiaVencimento = $inNroDiasMes - 1;
                    } else {
                        $dtDiaVencimento = $inNroDiasMes;
                    }
                } elseif (($inNroDiasMes - 1) == $inDiaInicial) {
                    $inDiaSemana  = date('w', mktime(0, 0, 0, sprintf('%02d', $arDtOrigem[1]), sprintf('%02d', $inNroDiasMes), sprintf('%04d', $arDtOrigem[0])));
                    if ($inDiaSemana == 0) {
                        $dtDiaVencimento = $inNroDiasMes + 1;
                    } elseif ($inDiaSemana == 6) {
                        $dtDiaVencimento = $inNroDiasMes - 1;
                    } else {
                        $dtDiaVencimento = $inNroDiasMes;
                    }
                } else {
                    $inDiaSemana  = date('w', mktime(0, 0, 0, sprintf('%02d', $arDtOrigem[1]), sprintf('%02d', $inDiaInicial), sprintf('%04d', $arDtOrigem[0])));
                    if ($inDiaSemana == 0) {
                        $dtDiaVencimento = $inDiaInicial + 1;
                    } elseif ($inDiaSemana == 6) {
                        $dtDiaVencimento = $inDiaInicial + 2;
                    } else {
                        $dtDiaVencimento = $inDiaInicial;
                    }
                }

                $boAvancaData = true;
                if ($inDiaInicial > 31) {
                    $inDiaInicial = 1;
                    $arDtOrigem[1] = $arDtOrigem[1] + 1;
                    $boAvancaData = false;
                }

                if ($dtDiaVencimento > 31) {
                    $dtDiaVencimento = 1;
                    $arDtOrigem[1] = $arDtOrigem[1] + 1;
                    $boAvancaData = false;
                }

                if (checkdate($arDtOrigem[1], $dtDiaVencimento, $arDtOrigem[0]) != 1) {
                    if ($arDtOrigem[1] >= 12) {
                        $arDtOrigem[1] = 1;
                        $arDtOrigem[0]++;
                    } else {
                        $arDtOrigem[1]++;
                    }

                    $dtDiaVencimento = 1;
                }

                $stNovaData = sprintf('%04d-%02d-%02d', $arDtOrigem[0], $arDtOrigem[1], $dtDiaVencimento);
                $stNovaDataBR = sprintf('%02d/%02d/%04d', $dtDiaVencimento, $arDtOrigem[1], $arDtOrigem[0]);
                $rsListaDA = $this->repository
                ->fetchMemorialCalculoGenerico($rsDadosValorCreditos['cod_inscricao'], $rsDadosValorCreditos['exercicio'], $rsDadosValorCreditos['cod_modalidade'], $rsDadosValorCreditos['inscricao'], $rsDadosValorCreditos['valor_origem'], $rsDadosValorCreditos['dt_vencimento_origem'], $stNovaData);

                if ($boAvancaData) {
                    $arDtOrigem[1]++;
                }

                while ($rsListaDACurrent = current($rsListaDA)) {
                    $arAcrescimos = explode(';', $rsListaDACurrent['acrescimos']);

                    $flCorrecao = 0.00;
                    $flJuros = 0.00;
                    $flMulta = 0.00;
                    for ($inY=1; $inY<count($arAcrescimos); $inY+=3) {
                        //valor_total, valor_parcial1, cod_acrescimo1, cod_tipo1
                        switch ($arAcrescimos[$inY+2]) {
                            case 1: //correcao
                                $flCorrecao += $arAcrescimos[$inY];
                                break;

                            case 2: //juros
                                $flJuros += $arAcrescimos[$inY];
                                break;

                            case 3: //multa
                                $flMulta += $arAcrescimos[$inY];
                                break;
                        }
                    }

                    $flValorOrigem = $rsDadosValorCreditos['valor_origem'];
                    $arValorOrigem[] = array (
                        'dt_calc' => $stNovaDataBR,
                        'origem' => $rsDadosValorCreditos['imposto'],
                        'valor_origem' => number_format($flValorOrigem, 2, ',', '.'),
                        'correcao' => number_format($flCorrecao, 2, ',', '.'),
                        'juros' => number_format($flJuros, 2, ',', '.'),
                        'multa' => number_format($flMulta, 2, ',', '.'),
                        'total_calc' => number_format($flValorOrigem + $arAcrescimos[0], 2, ',', '.')
                    );

                    next($rsListaDA);
                }
            }

            $arValorOrigemDataAtual[] = array (
                'origem' => $arValorOrigem[count($arValorOrigem)-1]['origem'],
                'valor_origem' => number_format($flValorOrigem, 2, ',', '.'),
                'correcao' => number_format($flCorrecao, 2, ',', '.'),
                'juros' => number_format($flJuros, 2, ',', '.'),
                'multa' => number_format($flMulta, 2, ',', '.'),
                'total_calc' => number_format($flValorOrigem + $arAcrescimos[0], 2, ',', '.')
            );

            $arValorCreditos = $dadosArquivo;

            $flValorTotal = $flValorOrigem + $arAcrescimos[0];
            $arValorCreditos[0]['total_tributo'] = number_format($flValorTotal, 2, ',', '.');
            if ($arValorCreditos[0]['total_reducao'] > 0.00) {
                $flValorTotal -= $arValorCreditos[0]['total_reducao'];
            }

            $arValorCreditos[0]['total_reducao'] = number_format($arValorCreditos[0]['total_reducao'], 2, ',', '.');
            $arValorCreditos[0]['valor_total'] = number_format($flValorTotal, 2, ',', '.');
        }

        $inDocumento = 3;

        $dadosConfiguracaoUsuario = $this->repository->fetchDadosConfiguracaoUsuario($inDocumento);

        return [
            'blocks' => [
                'Dat' => $dadosConfiguracaoUsuario,
                'Dat2' => $arValorCreditos,
                'Dat3' => $arValorOrigem,
                'Dat4' => $arValorOrigemDataAtual,
            ],
            'vars' => [
                'msg' => !empty($dadosConfiguracaoUsuario['util_msg_doc']),
            ],
        ];
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosCertidaoDivida(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosCertidaoDivida(['numParcelamento' => $numParcelamento, 'numDocumento' => $documento->getFkDividaEmissaoDocumentos()->last()->getNumDocumento()]);

        $dat4 = [];
        $dat4['valor_original'] = number_format(array_sum(array_column($dadosArquivo, 'valor_origem')), 2, ',', '.');
        $dat4['multa'] = number_format(array_sum(array_column($dadosArquivo, 'multa')), 2, ',', '.');
        $dat4['juros'] = number_format(array_sum(array_column($dadosArquivo, 'juros')), 2, ',', '.');
        $dat4['correcao'] = number_format(array_sum(array_column($dadosArquivo, 'correcao')), 2, ',', '.');
        $dat4['multa_infracao'] = number_format(array_sum(array_column($dadosArquivo, 'multa_infracao')), 2, ',', '.');
        $dat4['valor_total'] = number_format(array_sum(array_column($dadosArquivo, 'valor_total')), 2, ',', '.');
        $dat4['dt_inscricao'] = strftime('%d de %B de %Y');

        foreach ($dadosArquivo as &$dados) {
            $dados['valor_total'] = $dados['juros'] + $dados['multa'] + $dados['multa_infracao'] + $dados['correcao'] + $dados['valor_origem'];

            $dados['juros'] = number_format($dados['juros'], 2, ',', '.');
            $dados['multa'] = number_format($dados['multa'], 2, ',', '.');
            $dados['multa_infracao'] = number_format($dados['multa_infracao'], 2, ',', '.');
            $dados['correcao'] = number_format($dados['correcao'], 2, ',', '.');
            $dados['valor_origem'] = number_format($dados['valor_origem'], 2, ',', '.');
            $dados['valor_total'] = number_format($dados['valor_total'], 2, ',', '.');

            if ($dados['numero_quadra'] && $dados['numero_lote']) {
                $dados['domicilio_fiscal'] = sprintf(
                    '%s, QUADRA: %s, LOTE: %s, %s %s',
                    $dados['endereco'],
                    $dados['numero_quadra'],
                    $dados['numero_lote'],
                    $dados['bairro'],
                    $dados['cep']
                );

                continue;
            }

            $dados['domicilio_fiscal'] = sprintf(
                '%s %s %s',
                $dados['endereco'],
                $dados['bairro'],
                $dados['cep']
            );
        }

        return [
            'blocks' => [
                'Dat' => $dadosArquivo,
                'Dat2' => $dadosArquivo,
                'Dat3' => $dadosArquivo,
                'Dat4' => [$dat4],
            ],
            'vars' => [],
        ];
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosNotificacaoDivida(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosNotificacaoDivida(['numParcelamento' => $numParcelamento]);
        if (!$dadosArquivo) {
            return [];
        }

        $valorOrigem = array_sum(array_column($dadosArquivo, 'valor_origem'));
        $juros = array_sum(array_column($dadosArquivo, 'juros'));
        $multa = array_sum(array_column($dadosArquivo, 'multa'));
        $multaInfracao = array_sum(array_column($dadosArquivo, 'multa_infracao'));
        $correcao = array_sum(array_column($dadosArquivo, 'correcao'));
        $valorTotal = $valorOrigem + $juros + $multa + $multaInfracao + $correcao;

        $valoresTotais = [];
        $valoresTotais['valor_original'] = number_format($valorOrigem, 2, ',', '.');
        $valoresTotais['juros'] = number_format($juros, 2, ',', '.');
        $valoresTotais['multa'] = number_format($multa, 2, ',', '.');
        $valoresTotais['multa_infracao'] = number_format($multaInfracao, 2, ',', '.');
        $valoresTotais['correcao'] = number_format($correcao, 2, ',', '.');
        $valoresTotais['valor_total'] = number_format($valorTotal, 2, ',', '.');

        $valorPorCredito = [];
        foreach ($dadosArquivo as $dados) {
            $credito = sprintf('%s~%s', $dados['descricao_credito'], $dados['exercicio_origem']);
            $valorPorCredito[$credito] = !empty($valorPorCredito[$credito]) ? $valorPorCredito[$credito] : [];

            $valorOrigem = !empty($valorPorCredito[$credito]['valor_origem']) ? $valorPorCredito[$credito]['valor_origem'] : 0;
            $juros = !empty($valorPorCredito[$credito]['juros']) ? $valorPorCredito[$credito]['juros'] : 0;
            $multa = !empty($valorPorCredito[$credito]['multa']) ? $valorPorCredito[$credito]['multa'] : 0;
            $multaInfracao = !empty($valorPorCredito[$credito]['multa_infracao']) ? $valorPorCredito[$credito]['multa_infracao'] : 0;
            $correcao = !empty($valorPorCredito[$credito]['correcao']) ? $valorPorCredito[$credito]['correcao'] : 0;
            $valorTotal = !empty($valorPorCredito[$credito]['valor_total']) ? $valorPorCredito[$credito]['valor_total'] : 0;

            $valorPorCredito[$credito]['valor_origem'] = $valorOrigem + $dados['valor_origem'];
            $valorPorCredito[$credito]['juros'] = $juros + $dados['juros'];
            $valorPorCredito[$credito]['multa'] = $multa + $dados['multa'];
            $valorPorCredito[$credito]['multa_infracao'] = $multaInfracao + $dados['multa_infracao'];
            $valorPorCredito[$credito]['correcao'] = $correcao + $dados['correcao'];

            $valorTotal = $valorTotal + $dados['valor_origem'] + $dados['juros'] + $dados['multa'] + $dados['multa_infracao'] + $dados['correcao'];
            $valorPorCredito[$credito]['valor_total'] = $valorTotal;

            $valorPorCredito[$credito]['dt_vencimento_origem'] = $dados['dt_vencimento_origem'];
            $valorPorCredito[$credito]['exercicio_origem'] = $dados['exercicio_origem'];
        }

        foreach ($valorPorCredito as &$dados) {
            $dados['valor_origem'] = number_format($dados['valor_origem'], 2, ',', '.');
            $dados['juros'] = number_format($dados['juros'], 2, ',', '.');
            $dados['multa'] = number_format($dados['multa'], 2, ',', '.');
            $dados['multa_infracao'] = number_format($dados['multa_infracao'], 2, ',', '.');
            $dados['correcao'] = number_format($dados['correcao'], 2, ',', '.');
            $dados['valor_total'] = number_format($dados['valor_total'], 2, ',', '.');
        }

        $emissaoDocumento = $documento->getFkDividaEmissaoDocumentos()->last();
        $dadosArquivo[0]['emissao_exercicio'] = sprintf('%d/%d', $emissaoDocumento->getNumDocumento(), $emissaoDocumento->getExercicio());
        $dadosArquivo[0]['dt_inscricao'] = strftime('%d de %B de %Y');
        $dadosArquivo[0]['exercicio'] = $dadosArquivo[0]['exercicio_origem'];

        return [
            'blocks' => [
                'Dat' => $dadosArquivo,
                'Dat2' => $valorPorCredito,
                'Dat3' => [$valoresTotais],
            ],
            'vars' => [],
        ];
    }

    /**
    * @param Documento $documento
    * @param strin $nomeArquivo
    * @return array
    */
    public function fetchDadosTermoComposicaoDAMariana(Documento $documento, $nomeArquivo)
    {
        $numParcelamento = $documento->getNumParcelamento();
        $dadosArquivo = $this->repository->fetchDadosTermoComposicaoDAMariana(['numParcelamento' => $numParcelamento]);
        if (!$dadosArquivo) {
            return;
        }

        $header = [];
        $header['contribuinte'] = $dadosArquivo[0]['nome_notificado'];
        $header['endereco'] = $dadosArquivo[0]['endereco_notificado'];
        $header['bairro'] = $dadosArquivo[0]['bairro_notificado'];
        $header['cep'] = $dadosArquivo[0]['cep_notificado'];
        $header['cid_est'] = $dadosArquivo[0]['cidade_estado_notificado'];

        foreach ($dadosArquivo as &$dados) {
            $dados['contribuinte'] = $dados['nome_notificado'];
            $dados['endereco'] = $dados['endereco_notificado'];
            $dados['exercicio'] = $dados['exercicio_origem'];
            $dados['tributo'] = $dados['descricao_credito'];

            $valorAtual = $dados['valor_origem'] + $dados['correcao'] + $dados['multa_infracao'];
            $dados['valor_atual'] = number_format($valorAtual, 2, ',', '.');

            $dados['multa'] = number_format($dados['multa'], 2, ',', '.');
            $dados['juros'] = number_format($dados['juros'], 2, ',', '.');

            $total = $dados['multa'] + $dados['juros'];
            $dados['total'] = number_format($total, 2, ',', '.');

            $desconto = $dados['reducao_juros'] + $dados['reducao_multa'];
            $dados['desconto'] = number_format($desconto, 2, ',', '.');

            $parcial = $total - $desconto;
            $dados['parcial'] = number_format($parcial, 2, ',', '.');

            $geral = $valorAtual + $parcial;
            $dados['geral'] = number_format($geral, 2, ',', '.');
            $dados['_geral'] = $geral;
        }

        $dividaParcelas = $this->entityManager->getRepository(Parcela::class)->findByNumParcelamento($numParcelamento, ['dtVencimentoParcela' => 'ASC']);

        $parcelas = [];
        $vlrParcelaUm = 0;
        foreach ($dividaParcelas as $dividaParcela) {
            $parcela = [];
            $parcela['vlr_parcela'] = number_format($dividaParcela->getVlrParcela(), 2, ',', '.');

            if ($dividaParcela->getNumParcela() == 1) {
                $parcela['parcela_um'] = $parcela['vlr_parcela'];
                $vlrParcelaUm = $dividaParcela->getVlrParcela();

                $parcela['nro_parcela'] = count($dividaParcelas);
            }

            array_push($parcelas, $parcela);
        }

        $footer = [];
        $totalGeral = array_sum(array_column($dadosArquivo, '_geral'));
        $footer['total_geral'] = number_format($totalGeral, 2, ',', '.');
        $footer['saldo'] = number_format($totalGeral - $vlrParcelaUm, 2, ',', '.');
        $footer['data'] = strftime('%d de %B de %Y');

        return [
            'blocks' => [
                'Head' => [$header],
                'Dat' => $dadosArquivo,
                'Dat2' => $parcelas,
                'Foot' => [$footer],
            ],
            'vars' => [],
        ];
    }
}
