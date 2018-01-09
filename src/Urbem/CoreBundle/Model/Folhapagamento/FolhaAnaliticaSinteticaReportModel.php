<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\ReportModel;
use Urbem\RecursosHumanosBundle\Helper\Constants\Folhapagamento\FolhaAnaliticaSinteticaReport as FolhaAnaliticaSinteticaReportConstants;

/**
 * Class FolhaAnaliticaSinteticaReportModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class FolhaAnaliticaSinteticaReportModel extends AbstractModel
{
    /**
     * @var EntityManager|null
     */
    protected $entityManager = null;

    /**
     * FolhaAnaliticaSinteticaReportModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function consultaUltimoPeriodoMovimentacao()
    {
        $periodoMovimentacao = new PeriodoMovimentacaoModel($this->entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        return reset($periodoUnico);
    }

    /**
     * Retorna um array com eventos atrelados a uma base
     * @param $formData
     * @return array
     */
    public function addTipoFolha($formData)
    {
        $tipoFolha = [];
        $stFolha = $this->entityManager->getRepository(ConfiguracaoEvento::class)
        ->find($formData['inCodConfiguracao']);

        $tipoFolha['stFolha'] = trim($stFolha->getDescricao());
        $tipoFolha['dtCompetencia'] = str_pad($formData['inCodMes'], 2, "0", STR_PAD_LEFT) . "/" . $formData['inAno'];

        $periodoUnico = $this->consultaUltimoPeriodoMovimentacao();

        $tipoFolha['rsPeriodoMovimentaco'] = $periodoUnico->dt_inicial . " até " . $periodoUnico->dt_final;

        return $tipoFolha;
    }

    /**
     * Retorna o tipo de ordenaçao que deve ser realizada, dependendo do tipo de filtro
     * @param array $formData
     * @return string
     */
    public function getOrdenacao($formData)
    {
        $stOrdenacao = "";
        switch ($formData['stTipoFiltro']) {
            case 'cgm_contrato':
                $stOrdenacao .= ($formData['stOrdenacao'] == 'alfabetica') ? 'nom_cgm' : 'registro';
                break;
            case 'atributo':
                if (isset($formData['boAtributoDinamico']) && $formData['boAtributoDinamico'] == '1') {
                    $stOrdenacao .= 'valor_label,';
                }
                $stOrdenacao .= ($formData['stOrdenacao'] == 'alfabetica' ) ? 'nom_cgm' : 'registro';
        }

        return $stOrdenacao;
    }

    /**
     * Retorna o filtro de acordo com o tipo de filtro selecionado no formulario
     * @param array $formData
     * @return array
     */
    public function getFiltro($formData)
    {
        $arFiltro = [];
        $arFiltro['inCodAtributo'] = 0;
        $arFiltro['valor'] = '';
        $arFiltro['filtro'] = '';

        switch ($formData['stTipoFiltro']) {
            case 'cgm_contrato':
                $arFiltro['filtro'] = " AND contrato.cod_contrato IN (" . implode(",", $formData['inContrato']) . ")";
                break;
            case 'atributo':
                $arFiltro['inCodAtributo'] = $formData['inCodAtributo'];
                $arFiltro['valor'] = "'" . $formData[$formData['inCodAtributo'] . "_atributoDinamico"] . "'";
                $arFiltro['filtro'] = " AND cod_atributo = " . $formData['inCodAtributo'] . " AND valor = '" . $formData[$formData['inCodAtributo'] . "_atributoDinamico"] . "'";
                break;
        }

        return $arFiltro;
    }

    /**
     * @param $formData
     * @param $stExercicio
     * @param string $stEntidade
     * @return array
     */
    public function folhaAnaliticaResumida($formData, $stExercicio, $stEntidade = '')
    {
        $periodoUnico = $this->consultaUltimoPeriodoMovimentacao();

        $arFiltro = $this->getFiltro($formData);

        $inCodConfiguracao = $formData['inCodConfiguracao'];
        $inCodComplementar = 0;
        if (array_key_exists('boFiltrarFolhaComplementar', $formData)) {
            $inCodConfiguracao = 0;
            $inCodComplementar = ($formData['inCodComplementar'] === '') ? 0 : $formData['inCodComplementar'];
        }

        $results = $this->entityManager->getRepository(Contrato::class)
        ->folhaAnaliticaResumida(
            $inCodConfiguracao,
            $periodoUnico->cod_periodo_movimentacao,
            $inCodComplementar,
            $arFiltro['filtro'],
            $this->getOrdenacao($formData),
            $arFiltro['inCodAtributo'],
            $arFiltro['valor'],
            $stEntidade,
            $stExercicio
        );

        $arDados = [];
        $arDados['resumoGeral'] = [];
        $arDados['resumoGeral']['provento'] = [];
        $arDados['resumoGeral']['desconto'] = [];
        $arDados['resumoGeral']['base'] = [];
        $arDados['contratos'] = [];

        foreach ($results as $result) {
            $situacao = $this->entityManager->getRepository(Contrato::class)
            ->recuperarSituacaoDoContratoLiteral(
                $result['cod_contrato'],
                $periodoUnico->cod_periodo_movimentacao
            );

            $arDados['contratos'][$result['cod_contrato']]['cabecalho'] = [
                'registro' => $result['registro'],
                'nom_cgm' => $result['nom_cgm'],
                'hr_mensais' => $result['hr_mensais'],
                'descricao_regime_funcao' => $result['descricao_regime_funcao'],
                'descricao_funcao' => $result['descricao_funcao'],
                'dt_admissao' => $result['dt_admissao'],
                'orgao' => $result['orgao'],
                'descricao_lotacao' => $result['descricao_lotacao'],
                'descricao_local' => $result['descricao_local'],
                'descricao_banco' => $result['descricao_banco'],
                'descricao_padrao' => $result['descricao_padrao'],
                'situacao' => $situacao->situacao
            ];

            // Provento
            if ($result['codigop'] != '') {
                $arDados['contratos'][$result['cod_contrato']]['provento'][] = [
                    'codigop' => $result['codigop'],
                    'descricaop' => $result['descricaop'],
                    'quantidadep' => $result['quantidadep'],
                    'valorp' => $result['valorp'],
                ];

                $arDados['resumoGeral']['provento'][] = [
                    'codigop' => $result['codigop'],
                    'descricaop' => $result['descricaop'],
                    'quantidadep' => $result['quantidadep'],
                    'valorp' => $result['valorp'],
                ];
            }

            // Desconto
            if ($result['codigod'] != '') {
                $arDados['contratos'][$result['cod_contrato']]['desconto'][] = [
                    'codigod' => $result['codigod'],
                    'descricaod' => $result['descricaod'],
                    'quantidaded' => $result['quantidaded'],
                    'valord' => $result['valord'],
                ];

                $arDados['resumoGeral']['desconto'][] = [
                    'codigod' => $result['codigod'],
                    'descricaod' => $result['descricaod'],
                    'quantidaded' => $result['quantidaded'],
                    'valord' => $result['valord'],
                ];
            }

            // Base
            if ($result['codigob'] != '') {
                $arDados['contratos'][$result['cod_contrato']]['base'][] = [
                    'codigob' => $result['codigob'],
                    'descricaob' => $result['descricaob'],
                    'quantidadeb' => $result['quantidadeb'],
                    'valorb' => $result['valorb'],
                ];

                $arDados['resumoGeral']['base'][] = [
                    'codigob' => $result['codigob'],
                    'descricaob' => $result['descricaob'],
                    'quantidadeb' => $result['quantidadeb'],
                    'valorb' => $result['valorb'],
                ];
            }
        }

        $resumoGeralProvento = [];

        foreach ($arDados['resumoGeral']['provento'] as $item) {
            if (! array_key_exists($item['codigop'], $resumoGeralProvento)) {
                $resumoGeralProvento[$item['codigop']] = [
                    'codigop' => $item['codigop'],
                    'descricaop' => $item['descricaop'],
                    'valorp' => $item['valorp'],
                    'ocorrenciap' => 1
                ];
            } else {
                $resumoGeralProvento[$item['codigop']]['valorp'] = $resumoGeralProvento[$item['codigop']]['valorp'] + $item['valorp'];
                $resumoGeralProvento[$item['codigop']]['ocorrenciap'] = $resumoGeralProvento[$item['codigop']]['ocorrenciap'] + 1;
            }
        }

        $resumoGeralDesconto = [];
        foreach ($arDados['resumoGeral']['desconto'] as $item) {
            if (! array_key_exists($item['codigod'], $resumoGeralDesconto)) {
                $resumoGeralDesconto[$item['codigod']] = [
                    'codigod' => $item['codigod'],
                    'descricaod' => $item['descricaod'],
                    'valord' => $item['valord'],
                    'ocorrenciad' => 1
                ];
            } else {
                $resumoGeralDesconto[$item['codigod']]['valord'] = $resumoGeralDesconto[$item['codigod']]['valord'] + $item['valord'];
                $resumoGeralDesconto[$item['codigod']]['ocorrenciad'] = $resumoGeralDesconto[$item['codigod']]['ocorrenciad'] + 1;
            }
        }

        $resumoGeralBase = [];
        foreach ($arDados['resumoGeral']['base'] as $item) {
            if (! array_key_exists($item['codigob'], $resumoGeralBase)) {
                $resumoGeralBase[$item['codigob']] = [
                    'codigob' => $item['codigob'],
                    'descricaob' => $item['descricaob'],
                    'valorb' => $item['valorb'],
                    'ocorrenciab' => 1
                ];
            } else {
                $resumoGeralBase[$item['codigob']]['valorb'] = $resumoGeralBase[$item['codigob']]['valorb'] + $item['valorb'];
                $resumoGeralBase[$item['codigob']]['ocorrenciab'] = $resumoGeralBase[$item['codigob']]['ocorrenciab'] + 1;
            }
        }

        $arDados['resumoGeralProvento'] = $resumoGeralProvento;
        $arDados['resumoGeralDesconto'] = $resumoGeralDesconto;
        $arDados['resumoGeralBase'] = $resumoGeralBase;

        return $arDados;
    }

    /**
     * Retorna dados da folhaAnalitica
     * @param array $formData
     * @param string $stExercicio
     * @return array
     */
    public function folhaAnalitica($formData, $stExercicio)
    {
        $periodoUnico = $this->consultaUltimoPeriodoMovimentacao();

        $arFiltro = $this->getFiltro($formData);

        $inCodConfiguracao = $formData['inCodConfiguracao'];
        $inCodComplementar = 0;
        if (array_key_exists('boFiltrarFolhaComplementar', $formData)) {
            $inCodConfiguracao = 0;
            $inCodComplementar = ($formData['inCodComplementar'] === '') ? 0 : $formData['inCodComplementar'];
        }

        $results = $this->entityManager->getRepository(Contrato::class)
        ->folhaAnalitica(
            $inCodConfiguracao,
            $periodoUnico->cod_periodo_movimentacao,
            $inCodComplementar,
            $arFiltro['filtro'],
            $this->getOrdenacao($formData),
            $stExercicio,
            $arFiltro['inCodAtributo'],
            $arFiltro['valor'],
            ''
        );

        $folhaAnalitica = [];
        $totalGeralDesconto = [];
        $totalGeralProvento = [];
        $totalGeralInformativo = [];
        $totalGeralBase = [];
        foreach ($results as $result) {
            $eventosCaluladosPD = $this->entityManager->getRepository(Contrato::class)
            ->eventosCalculadosFolhaAnalitica(
                $inCodConfiguracao,
                $result['cod_contrato'],
                $periodoUnico->cod_periodo_movimentacao,
                $inCodComplementar,
                'codigo',
                'P',
                'D',
                ''
            );

            $folhaAnalitica['folha'][$result['cod_contrato']]['cabecalho'] = $result;

            foreach ($eventosCaluladosPD as $eventoCaluladoPD) {
                // Desconto
                if ($eventoCaluladoPD['codigod'] != '') {
                    $folhaAnalitica['folha'][$result['cod_contrato']]['desconto'][] = [
                        'codigod' => $eventoCaluladoPD['codigod'],
                        'descricaod' => $eventoCaluladoPD['descricaod'],
                        'quantidaded' => $eventoCaluladoPD['quantidaded'],
                        'valord' => $eventoCaluladoPD['valord']
                    ];

                    if (! array_key_exists($eventoCaluladoPD['codigod'], $totalGeralDesconto)) {
                        $totalGeralDesconto[$eventoCaluladoPD['codigod']] = [
                            'codigod' => $eventoCaluladoPD['codigod'],
                            'descricaod' => $eventoCaluladoPD['descricaod'],
                            'quantidaded' => $eventoCaluladoPD['quantidaded'],
                            'valord' => $eventoCaluladoPD['valord']
                        ];
                    } else {
                        $totalGeralDesconto[$eventoCaluladoPD['codigod']]['quantidaded'] = $totalGeralDesconto[$eventoCaluladoPD['codigod']]['quantidaded'] + $eventoCaluladoPD['quantidaded'];
                        $totalGeralDesconto[$eventoCaluladoPD['codigod']]['valord'] = $totalGeralDesconto[$eventoCaluladoPD['codigod']]['valord'] + $eventoCaluladoPD['valord'];
                    }
                }

                // Provento
                if ($eventoCaluladoPD['codigoe'] != '') {
                    $folhaAnalitica['folha'][$result['cod_contrato']]['provento'][] = [
                        'codigoe' => $eventoCaluladoPD['codigoe'],
                        'descricaoe' => $eventoCaluladoPD['descricaoe'],
                        'quantidadee' => $eventoCaluladoPD['quantidadee'],
                        'valore' => $eventoCaluladoPD['valore']
                    ];

                    if (! array_key_exists($eventoCaluladoPD['codigoe'], $totalGeralProvento)) {
                        $totalGeralProvento[$eventoCaluladoPD['codigoe']] = [
                            'codigoe' => $eventoCaluladoPD['codigoe'],
                            'descricaoe' => $eventoCaluladoPD['descricaoe'],
                            'quantidadee' => $eventoCaluladoPD['quantidadee'],
                            'valore' => $eventoCaluladoPD['valore']
                        ];
                    } else {
                        $totalGeralProvento[$eventoCaluladoPD['codigoe']]['quantidadee'] = $totalGeralProvento[$eventoCaluladoPD['codigoe']]['quantidadee'] + $eventoCaluladoPD['quantidadee'];
                        $totalGeralProvento[$eventoCaluladoPD['codigoe']]['valore'] = $totalGeralProvento[$eventoCaluladoPD['codigoe']]['valore'] + $eventoCaluladoPD['valore'];
                    }
                }
            }

            $eventosCaluladosBI = $this->entityManager->getRepository(Contrato::class)
            ->eventosCalculadosFolhaAnalitica(
                $inCodConfiguracao,
                $result['cod_contrato'],
                $periodoUnico->cod_periodo_movimentacao,
                $inCodComplementar,
                'codigo',
                'B',
                'I',
                ''
            );

            foreach ($eventosCaluladosBI as $eventoCaluladoBI) {
                // Eventos Informativos
                if ($eventoCaluladoBI['codigod'] != '') {
                    $folhaAnalitica['folha'][$result['cod_contrato']]['informativo'][] = [
                        'codigod' => $eventoCaluladoBI['codigod'],
                        'descricaod' => $eventoCaluladoBI['descricaod'],
                        'quantidaded' => $eventoCaluladoBI['quantidaded'],
                        'valord' => $eventoCaluladoBI['valord']
                    ];

                    if (! array_key_exists($eventoCaluladoBI['codigod'], $totalGeralInformativo)) {
                        $totalGeralInformativo[$eventoCaluladoBI['codigod']] = [
                            'codigod' => $eventoCaluladoBI['codigod'],
                            'descricaod' => $eventoCaluladoBI['descricaod'],
                            'quantidaded' => $eventoCaluladoBI['quantidaded'],
                            'valord' => $eventoCaluladoBI['valord']
                        ];
                    } else {
                        $totalGeralInformativo[$eventoCaluladoBI['codigod']]['quantidaded'] = $totalGeralInformativo[$eventoCaluladoBI['codigod']]['quantidaded'] + $eventoCaluladoBI['quantidaded'];
                        $totalGeralInformativo[$eventoCaluladoBI['codigod']]['valord'] = $totalGeralInformativo[$eventoCaluladoBI['codigod']]['valord'] + $eventoCaluladoBI['valord'];
                    }
                }

                // Eventos de Base
                if ($eventoCaluladoBI['codigoe'] != '') {
                    $folhaAnalitica['folha'][$result['cod_contrato']]['base'][] = [
                        'codigoe' => $eventoCaluladoBI['codigoe'],
                        'descricaoe' => $eventoCaluladoBI['descricaoe'],
                        'quantidadee' => $eventoCaluladoBI['quantidadee'],
                        'valore' => $eventoCaluladoBI['valore']
                    ];

                    if (! array_key_exists($eventoCaluladoBI['codigoe'], $totalGeralBase)) {
                        $totalGeralBase[$eventoCaluladoBI['codigoe']] = [
                            'codigoe' => $eventoCaluladoBI['codigoe'],
                            'descricaoe' => $eventoCaluladoBI['descricaoe'],
                            'quantidadee' => $eventoCaluladoBI['quantidadee'],
                            'valore' => $eventoCaluladoBI['valore']
                        ];
                    } else {
                        $totalGeralBase[$eventoCaluladoBI['codigoe']]['quantidadee'] = $totalGeralBase[$eventoCaluladoBI['codigoe']]['quantidadee'] + $eventoCaluladoBI['quantidadee'];
                        $totalGeralBase[$eventoCaluladoBI['codigoe']]['valore'] = $totalGeralBase[$eventoCaluladoBI['codigoe']]['valore'] + $eventoCaluladoBI['valore'];
                    }
                }
            }
        }

        $folhaAnalitica['totalGeralProvento'] = $totalGeralProvento;
        $folhaAnalitica['totalGeralDesconto'] = $totalGeralDesconto;
        $folhaAnalitica['totalGeralInformativo'] = $totalGeralInformativo;
        $folhaAnalitica['totalGeralBase'] = $totalGeralBase;

        return $folhaAnalitica;
    }

    /**
     * Retorna dados da folha sintetica
     * @param array $formData
     * @param string $stExercicio
     * @return mixed
     */
    public function folhaSintetica($formData, $stExercicio)
    {
        $periodoUnico = $this->consultaUltimoPeriodoMovimentacao();

        $arFiltro = $this->getFiltro($formData);

        $inCodConfiguracao = $formData['inCodConfiguracao'];
        $inCodComplementar = 0;
        if (array_key_exists('boFiltrarFolhaComplementar', $formData)) {
            $inCodConfiguracao = 0;
            $inCodComplementar = ($formData['inCodComplementar'] === '') ? 0 : $formData['inCodComplementar'];
        }

        $results = $this->entityManager->getRepository(Contrato::class)
        ->folhaSintetica(
            $inCodConfiguracao,
            $periodoUnico->cod_periodo_movimentacao,
            $inCodComplementar,
            $arFiltro['filtro'],
            $this->getOrdenacao($formData),
            $stExercicio,
            $arFiltro['inCodAtributo'],
            $arFiltro['valor'],
            ''
        );

        return $results;
    }

    /**
     * Verifica qual template deve ser retornado (Resumida, Analitica ou Sintetica)
     * @param array $formData
     * @param string $exercicio
     * @param Usuario $currentUser
     * @return array
     */
    public function consultaFolha($formData, $exercicio, Usuario $currentUser)
    {
        $arConfiguracao = (new ReportModel($this->entityManager))
        ->recuperaCabecalho($exercicio, FolhaAnaliticaSinteticaReportConstants::CODACAO);

        $tipoFolha = $this->addTipoFolha($formData);

        switch ($formData['stFolha']) {
            case 'analítica_resumida':
                $folhaAnaliticaResumida = $this->folhaAnaliticaResumida($formData, $exercicio);

                return [
                    'view' => 'RecursosHumanosBundle:FolhaPagamento/Relatorios:folhaAnaliticaResumida.html.twig',
                    'parameters' => [
                        'arConfiguracao' => $arConfiguracao,
                        'dtEmissao' => (new \DateTime('now')),
                        'usuario' => $currentUser,
                        'versao' => '3.0.0',
                        'tipoFolha' => $tipoFolha,
                        'folha' => $folhaAnaliticaResumida
                    ]
                ];
                break;
            case 'analítica':
                $folhaAnalitica = $this->folhaAnalitica($formData, $exercicio);

                return [
                    'view' => 'RecursosHumanosBundle:FolhaPagamento/Relatorios:folhaAnalitica.html.twig',
                    'parameters' => [
                        'arConfiguracao' => $arConfiguracao,
                        'dtEmissao' => (new \DateTime('now')),
                        'usuario' => $currentUser,
                        'versao' => '3.0.0',
                        'tipoFolha' => $tipoFolha,
                        'folha' => $folhaAnalitica
                    ]
                ];
                break;
            case 'sintética':
                $folhaSintetica = $this->folhaSintetica($formData, $exercicio);

                return [
                    'view' => 'RecursosHumanosBundle:FolhaPagamento/Relatorios:folhaSintetica.html.twig',
                    'parameters' => [
                        'arConfiguracao' => $arConfiguracao,
                        'dtEmissao' => (new \DateTime('now')),
                        'usuario' => $currentUser,
                        'versao' => '3.0.0',
                        'tipoFolha' => $tipoFolha,
                        'folha' => $folhaSintetica
                    ]
                ];
                break;
        }
    }
}
