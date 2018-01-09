<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil;
use Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoPlano;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso;
use Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Cheque;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Ppa\AcaoRecursoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class PlanoContaAdmin extends AbstractSonataAdmin
{
    const ESCRITURACAO_ANALITICA = 'analitica';
    const ESCRITURACAO_SINTETICA = 'sintetica';

    const NATUREZA_SALDO_CREDOR = 'credor';
    const NATUREZA_SALDO_DEVEDOR = 'devedor';

    protected $baseRouteName = 'urbem_contabilidade_planoconta';
    protected $baseRoutePattern = 'financeiro/contabilidade/planoconta';
    protected $includeJs = ['/financeiro/javascripts/contabilidade/planoconta.js'];
    const ACTION_EDIT = 'editAction';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('encerramento', 'encerramento/' . $this->getRouterIdParameter());
        $collection->add('cancela_encerramento', 'cancela-encerramento/' . $this->getRouterIdParameter());
    }

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'codConta'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $fieldOptions['codReduzido'] = array(
            'callback' => array($this, 'getSearchFilter'),
            'label'         => 'label.planoconta.codReduzido',
        );
        $datagridMapper
            ->add('codReduzido', 'doctrine_orm_callback', $fieldOptions['codReduzido'])
            ->add('codEstrutural', null, ['label' => 'label.planoconta.codEstrutural', 'sortable' => false])
            ->add('nomConta', null, ['label' => 'label.planoconta.nomConta', 'sortable' => false])
            ->add(
                'banco',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.planoconta.banco',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Monetario\Banco',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("e");
                    },
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'placeholder' => 'label.selecione',
                    'choice_label' => function ($banco) {
                        if ($banco) {
                            return $banco->getNomBanco();
                        }
                    },
                    'choice_value' => function ($banco) {
                        if ($banco) {
                            return $banco->getCodBanco();
                        }
                    },
                )
            )
            ->add(
                'agencia',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.planoconta.agencia',
                ),
                'choice',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'contaCorrente',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.planoconta.contaCorrente',
                ),
                'choice',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'recurso',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.planoconta.recurso',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Orcamento\Recurso',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("r")
                            ->where("r.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'placeholder' => 'label.selecione',
                    'choice_label' => function ($recurso) {
                        if ($recurso) {
                            return $recurso->getNomRecurso();
                        }
                    },
                    'choice_value' => function ($recurso) {
                        if ($recurso) {
                            return $recurso->getCodRecurso() . '-' . $recurso->getExercicio();
                        }
                    },
                )
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codPlanoContaList = (new \Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel($entityManager))
            ->filterPlanoConta($filter);

        $ids = array();
        foreach ($codPlanoContaList as $codPlanoConta) {
            $ids[] = $codPlanoConta->cod_conta;
        }

        if (count($codPlanoContaList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codConta", $ids));
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, ['label' => 'label.planoconta.codEstrutural'])
            ->add('nomConta', null, ['label' => 'label.planoconta.nomConta'])
        ;

        $this->addActionsGrid($listMapper);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq('o.exercicio', ':exercicio')
        );
        $query->setParameter('exercicio', $this->getExercicio());
        $query->leftJoin('CoreBundle:Contabilidade\PlanoBanco', 'b', 'WITH', 'o.codConta = b.codPlano');

        return $query;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'encerramento' => array('template' => 'FinanceiroBundle:Sonata/Acao/CRUD:list__action_encerramento.html.twig'),
                )
            ))
        ;
    }

    public function verificaEncerramento($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $planoContaEncerradaRepository = $em->getRepository('CoreBundle:Contabilidade\PlanoContaEncerrada');
        $planoContaEncerrada = $planoContaEncerradaRepository->findBy(
            array('exercicio' => $object->getExercicio(), 'codConta' => $object->getCodConta())
        );

        if (count($planoContaEncerrada) > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $emPlanoConta = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Contabilidade\PlanoConta');
        $planoContaModel = (new \Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel($emPlanoConta));

        $desabilitado = false;
        if ($this->isCurrentRoute('edit')) {
            $isContaDesdobrada =  $planoContaModel
               ->verificaContaDesdobrada($this->getExercicio(), $this->getSubject()->getCodEstrutural());
            $isContaMovimentacao = $planoContaModel
               ->verificaMovimentacaoConta($this->getExercicio(), $this->getSubject()->getCodEstrutural());
            if ($isContaDesdobrada->retorno || $isContaMovimentacao->retorno) {
                $desabilitado = true;
            }
        }

        $fieldOptions = array();
        $fieldType = array();

        $fieldOptions['escrituracao'] = array(
            'choices'       => [
                'label.planoconta.escrituracaoAnalitica'    => 'analitica',
                'label.planoconta.escrituracaoSintetica'     => 'sintetica'
            ],
            'required'      => true,
            'disabled'      => $desabilitado,
            'label'         => 'label.planoconta.escrituracao',
            'attr'          => [
                'class'    => 'select2-parameters'
            ],
        );
        $fieldOptions['naturezaSaldo'] = array(
            'choices'       => [
                'label.planoconta.naturezaSaldoCredor'    => 'credor',
                'label.planoconta.naturezaSaldoDevedor'     => 'devedor'
            ],
            'required'      => true,
            'label'         => 'label.planoconta.naturezaSaldo',
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );
        $posicaoReceitaRepository = $em->getRepository('CoreBundle:Orcamento\PosicaoReceita');
        $posicaoReceitas = $posicaoReceitaRepository->findBy(
            array('exercicio' => $this->getExercicio(), 'codTipo' => 1),
            array('codPosicao' => 'ASC')
        );
        $mascara = MascaraHelper::parseMascara($posicaoReceitas);

        $fieldOptions['codEstrutural'] = array(
            'required'      => true,
            'label'         => 'label.planoconta.codEstrutural',
        );
        $fieldOptions['mascara'] = array(
            'required'      => false,
            'data' => $mascara,
            'mapped' => false
        );
        $fieldOptions['nomConta'] = array(
            'required'      => true,
            'label'         => 'label.planoconta.nomConta'
        );
        $fieldOptions['funcao'] = array(
            'required'      => false,
            'label'         => 'label.planoconta.funcao'
        );
        $emSistema = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil');
        $fieldOptions['codSistema'] = array(
            'label'         => 'label.planoconta.codSistema',
            'mapped'        => false,
            'required'      => true,
            'class'         => 'CoreBundle:Contabilidade\\SistemaContabil',
            'choices'       => $emSistema->getRepository('CoreBundle:Contabilidade\\SistemaContabil')->findByExercicio($this->getExercicio()),
            'choice_label'  => 'nom_sistema',
            'choice_value' => function ($sistema) {
                if ($sistema) {
                    return $sistema->getCodSistema() . '-' . $sistema->getExercicio();
                }
            },
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['indicadorSuperavit'] = array(
            'choices'       => [
                'label.planoconta.indicadorSuperavitPermanente' => 'permanente',
                'label.planoconta.indicadorSuperavitFinanceiro' => 'financeiro',
                'label.planoconta.indicadorSuperavitMisto'      => 'misto'
            ],
            'required'      => false,
            'label'         => 'label.planoconta.indicadorSuperavit',
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );

        if ($this->id($this->getSubject())) {
            $codSistema = $em->getRepository('CoreBundle:Contabilidade\SistemaContabil')->findOneBy(
                array(
                    'codSistema'  => $this->getSubject()->getCodSistema(),
                    'exercicio'   => $this->getExercicio()
                )
            );
            if (!empty($codSistema)) {
                $fieldOptions['codSistema']['choice_attr'] = function ($entidade, $key, $index) use ($codSistema) {
                    if ($entidade->getCodSistema() == $codSistema->getCodSistema()) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                };
            }

            $fieldOptions['naturezaSaldo']['data'] = trim($this->getSubject()->getNaturezaSaldo());
            $fieldOptions['indicadorSuperavit']['data'] = trim($this->getSubject()->getIndicadorSuperavit());
        }

        $formMapper
            ->with('label.planoconta.identificacao')
            ->add('escrituracao', 'choice', $fieldOptions['escrituracao'])
            ->add('naturezaSaldo', 'choice', $fieldOptions['naturezaSaldo'])
            ->add('codSistema', 'entity', $fieldOptions['codSistema'])
            ->add('indicadorSuperavit', 'choice', $fieldOptions['indicadorSuperavit'])
            ->add('codEstrutural', null, $fieldOptions['codEstrutural'])
            ->add('mascara', 'hidden', $fieldOptions['mascara'])
            ->add('nomConta', null, $fieldOptions['nomConta'])
            ->add('funcao', null, $fieldOptions['funcao'])
        ;

        $emRecurso = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Recurso');
        $fieldOptions['recurso'] = array(
            'label'         => 'label.planoconta.recurso',
            'mapped'        => false,
            'required'      => false,
            'class'         => 'CoreBundle:Orcamento\\DestinacaoRecurso',
            'choices'       => $emRecurso->getRepository('CoreBundle:Orcamento\\Recurso')->findByExercicio($this->getExercicio()),
            'choice_label' => function ($recurso) {
                if ($recurso) {
                    return $recurso->getNomRecurso();
                }
            },
            'choice_value' => function ($recurso) {
                if ($recurso) {
                    return $recurso->getCodRecurso();
                }
            },
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldOptions['recursoContraPartida'] = array(
            'label'         => 'label.planoconta.recursoContraPartida',
            'mapped'        => false,
            'required'      => false,
            'class'         => 'CoreBundle:Orcamento\\DestinacaoRecurso',
            'choices'       => $emRecurso->getRepository('CoreBundle:Orcamento\\Recurso')->findByExercicio($this->getExercicio()),
            'choice_label' => function ($recurso) {
                if ($recurso) {
                    return str_pad($recurso->getCodRecurso(), 4, "0", STR_PAD_LEFT) . ' - ' . $recurso->getNomRecurso();
                }
            },
            'choice_value' => function ($recurso) {
                if ($recurso) {
                    return $recurso->getCodRecurso();
                }
            },
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );

        if ($this->id($this->getSubject()->getFkContabilidadePlanoAnalitica())) {
            $planoRecurso = $em->getRepository('CoreBundle:Contabilidade\PlanoRecurso')->findOneBy(
                array(
                    'codPlano'  => $this->getSubject()->getFkContabilidadePlanoAnalitica()->getCodPlano(),
                    'exercicio'   => $this->getExercicio()
                )
            );

            if ($planoRecurso) {
                $fieldOptions['recurso']['choice_attr'] = function ($entidade, $key, $index) use ($planoRecurso) {

                    if ($entidade->getCodRecurso() == $planoRecurso->getCodRecurso()) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                };
                $fieldOptions['recursoContraPartida']['choice_attr'] = function ($entidade, $key, $index) use ($planoRecurso) {
                    if ($entidade->getCodRecurso() == $planoRecurso->getCodRecursoContraPartida()) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                };
            }
        }

        $formMapper
            ->add('recurso', 'entity', $fieldOptions['recurso'])
            ->add('recursoContraPartida', 'entity', $fieldOptions['recursoContraPartida'])
        ;


        $fieldOptions['conta'] = array(
            'choices'       => [
                'label.administracao.nao'     => 'n',
                'label.administracao.sim'    => 's'
            ],
            'label'         => 'label.planoconta.isContaBanco',
            'mapped'        => false,
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );
        $entidadeRepository = $em->getRepository("CoreBundle:Orcamento\\Entidade");
        $entidades = $entidadeRepository->getEntidadeByCgmAndExercicio($this->getExercicio());
        $entidadesChoice = array();
        foreach ($entidades as $entidade) {
            $entidadesChoice[$entidade->nom_cgm] = $entidade->cod_entidade;
        }
        $fieldOptions['entidade'] = array(
            'label'        => 'label.suplementacao.entidade',
            'choices'      => $entidadesChoice,
            'mapped'       => false,
            'attr'         => [
                'class'    => 'select2-parameters'
            ]
        );
        $emBanco = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Monetario\Banco');
        $fieldOptions['banco'] = array(
            'label'         => 'label.planoconta.banco',
            'mapped'         => false,
            'class'         => 'CoreBundle:Monetario\\Banco',
            'choices'       => $emBanco->getRepository('CoreBundle:Monetario\\Banco')->findAll(),
            'choice_label' => function ($banco) {
                if ($banco) {
                    return $banco->getNomBanco();
                }
            },
            'choice_value' => function ($banco) {
                if ($banco) {
                    return $banco->getCodBanco();
                }
            },
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldType['agencia'] = 'choice';
        $fieldOptions['agencia'] = array(
            'label'         => 'label.planoconta.agencia',
            'mapped'         => false,
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );
        $fieldType['contaCorrente'] = 'choice';
        $fieldOptions['contaCorrente'] = array(
            'label'         => 'label.planoconta.contaCorrente',
            'mapped'         => false,
            'placeholder'   => '',
            'attr'          => [
                'class'       => 'select2-parameters'
            ]
        );

        $formMapper
            ->end()
            ->with('label.planoconta.contaBanco')
        ;

        if ($this->id($this->getSubject()->getFkContabilidadePlanoAnalitica())) {
            $planoBanco = $em->getRepository('CoreBundle:Contabilidade\PlanoBanco')->findOneBy(
                array(
                    'codPlano'  => $this->getSubject()->getFkContabilidadePlanoAnalitica()->getCodPlano(),
                    'exercicio'   => $this->getExercicio()
                )
            );

            if (!empty($planoBanco)) {
                $fieldOptions['conta']['data'] = 's';
                $fieldOptions['entidade']['data'] = $planoBanco->getCodEntidade();
                $fieldOptions['banco']['choice_attr'] = function ($entidade, $key, $index) use ($planoBanco) {
                    if ($entidade->getCodBanco() == $planoBanco->getCodBanco()) {
                        return ['selected' => 'selected'];
                    } else {
                        return ['selected' => false];
                    }
                };
                $emAgencia = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Monetario\Agencia');
                $fieldType['agencia'] = 'entity';
                $fieldOptions['agencia'] = array(
                    'label'         => 'label.planoconta.agencia',
                    'mapped'         => false,
                    'class'         => 'CoreBundle:Monetario\\Agencia',
                    'choices'       => $emAgencia->getRepository('CoreBundle:Monetario\\agencia')->findByCodBanco($planoBanco->getCodBanco()),
                    'choice_label' => function ($agencia) {
                        if ($agencia) {
                            return $agencia->getNomAgencia();
                        }
                    },
                    'choice_value' => function ($agencia) {
                        if ($agencia) {
                            return $agencia->getCodAgencia();
                        }
                    },
                    'placeholder'   => '',
                    'attr'          => [
                        'class'       => 'select2-parameters'
                    ],
                    'choice_attr'   => function ($entidade, $key, $index) use ($planoBanco) {
                        if ($entidade->getCodAgencia() == $planoBanco->getCodAgencia()) {
                            return ['selected' => 'selected'];
                        } else {
                            return ['selected' => false];
                        }
                    }
                );
                $emContaCorrente = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Monetario\ContaCorrente');
                $fieldType['contaCorrente'] = 'entity';
                $fieldOptions['contaCorrente'] = array(
                    'label'         => 'label.planoconta.contaCorrente',
                    'mapped'         => false,
                    'class'         => 'CoreBundle:Monetario\\ContaCorrente',
                    'choices'       => $emContaCorrente->getRepository('CoreBundle:Monetario\\ContaCorrente')->findByCodAgencia($planoBanco->getCodAgencia()),
                    'choice_label' => function ($contaCorrente) {
                        if ($contaCorrente) {
                            return $contaCorrente->getNumContaCorrente();
                        }
                    },
                    'choice_value' => function ($contaCorrente) {
                        if ($contaCorrente) {
                            return $contaCorrente->getCodContaCorrente() . '/' . $contaCorrente->getNumContaCorrente();
                        }
                    },
                    'placeholder'   => '',
                    'attr'          => [
                        'class'       => 'select2-parameters'
                    ],
                    'choice_attr'   => function ($entidade, $key, $index) use ($planoBanco) {
                        if ($index == ($planoBanco->getFkMonetarioContaCorrente()->getCodContaCorrente() . '/' . $planoBanco->getFkMonetarioContaCorrente()->getNumContaCorrente())) {
                            return ['selected' => 'selected'];
                        } else {
                            return ['selected' => false];
                        }
                    }
                );
            }
        }

        $formMapper
            ->add('conta', 'choice', $fieldOptions['conta'])
            ->add('entidade', 'choice', $fieldOptions['entidade'])
            ->add('banco', 'entity', $fieldOptions['banco'])
            ->add('agencia', $fieldType['agencia'], $fieldOptions['agencia'])
            ->add('contaCorrente', $fieldType['contaCorrente'], $fieldOptions['contaCorrente'])
            ->end()
        ;

        $admin = $this;

        if (!empty($this->request->request->get($this->request->query->get('uniqid'))['agencia'])) :
            $formMapper->getFormBuilder()->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $admin) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    $codBanco = $data['banco'];
                    $em = $this->modelManager->getEntityManager('CoreBundle:Monetario\Agencia');
                    if ($form->has('agencia')) {
                        $form->remove('agencia');
                    }

                    if (isset($data['agencia']) && $data['agencia'] != "") {
                        $agencias = $em->getRepository('CoreBundle:Monetario\\Agencia')->findByCodBanco($codBanco);

                        $listAgencias = array();
                        foreach ($agencias as $agencia) {
                            $descricao = $agencia->getNomAgencia();
                            $choiceValue = $agencia->getCodAgencia();
                            $choiceKey = $descricao;
                            $listAgencias[$choiceKey] = $choiceValue;
                        }

                        $codAgencia = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'agencia',
                            'choice',
                            null,
                            array(
                                'label' => 'label.planoconta.agencia',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'choices' => $listAgencias,
                                'placeholder' => 'label.selecione',
                                'required' => true,
                                'attr' => array(
                                    'class' => 'select2-parameters'
                                ),
                                'data' => $data['agencia']
                            )
                        );

                        $form->add($codAgencia);
                    }

                    $codAgencia = (!empty($data['agencia']) ? $data['agencia'] : null);
                    $em = $this->modelManager->getEntityManager('CoreBundle:Monetario\ContaCorrente');
                    if ($form->has('contaCorrente')) {
                        $form->remove('contaCorrente');
                    }

                    if (isset($data['contaCorrente']) && $data['contaCorrente'] != "") {
                        $contas = $em->getRepository('CoreBundle:Monetario\\ContaCorrente')->findByCodAgencia($codAgencia);

                        $listContas = array();
                        foreach ($contas as $conta) {
                            $descricao = $conta->getNumContaCorrente();
                            $choiceValue = $conta->getCodContaCorrente() . '/' . $conta->getNumContaCorrente();
                            $choiceKey = $descricao;
                            $listContas[$choiceKey] = $choiceValue;
                        }

                        $codConta = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'contaCorrente',
                            'choice',
                            null,
                            array(
                                'label' => 'label.planoconta.contaCorrente',
                                'mapped' => false,
                                'auto_initialize' => false,
                                'choices' => $listContas,
                                'placeholder' => 'label.selecione',
                                'required' => true,
                                'attr' => array(
                                    'class' => 'select2-parameters'
                                ),
                                'data' => $data['contaCorrente']
                            )
                        );

                        $form->add($codConta);
                    }
                }
            );
        endif;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->isCurrentRoute('create') && !$this->validateCreate($errorElement, $object)) {
            return;
        }

        $form = $this->getForm();

        $grupoConta = substr($form->get('codEstrutural')->getData(), 0, 1);
        $naturezaSaldo = $form->get('naturezaSaldo')->getData();
        $errorMessage = null;
        if (in_array($grupoConta, [3, 9]) && $naturezaSaldo == $this::NATUREZA_SALDO_CREDOR) {
            $errorMessage = 'label.planoconta.validacoes.somenteDevedor';
        }

        if ($grupoConta == 4 && $naturezaSaldo == $this::NATUREZA_SALDO_DEVEDOR) {
            $errorMessage = 'label.planoconta.validacoes.somenteCredor';
        }

        if ($errorMessage) {
            $error = $this->getTranslator()->transChoice(
                $errorMessage,
                0,
                ['{grupo}' => $grupoConta]
            );

            $errorElement->addViolation($error)->end();
        }
    }

    public function prePersist($object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);
        $emPlanoConta = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Contabilidade\PlanoConta');
        $planoContaModel = (new \Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel($emPlanoConta));

        $codConta = $this->getDoctrine()->getRepository(PlanoConta::class)->getNewCodConta($this->getExercicio());
        $object->setCodConta($codConta);
        $object->setCodClassificacao($planoContaModel::COD_CLASSIFICACAO);
        $object->setExercicio($this->getExercicio());

        $classificacaoContabilarr = $this->getDoctrine()->getRepository(ClassificacaoContabil::class)->findByCodClassificacao($planoContaModel::COD_CLASSIFICACAO);
        foreach ($classificacaoContabilarr as $classificacaoContabil) {
            if ($classificacaoContabil->getExercicio() == $this->getExercicio()) {
                $object->setFkContabilidadeClassificacaoContabil($classificacaoContabil);
            }
        }

        if (!empty($formData['codSistema'])) {
            $formData['codSistema'] = explode('-', $formData['codSistema']);
            $object->setCodSistema(current($formData['codSistema']));
            $sistemaContabilarr = $this->getDoctrine()->getRepository(SistemaContabil::class)->findByCodSistema($object->getCodSistema());
            foreach ($sistemaContabilarr as $sistemaContabil) {
                if ($sistemaContabil->getExercicio() == $this->getExercicio()) {
                    $object->setFkContabilidadeSistemaContabil($sistemaContabil);
                }
            }
        }
    }

    public function postPersist($object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        try {
            $this->cadastrarClassificacaoPlano($object, $formData);
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        try {
            $this->cadastrarPlanoAnalitica($object);
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        //Cadastrando PlanoRecurso
        try {
            if ($formData['recurso'] && $formData['recursoContraPartida']) {
                $this->cadastrarPlanoRecurso($formData['recurso'], $formData['recursoContraPartida'], $object);
            }
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        if (!empty($formData['conta']) && $formData['conta'] == 's') {
            //Cadastrando PlanoBanco
            try {
                $this->cadastrarPlanoBanco($object, $formData['contaCorrente'], $formData['entidade']);
            } catch (\Exception $e) {
                $this->getFlashBag()->add('error', $e->getMessage());
            }
        }

        $this->getDoctrine()->flush($object);
    }

    public function preUpdate($object)
    {
        if (!empty($object->getFkContabilidadePlanoAnalitica())) {
            $object->getFkContabilidadePlanoAnalitica()->setNaturezaSaldo(strtoupper(substr($object->getNaturezaSaldo(), 0, 1)));
        }
    }

    public function postUpdate($object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);
        //Remover ClassificacaoPlano desse PlanoConta
        try {
            $object->getFkContabilidadeClassificacaoPlanos()->clear();
            $this->getDoctrine()->flush();
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        //Cadastrar ClassificacaoPlano
        try {
            $this->cadastrarClassificacaoPlano($object, $formData);
            $this->getDoctrine()->flush();
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        if (!empty($object->getFkContabilidadePlanoAnalitica())) {
            //Removendo PlanoBanco
            if (!empty($object->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoBanco())) {
                try {
                    $this->getDoctrine()->remove($object->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoBanco());
                    $this->getDoctrine()->flush();
                    $this->getDoctrine()->refresh($object);
                } catch (\Exception $e) {
                    $this->getFlashBag()->add('error', $e->getMessage());
                }
            }

            //Removendo PlanoRecurso
            if (!empty($object->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoRecurso())) {
                try {
                    $this->getDoctrine()->remove($object->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoRecurso());
                    $this->getDoctrine()->flush();
                    $this->getDoctrine()->refresh($object);
                } catch (\Exception $e) {
                    $this->getFlashBag()->add('error', $e->getMessage());
                }
            }
        }

        //Cadastrando PlanoRecurso
        try {
            if ($formData['recurso'] && $formData['recursoContraPartida']) {
                $this->cadastrarPlanoRecurso($formData['recurso'], $formData['recursoContraPartida'], $object);
                $this->getDoctrine()->flush();
            }
        } catch (\Exception $e) {
            $this->getFlashBag()->add('error', $e->getMessage());
        }

        if (!empty($formData['conta']) && $formData['conta'] == 's') {
            //Cadastrando PlanoBanco
            try {
                $this->cadastrarPlanoBanco($object, $formData['contaCorrente'], $formData['entidade']);
                $this->getDoctrine()->flush();
            } catch (\Exception $e) {
                $this->getFlashBag()->add('error', $e->getMessage());
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->exibirBotaoEditar = false;
        $this->exibirBotaoExcluir = false;

        $itens = null;
        $em = $this->modelManager->getEntityManager('CoreBundle:Ppa\AcaoRecurso');

        $codRecurso = $this->getSubject()->getFkContabilidadePlanoAnalitica();
        $codRecurso = $codRecurso ? $codRecurso->getFkContabilidadePlanoRecurso() : null;

        if ($codRecurso) {
            $acaoRecurso = (new AcaoRecursoModel($em))->findOneByCodRecursoAndExercicio($codRecurso->getCodRecurso(), $this->getExercicio());

            if ($acaoRecurso) {
                $em = $this->modelManager->getEntityManager($this->getClass());
                $planoconta = (new PlanoContaModel($em))
                    ->getNumCgmPorCodAcao($acaoRecurso->getCodAcao());
                $itens = (new PlanoContaModel($em))
                    ->getPlanoContaSaldoPorEntidade($this->getExercicio(), $this->getSubject()->getCodConta(), array_shift($planoconta)['numcgm']);
            }
        }

        $showMapper
            ->add('fkContabilidadeSistemaContabil', 'string', ['label' => 'label.planoconta.codSistema'])
            ->add('fkContabilidadeClassificacaoContabil', 'string', ['label' => 'label.planoconta.classificacaoSistema'])
            ->add('codEstrutural', null, ['label' => 'label.planoconta.codEstrutural'])
            ->add('nomConta', null, ['label' => 'label.planoconta.nomConta'])
            ->add('escrituracao', null, ['label' => 'label.planoconta.escrituracao'])
            ->add('fkContabilidadePlanoAnalitica.fkContabilidadePlanoRecurso.fkOrcamentoRecurso', 'string', ['label' => 'label.planoconta.recurso'])
            ->end()
            ->with('label.orcamentariaPagamentos.registros')
            ->add(
                'registros',
                'customField',
                [
                    'mapped' => false,
                    'template' => 'FinanceiroBundle::Contabilidade/PlanoConta/show.html.twig',
                    'data' => [
                        'itens' => $itens
                    ]
                ]
            )
            ->end()
            ->with('label.planoconta.contaBanco')
            ->add(
                'fkContabilidadePlanoAnalitica.fkContabilidadePlanoBanco',
                null,
                [
                    'label' => 'label.planoconta.entidade',
                    'associated_property' => function (PlanoBanco $pb) use ($em) {
                        $result = (new EntidadeModel($em))
                            ->findOneByCodEntidade($pb->getCodEntidade());
                        return $pb->getCodEntidade().' - '.$result->getFkSwCgm()->getNomCgm();
                    }
                ]
            )
            ->add('fkContabilidadePlanoAnalitica.fkContabilidadePlanoBanco.fkMonetarioContaCorrente.codBanco', null, ['label' => 'label.planoconta.banco'])
            ->add('fkContabilidadePlanoAnalitica.fkContabilidadePlanoBanco.fkMonetarioContaCorrente.codAgencia', null, ['label' => 'label.planoconta.agencia'])
            ->add('fkContabilidadePlanoAnalitica.fkContabilidadePlanoBanco.contaCorrente', null, ['label' => 'label.planoconta.contaCorrente'])
        ;
    }

    /**
     * @param $object
     * @param $formData
     * @throws \Exception
     */
    protected function cadastrarClassificacaoPlano($object, $formData)
    {
        $estruturaArray = explode('.', $formData['codEstrutural']);
        $i = 1;
        foreach ($estruturaArray as $estrutura) {
            $classificacaoPlano = new ClassificacaoPlano();
            $classificacaoPlano->setFkContabilidadePlanoConta($object);
            $classificacaoPlano->setCodPosicao($i++);
            $classificacaoPlano->setCodClassificacao($estrutura);
            $object->addFkContabilidadeClassificacaoPlanos($classificacaoPlano);
        }
    }

    /**
     * @param $recurso
     * @param $recursoContraPartida
     * @param $object
     */
    protected function cadastrarPlanoRecurso($recurso, $recursoContraPartida, $object)
    {
        if (!empty($object->getFkContabilidadePlanoAnalitica())) {
            $planoRecurso = new PlanoRecurso();
            $planoRecurso->setCodRecurso($recurso);
            $planoRecurso->setFkContabilidadePlanoAnalitica($object->getFkContabilidadePlanoAnalitica());
            if (!empty($recursoContraPartida)) {
                $planoRecurso->setCodRecursoContraPartida($recursoContraPartida);
            }
            $object->getFkContabilidadePlanoAnalitica()->setFkContabilidadePlanoRecurso($planoRecurso);
        }
    }

    /**
     * @param $object
     * @param $codAndNumContaCorrente
     * @param $entidade
     */
    protected function cadastrarPlanoBanco($object, $codAndNumContaCorrente, $entidade)
    {
        $planoBanco = new PlanoBanco();
        $planoBanco->setFkContabilidadePlanoAnalitica($object->getFkContabilidadePlanoAnalitica());
        list($codContaCorrente, $numContaCorrente) = $this->codAndNumContaCorrente($codAndNumContaCorrente);
        $planoBanco->setContaCorrente($numContaCorrente);
        $planoBanco->setCodEntidade($entidade);
        $contaCorrente = $this->getDoctrine()->getRepository(ContaCorrente::class)->findByCodContaCorrente($codContaCorrente);
        $planoBanco->setFkMonetarioContaCorrente(current($contaCorrente));
        $object->getFkContabilidadePlanoAnalitica()->setFkContabilidadePlanoBanco($planoBanco);
    }

    /**
     * @param $codAndNumContaCorrente
     * @return ArrayCollection
     */
    protected function codAndNumContaCorrente($codAndNumContaCorrente)
    {
        $contaCorrenteArray = new ArrayCollection();
        foreach (explode('/', $codAndNumContaCorrente) as $item) {
            $contaCorrenteArray->add($item);
        }
        return $contaCorrenteArray;
    }

    /**
     * @param $object
     * @return PlanoAnalitica
     */
    protected function cadastrarPlanoAnalitica($object)
    {
        $codPlano = $this->getDoctrine()->getRepository(PlanoAnalitica::class)->getNewCodPlano($object->getExercicio());
        $planoAnalitica = new PlanoAnalitica();
        $planoAnalitica->setCodPlano($codPlano);
        $planoAnalitica->setFkContabilidadePlanoConta($object);
        $planoAnalitica->setNaturezaSaldo(strtoupper(substr($object->getNaturezaSaldo(), 0, 1)));
        $object->setFkContabilidadePlanoAnalitica($planoAnalitica);
    }

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $planoBanco = $object->getFkContabilidadePlanoAnalitica();

        if ($planoBanco) {
            if ($planoBanco->getFkContabilidadePlanoBanco()) {
                $planoBanco = $planoBanco->getFkContabilidadePlanoBanco();
                $codBanco = $planoBanco->getCodBanco();
                $codAgencia = $planoBanco->getCodAgencia();
                $codContaCorrente = $planoBanco->getCodContaCorrente();

                if ($codBanco || $codAgencia || $codContaCorrente) {
                    $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
                    $cheques = $repository->findBy(array('codBanco' => $codBanco, 'codAgencia' => $codAgencia, 'codContaCorrente' => $codContaCorrente));

                    // Mostra erro caso conta tenha cheques.
                    if ($cheques) {
                        $this::exibeMensagemErro($object, 'label.planoconta.erroCheque');
                        return false;
                    }
                }
            }
        }

        $repository = $em->getRepository('CoreBundle:Contabilidade\PlanoConta');
        $codEstrutural = $object->getCodEstrutural();
        $exercicio = $this->getExercicio();
        $modulo = Modulo::MODULO_CONTABILIDADE;
        $lancamentos = $repository->verificaLancamentosEmConta($codEstrutural, $exercicio, $modulo);

        // Mostra erro caso conta tenha lançamentos.
        if ($lancamentos->quantidade) {
            $this::exibeMensagemErro($object, 'label.planoconta.erroLancamento');
            return false;
        }

        // Mostra erro caso tenha valores nas FKs Plano Conta.
        if (!is_null($object)) {
            if (!$this->canRemove($object, [])) {
                $this::exibeMensagemErro($object, 'label.planoconta.erroFk');
                return false;
            }
        }

        // Mostra erro caso tenha valores nas FKs do Plano Analítica.
        if (!is_null($object->getFkContabilidadePlanoAnalitica())) {
            if (!$this->canRemove($object->getFkContabilidadePlanoAnalitica(), ['fkContabilidadePlanoConta'])) {
                $this::exibeMensagemErro($object, 'label.planoconta.erroFk');
                return false;
            }
        }
    }

   /**
    * @param $object
    * @param $mensagem
    */
    public function exibeMensagemErro($object, $mensagem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans($mensagem, array('%planoConta%' => $object)));

        $this->modelManager->getEntityManager($this->getClass())->clear();
        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
    * @param ErrorElement $errorElement
    * @param mixed $object
    * @return bool
    */
    protected function validateCreate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository(PlanoConta::class);

        $form = $this->getForm();

        $codEstrutural = $form->get('codEstrutural')->getData();

        $planoConta = $repository->findBy([
            'codEstrutural' => $codEstrutural,
            'exercicio' => $this->getExercicio(),
        ]);

        if ($planoConta) {
            $error = $this->getTranslator()->trans('label.planoconta.validacoes.erroSalvar');
            $errorElement->with('codEstrutural')->addViolation($error)->end();

            return false;
        }

        $lastDigitPos = $this->getLastDigitPos($codEstrutural);
        $codEstruturalContaMae = $this->getCodEstruturalContaMae($codEstrutural);
        if (!$codEstruturalContaMae) {
            return true;
        }

        $contaMae = $repository->findOneBy(
            [
                'codEstrutural' => $codEstruturalContaMae,
                'exercicio' => $this->getExercicio(),
            ],
            [
                'codEstrutural' => 'DESC',
            ]
        );

        if (!$contaMae) {
            $error = $this->getTranslator()->trans('label.planoconta.validacoes.contaMae');
            $errorElement->addViolation($error)->end();

            return false;
        }

        if ($contaMae->getEscrituracao() == $this::ESCRITURACAO_ANALITICA) {
            $error = $this->getTranslator()->trans('label.planoconta.validacoes.contaMaeAnalitica');
            $errorElement->addViolation($error)->end();

            return false;
        }

        $escrituracao = $form->get('escrituracao')->getData();
        if (($lastDigitPos+1) == strlen($codEstruturalContaMae) && $escrituracao == $this::ESCRITURACAO_SINTETICA) {
            $error = $this->getTranslator()->trans('label.planoconta.validacoes.ultimoNivel');
            $errorElement->addViolation($error)->end();

            return false;
        }

        $recurso = $form->get('recurso')->getData();
        if ($recurso && $this->getContaAnaliticaPorRecurso($codEstruturalContaMae, $this->getExercicio(), $recurso->getCodRecurso())) {
            $error = $this->getTranslator()->trans('label.planoconta.validacoes.recurso');
            $errorElement->addViolation($error)->end();

            return false;
        }

        return true;
    }

    /**
    * @param string $codEstrutural
    * @return string|bool
    */
    protected function getCodEstruturalContaMae($codEstrutural)
    {
        $lastDigitPos = $this->getLastDigitPos($codEstrutural);
        if (is_bool($lastDigitPos) || $lastDigitPos == 0) {
            return false;
        }

        return substr_replace($codEstrutural, '0', $lastDigitPos, 1);
    }

    /**
    * @param string $codEstrutural
    * @return int|bool
    */
    protected function getLastDigitPos($codEstrutural)
    {
        $lastOcurrence = false;

        foreach (range(1, 9) as $digit) {
            $pos = strrpos($codEstrutural, (string) $digit);
            if (is_bool($pos) || $pos <= $lastOcurrence) {
                continue;
            }

            $lastOcurrence = $pos;
        }

        return $lastOcurrence;
    }

    /**
    * @param string $codEstrutural
    * @param string $exercicio
    * @param int $codRecurso
    * @return PlanoAnalitica|null
    */
    protected function getContaAnaliticaPorRecurso($codEstrutural, $exercicio, $codRecurso)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository(PlanoAnalitica::class)->createQueryBuilder('pa');

        $qb->join('pa.fkContabilidadePlanoConta', 'pc');
        $qb->join('pa.fkContabilidadePlanoRecurso', 'pr');

        $qb->where('pc.codEstrutural LIKE :codEstrutural');
        $qb->andWhere('pc.exercicio = :exercicio');
        $qb->andWhere('pr.codRecurso = :codRecurso');

        $lastDigitPos = $this->getLastDigitPos($codEstrutural);
        $qb->setParameter('codEstrutural', sprintf('%%%s%%', substr($codEstrutural, 0, $lastDigitPos+1)));
        $qb->setParameter('exercicio', $this->getExercicio());
        $qb->setParameter('codRecurso', $codRecurso);

        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
