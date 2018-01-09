<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContraChequeReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_contra_cheque';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/contra-cheque';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/contraCheque.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    protected $includeJs = array('/recursoshumanos/javascripts/folhapagamento/contraCheque.js');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consulta_folha_complementar', 'consulta-folha-complementar');
        $collection->clearExcept(array('create', 'consulta_folha_complementar'));
    }

    /**
     * @param null|string $dtFinal
     *
     * @return null|array
     */
    public function consultaUltimoPeriodoMovimentacao($dtFinal = null)
    {
        $entityManager = $this->getDoctrine();

        $periodoMovimentacao = null;

        if ($dtFinal) {
            $periodoMovimentacao = $entityManager->getRepository(PeriodoMovimentacao::class)
                ->consultaPeriodoMovimentacaoCompetencia($dtFinal);
        }

        if (!$periodoMovimentacao) {
            return $entityManager->getRepository(PeriodoMovimentacao::class)
                ->montaRecuperaUltimaMovimentacao();
        }

        return $periodoMovimentacao;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($entityManager);

        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($entityManager);
        /** @var OrgaoModel $orgaoModel */
        $orgaoModel = new OrgaoModel($entityManager);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Alfabética' => 'alfabetica',
                'Numérica' => 'numerica',
            ],
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'mapped' => false,
            'data' => 'alfabetica',
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.ordenacao'
        ];

        $fieldOptions['mensagem'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.mensagem',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['boDuplicar'] = [
            'label' => 'Emitir Cópia',
            'mapped' => false,
            'choices' => [
                'Sim' => 'sim',
                'Não' => 'nao',
            ],
            'data' => 'nao',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['boMensagemAniversariante'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.mensagemAniversariante',
            'mapped' => false,
            'choices' => [
                'Sim' => 'sim',
                'Não' => 'nao',
            ],
            'data' => 'nao',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['inContratoReemissao'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.matriculaReemissao',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => false,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['stSituacao'] = [
            'choices' => [
                'Ativos' => 'ativos',
                'Rescindidos' => 'rescindidos',
                'Aposentados' => 'aposentados',
                'Pensionistas' => 'pensionistas',
                'Todos' => 'todos'
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.stSituacao',
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'data' => 'ativos',
        ];

        $fieldOptions['stConfiguracao'] = [
            'choices' => [
                'Complementar' => 0,
                'Salário' => 1,
                'Férias' => 2,
                '13 Salário' => 3,
                'Rescisão' => 4
            ],
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.stConfiguracao',
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'data' => 1,
        ];

        $fieldOptions['ano'] = [
            'label' => 'label.ferias.ano',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        ];
        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());
        $lastMes = (is_array($mes)) ? end($mes) : $mes;

        $fieldOptions['mes'] = [
            'label' => 'label.ferias.mes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio()),
            'choice_attr' => function ($competenciaMeses, $key, $index) use ($lastMes) {
                if ($index == $lastMes) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            },
            'attr' => ['class' => 'select2-parameters'],
        ];

        $fieldOptions['inCodComplementar'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.inCodComplementar',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => [],
            'attr' => [
                'class' => 'select2-parameters',
                'disabled' => 'disabled'
            ],
        ];

        $fieldOptions['stDesdobramento'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.contraCheque.stDesdobramento',
            'mapped' => false,
            'choices' => [
                "13 Salário" => "D",
                "Adiantamento" => "A",
                "Complemento 13° Salário" => "F"
            ],
            'attr' => [
                'class' => 'select2-parameters',
                'disabled' => 'disabled'
            ],
            'required' => false
        ];

        $fieldOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'choices' => array('cgm' => 'cgm_contrato', 'lotacao' => 'lotacao', 'local' => 'local'),
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false
        ];

        $fieldOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        ];

        $fieldOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true
        ];

        $formMapper
            ->with('label.recursosHumanos.relatorios.folha.contraCheque.selecaoFiltro')
                ->add('stSituacao', 'choice', $fieldOptions['stSituacao'])
                ->add('ano', 'number', $fieldOptions['ano'])
                ->add('mes', 'choice', $fieldOptions['mes'])
                ->add('stConfiguracao', 'choice', $fieldOptions['stConfiguracao'])
                ->add('inCodComplementar', 'choice', $fieldOptions['inCodComplementar'])
                ->add('stDesdobramento', 'choice', $fieldOptions['stDesdobramento'])
            ->end()

            ->with('label.recursosHumanos.relatorios.folha.contraCheque.parametrosBusca')
                ->add('tipo', 'choice', $fieldOptions['tipo'])
                ->add('codContrato', 'autocomplete', $fieldOptions['fkPessoalContratoServidor'])
                ->add('lotacao', 'choice', $fieldOptions['lotacao'])
                ->add('local', 'entity', $fieldOptions['local'])

                ->add('mensagem', 'textarea', $fieldOptions['mensagem'])
                ->add('boMensagemAniversariante', 'choice', $fieldOptions['boMensagemAniversariante'])
                ->add('boDuplicar', 'choice', $fieldOptions['boDuplicar'])
                ->add('boAgrupar', 'hidden', ['mapped' => false])
                ->add('boQuebrar', 'hidden', ['mapped' => false])
                ->add('stCodigos', 'hidden', ['mapped' => false])
                ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
                ->add('inContratoReemissao', 'autocomplete', $fieldOptions['inContratoReemissao'])
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $boAgrupar = ($this->getForm()->get('boAgrupar')->getData() == 'sim') ? 'true' : 'false';
        $boDuplicar = ($this->getForm()->get('boDuplicar')->getData() == 'sim') ? 'true' : 'false';
        $inFolha = $this->getForm()->get('stConfiguracao')->getData();
        $stOrdenacao = $this->getForm()->get('ordenacao')->getData();
        $inMes = ($this->getForm()->get('mes')->getData() < 10) ? "0" . $this->getForm()->get('mes')->getData() : $this->getForm()->get('mes')->getData();
        $ano = $this->getForm()->get('ano')->getData();
        $inCodComplementar = $this->getForm()->get('inCodComplementar')->getData();
        $exercicio = $this->getExercicio();
        $stTipoFiltro = $this->getForm()->get('tipo')->getData();
        $contratos = $this->getForm()->get('codContrato')->getData();
        $inCodLotacaoSelecionados = $this->getForm()->get('lotacao')->getData();
        $inCodLocalSelecionados = $this->getForm()->get('local')->getData();
        $stOrdem = '';
        $entidade = '';
        $inQuantEvento = 17;
        $timestampSituacao = $periodoFinal->getFkFolhapagamentoFolhaSituacoes()->last()->getTimestamp()->format('Y-m-d');
        $inContratoReemissao = $this->getForm()->get('inContratoReemissao')->getData();
        $inContratoReemissao = ($inContratoReemissao) ? $inContratoReemissao->getCodContrato() : 0;
        $stSituacao = $this->getForm()->get('stSituacao')->getData();
        $stMensagemAniversario = '';
        $stMensagem = $this->getForm()->get('mensagem')->getData();
        $dtCompetencia = $inMes . '/' . $ano;
        $stDesdobramento = $this->getForm()->get('stDesdobramento')->getData();

        switch ($stTipoFiltro) {
            case "cgm_contrato":
                if ($stOrdenacao == "alfabetica") {
                    $stOrdem = "nom_cgm";
                } else {
                    $stOrdem = "registro";
                }

                $stFiltroContratos = " AND contrato.cod_contrato IN (";
                foreach ($contratos as $arContrato) {
                    $stFiltroContratos .= $arContrato->getCodContrato() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";
                break;
            case "geral":
                if ($stOrdenacao == "alfabetica") {
                    $stOrdem = "nom_cgm";
                } else {
                    $stOrdem = "registro";
                }
                break;
            case "lotacao":
                $stOrdem = "";
                $virgula = "";

                if ($boAgrupar) {
                    $stOrdem .= "orgao";
                    $virgula = ", ";
                }
                if ($stOrdenacao == "alfabetica") {
                    $stOrdem .= $virgula . "descricao_lotacao,nom_cgm";
                } else {
                    $stOrdem .= $virgula . "orgao,registro";
                }
                $stFiltroContratos = " AND cadastros.cod_orgao IN (";
                foreach ($inCodLotacaoSelecionados as $inCodOrgao) {
                    $stFiltroContratos .= $inCodOrgao . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";
                break;
            case "local":
                $stOrdem = "";
                $virgula = "";

                if ($boAgrupar) {
                    $stOrdem .= "local";
                    $virgula = ", ";
                }

                if ($stOrdenacao == "alfabetica") {
                    $stOrdem .= $virgula . "descricao_local,nom_cgm";
                } else {
                    $stOrdem .= $virgula . "cod_local,registro";
                }
                $stFiltroContratos = " AND cadastros.cod_local IN (";
                /** @var Local $inCodLocal */
                foreach ($inCodLocalSelecionados as $inCodLocal) {
                    $stFiltroContratos .= $inCodLocal->getCodLocal() . ",";
                }
                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";
                break;
        }

        if ($stOrdem == '') {
            $stOrdem = 'nom_cgm';
        }

        switch ($inFolha) {
            case 0:
                $stFolha = "Folha Complementar";
                break;
            case 1:
                $stFolha = "Folha Salário";
                break;
            case 2:
                $stFolha = "Folha Férias";
                break;
            case 3:
                $stFolha = "Folha Décimo";
                break;
            case 4:
                $stFolha = "Folha Rescisão";
                break;
        }

        $fileName = $this->parseNameFile("contracheque");

        $params = [
            "term_user" => 'suporte',
            "cod_acao" => 1666,
            "inCodGestao" => Gestao::GESTAO_RECURSOS_HUMANOS,
            "inCodModulo" => Modulo::MODULO_FOLHAPAGAMENTO,
            "inCodRelatorio" => Relatorio::RECURSOS_HUMANOS_FOLHAPAGAMENTO_CONTRACHEQUE,
            "exercicio" => $exercicio,
            "entidade" => $entidade,
            "qtdEventos" => $inQuantEvento,
            "periodoMovimentacao" => $periodoFinal->getCodPeriodoMovimentacao(),
            "timestamp_situacao" => $timestampSituacao,
            "dt_inicial" => $periodoFinal->getDtInicial()->format('d/m/Y'),
            "dt_final" => $periodoFinal->getDtFinal()->format('Y-m-d'),
            "ordenacao" => $stOrdem,
            "codConfiguracao" => $inFolha,
            "dt_competencia" => $dtCompetencia,
            "codComplementar" => $inCodComplementar,
            "filtro" => $stFiltroContratos,
            "registroReemissao" => $inContratoReemissao,
            "duplicar" => $boDuplicar,
            "situacao" => $stSituacao,
            "st_Folha" => $stFolha,
            "mensagem_aniversario" => $stMensagemAniversario,
            "mensagem" => $stMensagem,
            "inMes" => $inMes,
            "desdobramento" => ($stDesdobramento) ? $stDesdobramento : "",
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
