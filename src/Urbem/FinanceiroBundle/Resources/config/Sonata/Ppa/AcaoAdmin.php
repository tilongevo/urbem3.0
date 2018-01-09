<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\FinanceiroBundle\Controller\Ppa\ConfiguracaoController;

class AcaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ppa_acao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/acao';
    protected $includeJs = array(
        '/financeiro/javascripts/ppa/acao.js',
        '/financeiro/javascripts/validate/input-number-validate.js'
    );
    protected $model = Model\Ppa\AcaoModel::class;

    const TIPO_ORCAMENTARIA = 1;
    const TIPO_NAO_ORCAMENTARIA = 2;
    const TIPO_PROJETO = 1;
    const TIPO_ATIVIDADE = 2;
    const TIPO_OPERACAO_ESPECIAL = 3;
    const TIPO_FINANCIAMENTOS = 4;
    const TIPO_PARCERIAS = 5;
    const TIPO_PLANO_DISPENDIO_ESTATAIS = 6;
    const TIPO_RENUNCIA_FISCAL = 7;
    const TIPO_OUTRAS_INICIATIVAS_DIRETRIZES = 8;

    const FORMA_DIRETA = 1;
    const FORMA_DESCENTRALIZADA = 2;
    const FORMA_TRANSFERENCIA_OBRIGATORIA = 3;
    const FORMA_TRANSFERENCIA_VOLUNTARIA = 4;
    const FORMA_TRANSFERENCIA_OUTRAS = 5;
    const FORMA_LINHA_CREDITO = 6;

    const ORCAMENTO_FISCAL = 1;
    const ORCAMENTO_SEGURIDADE = 2;
    const ORCAMENTO_INVESTIMENTO_ESTATAIS = 3;
    const ORCAMENTO_NAO_ORCAMENTARIO = 4;

    const NATUREZA_CORRENTE = 1;
    const NATUREZA_CAPITAL = 2;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('remover_recurso', 'remover-recurso');
        $collection->add('consultar_unidades', 'consultar-unidades', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_programas', 'consultar-programas', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_subtipos', 'consultar-subtipos', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_natureza_temporal', 'consultar-natureza-temporal', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_num_acao', 'consultar-num-acao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('autocomplete_norma', 'autocomplete-norma');
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkPpaPrograma.fkPpaProgramaSetorial.fkPpaMacroObjetivo.fkPpaPpa', null, [
                'label' => 'label.ppaAcao.ppa'
            ])
            ->add('fkPpaPrograma', null, ['label' => 'label.ppaAcao.programa'])
            ->add(
                'tipoAcao',
                'doctrine_orm_choice',
                [
                    'label' => 'label.ppaAcao.tipoAcao'
                ],
                'choice',
                [
                    'choices' => array(
                        'label.ppaAcao.orcamentaria' => self::TIPO_ORCAMENTARIA,
                        'label.ppaAcao.naoOrcamentaria' => self::TIPO_NAO_ORCAMENTARIA
                    ),
                    'mapped' => false,
                    'expanded' => true,
                    'placeholder' => false
                ]
            )
            ->add('fkPpaAcaoDados.fkPpaTipoAcao', null, ['label' => 'label.ppaAcao.subTipoAcao'])
            ->add('numAcao', null, ['label' => 'label.ppaAcao.codAcao'])
            ->add('fkPpaAcaoDados.titulo', null, ['label' => 'label.ppaAcao.titulo'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('getCodigoComposto', null, ['label' => 'label.ppaAcao.codAcao'])
            ->add('fkPpaPrograma.fkPpaProgramaSetorial.fkPpaMacroObjetivo.fkPpaPpa', 'text', ['label' => 'label.ppaAcao.ppa'])
            ->add('getTipoAcao', 'text', ['label' => 'label.ppaAcao.tipoAcao'])
            ->add('getDescricao', 'text', ['label' => 'label.ppaAcao.titulo'])
            ->add('getValor', 'currency', ['label' => 'label.ppaAcao.valorAcao', 'currency' => 'BRL'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                )
            ));
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $fontesRecurso = array();
        $fontesRecursoTotais = array('ano1' => 0, 'ano2' => 0, 'ano3' => 0, 'ano4' => 0, 'total' => 0);
        $fieldOptions = array();

        $fieldOptions['ppa'] = array(
            'label' => 'label.ppaAcao.ppa',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Ppa\Ppa',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters ppa-ppa'
            )
        );

        $fieldOptions['fkPpaPrograma'] = array(
            'label' => 'label.ppaAcao.programa',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters ppa-programa'
            )
        );

        $fieldOptions['numAcao'] = array(
            'label' => 'label.ppaAcao.numAcao',
            'attr' => ['min' => 1, 'max' => 9999,
                'class' => 'validateNumber '
            ],
        );

        $fieldOptions['tipoTipoAcao'] = array(
            'label' => 'label.ppaAcao.tipoAcao',
            'choices' => array(
                'label.ppaAcao.orcamentaria' => self::TIPO_ORCAMENTARIA,
                'label.ppaAcao.naoOrcamentaria' => self::TIPO_NAO_ORCAMENTARIA
            ),
            'expanded' => true,
            'data' => 1,
            'mapped' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata ppa-sub-tipo-acao']
        );

        $fieldOptions['dadosTipoAcao'] = array(
            'label' => 'label.ppaAcao.subTipoAcao',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Ppa\TipoAcao',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters ppa-tipo-acao'
            )
        );

        $fieldOptions['dadosTitulo'] = array(
            'label' => 'label.ppaAcao.titulo',
            'mapped' => false
        );

        $fieldOptions['dadosFinalidade'] = array(
            'label' => 'label.ppaAcao.finalidade',
            'mapped' => false
        );

        $fieldOptions['dadosDescricao'] = array(
            'label' => 'label.ppaAcao.descricao',
            'mapped' => false
        );

        $fieldOptions['dadosDetalhamento'] = array(
            'label' => 'label.ppaAcao.detalhamento',
            'mapped' => false
        );

        $fieldOptions['dadosCodForma'] = array(
            'label' => 'label.ppaAcao.forma',
            'placeholder' => 'label.selecione',
            'choices' => array(
                'label.ppaAcao.direta' => self::FORMA_DIRETA,
                'label.ppaAcao.descentralizada' => self::FORMA_DESCENTRALIZADA,
                'label.ppaAcao.transferenciaObrigatoria' => self::FORMA_TRANSFERENCIA_OBRIGATORIA,
                'label.ppaAcao.transferenciaVoluntaria' => self::FORMA_TRANSFERENCIA_VOLUNTARIA,
                'label.ppaAcao.transferenciaOutras' => self::FORMA_TRANSFERENCIA_OUTRAS,
                'label.ppaAcao.linhaCredito' => self::FORMA_LINHA_CREDITO
            ),
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['dadosCodRegiao'] = array(
            'label' => 'label.ppaAcao.regiao',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Ppa\Regiao',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['dadosCodProduto'] = array(
            'label' => 'label.ppaAcao.produto',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Ppa\Produto',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['normaCodNorma'] = array(
            'label' => 'label.ppaAcao.norma',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters '],
            'route' => ['name' => 'urbem_financeiro_ppa_acao_autocomplete_norma']
        );

        $fieldOptions['dadosCodTipoOrcamento'] = array(
            'label' => 'label.ppaAcao.tipoOrcamento',
            'placeholder' => 'label.selecione',
            'choices' => array(
                'label.ppaAcao.fiscal' => self::ORCAMENTO_FISCAL,
                'label.ppaAcao.seguridade' => self::ORCAMENTO_SEGURIDADE,
                'label.ppaAcao.investimentoEstatais' => self::ORCAMENTO_INVESTIMENTO_ESTATAIS,
                'label.ppaAcao.naoOrcamentaria' => self::ORCAMENTO_NAO_ORCAMENTARIO
            ),
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['unidadeExecutoraCodOrgao'] = array(
            'label' => 'label.ppaAcao.orgao',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\Orgao',
            'choice_value' => 'numOrgao',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters orcamento-orgao'
            )
        );

        $fieldOptions['unidadeExecutoraCodUnidade'] = array(
            'label' => 'label.ppaAcao.unidade',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\Unidade',
            'choice_value' => 'numUnidade',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters orcamento-unidade'
            )
        );

        $fieldOptions['dadosCodNatureza'] = array(
            'label' => 'label.ppaAcao.natureza',
            'choices' => array(
                'label.ppaAcao.corrente' => self::NATUREZA_CORRENTE,
                'label.ppaAcao.capital' => self::NATUREZA_CAPITAL
            ),
            'expanded' => true,
            'data' => 1,
            'mapped' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        );

        $fieldOptions['dadosCodFuncao'] = array(
            'label' => 'label.ppaAcao.funcao',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\Funcao',
            'choice_value' => 'codFuncao',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['dadosCodSubfuncao'] = array(
            'label' => 'label.ppaAcao.subfuncao',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\Subfuncao',
            'choice_value' => 'codSubFuncao',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['dadosCodUnidadeMedida'] = array(
            'label' => 'label.ppaAcao.unidadeMedida',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Administracao\UnidadeMedida',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['periodoDataInicio'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ppaAcao.dataInicio',
            'mapped' => false,
        );

        $fieldOptions['periodoDataTermino'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ppaAcao.dataTermino',
            'mapped' => false,
        );

        $fieldOptions['dadosValorEstimado'] = array(
            'label' => 'label.ppaAcao.valorEstimado',
            'mapped' => false,
            'grouping' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        );

        $fieldOptions['dadosMetaEstimada'] = array(
            'label' => 'label.ppaAcao.metaEstimada',
            'mapped' => false,
            'grouping' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        );

        if ($this->id($this->getSubject())) {
            $acao = $this->getSubject();

            $ppa = (new Model\Ppa\AcaoModel($em))->getPpaByCodPrograma($acao->getFkPpaPrograma()->getCodPrograma());
            $fieldOptions['ppa']['data'] = $ppa;
            $fieldOptions['ppa']['disabled'] = true;

            $acaoDados = $acao->getAcaoDados();
            if ($acaoDados) {
                $tipoAcao = $acaoDados->getFkPpaTipoAcao();
                switch ($tipoAcao->getCodTipo()) {
                    case self::TIPO_PROJETO:
                    case self::TIPO_ATIVIDADE:
                    case self::TIPO_OPERACAO_ESPECIAL:
                        $fieldOptions['tipoTipoAcao']['data'] = self::TIPO_ORCAMENTARIA;
                        break;
                    case self::TIPO_FINANCIAMENTOS:
                    case self::TIPO_PARCERIAS:
                    case self::TIPO_PLANO_DISPENDIO_ESTATAIS:
                    case self::TIPO_RENUNCIA_FISCAL:
                    case self::TIPO_OUTRAS_INICIATIVAS_DIRETRIZES:
                        $fieldOptions['tipoTipoAcao']['data'] = self::TIPO_NAO_ORCAMENTARIA;
                        break;
                }
                $fieldOptions['tipoTipoAcao']['disabled'] = true;

                $fieldOptions['dadosTipoAcao']['data'] = $acaoDados->getFkPpaTipoAcao();
                $fieldOptions['dadosTipoAcao']['disabled'] = true;

                $fieldOptions['numAcao']['mapped'] = false;
                $fieldOptions['numAcao']['data'] = $acao->getNumAcao();
                $fieldOptions['numAcao']['disabled'] = true;

                $fieldOptions['dadosTitulo']['data'] = $acaoDados->getTitulo();
                $fieldOptions['dadosFinalidade']['data'] = $acaoDados->getFinalidade();
                $fieldOptions['dadosDescricao']['data'] = $acaoDados->getDescricao();
                $fieldOptions['dadosDetalhamento']['data'] = $acaoDados->getDetalhamento();

                $fieldOptions['dadosCodForma']['data'] = $acaoDados->getCodForma();
                $fieldOptions['dadosCodRegiao']['data'] = $acaoDados->getFkPpaRegiao();
                $fieldOptions['dadosCodProduto']['data'] = $acaoDados->getFkPpaProduto();

                $codNorma = $acaoDados->getFkPpaAcaoNormas()->current();
                if ($codNorma) {
                    $fieldOptions['normaCodNorma']['data'] = $codNorma->getFkNormasNorma();
                }

                $fieldOptions['dadosCodTipoOrcamento']['data'] = $acaoDados->getCodTipoOrcamento();
                $fieldOptions['dadosCodNatureza']['data'] = $acaoDados->getCodNatureza();
                $fieldOptions['dadosCodFuncao']['data'] = $acaoDados->getFkOrcamentoFuncao();
                $fieldOptions['dadosCodSubfuncao']['data'] = $acaoDados->getFkOrcamentoSubfuncao();
                $fieldOptions['dadosCodUnidadeMedida']['data'] = $acaoDados->getFkAdministracaoUnidadeMedida();

                $unidade = $acaoDados->getFkPpaAcaoUnidadeExecutoras()->current()->getFkOrcamentoUnidade();
                $fieldOptions['unidadeExecutoraCodOrgao']['data'] = $unidade->getFkOrcamentoOrgao();
                $fieldOptions['unidadeExecutoraCodUnidade']['data'] = $unidade;

                $periodoAcao = $acaoDados->getFkPpaAcaoPeriodo();
                if ($periodoAcao) {
                    $fieldOptions['periodoDataInicio']['data'] = $periodoAcao->getDataInicio();
                    $fieldOptions['periodoDataTermino']['data'] = $periodoAcao->getDataTermino();
                    $fieldOptions['dadosMetaEstimada']['data'] = $acaoDados->getMetaEstimada();
                    $fieldOptions['dadosValorEstimado']['data'] = $acaoDados->getValorEstimado();
                }

                if ($acaoDados->getFkPpaAcaoRecursos()->count()) {
                    $ano = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
                    $total = 0;
                    foreach ($acaoDados->getFkPpaAcaoRecursos() as $fkPpaAcaoRecurso) {
                        $fontesRecurso[(string) $fkPpaAcaoRecurso->getFkOrcamentoRecurso()][$fkPpaAcaoRecurso->getAno()] = $fkPpaAcaoRecurso;
                        $ano[$fkPpaAcaoRecurso->getAno()] += $fkPpaAcaoRecurso->getValor();
                        $total += $fkPpaAcaoRecurso->getValor();
                    }
                    $fontesRecursoTotais = array(
                        'ano1' => $ano[1],
                        'ano2' => $ano[2],
                        'ano3' => $ano[3],
                        'ano4' => $ano[4],
                        'total' => $total
                    );
                }
            }
        }

        $formMapper->with('label.ppaAcao.dadosAcao');
        $formMapper->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false]);
        $formMapper->add('tipoTipoAcao', 'choice', $fieldOptions['tipoTipoAcao']);
        $formMapper->add('dadosCodNatureza', 'choice', $fieldOptions['dadosCodNatureza']);
        $formMapper->add('ppa', 'entity', $fieldOptions['ppa']);
        $formMapper->add('fkPpaPrograma', null, $fieldOptions['fkPpaPrograma']);
        $formMapper->add('dadosTipoAcao', 'entity', $fieldOptions['dadosTipoAcao']);
        $formMapper->add('numAcao', null, $fieldOptions['numAcao']);
        $formMapper->add('dadosTitulo', 'textarea', $fieldOptions['dadosTitulo']);
        $formMapper->add('dadosFinalidade', 'textarea', $fieldOptions['dadosFinalidade']);
        $formMapper->add('dadosDescricao', 'textarea', $fieldOptions['dadosDescricao']);
        $formMapper->add('dadosDetalhamento', 'textarea', $fieldOptions['dadosDetalhamento']);
        $formMapper->add('dadosCodForma', 'choice', $fieldOptions['dadosCodForma']);
        $formMapper->add('dadosCodRegiao', 'entity', $fieldOptions['dadosCodRegiao']);
        $formMapper->add('dadosCodProduto', 'entity', $fieldOptions['dadosCodProduto']);
        $formMapper->add('normaCodNorma', 'autocomplete', $fieldOptions['normaCodNorma']);
        $formMapper->add('dadosCodTipoOrcamento', 'choice', $fieldOptions['dadosCodTipoOrcamento']);
        $formMapper->add('dadosCodFuncao', 'entity', $fieldOptions['dadosCodFuncao']);
        $formMapper->add('dadosCodSubfuncao', 'entity', $fieldOptions['dadosCodSubfuncao']);
        $formMapper->add('dadosCodUnidadeMedida', 'entity', $fieldOptions['dadosCodUnidadeMedida']);
        $formMapper->end();
        $formMapper->with('label.ppaAcao.acaoPeriodo');
        $formMapper->add('periodoDataInicio', 'sonata_type_date_picker', $fieldOptions['periodoDataInicio']);
        $formMapper->add('periodoDataTermino', 'sonata_type_date_picker', $fieldOptions['periodoDataTermino']);
        $formMapper->add('dadosValorEstimado', 'money', $fieldOptions['dadosValorEstimado']);
        $formMapper->add('dadosMetaEstimada', 'money', $fieldOptions['dadosMetaEstimada']);
        $formMapper->end();

        $utilizaFontesRecurso = (new Model\Administracao\ConfiguracaoModel($em))
            ->utilizaFontesRecurso($this->getExercicio());

        if ($utilizaFontesRecurso) {
            $fieldOptions['codRecurso'] = [
                'label' => 'label.ppaAcao.recurso',
                'class' => Entity\Orcamento\Recurso::class,
                'required' => false,
                'mapped' => false,
                'placeholder' => 'label.selecione',
                'choice_value' => 'codRecurso',
                'query_builder' => function ($em) use ($exercicio) {
                    $qb = $em->createQueryBuilder('o');
                    $qb->where('o.exercicio = :exercicio');
                    $qb->setParameter('exercicio', $exercicio);
                    $qb->orderBy('o.codRecurso', 'ASC');
                    return $qb;
                },
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ];

            $fieldOptions['valor1'] = [
                'label' => 'label.ppaAcao.valor1',
                'required' => false,
                'mapped' => false,
                'grouping' => false,
                'currency' => 'BRL',
                'data' => 0,
                'attr' => [
                    'class' => 'mask-monetaria recurso-valores '
                ]
            ];

            $fieldOptions['valor2'] = [
                'label' => 'label.ppaAcao.valor2',
                'required' => false,
                'mapped' => false,
                'grouping' => false,
                'currency' => 'BRL',
                'data' => 0,
                'attr' => [
                    'class' => 'mask-monetaria recurso-valores '
                ]
            ];

            $fieldOptions['valor3'] = [
                'label' => 'label.ppaAcao.valor3',
                'required' => false,
                'mapped' => false,
                'grouping' => false,
                'currency' => 'BRL',
                'data' => 0,
                'attr' => [
                    'class' => 'mask-monetaria recurso-valores '
                ]
            ];

            $fieldOptions['valor4'] = [
                'label' => 'label.ppaAcao.valor4',
                'mapped' => false,
                'required' => false,
                'grouping' => false,
                'currency' => 'BRL',
                'data' => 0,
                'attr' => [
                    'class' => 'mask-monetaria recurso-valores '
                ]
            ];

            $fieldOptions['fontesRecurso'] = array(
                'label' => false,
                'mapped' => false,
                'template' => 'FinanceiroBundle::Ppa/Acao/fontesRecurso.html.twig',
                'data' => array(
                    'fontesRecurso' => $fontesRecurso,
                    'totais' => $fontesRecursoTotais
                )
            );

            $formMapper->with('label.ppaAcao.fonteRecurso');
            $formMapper->add('codRecurso', 'entity', $fieldOptions['codRecurso']);
            $formMapper->add('valor1', 'money', $fieldOptions['valor1']);
            $formMapper->add('valor2', 'money', $fieldOptions['valor2']);
            $formMapper->add('valor3', 'money', $fieldOptions['valor3']);
            $formMapper->add('valor4', 'money', $fieldOptions['valor4']);
            $formMapper->add('fontesRecurso', 'customField', $fieldOptions['fontesRecurso']);
            $formMapper->end();
        }

        $formMapper->with('label.ppaAcao.unidadeExecutora');
        $formMapper->add('unidadeExecutoraCodOrgao', 'entity', $fieldOptions['unidadeExecutoraCodOrgao']);
        $formMapper->add('unidadeExecutoraCodUnidade', 'entity', $fieldOptions['unidadeExecutoraCodUnidade']);
        $formMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if (!$this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $acaoModel = new Model\Ppa\AcaoModel($em);
            $exercicio = $this->getExercicio();

            $tipoAcao = $this->getForm()->get('dadosTipoAcao')->getData();

            $numAcao = $acaoModel->verificaNumAcaoByCodTipo($tipoAcao->getCodTipo(), $exercicio, $object->getNumAcao());
            $codigoComposto = str_pad($object->getNumAcao(), 4, '0', STR_PAD_LEFT);

            if (!$numAcao) {
                $error = $this->getTranslator()->trans('label.ppaAcao.erroCodigoTipoAcao', ['%codigo%' => $codigoComposto]);
                $errorElement->with('numAcao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }

            $repository = $em->getRepository('CoreBundle:Ppa\Acao');
            $qb = $repository->createQueryBuilder('o');
            $qb->where($qb->expr()->orX(
                $qb->expr()->eq('o.codAcao', ':numAcao'),
                $qb->expr()->eq('o.numAcao', ':numAcao')
            ));
            $qb->setParameter('numAcao', $object->getNumAcao());
            $result = $qb->getQuery()->getResult();

            if (count($result)) {
                $error = $this->getTranslator()->trans('label.ppaAcao.erroCodigoEmUso', ['%codigo%' => $codigoComposto]);
                $errorElement->with('numAcao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }

        $ppa = $this->getForm()->get('ppa')->getData();
        $anoInicio = $this->getForm()->get('periodoDataInicio')->getData();
        $anoTermino = $this->getForm()->get('periodoDataTermino')->getData();
        if (($anoInicio) && ($anoTermino)) {
            $ppa = $object->getFkPpaPrograma()->getFkPpaProgramaSetorial()->getFkPpaMacroObjetivo()->getFkPpaPpa();

            $ppaAnoInicio = (int) $ppa->getAnoInicio();
            $ppaAnoTermino = (int) $ppa->getAnoFinal();

            if ($anoTermino < $anoInicio) {
                $error = $this->getTranslator()->trans('label.ppaAcao.erroDataTermino');
                $errorElement->with('periodoDataTermino')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            } elseif (((int) $anoInicio->format('Y') < $ppaAnoInicio) || ((int) $anoTermino->format('Y') > $ppaAnoTermino)) {
                $error = $this->getTranslator()->trans('label.ppaAcao.erroPeriodo');
                $errorElement->with('periodoDataInicio')->addViolation($error)->end();
                $errorElement->with('periodoDataTermino')->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $object->setCodAcao($object->getNumAcao());
        $programa = $object->getFkPpaPrograma();
        $programaDados = $em->getRepository('CoreBundle:Ppa\ProgramaDados')
            ->findOneBy([
                'codPrograma' => $programa->getCodPrograma(),
                'timestampProgramaDados' => $programa->getUltimoTimestampProgramaDados()
            ]);

        $continuo = $programaDados
            ? $programaDados->getContinuo()
            : false;

        $dataAtual = new DateTimeMicrosecondPK();
        $object->setUltimoTimestampAcaoDados($dataAtual);
        $em->persist($object);

        $titulo = $this->getForm()->get('dadosTitulo')->getData();
        $detalhamento = $this->getForm()->get('dadosDetalhamento')->getData();

        $acaoDados = new Entity\Ppa\AcaoDados();
        $acaoDados->setFkPpaAcao($object);
        $acaoDados->setTimestampAcaoDados($dataAtual);
        $acaoDados->setTitulo($titulo);
        $acaoDados->setDescricao($this->getForm()->get('dadosDescricao')->getData());
        $acaoDados->setFinalidade($this->getForm()->get('dadosFinalidade')->getData());
        $acaoDados->setDetalhamento($detalhamento);
        $acaoDados->setCodForma($this->getForm()->get('dadosCodForma')->getData());
        $acaoDados->setCodTipoOrcamento($this->getForm()->get('dadosCodTipoOrcamento')->getData());
        $acaoDados->setCodNatureza($this->getForm()->get('dadosCodNatureza')->getData());
        $acaoDados->setFkPpaRegiao($this->getForm()->get('dadosCodRegiao')->getData());
        $acaoDados->setFkAdministracaoUnidadeMedida($this->getForm()->get('dadosCodUnidadeMedida')->getData());
        $acaoDados->setFkOrcamentoFuncao($this->getForm()->get('dadosCodFuncao')->getData());
        $acaoDados->setFkOrcamentoSubfuncao($this->getForm()->get('dadosCodSubfuncao')->getData());
        $acaoDados->setFkPpaProduto($this->getForm()->get('dadosCodProduto')->getData());
        $acaoDados->setFkPpaTipoAcao($this->getForm()->get('dadosTipoAcao')->getData());
        $em->persist($acaoDados);

        $unidade = $this->getForm()->get('unidadeExecutoraCodUnidade')->getData();
        $orgao = $this->getForm()->get('unidadeExecutoraCodOrgao')->getData();
        $unidadeExecutora = $em->getRepository('CoreBundle:Orcamento\Unidade')
            ->findOneBy([
                'numOrgao' => $orgao->getNumOrgao(),
                'numUnidade' => $unidade->getNumUnidade(),
                'exercicio' => $this->getExercicio()
            ]);

        $acaoUnidadeExecutora = new Entity\Ppa\AcaoUnidadeExecutora();
        $acaoUnidadeExecutora->setFkOrcamentoUnidade($unidadeExecutora);
        $acaoDados->addFkPpaAcaoUnidadeExecutoras($acaoUnidadeExecutora);

        $codNorma = $this->getForm()->get('normaCodNorma')->getData();
        if (is_object($codNorma)) {
            $acaoNorma = new Entity\Ppa\AcaoNorma();
            $acaoNorma->setFkNormasNorma($codNorma);
            $acaoDados->addFkPpaAcaoNormas($acaoNorma);
        }

        $ppa = $programa->getFkPpaProgramaSetorial()->getFkPpaMacroObjetivo()->getFkPpaPpa();
        $anoInicio = (int) $ppa->getAnoInicio();
        $anoFinal = (int) $ppa->getAnoFinal();
        for ($ano = $anoInicio; $ano <= $anoFinal; $ano++) {
            $pao = new Entity\Orcamento\Pao();
            $pao->setNumPao($object->getCodAcao());
            $pao->setExercicio((string) $ano);
            $pao->setNomPao($titulo);
            $pao->setDetalhamento($detalhamento);

            $paoPpaAcao = new Entity\Orcamento\PaoPpaAcao();
            $paoPpaAcao->setFkOrcamentoPao($pao);
            $object->addFkOrcamentoPaoPpaAcoes($paoPpaAcao);
        }

        $dataInicio = $this->getForm()->get('periodoDataInicio')->getData();
        $dataTermino = $this->getForm()->get('periodoDataTermino')->getData();
        if (((!$continuo) && ($acaoDados->getCodTipo() == 1)) && (($dataInicio != null) || ($dataTermino != null))) {
            $acaoPeriodo = new Entity\Ppa\AcaoPeriodo();
            $acaoPeriodo->setCodAcao($acaoDados);
            $acaoPeriodo->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
            $acaoPeriodo->setDataInicio($dataInicio);
            $acaoPeriodo->setDataTermino($dataTermino);

            $acaoDados->setFkPpaAcaoPeriodo($acaoPeriodo);
            $acaoDados->setValorEstimado((float) $this->getForm()->get('dadosValorEstimado')->getData());
            $acaoDados->setMetaEstimada((float) $this->getForm()->get('dadosMetaEstimada')->getData());
        } else {
            $acaoDados->setValorEstimado(0);
            $acaoDados->setMetaEstimada(0);
        }

        if (count($this->request->get('acaoRecurso'))) {
            foreach ($this->request->get('acaoRecurso') as $key => $items) {
                $ppa = (new Model\Orcamento\OrgaoModel($em))
                    ->getPpaByExercicio($this->getExercicio());
                $ano = 1;
                for ($exercicio = (int) $ppa->getAnoInicio(); $exercicio <= (int) $ppa->getAnoFinal(); $exercicio++) {
                    $recurso = $em->getRepository(Entity\Orcamento\Recurso::class)
                        ->findOneBy(
                            array(
                                'exercicio' => $exercicio,
                                'codRecurso' => $key
                            )
                        );

                    $newAcaoRecurso = new Entity\Ppa\AcaoRecurso();
                    $newAcaoRecurso->setFkOrcamentoRecurso($recurso);
                    $newAcaoRecurso->setAno($ano);
                    $newAcaoRecurso->setValor((float) $items['valor' . $ano]);
                    $newAcaoRecurso->setFkPpaAcaoDados($acaoDados);

                    $newAcaoQuantidade = new Entity\Ppa\AcaoQuantidade();
                    $newAcaoQuantidade->setValor((float) $items['valor' . $ano]);
                    $newAcaoQuantidade->setQuantidade((float) $items['quantidade' . $ano]);

                    $newAcaoRecurso->setFkPpaAcaoQuantidade($newAcaoQuantidade);

                    $acaoDados->addFkPpaAcaoRecursos($newAcaoRecurso);
                    $ano++;
                }
            }
        }

        $object->addFkPpaAcaoDados($acaoDados);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $programa = $object->getFkPpaPrograma();
        $programaDados = $em->getRepository('CoreBundle:Ppa\ProgramaDados')
            ->findOneBy([
                'codPrograma' => $programa->getCodPrograma(),
                'timestampProgramaDados' => $programa->getUltimoTimestampProgramaDados()
            ]);
        $continuo = true;
        if ($programaDados) {
            $continuo = $programaDados->getContinuo();
        }

        $dataAtual = new DateTimeMicrosecondPK();
        $object->setUltimoTimestampAcaoDados($dataAtual);

        $titulo = $this->getForm()->get('dadosTitulo')->getData();
        $detalhamento = $this->getForm()->get('dadosDetalhamento')->getData();

        $paoPpaAcoes = $object->getFkOrcamentoPaoPpaAcoes();
        foreach ($paoPpaAcoes as $paoPpaAcao) {
            $pao = $paoPpaAcao->getFkOrcamentoPao();
            $pao->setNomPao($titulo);
            $pao->setDetalhamento($detalhamento);
        }

        $acaoDados = new Entity\Ppa\AcaoDados();
        $acaoDados->setFkPpaAcao($object);
        $acaoDados->setTimestampAcaoDados($dataAtual);
        $acaoDados->setTitulo($titulo);
        $acaoDados->setDescricao($this->getForm()->get('dadosDescricao')->getData());
        $acaoDados->setFinalidade($this->getForm()->get('dadosFinalidade')->getData());
        $acaoDados->setDetalhamento($detalhamento);
        $acaoDados->setCodForma($this->getForm()->get('dadosCodForma')->getData());
        $acaoDados->setCodTipoOrcamento($this->getForm()->get('dadosCodTipoOrcamento')->getData());
        $acaoDados->setCodNatureza($this->getForm()->get('dadosCodNatureza')->getData());
        $acaoDados->setFkPpaRegiao($this->getForm()->get('dadosCodRegiao')->getData());
        $acaoDados->setFkAdministracaoUnidadeMedida($this->getForm()->get('dadosCodUnidadeMedida')->getData());
        $acaoDados->setFkOrcamentoFuncao($this->getForm()->get('dadosCodFuncao')->getData());
        $acaoDados->setFkOrcamentoSubfuncao($this->getForm()->get('dadosCodSubfuncao')->getData());
        $acaoDados->setFkPpaProduto($this->getForm()->get('dadosCodProduto')->getData());
        $acaoDados->setFkPpaTipoAcao($object->getFkPpaAcaoDados()->first()->getFkPpaTipoAcao());
        $em->persist($acaoDados);

        $unidade = $this->getForm()->get('unidadeExecutoraCodUnidade')->getData();
        $orgao = $this->getForm()->get('unidadeExecutoraCodOrgao')->getData();
        $unidadeExecutora = $em->getRepository('CoreBundle:Orcamento\Unidade')
            ->findOneBy([
                'numOrgao' => $orgao->getNumOrgao(),
                'numUnidade' => $unidade->getNumUnidade(),
                'exercicio' => $this->getExercicio()
            ]);

        $acaoUnidadeExecutora = new Entity\Ppa\AcaoUnidadeExecutora();
        $acaoUnidadeExecutora->setFkOrcamentoUnidade($unidadeExecutora);
        $acaoDados->addFkPpaAcaoUnidadeExecutoras($acaoUnidadeExecutora);

        $codNorma = $this->getForm()->get('normaCodNorma')->getData();
        if (is_object($codNorma)) {
            $acaoNorma = new Entity\Ppa\AcaoNorma();
            $acaoNorma->setFkNormasNorma($codNorma);
            $acaoDados->addFkPpaAcaoNormas($acaoNorma);
        }

        $dataInicio = $this->getForm()->get('periodoDataInicio')->getData();
        $dataTermino = $this->getForm()->get('periodoDataTermino')->getData();
        if (((!$continuo) && ($acaoDados->getCodTipo() == 1)) && (($dataInicio != null) || ($dataTermino != null))) {
            $acaoPeriodo = new Entity\Ppa\AcaoPeriodo();
            $acaoPeriodo->setCodAcao($acaoDados);
            $acaoPeriodo->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
            $acaoPeriodo->setDataInicio($dataInicio);
            $acaoPeriodo->setDataTermino($dataTermino);

            $acaoDados->setFkPpaAcaoPeriodo($acaoPeriodo);
            $acaoDados->setValorEstimado((float) $this->getForm()->get('dadosValorEstimado')->getData());
            $acaoDados->setMetaEstimada((float) $this->getForm()->get('dadosMetaEstimada')->getData());
        } else {
            $acaoDados->setValorEstimado(0);
            $acaoDados->setMetaEstimada(0);
        }
        
        $acaoRecursoArr = $this->request->get('acaoRecurso');
        
        if (count($acaoRecursoArr)) {
            // LIMPA DADOS QUE NÃO MAIS UTILIZADOS
            $acaoRecursoRepo = $em->getRepository(Entity\Ppa\AcaoRecurso::class);
            $toKeep = [];
            foreach ($acaoRecursoArr as $key => $items) {
                if (isset($items['old'])) {
                    list($codAcao, $timestampAcaoDados, $codRecurso) = explode('~', $items['old']);
                    $toKeep[] = ['acao' => $codAcao, 'recurso' => $codRecurso];
                }
            }
            if (count($toKeep)) {
                $qb = $em->createQueryBuilder();
                $qb->select('ar.codAcao, ar.codRecurso, ar.timestampAcaoDados, ar.exercicioRecurso, ar.ano')
                ->from(Entity\Ppa\AcaoRecurso::class, 'ar')
                ->where('ar.codAcao = :codAcao');
                $qb->setParameter('codAcao', $toKeep[0]['acao']);
                for ($i = 0; $i < count($toKeep);$i++) {
                    $qb->andWhere("ar.codRecurso <> :recurso{$i}");
                    $qb->setParameter("recurso{$i}", $toKeep[$i]['recurso']);
                }
                $query = $qb->getQuery();
                $toDelete = $query->execute();
                
                foreach ($toDelete as $delete) {
                    $acaoRecurso = $acaoRecursoRepo
                        ->findOneBy(
                            [
                                'codAcao' => $delete['codAcao'],
                                'timestampAcaoDados' => $delete['timestampAcaoDados'],
                                'codRecurso' => $delete['codRecurso'],
                                'ano' => $delete['ano']
                            ]
                        )
                    ;
                    $em->remove($acaoRecurso);
                    $em->flush();
                }
            }
            
            foreach ($acaoRecursoArr as $key => $items) {
                $ppa = (new Model\Orcamento\OrgaoModel($em))
                    ->getPpaByExercicio($this->getExercicio());
                $ano = 1;
                for ($exercicio = (int) $ppa->getAnoInicio(); $exercicio <= (int) $ppa->getAnoFinal(); $exercicio++) {
                    // UPDATE DOS DADOS
                    if (isset($items['old'])) {
                        list($codAcao, $timestampAcaoDados, $codRecurso) = explode('~', $items['old']);
                        $acaoRecurso = $acaoRecursoRepo
                            ->findOneBy(
                                [
                                    'codAcao' => $codAcao,
                                    'timestampAcaoDados' => $timestampAcaoDados,
                                    'codRecurso' => $codRecurso,
                                    'ano' => $ano
                                ]
                            )
                        ;
                        $newAcaoRecurso = new Entity\Ppa\AcaoRecurso();
                        $newAcaoRecurso->setFkOrcamentoRecurso($acaoRecurso->getFkOrcamentoRecurso());
                        $newAcaoRecurso->setAno($ano);
                        $newAcaoRecurso->setValor($acaoRecurso->getValor());
                        $newAcaoRecurso->setFkPpaAcaoDados($acaoDados);

                        $newAcaoQuantidade = new Entity\Ppa\AcaoQuantidade();
                        $newAcaoQuantidade->setValor($acaoRecurso->getFkPpaAcaoQuantidade()->getValor());
                        $newAcaoQuantidade->setQuantidade($acaoRecurso->getFkPpaAcaoQuantidade()->getQuantidade());
                        $newAcaoRecurso->setFkPpaAcaoQuantidade($newAcaoQuantidade);
                        $em->persist($newAcaoRecurso);

                        if ($acaoRecurso->getFkPpaAcaoQuantidade()->getFkLdoAcaoValidada()) {
                            $newAcaoValidada = new Entity\Ldo\AcaoValidada();
                            $newAcaoValidada->setValor(floatval($acaoRecurso->getFkPpaAcaoQuantidade()->getValor()));
                            $newAcaoValidada->setQuantidade($acaoRecurso->getFkPpaAcaoQuantidade()->getQuantidade());
                            $newAcaoQuantidade->setFkLdoAcaoValidada($newAcaoValidada);
                        }
                        $em->remove($acaoRecurso);
                        $em->flush();
                    } else {
                        // INSERE NOVOS DADOS
                        $recurso = $em->getRepository(Entity\Orcamento\Recurso::class)
                            ->findOneBy(
                                [
                                    'exercicio' => $exercicio,
                                    'codRecurso' => $key
                                ]
                            )
                        ;
                        $newAcaoRecurso = new Entity\Ppa\AcaoRecurso();
                        $newAcaoRecurso->setFkOrcamentoRecurso($recurso);
                        $newAcaoRecurso->setAno($ano);
                        $newAcaoRecurso->setValor((float) $items['valor' . $ano]);
                        $newAcaoRecurso->setFkPpaAcaoDados($acaoDados);

                        $newAcaoQuantidade = new Entity\Ppa\AcaoQuantidade();
                        $newAcaoQuantidade->setValor((float) $items['valor' . $ano]);
                        $newAcaoQuantidade->setQuantidade((float) $items['quantidade' . $ano]);

                        $newAcaoRecurso->setFkPpaAcaoQuantidade($newAcaoQuantidade);
                    }

                    $acaoDados->addFkPpaAcaoRecursos($newAcaoRecurso);

                    $ano++;
                }
            }
        }
        $object->addFkPpaAcaoDados($acaoDados);
    }
}
