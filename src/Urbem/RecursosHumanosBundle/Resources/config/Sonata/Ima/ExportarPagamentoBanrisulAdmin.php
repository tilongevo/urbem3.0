<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Datetime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoBanrisulRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ExportarPagamentoBanrisulAdmin extends AbstractSonataAdmin
{
    const TIPO_CADASTRO_ATIVO = 'ativo';
    const TIPO_CADASTRO_APOSENTADO = 'aposentado';
    const TIPO_CADASTRO_PENSIONISTA = 'pensionista';
    const TIPO_CADASTRO_ESTAGIARIO = 'estagiario';
    const TIPO_CADASTRO_RESCINDIDO = 'rescindido';
    const TIPO_CADASTRO_PENSAO_JUDICIAL = 'pensao-judicial';
    const TIPO_CADASTRO_TODOS = 'todos';
    const TIPOS_CADASTRO = [
        self::TIPO_CADASTRO_ATIVO => 'Ativos',
        self::TIPO_CADASTRO_APOSENTADO => 'Aposentados',
        self::TIPO_CADASTRO_PENSIONISTA => 'Pensionistas',
        self::TIPO_CADASTRO_ESTAGIARIO => 'Estagiários',
        self::TIPO_CADASTRO_RESCINDIDO => 'Rescindidos',
        self::TIPO_CADASTRO_PENSAO_JUDICIAL => 'Pensão Judicial',
        self::TIPO_CADASTRO_TODOS => 'Todos',
    ];

    const TIPO_FOLHA_COMPLEMENTAR = 0;
    const TIPO_FOLHA_SALARIO = 1;
    const TIPO_FOLHA_FERIAS = 2;
    const TIPO_FOLHA_13_SALARIO = 3;
    const TIPO_FOLHA_RESCISAO = 4;
    const TIPOS_FOLHA = [
        self::TIPO_FOLHA_COMPLEMENTAR => 'Complementar',
        self::TIPO_FOLHA_SALARIO => 'Salário',
        self::TIPO_FOLHA_FERIAS => 'Férias',
        self::TIPO_FOLHA_13_SALARIO => '13º salário',
        self::TIPO_FOLHA_RESCISAO => 'Rescisão',
    ];

    const TIPO_FILTRO_MATRICULA = 'contrato';
    const TIPO_FILTRO_CGM_MATRICULA = 'cgm_contrato';
    const TIPO_FILTRO_LOTACAO = 'lotacao';
    const TIPO_FILTRO_LOCAL = 'local';
    const TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR = 'atributo_servidor';
    const TIPO_FILTRO_GERAL = 'geral';
    const TIPO_FILTRO_ATRIBUTO_DINAMICO_PENSIONISTA = 'atributo_pensionista';
    const TIPO_FILTRO_CODIGO_ESTAGIO = 'codigo-estagio';
    const TIPO_FILTRO_ATRIBUTO_DINAMICO_ESTAGIARIO = 'atributo_estagiario';
    const TIPO_FILTRO_CGM_DEPENDENTE_PENSAO = 'cgm-dependente-pensao';
    const TIPO_FILTRO_CGM_MATRICULA_SERVIDOR = 'cgm-matricula-servidor';
    const TIPOS_FILTRO = [
        self::TIPO_FILTRO_MATRICULA => 'Matrícula',
        self::TIPO_FILTRO_CGM_MATRICULA => 'CGM/Matrícula',
        self::TIPO_FILTRO_LOTACAO => 'Lotação',
        self::TIPO_FILTRO_LOCAL => 'Local',
        self::TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR => 'Atributo Dinâmico Servidor',
        self::TIPO_FILTRO_GERAL => 'Geral',
        self::TIPO_FILTRO_ATRIBUTO_DINAMICO_PENSIONISTA => 'Atributo Dinâmico Pensionista',
        self::TIPO_FILTRO_CODIGO_ESTAGIO => 'Código do Estágio',
        self::TIPO_FILTRO_ATRIBUTO_DINAMICO_ESTAGIARIO => 'Atributo Dinâmico Estagiário',
        self::TIPO_FILTRO_CGM_DEPENDENTE_PENSAO => 'CGM do Dependente da Pensão',
        self::TIPO_FILTRO_CGM_MATRICULA_SERVIDOR => 'CGM/Matrícula do Servidor',
    ];

    const COD_CONFIGURACAO_DESDOBRAMENTO_13_SALARIO = 3;

    protected $baseRouteName = 'urbem_recursos_humanos_ima_exportar_pagamento_banrisul';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/exportar-pagamentos/banrisul';
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/recursoshumanos/javascripts/ima/exportar-pagamento-banrisul.js'
    ];
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Exportar'];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $request = $this->getRequest();

        $redirectUrl = $this->generateObjectUrl('detalhe', $object, ['uniqid' => $request->get('uniqid')]);

        (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('filtro', 'filtro');
        $routes->add('detalhe', 'detalhe');
        $routes->add('download', 'download');
        $routes->add('api_matricula', 'api/matriculas');

        $routes->clearExcept(['create', 'filtro', 'detalhe', 'download', 'api_matricula']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = new ExportarPagamentoBanrisulRepository($em);

        $fieldOptions = [];
        $fieldOptions['tipoCadastro'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPOS_CADASTRO),
            'data' => $this::TIPO_CADASTRO_ATIVO,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.cadastro',
        ];

        $ultimaCompetencia = $repository->fetchUltimoPeriodoMovimentacao()['dt_final'];
        $fieldOptions['ultimaCompetencia'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'data' => (new DateTime())->createFromFormat('d/m/Y', $ultimaCompetencia)->format('m/Y'),
        ];

        $fieldOptions['competencia'] = [
            'mapped' => false,
            'required' => true,
            'label' => 'label.imaExportarPagamentoBanrisul.competencia',
        ];

        $fieldOptions['tipoFolha'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPOS_FOLHA),
            'data' => $this::TIPO_FOLHA_SALARIO,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.tipoCalculo',
        ];

        $fieldOptions['folhaComplementar'] = [
            'mapped' => false,
            'choices' => $repository->fetchFolhaComplementar(),
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.folhaComplementar',
        ];

        $fieldOptions['desdobramento'] = [
            'mapped' => false,
            'choices' => array_flip($repository->fetchDesdobramentos($this::COD_CONFIGURACAO_DESDOBRAMENTO_13_SALARIO)),
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.desdobramento',
        ];

        $fieldOptions['tipoFiltro'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPOS_FILTRO),
            'data' => $this::TIPO_FILTRO_GERAL,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.tipoFiltro',
        ];

        $fieldOptions['matricula'] = [
            'class' => Contrato::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkPessoalContratoServidor', 'cs');
                $qb->join('cs.fkPessoalServidorContratoServidores', 'scs');
                $qb->join('scs.fkPessoalServidor', 's');
                $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = s.numcgm');

                $qb->andWhere('(LOWER(cgm.nomCgm) LIKE :nomCgm OR o.registro = :registro)');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('registro', (int) $term);

                $qb->orderBy('o.registro', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Contrato $contrato) {
                return sprintf('%d - %s', $contrato->getRegistro(), $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalContratoServidor()->getCgm());
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.matricula',
        ];

        $fieldOptions['cgm'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join(Servidor::class, 's', 'WITH', 's.numcgm = o.numcgm');
                $qb->join('s.fkPessoalServidorContratoServidores', 'scs');
                $qb->join('scs.fkPessoalContratoServidor', 'cs');

                $qb->andWhere('(LOWER(o.nomCgm) LIKE :nomCgm OR o.numcgm = :numcgm)');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('numcgm', (int) $term);

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.cgm',
        ];

        $fieldOptions['cgmMatricula'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.matricula',
        ];

        $fieldOptions['lotacao'] = [
            'mapped' => false,
            'choices' => array_flip($repository->fetchLotacoes()),
            'required' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.lotacao',
        ];

        $fieldOptions['local'] = [
            'class' => Local::class,
            'mapped' => false,
            'required' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.local',
        ];

        $fieldOptions['codEstagio'] = [
            'class' => EstagiarioEstagio::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkEstagioEstagiario', 'e');
                $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = e.numcgm');

                $qb->andWhere('(LOWER(cgm.nomCgm) LIKE :nomCgm OR o.numeroEstagio = :numeroEstagio)');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('numeroEstagio', (int) $term);

                $qb->orderBy('o.numeroEstagio', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (EstagiarioEstagio $estagio) {
                return sprintf('%d - %s', $estagio->getNumeroEstagio(), $estagio->getFkEstagioEstagiario()->getFkSwCgmPessoaFisica());
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.codigoEstagio',
        ];

        $fieldOptions['cgmDependente'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join(Dependente::class, 'd', 'WITH', 'd.numcgm = o.numcgm');
                $qb->join(Pensao::class, 'p', 'WITH', 'p.codDependente = d.codDependente');

                $qb->andWhere('(LOWER(o.nomCgm) LIKE :nomCgm OR o.numcgm = :numcgm)');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('numcgm', (int) $term);

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.cgmDependente',
        ];

        $fieldOptions['cgmServidorDependente'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join(Servidor::class, 's', 'WITH', 's.numcgm = o.numcgm');
                $qb->join('s.fkPessoalServidorContratoServidores', 'scs');
                $qb->join('scs.fkPessoalContratoServidor', 'cs');
                $qb->join('s.fkPessoalServidorDependentes', 'sd');
                $qb->join(Pensao::class, 'p', 'WITH', 'p.codServidor = s.codServidor');

                $qb->andWhere('(LOWER(o.nomCgm) LIKE :nomCgm OR o.numcgm = :numcgm)');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('numcgm', (int) $term);

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.cgmServidorDependente',
        ];

        $fieldOptions['cgmServidorDependenteMatricula'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.matricula',
        ];

        $fieldOptions['valoresLiquidosDe'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'data' => 0.01,
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.filtrarValoresLiquidosDe',
        ];

        $fieldOptions['valoresLiquidosAte'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'data' => 99999999.99,
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.filtrarValoresLiquidosAte',
        ];

        $fieldOptions['percentualAPagar'] = [
            'mapped' => false,
            'scale' => 2,
            'type' => 'integer',
            'required' => false,
            'data' => 100,
            'label' => 'label.imaExportarPagamentoBanrisul.percentualAPagar',
        ];

        $fieldOptions['codConvenio'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'data' => $repository->fetchCodConvenioBanco(),
            'label' => 'label.imaExportarPagamentoBanrisul.codConvenio',
        ];

        $fieldOptions['listaGrupoContas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_grupo_contas.html.twig',
            'data' => [
                'itens' => $repository->fetchGrupoDeContas(),
            ],
        ];

        $fieldOptions['dtGeracaoArquivo'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.imaExportarPagamentoBanrisul.dtGeracaoArquivo',
        ];

        $fieldOptions['dtPagamento'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.imaExportarPagamentoBanrisul.dtPagamento',
        ];

        $fieldOptions['numeroSequencialArquivo'] = [
            'mapped' => false,
            'data' => $repository->fetchNumSequencialArquivo($this->getExercicio()),
            'label' => 'label.imaExportarPagamentoBanrisul.numeroSequencialArquivo',
        ];

        $fieldOptions['incluirMatricula'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_matricula.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaMatriculas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_matriculas.html.twig',
            'data' => [],
        ];

        $fieldOptions['incluirCgmMatricula'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_cgm_matricula.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaCgmMatriculas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_cgm_matriculas.html.twig',
            'data' => [],
        ];

        $fieldOptions['incluirCodEstagio'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_cod_estagio.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaCodEstagios'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_cod_estagios.html.twig',
            'data' => [],
        ];

        $fieldOptions['incluirCgmDependente'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_cgm_dependente.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaCgmDependentes'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_cgm_dependentes.html.twig',
            'data' => [],
        ];

        $fieldOptions['incluirCgmServidorDependente'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/incluir_cgm_servidor_dependente.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaCgmServidorDependentes'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/lista_cgm_servidor_dependentes.html.twig',
            'data' => [],
        ];

        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];

        $fieldOptions['agrupamentoAtributoDinamicoEstagiario'] = [
            'mapped' => false,
            'choices' => [
                'Agrupar' => 'agrupar',
                'Quebrar Página' => 'quebrar-pagina',
            ],
            'expanded' => true,
            'required' => false,
            'multiple' => true,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata',
            ],
            'label' => 'label.imaExportarPagamentoBanrisul.agrupamento',
        ];

        $formMapper
            ->with('label.imaExportarPagamentoBanrisul.cabecalhoFiltro')
                ->add('tipoCadastro', 'choice', $fieldOptions['tipoCadastro'])
                ->add('ultimaCompetencia', 'hidden', $fieldOptions['ultimaCompetencia'])
                ->add('competencia', 'text', $fieldOptions['competencia'])
                ->add('tipoFolha', 'choice', $fieldOptions['tipoFolha'])
                ->add('folhaComplementar', 'choice', $fieldOptions['folhaComplementar'])
                ->add('desdobramento', 'choice', $fieldOptions['desdobramento'])
            ->end()
            ->with('label.imaExportarPagamentoBanrisul.cabecalhoAtivos')
                ->add('tipoFiltro', 'choice', $fieldOptions['tipoFiltro'])
                ->add('matricula', 'autocomplete', $fieldOptions['matricula'])
                ->add('cgm', 'autocomplete', $fieldOptions['cgm'])
                ->add('cgmMatricula', 'choice', $fieldOptions['cgmMatricula'])
                ->add('lotacao', 'choice', $fieldOptions['lotacao'])
                ->add('local', 'entity', $fieldOptions['local'])
                ->add('codEstagio', 'autocomplete', $fieldOptions['codEstagio'])
                ->add('cgmDependente', 'autocomplete', $fieldOptions['cgmDependente'])
                ->add('cgmServidorDependente', 'autocomplete', $fieldOptions['cgmServidorDependente'])
                ->add('cgmServidorDependenteMatricula', 'choice', $fieldOptions['cgmServidorDependenteMatricula'])
                ->add('incluirMatricula', 'customField', $fieldOptions['incluirMatricula'])
                ->add('incluirCgmMatricula', 'customField', $fieldOptions['incluirCgmMatricula'])
                ->add('incluirCodEstagio', 'customField', $fieldOptions['incluirCodEstagio'])
                ->add('incluirCgmDependente', 'customField', $fieldOptions['incluirCgmDependente'])
                ->add('incluirCgmServidorDependente', 'customField', $fieldOptions['incluirCgmServidorDependente'])
                ->add('listaMatriculas', 'customField', $fieldOptions['listaMatriculas'])
                ->add('listaCgmMatriculas', 'customField', $fieldOptions['listaCgmMatriculas'])
                ->add('listaCodEstagios', 'customField', $fieldOptions['listaCodEstagios'])
                ->add('listaCgmDependentes', 'customField', $fieldOptions['listaCgmDependentes'])
                ->add('listaCgmServidorDependentes', 'customField', $fieldOptions['listaCgmServidorDependentes'])
                ->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos'])
                ->add('agrupamentoAtributoDinamicoEstagiario', 'choice', $fieldOptions['agrupamentoAtributoDinamicoEstagiario'])
            ->end()
            ->with('label.imaExportarPagamentoBanrisul.cabecalhoInformacoesGerais')
                ->add('valoresLiquidosDe', 'money', $fieldOptions['valoresLiquidosDe'])
                ->add('valoresLiquidosAte', 'money', $fieldOptions['valoresLiquidosAte'])
                ->add('percentualAPagar', 'percent', $fieldOptions['percentualAPagar'])
                ->add('codConvenio', 'text', $fieldOptions['codConvenio'])
            ->end()
            ->with('label.imaExportarPagamentoBanrisul.cabecalhoGrupoContas')
                ->add('listaGrupoContas', 'customField', $fieldOptions['listaGrupoContas'])
                ->add('dtGeracaoArquivo', 'datepkpicker', $fieldOptions['dtGeracaoArquivo'])
                ->add('dtPagamento', 'datepkpicker', $fieldOptions['dtPagamento'])
                ->add('numeroSequencialArquivo', 'integer', $fieldOptions['numeroSequencialArquivo'])
            ->end();
    }
}
