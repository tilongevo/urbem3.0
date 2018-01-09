<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoBanrisulRepository;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima\ExportarPagamentoBanrisulAdmin;

/**
 * Class ExportarPagamentoBanrisulModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class ExportarPagamentoBanrisulModel extends AbstractModel
{
    const NUM_BANCO = 41;
    const NOM_BANCO = 'BANCO DO RIO GRANDE DO SUL SA';

    protected $entityManager = null;
    protected $repository;

    /**
     * ExportarPagamentoBanrisulModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = new ExportarPagamentoBanrisulRepository($this->entityManager);
    }

    /**
    * @param array $filtro
    * @return void
    */
    public function setValorFiltro(&$filtro)
    {
        $tipoFiltro = $filtro['tipoFiltro'];
        $filtro['valorFiltro'] = '';
        if (in_array($tipoFiltro, [ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_MATRICULA, ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_CGM_MATRICULA])) {
            $cgmMatriculas = !empty($filtro['cgmMatriculas']) ? array_column($filtro['cgmMatriculas'], 'codContrato') : [0];
            $filtro['valorFiltro'] = implode(',', $cgmMatriculas);
        }

        if ($tipoFiltro == ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_LOTACAO) {
            $filtro['valorFiltro'] = implode(',', $filtro['lotacao']);
        }

        if ($tipoFiltro == ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_LOCAL) {
            $filtro['valorFiltro'] = implode(',', $filtro['local']);
        }

        if (in_array($tipoFiltro, [ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR, ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_PENSIONISTA])) {
            foreach ($filtro['atributoDinamico'] as $codAtributo => $atributo) {
                $valorAtributo = array_shift($atributo);
                if (!$valorAtributo) {
                    continue;
                }

                $filtro['valorFiltro'] = sprintf(
                    '%s#%s#%s',
                    (int) is_array($valorAtributo),
                    $codAtributo,
                    is_array($valorAtributo) ? implode(',', $valorAtributo) : $valorAtributo
                );
            }
        }

        if ($tipoFiltro == ExportarPagamentoBanrisulAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_ESTAGIARIO) {
            foreach ($filtro['atributoDinamico'] as $codAtributo => $atributo) {
                $valorAtributo = array_shift($atributo);
                if (!$valorAtributo) {
                    continue;
                }

                $filtro['codAtributo'] = $codAtributo;
                $filtro['valorAtributo'] = is_array($valorAtributo) ? implode(',', $valorAtributo) : $valorAtributo;
            }
        }
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getRemessas($filtro)
    {
        $arquivo = [];
        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_ATIVO, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaAtivos($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_APOSENTADO, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaAposentados($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_PENSIONISTA, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaPensionistas($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_ESTAGIARIO, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaEstagiarios($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_RESCINDIDO, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaRescindidos($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_PENSAO_JUDICIAL, ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaPensaoJudicial($filtro));
        }

        return $arquivo;
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @return string
    */
    public function formatarCabecalhoArquivo(array $entidade, array $filtro)
    {
        $cabecalhoArquivo = [
            'banco' => $this::NUM_BANCO,
            'lote' => 0,
            'registro' => 0,
            'cnab' => '',
            'tipoInscricao' => 2,
            'numInscricao' => $entidade['cnpj'],
            'convenio' => $filtro['codConvenio'],
            'codAgencia' => $filtro['codAgencia'],
            'numContaCorrente' => preg_replace('/[^\d]/', '', $filtro['numContaCorrente']),
            'nomEmpresa' => $entidade['nom_cgm'],
            'nomBanco' => $this::NOM_BANCO,
            'codigoRemessa' => 1,
            'dtGeracao' => '',
            'hrGeracao' => date('his'),
            'numSequencial' => $filtro['numeroSequencialArquivo'],
            'numVersaoLayout' => 20,
            'densidadeGravacaoArquivo' => 0,
            'reservadoBanco' => '',
            'reservadoEmpresa' => '',

        ];

        return implode(
            '',
            [
                $this->formatarValor($cabecalhoArquivo['banco'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['lote'], 4, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['registro'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor('', 9, ' '),
                $this->formatarValor($cabecalhoArquivo['tipoInscricao'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['numInscricao'], 14, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['convenio'], 5, '0', STR_PAD_LEFT),
                $this->formatarValor('', 15, ' '),
                $this->formatarValor($cabecalhoArquivo['codAgencia'], 5, '0', STR_PAD_LEFT),
                $this->formatarValor('', 4, '0'),
                $this->formatarValor($cabecalhoArquivo['numContaCorrente'], 10, '0', STR_PAD_LEFT),
                $this->formatarValor('', 1, '0'),
                $this->formatarValor($cabecalhoArquivo['nomEmpresa'], 30, ' '),
                $this->formatarValor($cabecalhoArquivo['nomBanco'], 30, ' '),
                $this->formatarValor($cabecalhoArquivo['cnab'], 10, ' ', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['codigoRemessa'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['dtGeracao'], 8, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['hrGeracao'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['numSequencial'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['numVersaoLayout'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['densidadeGravacaoArquivo'], 5, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoArquivo['reservadoBanco'], 20, ' '),
                $this->formatarValor($cabecalhoArquivo['reservadoEmpresa'], 20, ' '),
                $this->formatarValor($cabecalhoArquivo['cnab'], 29, ' ', STR_PAD_LEFT),
            ]
        );
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @return string
    */
    public function formatarCabecalhoLote(array $entidade, array $filtro)
    {
        $cabecalhoLote = [
            'banco' => $this::NUM_BANCO,
            'lote' => 1,
            'registro' => 1,
            'operacao' => 'C',
            'servico' => 30,
            'formaLancamento' => 1,
            'layoutLote' => 20,
            'cnab' => '',
            'tipoInscricao' => 2,
            'numInscricao' => $entidade['cnpj'],
            'convenio' => $filtro['codConvenio'],
            'codAgencia' => $filtro['codAgencia'],
            'numContaCorrente' => preg_replace('/[^\d]/', '', $filtro['numContaCorrente']),
            'nomEmpresa' => $entidade['nom_cgm'],
            'mesagem' => '',
            'logradouro' => $entidade['logradouro'],
            'numLocal' => $entidade['numero'],
            'complemento' => $entidade['complemento'],
            'cidade' => $entidade['nom_municipio'],
            'cep' => $entidade['cep'],
            'estado' => $entidade['sigla_uf'],
            'ocorrencias' => '',
        ];

        return implode(
            '',
            [
                $this->formatarValor($cabecalhoLote['banco'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['lote'], 4, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['registro'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['operacao'], 1, ' '),
                $this->formatarValor($cabecalhoLote['servico'], 2, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['formaLancamento'], 2, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['layoutLote'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['cnab'], 1, ' '),
                $this->formatarValor($cabecalhoLote['tipoInscricao'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['numInscricao'], 14, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['convenio'], 5, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['cnab'], 15, ' '),
                $this->formatarValor($cabecalhoLote['codAgencia'], 5, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['numContaCorrente'], 10, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['cnab'], 1, ' '),
                $this->formatarValor($cabecalhoLote['nomEmpresa'], 30, ' '),
                $this->formatarValor($cabecalhoLote['cnab'], 40, ' '),
                $this->formatarValor($cabecalhoLote['logradouro'], 30, ' '),
                $this->formatarValor($cabecalhoLote['numLocal'], 5, ' '),
                $this->formatarValor($cabecalhoLote['complemento'], 15, ' '),
                $this->formatarValor($cabecalhoLote['cidade'], 20, ' '),
                $this->formatarValor($cabecalhoLote['cep'], 8, '0', STR_PAD_LEFT),
                $this->formatarValor($cabecalhoLote['estado'], 2, ' '),
                $this->formatarValor($cabecalhoLote['cnab'], 8, ' '),
                $this->formatarValor($cabecalhoLote['ocorrencias'], 10, ' '),
            ]
        );
    }

    /**
    * @param array $remessas
    * @param array $filtro
    * @return string
    */
    public function formatarRemessas(array $remessas, array $filtro)
    {
        $detalheRemessas = [
            'banco' => $this::NUM_BANCO,
            'lote' => 1,
            'registroDetalheLote' => 3,
            'segmento' => 'A',
            'tipoMovimento' => 0,
            'codigoInstrucao' => 0,
            'compensacao' => 18,
            'finalidade' => 4,
            'tipoMoeda' => 'BRL',
            'dtRealEfetivacao' => 0,
            'vlRealEfetivacao' => 0,
            'tipoInscricao' => 1,
            'cnab' => '',
            'avisoFavorecido' => 0,
            'ocorrencias' => '',
        ];

        $registros = [];
        foreach ($remessas as $i => $remessa) {
            $finalidade = $detalheRemessas['finalidade'];
            $seuNumero = !empty($remessa['registro']) ? $remessa['registro'] : '';
            if ($remessa['tipo'] == ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_ESTAGIARIO) {
                $seuNumero = $remessa['numero_estagio'];
            }

            if ($remessa['tipo'] == ExportarPagamentoBanrisulAdmin::TIPO_CADASTRO_PENSAO_JUDICIAL) {
                $finalidade = 101;
                $seuNumero = $remessa['numcgm_dependente'];
            }

            $registros[] = implode(
                '',
                [
                    $this->formatarValor($detalheRemessas['banco'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['lote'], 4, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['registroDetalheLote'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($i, 5, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['segmento'], 1, ' '),
                    $this->formatarValor($detalheRemessas['tipoMovimento'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['codigoInstrucao'], 2, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['compensacao'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor($remessa['num_banco'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor(strstr($remessa['num_agencia'], '-', true), 5, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['cnab'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor(preg_replace('/[^\d]/', '', $remessa['nr_conta']), 13, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['cnab'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($remessa['nom_cgm'], 30, ' '),
                    $this->formatarValor($seuNumero, 15, ' '),
                    $this->formatarValor($finalidade, 5, '0', STR_PAD_LEFT),
                    $this->formatarValor(str_replace('/', '', $filtro['dtPagamento']), 8, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['tipoMoeda'], 3, ' '),
                    $this->formatarValor($detalheRemessas['cnab'], 15, '0', STR_PAD_LEFT),
                    $this->formatarValor(str_replace([',', '.'], '', $remessa['liquido']), 15, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['cnab'], 20, ' '),
                    $this->formatarValor($detalheRemessas['dtRealEfetivacao'], 8, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['vlRealEfetivacao'], 15, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['cnab'], 25, ' '),
                    $this->formatarValor($detalheRemessas['tipoInscricao'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($remessa['cpf'], 14, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['cnab'], 12, ' '),
                    $this->formatarValor($detalheRemessas['avisoFavorecido'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($detalheRemessas['ocorrencias'], 10, ' '),
                ]
            );
        }

        return implode(PHP_EOL, $registros);
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @param array $remessas
    * @return string
    */
    public function formatarRodapeArquivo(array $entidade, array $filtro, array $remessas)
    {
        $rodapeArquivo = [
            'banco' => $this::NUM_BANCO,
            'lote' => 9999,
            'registro' => 9,
            'cnab' => '',
            'qtdLotes' => 1,
            'qtdRegistros' => count($remessas),
            'qtdContas' => 0,
        ];

        return implode(
            '',
            [
                $this->formatarValor($rodapeArquivo['banco'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['lote'], 4, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['registro'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['cnab'], 9, ' '),
                $this->formatarValor($rodapeArquivo['qtdLotes'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['qtdRegistros'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['qtdContas'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeArquivo['cnab'], 205, ' '),
            ]
        );
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @param array $remessas
    * @return string
    */
    public function formatarRodapeLote(array $entidade, array $filtro, array $remessas)
    {
        $rodapeLote = [
            'banco' => $this::NUM_BANCO,
            'lote' => 1,
            'registro' => 5,
            'cnab' => '',
            'qtdRegistros' => count($remessas),
            'valorDebitoCredito' => str_replace([',', '.'], '', array_sum(array_column($remessas, 'liquido'))),
            'qtdMoedas' => 0,
            'ocorrencias' => '',
        ];

        return implode(
            '',
            [
                $this->formatarValor($rodapeLote['banco'], 3, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['lote'], 4, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['registro'], 1, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['cnab'], 9, ' '),
                $this->formatarValor($rodapeLote['qtdRegistros'], 6, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['valorDebitoCredito'], 18, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['qtdMoedas'], 18, '0', STR_PAD_LEFT),
                $this->formatarValor($rodapeLote['cnab'], 171, ' '),
                $this->formatarValor($rodapeLote['ocorrencias'], 10, ' '),
            ]
        );
    }

    /**
    * @param string $input
    * @param int $tamanho
    * @param string $char
    * @param int|null $direcao
    * @return string
    */
    protected function formatarValor($input, $tamanho, $char, $direcao = STR_PAD_RIGHT)
    {
        $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
        $to   = 'AAAAEEIOOOUUCaaaaeeiooouuc';
        $input = strtr($input, $from, $to);

        return str_pad(substr($input, 0, $tamanho), $tamanho, $char, $direcao);
    }
}
