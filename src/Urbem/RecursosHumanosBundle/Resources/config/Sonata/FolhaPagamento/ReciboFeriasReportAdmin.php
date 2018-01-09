<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin as AbstractAdmin;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class ReciboFeriasReportAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_recibo_ferias';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/recibo-ferias';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/reciboDeFerias.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/relatorioReciboFerias.js'
    ];

    const COD_ACAO ='1728';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $em = $this->getEntityManager();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $filter = $this->getRequest()->query->get('filter');

        $mes = '';
        if ($filter) {
            if (array_key_exists('value', $filter['mes'])) {
                $mes = $filter['mes']['value'];
            }
        }

        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $meses = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());

        $formMapper
            ->with("label.relatorios.reciboFerias.titulo")
            ->add(
                'ano',
                'number',
                [
                    'label' => 'label.ferias.ano',
                    'mapped' => false,
                    'attr' => [
                        'value' => $this->getExercicio(),
                        'class' => 'numero '
                    ],
                ]
            )
            ->add(
                'mes',
                'choice',
                [
                    'label' => 'label.ferias.mes',
                    'mapped' => false,
                    'placeholder' => 'label.selecione',
                    'choices' => $meses,
                    'data' => end($meses),
                    'attr' => [
                        'data-mes' => $mes,
                    ],
                ]
            )
            ->end();
            parent::configureFields($formMapper, GeneralFilterAdmin::RECURSOSHUMANOS_FOLHA_RECIBOFERIAS);
            $formMapper
            ->end()
                ->with("label.lotacao")
                ->add(
                    'lotacaoChoice',
                    'choice',
                    [
                        'mapped' => false,
                        'choices' => [
                            'label.relatorios.filtro.ordenacao.choices.alfabetica' => 'A',
                            'label.relatorios.filtro.ordenacao.choices.numerica' => 'N',
                        ],
                        'label' => 'label.relatorios.reciboFerias.filtro.lotacao',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'lotacaoCheck',
                    'choice',
                    [
                        'label' => 'label.lotacao',
                        'choices' => [
                            'sim' => true,
                            'nao' => false
                        ],
                        'expanded' => true,
                        'mapped' => false,
                        'label_attr' => [
                            'class' => 'checkbox-sonata '
                        ],
                        'attr' => ['class' => 'checkbox-sonata'],
                        'data' => false,
                    ]
                )
                ->end()

                ->with("label.local")
                ->add(
                    'localChoice',
                    'choice',
                    [
                        'mapped' => false,
                        'choices' => [
                            'label.relatorios.filtro.ordenacao.choices.alfabetica' => 'A',
                            'label.relatorios.filtro.ordenacao.choices.numerica' => 'N',
                        ],
                        'label' => 'label.relatorios.reciboFerias.filtro.local',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'localCheck',
                    'choice',
                    [
                        'label' => 'label.local',
                        'choices' => [
                            'sim' => true,
                            'nao' => false
                        ],
                        'expanded' => true,
                        'mapped' => false,
                        'label_attr' => [
                            'class' => 'checkbox-sonata '
                        ],
                        'attr' => ['class' => 'checkbox-sonata'],
                        'data' => false,
                    ]
                )
                ->end()

                ->with("label.cgm")
                ->add(
                    'cgmChoice',
                    'choice',
                    [
                        'mapped' => false,
                        'choices' => [
                            'label.relatorios.filtro.ordenacao.choices.alfabetica' => 'A',
                            'label.relatorios.filtro.ordenacao.choices.numerica' => 'N',
                        ],
                        'label' => 'label.relatorios.reciboFerias.filtro.cgm',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'cgmCheck',
                    'choice',
                    [
                        'label' => 'label.cgm',
                        'choices' => [
                            'sim' => true,
                            'nao' => false
                        ],
                        'expanded' => true,
                        'mapped' => false,
                        'label_attr' => [
                            'class' => 'checkbox-sonata '
                        ],
                        'attr' => ['class' => 'checkbox-sonata'],
                        'data' => false,
                    ]
                )
                ->end()
        ;
    }

    /**
     * @return array
     */
    public function getMesCompetencia()
    {
        $entityManager = $this->getEntityManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno <= (int) $this->getExercicio()) {
                if ($mes->getCodMes() >= $inCodMes) {
                    $options[trim($mes->getDescricao())] = $mes->getCodMes();
                }
            }
        }

        return $options;
    }

    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fileName = $this->parseNameFile("reciboferias");

        $stAno = (int) $this->getForm()->get('ano')->getData();
        $stMes = (int) $this->getForm()->get('mes')->getData();

        $boOrLotacao = $this->getForm()->get('lotacaoCheck')->getData();
        $boOrLocal = $this->getForm()->get('localCheck')->getData();
        $boOrCGM = $this->getForm()->get('cgmCheck')->getData();

        $strLotacao = $this->getForm()->get('lotacaoChoice')->getData();
        $strLocal = $this->getForm()->get('localChoice')->getData();
        $strCGM = $this->getForm()->get('cgmChoice')->getData();
        $tipo = $this->getForm()->get('tipo')->getData();
        $stValor = '';

        switch ($tipo) {
            case "lotacao":
                $lotacoes = $this->getForm()->get('lotacao')->getData();

                foreach ($lotacoes as $lotacao) {
                    $stValor .= $lotacao.",";
                }

                $stValor = substr($stValor, 0, strlen($stValor)-1);
                break;
            case "local":
                $locais = $this->getForm()->get('local')->getData();

                foreach ($locais as $local) {
                    $stValor .= $local->getCodLocal().",";
                }

                $stValor = substr($stValor, 0, strlen($stValor)-1);
                break;
            case "contrato":
            case "cgm_contrato":
                $codContratos = $this->getForm()->get('codContrato')->getData();

                foreach ($codContratos as $codContrato) {
                    $stValor .= $codContrato->getCodContrato().",";
                }

                $stValor = substr($stValor, 0, strlen($stValor)-1);

                break;
        }

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidadePrefeitura = $configuracaoModel->getConfiguracao(
            'cod_entidade_prefeitura',
            Modulo::MODULO_ORCAMENTO,
            true,
            $this->getExercicio()
        );

        if (!is_null($stMes) && $stMes < 10) {
            $stMes = "0".$stMes;
        }

        // Data final da competência
        $ultimo_dia = date("t", mktime(0, 0, 0, $stMes, '01', $stAno));

        $dtFinal = $ultimo_dia.'/'.$stMes.'/'.$stAno;

        // Recupera o periodo de movimentação do mes e ano da competência
        $codPeriodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)->findOneBy(array('dtFinal' => (new \DateTime($stAno.'-'.$stMes.'-'.$ultimo_dia))));
        $codPeriodoMovimentacao = $codPeriodoMovimentacao ? $codPeriodoMovimentacao->getCodPeriodoMovimentacao() : '';

        $params = [
            "term_user" => $this->getCurrentUser()->getUserName(),
            "cod_acao" => self::COD_ACAO,
            "exercicio" => $this->getExercicio(),
            "inCodGestao" => Gestao::GESTAO_RECURSOS_HUMANOS,
            "inCodModulo" => Modulo::MODULO_FOLHAPAGAMENTO,
            "inCodRelatorio" => Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_RECIBO_FERIAS,
            "entidade" => (string) $codEntidadePrefeitura,
            "stEntidade" => "" ,
            "dtFinalCompetencia" => $dtFinal,
            "inCodPeriodoMovimentacao" => (string) $codPeriodoMovimentacao,
            "stAnoCompetencia" => $stAno ? (string) $stAno : '',
            "stMesCompetencia" => $stMes ? (string) $stMes : '',
            "boOrdenacaoLotacao" =>  $boOrLotacao ? "true" : "false",
            "boOrdenacaoLocal" => $boOrLocal ? "true" : "false",
            "boOrdenacaoCGM" => $boOrCGM ? "true" : "false",
            "stOrdenacaoLotacao" => $strLotacao ,
            "stOrdenacaoLocal" => $strLocal ,
            "stOrdenacaoCGM" => $strCGM ,
            "stTipoFiltro" => $tipo ,
            "stValor" => $stValor ,
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
}
