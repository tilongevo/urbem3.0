<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;

class TermoRescisaoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_termo_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/termo-rescisao';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $exibirBotaoSalvar = false;

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/relatorioTermoRescisao.js'
    ];

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('gerar_relatorio', 'gerar_relatorio');
        $collection->add('download_arquivo', 'download-arquivo');
        $collection->add('view_download_arquivo', 'view-download-arquivo/{filename}');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->getEntityManager();

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
            ->with('label.relatorios.termoRescisao.titulo')
            ->add(
                'ano',
                'number',
                [
                    'label' => 'label.relatorios.termoRescisao.ano',
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
                    'label' => 'label.relatorios.termoRescisao.mes',
                    'mapped' => false,
                    'placeholder' => 'label.selecione',
                    'choices' => $meses,
                    'attr' => [
                        'data-mes' => $mes,
                    ],
                    'data' => end($meses)
                ]
            )
            ->end();

        $fieldOptions['tipo'] = array(
            'mapped' => false,
            'required' => true,
            'placeholder' => 'label.selecione',
            'choices' => array(
                'label.relatorios.termoRescisao.cgmMatricula' => 'matricula',
                'label.relatorios.termoRescisao.lotacao' => 'lotacao',
                'label.relatorios.termoRescisao.local' => 'local',
                'label.relatorios.termoRescisao.geral' => 'geral',
            ),
            'label' => 'label.emitirFerias.tipo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['cgmMatricula'] = array(
            'label' => 'label.relatorios.termoRescisao.cgmMatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'required' => false,
            'json_choice_label' => function ($contrato) use ($em) {
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
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'mapped' => false
        );

        $organogramaModel = new OrganogramaModel($em);
        $orgaoModel = new OrgaoModel($em);

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

        $fieldOptions['lotacao'] = array(
            'label' => 'label.relatorios.termoRescisao.lotacao',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        );

        $fieldOptions['local'] = array(
            'class' => Local::class,
            'label' => 'label.relatorios.termoRescisao.local',
            'required' => false,
            'mapped' => false,
            'data' => array_flip($lotacaoArray),
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'expanded' => false,
            'multiple' => true
        );

        $formMapper
            ->with('label.relatorios.termoRescisao.filtro')
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->add('matricula', 'autocomplete', $fieldOptions['cgmMatricula'])
            ->add('lotacao', 'choice', $fieldOptions['lotacao'])
            ->add('local', 'entity', $fieldOptions['local'])
            ->end()
            ;

        $formMapper
            ->with('label.relatorios.termoRescisao.ordenacao')
            ->add(
                'ordenacao',
                'choice',
                [
                    'mapped' => false,
                    'choices' => [
                        'label.relatorios.filtro.ordenacao.choices.alfabetica' => 'A',
                        'label.relatorios.filtro.ordenacao.choices.numerica' => 'N',
                    ],
                    'label' => 'label.ordenacao',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add('gerarRelatorio', 'customField', [
                'template' => 'RecursosHumanosBundle:Sonata/FolhaPagamento/TermoRescisao/CRUD:btn_gerar_relatorio_termo_rescisao.html.twig',
                'data' => '',
                'mapped' => false
            ])
            ->end();
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

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $stAno = (int) $this->getForm()->get('ano')->getData();
        $stMes = (int) $this->getForm()->get('mes')->getData();

        $ordenacao = $this->getForm()->get('ordenacao')->getData();

        $tipo = $this->getForm()->get('tipo')->getData();
        $stValor = '';

        switch ($tipo) {
            case "contrato":
            case "lotacao":
            case "local":
                break;
            case "cgm_contrato":
                break;
        }
    }
}
