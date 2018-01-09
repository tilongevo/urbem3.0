<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarPagamentoBanrisulRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;

class ServidoresReportAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_relatorios_servidores';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/relatorios/servidores';
    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/servidor-report-atributos.js',
        '/recursoshumanos/javascripts/pessoal/servidor-report.js'
    ];
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    const TIPO_CADASTRO_ATIVO = 'ativo';
    const TIPO_CADASTRO_APOSENTADO = 'aposentado';
    const TIPO_CADASTRO_PENSIONISTA = 'pensionista';
    const TIPO_CADASTRO_RESCINDIDO = 'rescindido';
    const TIPO_CADASTRO_TODOS = 'todos';
    const TIPOS_CADASTRO = [
        self::TIPO_CADASTRO_ATIVO => 'label.pessoal.relatorioServidor.ativos',
        self::TIPO_CADASTRO_APOSENTADO => 'label.pessoal.relatorioServidor.aposentados',
        self::TIPO_CADASTRO_PENSIONISTA => 'label.pessoal.relatorioServidor.pensionistas',
        self::TIPO_CADASTRO_RESCINDIDO => 'label.pessoal.relatorioServidor.rescindidos',
        self::TIPO_CADASTRO_TODOS => 'label.pessoal.relatorioServidor.todos',
    ];

    const TIPO_FILTRO_MATRICULA = 'contrato';
    const TIPO_FILTRO_CGM_MATRICULA = 'cgm_contrato';
    const TIPO_FILTRO_LOTACAO = 'lotacao';
    const TIPO_FILTRO_LOCAL = 'local';
    const TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR = 'atributo_servidor';
    const TIPOS_FILTRO = [
        self::TIPO_FILTRO_MATRICULA => 'label.pessoal.relatorioServidor.matricula',
        self::TIPO_FILTRO_CGM_MATRICULA => 'label.pessoal.relatorioServidor.cgmMatricula',
        self::TIPO_FILTRO_LOTACAO => 'label.pessoal.relatorioServidor.lotacao',
        self::TIPO_FILTRO_LOCAL => 'label.pessoal.relatorioServidor.local',
        self::TIPO_FILTRO_ATRIBUTO_DINAMICO_SERVIDOR => 'label.pessoal.relatorioServidor.atributoDinamicoServidor'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('relatorio', 'relatorio');
        $collection->add('filtro', 'filtro');
        $collection->add('api_matricula', 'api/matriculas');
        $collection->clearExcept(['create', 'filtro', 'api_matricula', 'relatorio']);
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

        $fieldOptions['exercicio'] = array(
            'data' => $this->getExercicio(),
            'mapped' => false,
        );

        $fieldOptions['entidade'] = array(
            'data' => $this->getEntidade()->getCodEntidade(),
            'mapped' => false,
        );

        $fieldOptions['tipoCadastro'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPOS_CADASTRO),
            'data' => $this::TIPO_CADASTRO_ATIVO,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.pessoal.relatorioServidor.cadastro',
        ];

        $fieldOptions['tipoFiltro'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPOS_FILTRO),
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.pessoal.relatorioServidor.tipoFiltro',
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
            'label' => 'label.pessoal.relatorioServidor.matricula',
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
            'label' => 'label.pessoal.relatorioServidor.cgm',
        ];

        $fieldOptions['cgmMatricula'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.pessoal.relatorioServidor.cgmMatricula',
        ];

        $fieldOptions['lotacao'] = [
            'mapped' => false,
            'choices' => array_flip($repository->fetchLotacoes()),
            'required' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.pessoal.relatorioServidor.lotacao',
        ];

        $fieldOptions['local'] = [
            'class' => Local::class,
            'mapped' => false,
            'required' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.pessoal.relatorioServidor.local',
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

        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'RecursosHumanosBundle::Ima/ExportarPagamentoBanrisul/atributos_dinamicos.html.twig',
            'data' => [],
        ];

        $fieldOptions['atributoSelecao'] = array(
            'label' => 'label.pessoal.relatorioServidor.atributos',
            'class' => AtributoDinamico::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return sprintf('%s', $atributoDinamico->getNomAtributo());
            },
            'choice_value' => 'codAtributo',
            'query_builder' => function (EntityRepository $er) {
                return $er
                    ->createQueryBuilder('o')
                    ->where('o.codModulo = :codModulo')
                    ->andWhere('o.codCadastro = :codCadastro')
                    ->andWhere('o.ativo = true')
                    ->setParameters(
                        array(
                            'codModulo' => Modulo::MODULO_PESSOAL,
                            'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO
                        )
                    );
            },
        );

        $opcoesVisualizacao = [
            'label.pessoal.relatorioServidor.identificacao' => 'identificacao',
            'label.pessoal.relatorioServidor.foto' => 'foto',
            'label.pessoal.relatorioServidor.documentacao' => 'documentacao',
            'label.pessoal.relatorioServidor.contratuais' => 'contratuais',
            'label.pessoal.relatorioServidor.salariais' => 'salariais',
            'label.pessoal.relatorioServidor.bancarias' => 'bancarias',
            'label.pessoal.relatorioServidor.lotacao' => 'lotacao',
            'label.pessoal.relatorioServidor.previdencia' => 'previdencia',
            'label.pessoal.relatorioServidor.ferias' => 'ferias',
            'label.pessoal.relatorioServidor.atributoDinamico' => 'atributos',
            'label.pessoal.relatorioServidor.dependentes' => 'dependentes',
            'label.pessoal.relatorioServidor.assentamentos' => 'assentamentos'
        ];

        $fieldOptions['opcoesVisualizacao'] = array(
            'mapped' => false,
            'required' => true,
            'multiple' => true,
            'placeholder' => 'label.selecione',
            'choices' => $opcoesVisualizacao,
            'label' => 'label.pessoal.relatorioServidor.informacoes',
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ]
        );

        $formMapper
            ->with('label.pessoal.relatorioServidor.titulo')
                ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
                ->add('entidade', 'hidden', $fieldOptions['entidade'])
                ->add('tipoCadastro', 'choice', $fieldOptions['tipoCadastro'])
            ->end()
            ->with('label.pessoal.relatorioServidor.ativos')
                ->add('tipoFiltro', 'choice', $fieldOptions['tipoFiltro'])
            ->end()
            ->with('label.pessoal.relatorioServidor.filtroMatricula')
                ->add('matricula', 'autocomplete', $fieldOptions['matricula'])
                ->add('cgm', 'autocomplete', $fieldOptions['cgm'])
                ->add('cgmMatricula', 'choice', $fieldOptions['cgmMatricula'])
                ->add('lotacao', 'choice', $fieldOptions['lotacao'])
                ->add('local', 'entity', $fieldOptions['local'])
                ->add('incluirMatricula', 'customField', $fieldOptions['incluirMatricula'])
                ->add('incluirCgmMatricula', 'customField', $fieldOptions['incluirCgmMatricula'])
                ->add('listaMatriculas', 'customField', $fieldOptions['listaMatriculas'])
                ->add('listaCgmMatriculas', 'customField', $fieldOptions['listaCgmMatriculas'])
                ->add('atributoSelecao', 'entity', $fieldOptions['atributoSelecao'])
                ->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos'])
            ->end()
            ->with('label.pessoal.relatorioServidor.opcoesVisualizacao')
                ->add('opcoesVisualizacao', 'choice', $fieldOptions['opcoesVisualizacao'])
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $request = $this->getRequest();

        $redirectUrl = $this->generateObjectUrl('relatorio', $object, ['uniqid' => $request->get('uniqid')]);

        (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
    }
}
