<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoCaixaRepository;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima\ExportarPagamentoCaixaAdmin;

/**
 * Class ExportarPagamentoCaixaModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class ExportarPagamentoCaixaModel extends AbstractModel
{
    const NUM_BANCO = 104;
    const NOM_BANCO = 'Caixa Economica Federal';
    const COD_TIPO_ARQUIVO_SIACC = 1;
    const COD_TIPO_ARQUIVO_SICOV = 2;

    protected $entityManager = null;
    protected $repository;

    /**
     * ExportarPagamentoCaixaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = new ExportarPagamentoCaixaRepository($this->entityManager);
    }

    /**
    * @param array $filtro
    * @return void
    */
    public function setValorFiltro(&$filtro)
    {
        $tipoFiltro = $filtro['tipoFiltro'];
        $filtro['valorFiltro'] = '';
        if (in_array($tipoFiltro, [ExportarPagamentoCaixaAdmin::TIPO_FILTRO_MATRICULA, ExportarPagamentoCaixaAdmin::TIPO_FILTRO_CGM_MATRICULA])) {
            $cgmMatriculas = !empty($filtro['cgmMatriculas']) ? array_column($filtro['cgmMatriculas'], 'codContrato') : [0];
            $filtro['valorFiltro'] = implode(',', $cgmMatriculas);
        }

        if ($tipoFiltro == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_LOTACAO) {
            $filtro['valorFiltro'] = implode(',', $filtro['lotacao']);
        }

        if ($tipoFiltro == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_LOCAL) {
            $filtro['valorFiltro'] = implode(',', $filtro['local']);
        }

        if (in_array($tipoFiltro, [ExportarPagamentoCaixaAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR, ExportarPagamentoCaixaAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_PENSIONISTA])) {
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

        if ($tipoFiltro == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_ESTAGIARIO) {
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
        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_ATIVO, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaAtivos($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_APOSENTADO, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaAposentados($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_PENSIONISTA, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaPensionistas($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_ESTAGIARIO, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaEstagiarios($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_RESCINDIDO, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaRescindidos($filtro));
        }

        if (in_array($filtro['tipoCadastro'], [ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_PENSAO_JUDICIAL, ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_TODOS])) {
            $arquivo = array_merge($arquivo, $this->repository->fetchRemessaPensaoJudicial($filtro));
        }

        return $arquivo;
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @param array $conta
    * @return string
    */
    public function formatarCabecalhoArquivo(array $entidade, array $filtro, array $conta)
    {
        $numConta = explode('-', $conta['num_conta_corrente']);

        $cabecalhoArquivo = [
            'codRegistro' => 'A',
            'codRemessa' => 1,
            'codConvenio' => $filtro['codConvenio'],
            'nomEmpresa' => $entidade['nom_cgm'],
            'banco' => $this::NUM_BANCO,
            'nomBanco' => $this::NOM_BANCO,
            'dtMovimento' => implode('', array_reverse(explode('/', $filtro['dtGeracaoArquivo']))),
            'numSequencial' => $filtro['numeroSequencialArquivo'],
            'numVersaoLayout' => 4,
            'servico' => 'FOLHA PAGAMENTO',
            'contaCompromissoAgencia' => strstr($conta['num_agencia'], '-', true),
            'contaCompromissoCodOperacao' => substr(current($numConta), 0, 3),
            'contaCompromissoNumConta' => substr(current($numConta), 3),
            'contaCompromissoDvConta' => array_pop($numConta),
            'ambienteCliente' => 'P',
            'ambienteCaixa' => 'P',
            'reservadoFuturo' => '',
            'numSequencialRegistro' => 0,
        ];

        if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SIACC) {
            return implode(
                '',
                [
                    $this->formatarValor($cabecalhoArquivo['codRegistro'], 1, ' '),
                    $this->formatarValor($cabecalhoArquivo['codRemessa'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['codConvenio'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['nomEmpresa'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['banco'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['nomBanco'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['dtMovimento'], 8, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['numSequencial'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['numVersaoLayout'], 2, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['servico'], 17, ' '),
                    $this->formatarValor($cabecalhoArquivo['contaCompromissoAgencia'], 4, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['contaCompromissoCodOperacao'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['contaCompromissoNumConta'], 8, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['contaCompromissoDvConta'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['ambienteCliente'], 1, ' '),
                    $this->formatarValor($cabecalhoArquivo['ambienteCaixa'], 1, ' '),
                    $this->formatarValor($cabecalhoArquivo['reservadoFuturo'], 27, ' '),
                    $this->formatarValor($cabecalhoArquivo['numSequencialRegistro'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['reservadoFuturo'], 1, ' '),
                ]
            );
        }

        if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SICOV) {
            return implode(
                '',
                [
                    $this->formatarValor($cabecalhoArquivo['codRegistro'], 1, ' '),
                    $this->formatarValor($cabecalhoArquivo['codRemessa'], 1, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['codConvenio'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['nomEmpresa'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['banco'], 3, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['nomBanco'], 20, ' '),
                    $this->formatarValor($cabecalhoArquivo['dtMovimento'], 8, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['numSequencial'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor($cabecalhoArquivo['numVersaoLayout'], 2, ' '),
                    $this->formatarValor($cabecalhoArquivo['servico'], 17, ' '),
                    $this->formatarValor($cabecalhoArquivo['reservadoFuturo'], 52, ' '),
                ]
            );
        }
    }

    /**
    * @param array $remessas
    * @param array $filtro
    * @param array $conta
    * @return string
    */
    public function formatarRemessas(array $remessas, array $filtro, $conta)
    {
        $detalheRemessas = [
            'codRegistro' => 'E',
            'dtVencimento' => implode('', array_reverse(explode('/', $filtro['dtPagamento']))),
            'codMoeda' => 3,
            'reservadoFuturo' => '',
            'tipoMovimento' => $filtro['tipoMovimento'],
        ];

        $registros = [];
        foreach ($remessas as $i => $remessa) {
            $clienteEmpresa = !empty($remessa['registro']) ? $remessa['registro'] : '';
            if ($remessa['tipo'] == ExportarPagamentoCaixaAdmin::TIPO_CADASTRO_ESTAGIARIO) {
                $clienteEmpresa = $remessa['numero_estagio'];
            }

            $numConta = explode('-', $remessa['nr_conta']);

            if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SIACC) {
                $registros[] = implode(
                    '',
                    [
                        $this->formatarValor($detalheRemessas['codRegistro'], 1, ' '),
                        $this->formatarValor($clienteEmpresa, 25, ' '),
                        $this->formatarValor(strstr($remessa['num_agencia'], '-', true), 4, '0', STR_PAD_LEFT),
                        $this->formatarValor(substr(current($numConta), 0, 3), 3, ' '),
                        $this->formatarValor(substr(current($numConta), 3), 8, '0', STR_PAD_LEFT),
                        $this->formatarValor(array_pop($numConta), 1, ' '),
                        $this->formatarValor($detalheRemessas['reservadoFuturo'], 2, ' '),
                        $this->formatarValor($detalheRemessas['dtVencimento'], 8, '0', STR_PAD_LEFT),
                        $this->formatarValor(str_replace([',', '.'], '', $remessa['liquido']), 15, '0', STR_PAD_LEFT),
                        $this->formatarValor($detalheRemessas['codMoeda'], 2, '0', STR_PAD_LEFT),
                        $this->formatarValor($remessa['nom_cgm'], 60, ' '),
                        $this->formatarValor($i, 6, '0', STR_PAD_LEFT),
                        $this->formatarValor($detalheRemessas['reservadoFuturo'], 8, ' '),
                        $this->formatarValor($i, 6, '0', STR_PAD_LEFT),
                        $this->formatarValor($detalheRemessas['tipoMovimento'], 1, '0', STR_PAD_LEFT),
                    ]
                );
            }

            if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SICOV) {
                $detalheRemessas['tipoMovimento'] = 2;

                $registros[] = implode(
                    '',
                    [
                        $this->formatarValor($detalheRemessas['codRegistro'], 1, ' '),
                        $this->formatarValor($clienteEmpresa, 25, ' '),
                        $this->formatarValor(strstr($remessa['num_agencia'], '-', true), 4, '0', STR_PAD_LEFT),
                        $this->formatarValor(substr(current($numConta), 0, 3), 3, ' '),
                        $this->formatarValor(substr(current($numConta), 3), 8, '0', STR_PAD_LEFT),
                        $this->formatarValor(array_pop($numConta), 1, ' '),
                        $this->formatarValor($detalheRemessas['reservadoFuturo'], 2, ' '),
                        $this->formatarValor($detalheRemessas['dtVencimento'], 8, '0', STR_PAD_LEFT),
                        $this->formatarValor(str_replace([',', '.'], '', $remessa['liquido']), 15, '0', STR_PAD_LEFT),
                        $this->formatarValor($detalheRemessas['codMoeda'], 2, '0', STR_PAD_LEFT),
                        $this->formatarValor($remessa['nom_cgm'], 60, ' '),
                        $this->formatarValor($detalheRemessas['reservadoFuturo'], 8, ' '),
                        $this->formatarValor($detalheRemessas['tipoMovimento'], 1, '0', STR_PAD_LEFT),
                    ]
                );
            }
        }

        return implode(PHP_EOL, $registros);
    }

    /**
    * @param array $entidade
    * @param array $filtro
    * @param array $remessas
    * @param array $conta
    * @return string
    */
    public function formatarRodapeArquivo(array $entidade, array $filtro, array $remessas, $conta)
    {
        $rodapeArquivo = [
            'codRegistro' => 'Z',
            'qtdRegistros' => count($remessas),
            'valorDebitoCredito' => str_replace([',', '.'], '', array_sum(array_column($remessas, 'liquido'))),
            'reservadoFuturo' => '',
        ];

        if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SIACC) {
            return implode(
                '',
                [
                    $this->formatarValor($rodapeArquivo['codRegistro'], 1, ' '),
                    $this->formatarValor($rodapeArquivo['qtdRegistros'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor($rodapeArquivo['valorDebitoCredito'], 17, '0', STR_PAD_LEFT),
                    $this->formatarValor($rodapeArquivo['qtdRegistros'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor($rodapeArquivo['reservadoFuturo'], 1, ' '),
                ]
            );
        }

        if ($conta['cod_tipo'] == $this::COD_TIPO_ARQUIVO_SICOV) {
            return implode(
                '',
                [
                    $this->formatarValor($rodapeArquivo['codRegistro'], 1, ' '),
                    $this->formatarValor($rodapeArquivo['qtdRegistros'], 6, '0', STR_PAD_LEFT),
                    $this->formatarValor('', 17, '0', STR_PAD_LEFT),
                    $this->formatarValor($rodapeArquivo['valorDebitoCredito'], 17, '0', STR_PAD_LEFT),
                    $this->formatarValor($rodapeArquivo['reservadoFuturo'], 109, ' '),
                ]
            );
        }
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
