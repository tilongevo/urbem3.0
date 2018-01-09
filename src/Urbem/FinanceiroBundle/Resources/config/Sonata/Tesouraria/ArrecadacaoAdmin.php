<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutora;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\Autenticacao;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ArrecadacaoAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria
 */
class ArrecadacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_arrecadacao_orcamentaria_arrecadacoes';
    protected $baseRoutePattern = 'financeiro/tesouraria/arrecadacao/orcamentaria-arrecadacoes';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/arrecadacao/arrecadacao.js');
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];
    protected $exibirBotaoExcluir = false;
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;

    const MODULO = 9;
    const PARAMETRO = 'utilizar_encerramento_mes';
    const SITUACAO = 'F';
    const TIPO_AUTENTICACAO = 'A ';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('boletim', 'boletim', array(), array(), array(), '', array(), array('POST'));
        $collection->add('receita', 'receita', array(), array(), array(), '', array(), array('POST'));
        $collection->add('conta_deducao', 'conta-deducao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('conta', 'conta', array(), array(), array(), '', array(), array('POST'));
        $collection->add('emissao', $this->getRouterIdParameter() . '/emissao');
        $collection->remove('show');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $aEstornar = $repository->getArrecadacaoEstornar();

        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->andWhere($query->expr()->in("o.codArrecadacao", $aEstornar));
        $query->setParameter('exercicio', $exercicio);
        $query->orderBy('codOrdem', 'DESC');
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.arrecadacao.entidade'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                    'multiple' => true,
                    'attr' => [
                        'required' => true
                    ]
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add('dtInicio', 'doctrine_orm_callback', ['label' => 'label.arrecadacao.dtInicio', 'callback' => array($this, 'getSearchFilter')], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add('dtFim', 'doctrine_orm_callback', ['label' => 'label.arrecadacao.dtFim', 'callback' => array($this, 'getSearchFilter')], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add('exercicio', null, ['label' => 'label.arrecadacao.ano'])
            ->add('codBoletim', null, ['label' =>  'label.arrecadacao.nrBoletim'])
            ->add('fkTesourariaBoletim.dtBoletim', null, ['label' => 'label.arrecadacao.dtBoletim'], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add(
                'fkContabilidadePlanoAnalitica',
                'composite_filter',
                [
                    'label' => 'label.arrecadacao.conta'
                ],
                null,
                [
                    'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                    'required' => true,
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('pa');
                        $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                        $qb->andWhere('pc.exercicio = :exercicio');
                        $qb->andWhere($qb->expr()->orX(
                            $qb->expr()->like('pc.codEstrutural', "'1.1.1.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'1.1.4.%'")
                        ));
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('pc.codEstrutural', 'ASC');
                        return $qb;
                    },
                ],
                ['admin_code' => 'financeiro.admin.conciliar_conta']
            )
            ->add(
                'fkTesourariaArrecadacaoReceitas.fkOrcamentoReceita',
                'composite_filter',
                [
                    'label' => 'label.arrecadacao.receita'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Receita',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.codReceita', 'ASC');
                        return $qb;
                    },
                ]
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!isset($filter['fkTesourariaArrecadacaoReceitas__fkOrcamentoReceita'])) {
            $queryBuilder->andWhere('1 = 0');
        }

        if (!count($value['value'])) {
            return;
        }

        if ($filter['dtInicio']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.dtAutenticacao >= :dtInicio");
            $queryBuilder->setParameter('dtInicio', $filter['dtInicio']['value']);
        }

        if ($filter['dtFim']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.dtAutenticacao <= :dtFim");
            $queryBuilder->setParameter('dtFim', $filter['dtFim']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm());

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/arrecadacao/permissao');
        }

        $listMapper
            ->add('fkEntidade.codEntidade', null, [
                'label' => 'label.arrecadacao.entidade'
            ])
            ->add('fkContabilidadePlanoAnalitica.codPlano', 'text', [
                'label' => 'label.arrecadacao.conta'
            ])
            ->add('fkTesourariaArrecadacaoReceitas', null, [
                'label' => 'label.arrecadacao.receita'
            ])
            ->add('fkTesourariaBoletim.dtBoletim', null, [
                'label' => 'label.arrecadacao.data'
            ])
            ->add('getValorArrecadado', 'currency', [
                'label' => 'label.arrecadacao.valorArrecadado',
                'currency' => 'BRL'
            ])
            ->add('getValorEstornado', 'currency', [
                'label' => 'label.arrecadacao.valorEstornado',
                'currency' => 'BRL'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'estornar' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/Arrecadacao/CRUD:list__action_estornar.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $usuario = $container->get('security.token_storage')->getToken()->getUser()->getFkSwCgm();
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm());

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/arrecadacao/permissao');
        }

        $fieldOptions = array();

        $fieldOptions['edit'] = [
            'mapped' => false,
            'data' => 0
        ];

        $fieldOptions['exercicio'] = [
            'mapped' => false,
            'data' => $exercicio
        ];

        $fieldOptions['codBoletim'] = [
            'mapped' => false
        ];

        $fieldOptions['codEntidade'] = [
            'mapped' => false
        ];

        $fieldOptions['codReceita'] = [
            'mapped' => false
        ];

        $fieldOptions['codContaDeducao'] = [
            'mapped' => false
        ];

        $fieldOptions['codConta'] = [
            'mapped' => false
        ];

        $fieldOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.arrecadacao.entidade',
            'choice_value' => 'codEntidade',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkTesourariaBoletim'] = [
            'label' => 'label.arrecadacao.boletim',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'choice_value' => 'codBoletim',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['receita'] = [
            'label' => 'label.arrecadacao.receita',
            'class' => 'CoreBundle:Orcamento\Receita',
            'choice_value' => 'codReceita',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['contaDeducao'] = [
            'label' => 'label.arrecadacao.contaDeducao',
            'class' => 'CoreBundle:Orcamento\Receita',
            'choice_value' => 'codReceita',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['valorDeducao'] = [
            'label' => 'label.arrecadacao.valorDeducao',
            'currency' => 'BRL',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkContabilidadePlanoAnalitica'] = [
            'label' => 'label.arrecadacao.conta',
            'choice_value' => 'codPlano',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('pc.codEstrutural', "'1.1.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.1.4.%'")
                ));
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.arrecadacao.valor',
            'currency' => 'BRL',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['codigoBarrasOptica'] = [
            'label' => 'label.arrecadacao.codigoBarrasOptica',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codigoBarras'] = [
            'label' => 'label.arrecadacao.codigoBarras',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['observacao'] = ['label' => 'label.arrecadacao.observacao'];

        $arrecadacaoReceitaDedutora = null;
        if ($this->id($this->getSubject())) {
            $this->legendButtonSave = ['icon' => 'reply', 'text' => 'Estornar'];
            $fieldOptions['edit']['data'] = 1;

            $arrecadacao = $this->getSubject();

            $arrecadacaoEstornadas = $arrecadacao->getFkTesourariaArrecadacaoEstornadas();
            $valorEstornado = 0.00;
            foreach ($arrecadacaoEstornadas as $arrecadacaoEstornada) {
                $valorEstornado += $arrecadacaoEstornada->getFkTesourariaArrecadacaoEstornadaReceita()->getVlEstornado();
            }

            $arrecadacaoReceita = $arrecadacao->getFkTesourariaArrecadacaoReceitas()->last();
            $valorEstornar = $arrecadacaoReceita->getVlArrecadacao() - $valorEstornado;

            $fieldOptions['fkTesourariaBoletim']['mapped'] = false;
            $fieldOptions['codEntidade']['data'] = $arrecadacao->getCodEntidade();
            $fieldOptions['codReceita']['data'] = $arrecadacaoReceita->getCodReceita();

            $fieldOptions['valor']['data'] = $arrecadacaoReceita->getVlArrecadacao();
            $fieldOptions['valor']['label'] = 'label.arrecadacao.valorArrecadado';
            if ($arrecadacaoReceita->getfkTesourariaArrecadacaoReceitaDedutoras()->last()) {
                $arrecadacaoReceitaDedutora = $arrecadacaoReceita->getfkTesourariaArrecadacaoReceitaDedutoras()->last();
                $fieldOptions['codContaDeducao']['data'] = $arrecadacaoReceitaDedutora->getCodReceitaDedutora();
                $fieldOptions['valorDeducao']['data'] = $arrecadacaoReceitaDedutora->getVlDeducao();
            }

            $fieldOptions['fkContabilidadePlanoAnalitica']['mapped'] = false;
            $fieldOptions['fkContabilidadePlanoAnalitica']['disabled'] = true;
            $fieldOptions['fkContabilidadePlanoAnalitica']['data'] = $arrecadacao->getFkContabilidadePlanoAnalitica();

            $fieldOptions['observacao']['mapped'] = false;
            $fieldOptions['observacao']['disabled'] = true;
            $fieldOptions['observacao']['data'] = $arrecadacao->getObservacao();
        }

        $formMapper->with('label.arrecadacao.dados');
        $formMapper->add('edit', 'hidden', $fieldOptions['edit']);
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('codBoletim', 'hidden', $fieldOptions['codBoletim']);
        $formMapper->add('codEntidade', 'hidden', $fieldOptions['codEntidade']);
        $formMapper->add('codReceita', 'hidden', $fieldOptions['codReceita']);
        $formMapper->add('codConta', 'hidden', $fieldOptions['codConta']);
        $formMapper->add('codContaDeducao', 'hidden', $fieldOptions['codContaDeducao']);
        $formMapper->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade']);
        $formMapper->add('fkTesourariaBoletim', null, $fieldOptions['fkTesourariaBoletim']);

        if (!$this->id($this->getSubject())) {
            $formMapper->add('codigoBarrasOptica', 'text', $fieldOptions['codigoBarrasOptica']);
            $formMapper->add('codigoBarras', 'text', $fieldOptions['codigoBarras']);
        }

        $formMapper->add('receita', 'entity', $fieldOptions['receita']);
        $formMapper->add('contaDeducao', 'entity', $fieldOptions['contaDeducao']);
        $formMapper->add('valorDeducao', 'money', $fieldOptions['valorDeducao']);
        $formMapper->add('fkContabilidadePlanoAnalitica', null, $fieldOptions['fkContabilidadePlanoAnalitica'], ['admin_code' => 'financeiro.admin.conciliar_conta']);
        $formMapper->add('valor', 'money', $fieldOptions['valor']);

        if ($this->id($this->getSubject())) {
            $formMapper->add('valorEstornado', 'money', [
                'label' => 'label.arrecadacao.valorEstornado',
                'currency' => 'BRL',
                'data' => $valorEstornado,
                'mapped' => false,
                'disabled' => true,
                'attr' => [
                    'class' => 'money '
                ]
            ]);
        }

        $formMapper->add('observacao', null, $fieldOptions['observacao']);
        $formMapper->end();

        if (($this->id($this->getSubject())) &&  (!$arrecadacaoReceitaDedutora)) {
            $formMapper->with('label.arrecadacao.dadosEstorno');
            $formMapper->add('valorEstornar', 'money', [
                'label' => 'label.arrecadacao.valorEstornar',
                'currency' => 'BRL',
                'mapped' => false,
                'data' => $valorEstornar,
                'attr' => [
                    'class' => 'money '
                ]
            ]);
            $formMapper->end();
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();

        $utilizarEncerramentoMes = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => self::MODULO,
                'parametro' => self::PARAMETRO,
                'exercicio' => $exercicio,
            ]);
        if ($utilizarEncerramentoMes) {
            $utilizarEncerramentoMes = $utilizarEncerramentoMes->getValor();
        }

        if ($utilizarEncerramentoMes == "true") {
            $encerramentoMes = $em->getRepository('CoreBundle:Contabilidade\EncerramentoMes')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'situacao' => self::SITUACAO
                ], ['timestamp' => 'DESC']);
            if ($encerramentoMes) {
                $encerramentoMes = $encerramentoMes->getMes();
            }
        }

        if (!$this->id($this->getSubject())) {
            if ($utilizarEncerramentoMes == "true") {
                if ($encerramentoMes >= date('m')) {
                    $mensagem = $this->getTranslator()->trans('label.arrecadacao.erroMesEncerramento');
                    $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }
            }

            $valor = $this->getForm()->get('valor')->getData();
            if ($valor <= 0) {
                $mensagem = $this->getTranslator()->trans('label.arrecadacao.erroValor');
                $errorElement->with('valor')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        } else {
            $arrecadacaoReceita = $object->getFkTesourariaArrecadacaoReceitas()->last();
            $arrecadacaoReceitaDedutora = $arrecadacaoReceita->getFkTesourariaArrecadacaoReceitaDedutoras();
            if (!$arrecadacaoReceitaDedutora->count()) {
                $valorArrecadado = $arrecadacaoReceita->getVlArrecadacao();
                $arrecadacoesEstornada = $object->getFkTesourariaArrecadacaoEstornadas();
                $valorEstornado = 0.00;
                if ($arrecadacoesEstornada->count()) {
                    foreach ($arrecadacoesEstornada as $arrecadacaoEstornada) {
                        $valorEstornado += $arrecadacaoEstornada->getFkTesourariaArrecadacaoEstornadaReceita()->getVlEstornado();
                    }
                }

                $valorDisponivel = $valorArrecadado - $valorEstornado;

                $valorEstornar = $this->getForm()->get('valorEstornar')->getData();

                if ($valorEstornar <= 0) {
                    $mensagem = $this->getTranslator()->trans('label.arrecadacao.erroValorEstornar');
                    $errorElement->with('valorEstornar')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }

                if ($valorEstornar > $valorDisponivel) {
                    $mensagem = $this->getTranslator()->trans('label.arrecadacao.erroValorSuperior');
                    $errorElement->with('valorEstornar')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }
            }
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codEntidade = $this->getForm()->get('codEntidade')->getData();
        $codBoletim = $this->getForm()->get('codBoletim')->getData();

        $boletim = $em->getRepository('CoreBundle:Tesouraria\Boletim')
            ->findOneBy([
                'codBoletim' => $codBoletim,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);
        $object->setFkTesourariaBoletim($boletim);

        $entidade = $object->getFkTesourariaBoletim()->getFkOrcamentoEntidade();
        $object->setFkOrcamentoEntidade($entidade);

        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $codArrecadacao = $repository->getCodArrecadacao();
        $object->setCodArrecadacao($codArrecadacao);

        $dtBoletim = $object->getFkTesourariaBoletim()->getDtBoletim();
        $codAutenticadao = $repository->getCodAutenticacao($dtBoletim->format('d/m/Y'));
        $tipo = $em->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')->find('A ');

        $dateAutenticacao = new DateTimeMicrosecondPK($dtBoletim->format('Y-m-d'));

        $autenticacao = new Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticadao);
        $autenticacao->setDtAutenticacao($dateAutenticacao);
        $autenticacao->setFkTesourariaTipoAutenticacao($tipo);
        $object->setFkTesourariaAutenticacao($autenticacao);

        $container = $this->getConfigurationPool()->getContainer();

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        /**
         * @todo: Usuário Terminal
         */
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm(), array('codTerminal' => 'DESC'));
        $object->setFkTesourariaUsuarioTerminal($usuarioTerminal);

        $receita = $this->getForm()->get('receita')->getData();
        $vlArrecadacao = $this->getForm()->get('valor')->getData();

        $arrecadacaoReceita = new ArrecadacaoReceita();
        $arrecadacaoReceita->setFkTesourariaArrecadacao($object);
        $arrecadacaoReceita->setFkOrcamentoReceita($receita);
        $arrecadacaoReceita->setVlArrecadacao($vlArrecadacao);

        $receitaDedutora = $this->getForm()->get('contaDeducao')->getData();
        $vlDeducao = $this->getForm()->get('valorDeducao')->getData();
        if (!$vlDeducao) {
            $vlDeducao = 0.00;
        }
        if ($receitaDedutora) {
            $arrecadacaoReceitaDedutora = new ArrecadacaoReceitaDedutora();
            $arrecadacaoReceitaDedutora->setFkTesourariaArrecadacaoReceita($arrecadacaoReceita);
            $arrecadacaoReceitaDedutora->setFkOrcamentoReceita($receitaDedutora);
            $arrecadacaoReceitaDedutora->setVlDeducao($vlDeducao);
            $arrecadacaoReceita->addFkTesourariaArrecadacaoReceitaDedutoras($arrecadacaoReceitaDedutora);
        }
        $object->addFkTesourariaArrecadacaoReceitas($arrecadacaoReceita);

        if (!$object->getObservacao()) {
            $object->setObservacao('');
        }
    }

    public function postPersist($object)
    {
        $this->forceRedirect(sprintf('/financeiro/tesouraria/arrecadacao/orcamentaria-arrecadacoes/%s/emissao', $this->getObjectKey($object)));
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codEntidade = $this->getForm()->get('codEntidade')->getData();

        $codBoletim = $this->getForm()->get('codBoletim')->getData();
        $boletim = $em->getRepository('CoreBundle:Tesouraria\Boletim')
            ->findOneBy([
                'codBoletim' => $codBoletim,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);

        $arrecadacaoReceita = $object->getFkTesourariaArrecadacaoReceitas()->last();
        if (!$arrecadacaoReceita->getFkTesourariaArrecadacaoReceitaDedutoras()->count()) {
            $valorEstorno = $this->getForm()->get('valorEstornar')->getData();
        } else {
            $valorEstorno = $arrecadacaoReceita->getVlArrecadacao();
        }

        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $dtBoletim = $object->getFkTesourariaBoletim()->getDtBoletim();
        $codAutenticadao = $repository->getCodAutenticacao($dtBoletim->format('d/m/Y'));
        $tipo = $em->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')->find(self::TIPO_AUTENTICACAO);

        $dateAutenticacao = new DateTimeMicrosecondPK($dtBoletim->format('Y-m-d'));

        $autenticacao = new Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticadao);
        $autenticacao->setDtAutenticacao($dateAutenticacao);
        $autenticacao->setFkTesourariaTipoAutenticacao($tipo);
        $object->setFkTesourariaAutenticacao($autenticacao);

        /**
         * @todo: Usuário Terminal
         */
        $container = $this->getConfigurationPool()->getContainer();
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm(), array('codTerminal' => 'DESC'));

        $timestimpEstornada = new DateTimeMicrosecondPK();

        $arrecadacaoEstornada = new ArrecadacaoEstornada();
        $arrecadacaoEstornada->setFkTesourariaArrecadacao($object);
        $arrecadacaoEstornada->setTimestampEstornada($timestimpEstornada);
        $arrecadacaoEstornada->setFkTesourariaBoletim($boletim);
        $arrecadacaoEstornada->setFkTesourariaAutenticacao($autenticacao);
        $arrecadacaoEstornada->setFkTesourariaUsuarioTerminal($usuarioTerminal);
        $arrecadacaoEstornada->setObservacao('');

        $arrecadacaoEstornadaReceita = new ArrecadacaoEstornadaReceita();
        $arrecadacaoEstornadaReceita->setFkTesourariaArrecadacaoEstornada($arrecadacaoEstornada);
        $arrecadacaoEstornadaReceita->setFkTesourariaArrecadacaoReceita($arrecadacaoReceita);
        $arrecadacaoEstornadaReceita->setVlEstornado($valorEstorno);

        $arrecadacaoEstornada->setFkTesourariaArrecadacaoEstornadaReceita($arrecadacaoEstornadaReceita);
        if ($arrecadacaoReceita->getFkTesourariaArrecadacaoReceitaDedutoras()->count()) {
            $arrecadacaoReceitaDedutora = $arrecadacaoReceita->getFkTesourariaArrecadacaoReceitaDedutoras()->last();
            $arrecadacaoReceitaDedutoraEstornada = new ArrecadacaoReceitaDedutoraEstornada();
            $arrecadacaoReceitaDedutoraEstornada->setFkTesourariaArrecadacaoReceitaDedutora($arrecadacaoReceitaDedutora);
            $arrecadacaoReceitaDedutoraEstornada->setVlEstornado($arrecadacaoReceitaDedutora->getVlDeducao());
            $arrecadacaoEstornada->addFkTesourariaArrecadacaoReceitaDedutoraEstornadas($arrecadacaoReceitaDedutoraEstornada);
        }
        $object->addFkTesourariaArrecadacaoEstornadas($arrecadacaoEstornada);
    }
}
