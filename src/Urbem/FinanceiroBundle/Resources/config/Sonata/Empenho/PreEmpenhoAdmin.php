<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoAnulada;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\TipoEmpenho;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PreEmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/autorizacao';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/autorizacao.js',
        '/financeiro/javascripts/empenho/pre-empenho-filtro.js'
    );
    protected $atributos;
    protected $despesa;
    protected $dtValidadeFinal;
    protected $exibirMensagemFiltro = false;
    protected $exibirBotaoEditar = true;

    const COD_HISTORICO_PADRAO = 0;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("delete");
        $collection->remove("export");
        $collection->remove("batch");
        $collection->add('get_dotacao', 'get-dotacao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_dt_autorizacao', 'get-dt-autorizacao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_desdobramento', 'get-desdobramento', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_saldo_dotacao', 'get-saldo-dotacao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_orgao_orcamentario', 'get-orgao-orcamentario', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_orgao_orcamentario_despesa', 'get-orgao-orcamentario-despesa', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_unidade_orcamentaria', 'get-unidade-orcamentaria', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_contrapartida', 'get-contrapartida', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_unidade_medida', 'get-unidade-medida', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_unidade_medida_item', 'get-unidade-medida-item', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_orgao_unidade', 'get-orgao-unidade', array(), array(), array(), '', array(), array('POST'));
        $collection->add('gerar_nota', $this->getRouterIdParameter() . '/gerar-nota');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
            $this->exibirMensagemFiltro = true;
        }
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codPreEmpenho'));
        
        $datagridMapper
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEntidade',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_value' => 'codEntidade',
                    'choice_label' => function ($entidade) {
                        return $entidade->getCodEntidade() . " - " . $entidade->getFkSwCgm()->getNomCgm();
                    },
                    'attr' => array(
                        'class' => 'select2-parameters',
                        'required' => 'required'
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'exercicio',
                null,
                array(
                    'label' => 'label.exercicio',
                ),
                'text',
                array(
                    'attr' => [
                        'readonly' => 'readonly',
                        'value' => $this->getExercicio()
                    ]
                )
            )
            ->add(
                'codCentroCusto',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCentroCusto',
                )
            )
            ->add(
                'codDespesa',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codDespesa',
                ),
                'choice',
                array(
                    'choices' => array(),
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'codAutorizacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoInicial',
                )
            )
            ->add(
                'codAutorizacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoFinal',
                )
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoInicial',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoFinal',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.cgmBeneficiario',
                ),
                'sonata_type_model_autocomplete',
                array(
                    'class' => 'CoreBundle:SwCgm',
                    'property' => 'nomCgm',
                    'to_string_callback' => function ($swCgm, $property) {
                        return $swCgm->getNomCgm();
                    },
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                ),
                array(
                    'admin_code' => 'core.admin.filter.sw_cgm'
                )
            )
            ->add(
                'codModalidadeCompra',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codModalidadeCompra',
                ),
                'choice',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'choices' => array(
                        '8 - Dispensa de Licitação' => 8,
                        '9 - Inexibilidade' => 9
                    ),
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codCompraDiretaInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCompraDiretaInicial',
                )
            )
            ->add(
                'codCompraDiretaFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCompraDiretaFinal',
                )
            )
            ->add(
                'codModalidadeLicitacao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codModalidadeLicitacao',
                ),
                'entity',
                array(
                    'auto_initialize' => false,
                    'class' => 'CoreBundle:Compras\Modalidade',
                    'choice_label' => 'descricao',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder("m");
                        $qb->where($qb->expr()->notIn("m.codModalidade", array(4,5,10,11)));
                        return $qb;
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codLicitacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codLicitacaoInicial',
                )
            )
            ->add(
                'codLicitacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codLicitacaoFinal',
                )
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return false;
        }
        
        $filter = $this->getDataGrid()->getValues();

        $container = $this->getConfigurationPool()->getContainer();
        /** @var Usuario $usuario */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codPreEmpenhoList = (new PreEmpenhoModel($entityManager))->filterPreEmpenho($filter, $usuario->getNumcgm());

        $ids = array();
        foreach ($codPreEmpenhoList as $codPreEmpenho) {
            $ids[] = $codPreEmpenho->cod_pre_empenho;
        }

        if (count($codPreEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codPreEmpenho", $ids));
            $queryBuilder->andWhere($queryBuilder->expr()->eq("{$alias}.exercicio", "'" . $this->getExercicio() . "'"));
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Autorizacao/CRUD:list__action_edit.html.twig'),
                    'print' => array('template' => 'FinanceiroBundle:Sonata/Empenho/EmitirEmpenhoAutorizacao/CRUD:list_action_emitirAutorizacaoAnulada.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        
        $listMapper
            ->add(
                'codEntidade',
                null,
                array(
                    'label' => 'label.preEmpenho.codEntidade',
                )
            )
            ->add(
                'autorizacao',
                null,
                array(
                    'label' => 'label.preEmpenho.autorizacao',
                )
            )
            ->add(
                'dtAutorizacao',
                null,
                array(
                    'label' => 'label.preEmpenho.dtAutorizacao',
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.preEmpenho.descricao',
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $numCgm = $container->get('security.token_storage')->getToken()->getUser();

        $formOptions = array();

        $formOptions['exercicio'] = array(
            'data' => $this->getExercicio(),
            'mapped' => false,
        );

        $formOptions['total'] = array(
            'data' => 0,
            'mapped' => false
        );

        $formOptions['totalReserva'] = array(
            'data' => 0,
            'mapped' => false
        );

        $formOptions['codEntidade'] = array(
            'label' => 'label.preEmpenho.codEntidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'choice_value' => 'codEntidade',
            'choice_label' => function ($entidade) {
                return $entidade->getCodEntidade() . " - " . $entidade->getFkSwCgm()->getNomCgm();
            },
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("e")
                    ->where("e.exercicio = '" . $this->getExercicio() . "'");
            },
            'placeholder' => 'label.selecione',
            'mapped' => false
        );

        $formOptions['dtAutorizacao'] = array(
            'label' => 'label.preEmpenho.dtAutorizacao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        $formOptions['codDespesa'] = array(
            'label' => 'label.preEmpenho.codDespesa',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['codClassificacao'] = array(
            'label' => 'label.preEmpenho.codClassificacao',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['saldoDotacao'] = array(
            'label' => 'label.preEmpenho.saldoDotacao',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        );

        $formOptions['numOrgao'] = array(
            'label' => 'label.preEmpenho.numOrgao',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );

        $formOptions['numUnidade'] = array(
            'label' => 'label.preEmpenho.numUnidade',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );

        $formOptions['fkSwCgm'] = array(
            'label' => 'label.preEmpenho.cgmBeneficiario',
            'class' => 'CoreBundle:SwCgm',
            'property' => 'nomCgm',
            'to_string_callback' => function (\Urbem\CoreBundle\Entity\SwCgm $swCgm, $property) {
                return $swCgm->getNomCgm();
            },
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formOptions['codCategoria'] = array(
            'label' => 'label.preEmpenho.codCategoria',
            'class' => 'CoreBundle:Empenho\CategoriaEmpenho',
            'choice_label' => 'descricao',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'mapped' => false
        );

        $formOptions['contaContrapartida'] = array(
            'label' => 'label.preEmpenho.contaContrapartida',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
            'required' => false
        );

        $formOptions['descricao'] = array(
            'label' => 'label.preEmpenho.descricao',
            'required' => false,
        );

        $formOptions['fkEmpenhoHistorico'] = array(
            'label' => 'label.preEmpenho.codHistorico',
            'class' => 'CoreBundle:Empenho\Historico',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                return $er->createQueryBuilder("h")
                    ->where("h.exercicio = '" . $this->getExercicio() . "'");
            },
            'choice_value' => function ($historico) {
                if (!empty($historico)) {
                    return $historico->getCodHistorico();
                }
            },
            'placeholder' => 'label.selecione',
            'required' => false,
        );

        $formOptions['dtValidadeFinal'] = array(
            'label' => 'label.preEmpenho.dtValidadeFinal',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        if ($this->id($this->getSubject())) {
            /** @var AutorizacaoEmpenho $autorizacaoEmpenho */
            $autorizacaoEmpenho = $this->getSubject()->getFkEmpenhoAutorizacaoEmpenhos()->last();
            if ($autorizacaoEmpenho) {
                $formOptions['codEntidade']['data'] = $autorizacaoEmpenho->getFkOrcamentoEntidade();
                $formOptions['dtAutorizacao']['data'] = $autorizacaoEmpenho->getDtAutorizacao();
                $formOptions['numOrgao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getOrgaoOrcamentario(
                    $autorizacaoEmpenho->getExercicio(),
                    $autorizacaoEmpenho->getFkOrcamentoEntidade()->getCodEntidade(),
                    $numCgm->getFkSwCgm()->getNumcgm(),
                    true
                );
                
                $formOptions['numOrgao']['data'] = $autorizacaoEmpenho->getNumOrgao();
                
                $formOptions['numUnidade']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getUnidadeOrcamentaria(
                    $autorizacaoEmpenho->getFkOrcamentoEntidade()->getCodEntidade(),
                    $autorizacaoEmpenho->getNumOrgao(),
                    true
                );

                $preEmpenhoDespesa = $entityManager->getRepository('CoreBundle:Empenho\PreEmpenhoDespesa')
                ->findOneBy(
                    array(
                        'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                        'exercicio' => $autorizacaoEmpenho->getExercicio(),
                    )
                );

                $formOptions['codDespesa']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                ->getDotacaoOrcamentaria(
                    $autorizacaoEmpenho->getExercicio(),
                    $numCgm->getFkSwCgm()->getNumcgm(),
                    $autorizacaoEmpenho->getFkOrcamentoEntidade()->getCodEntidade(),
                    true
                );
                
                if ($preEmpenhoDespesa) {
                    $formOptions['codDespesa']['data'] = $preEmpenhoDespesa->getCodDespesa();

                    $formOptions['codClassificacao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getDesdobramento(
                        $preEmpenhoDespesa->getCodDespesa(),
                        $autorizacaoEmpenho->getExercicio(),
                        true
                    );

                    $formOptions['codClassificacao']['data'] = $entityManager->getRepository('CoreBundle:Orcamento\ContaDespesa')
                    ->findOneBy(
                        array(
                            'exercicio' => $autorizacaoEmpenho->getExercicio(),
                            'codConta' => $preEmpenhoDespesa->getCodConta()
                        )
                    )->getCodEstrutural();

                    $formOptions['saldoDotacao']['data'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getSaldoDotacaoDataAtual(
                        $autorizacaoEmpenho->getExercicio(),
                        $preEmpenhoDespesa->getCodDespesa(),
                        $autorizacaoEmpenho->getDtAutorizacao()->format("d/m/Y"),
                        $autorizacaoEmpenho->getFkOrcamentoEntidade()->getCodEntidade(),
                        true
                    );
                }


                $formOptions['numUnidade']['data'] = $autorizacaoEmpenho->getNumUnidade();
                $formOptions['codCategoria']['data'] = $autorizacaoEmpenho->getFkEmpenhoCategoriaEmpenho();
                $formOptions['contaContrapartida']['choices'] = (new PreEmpenhoModel($entityManager))
                    ->getContraPartida(
                        $autorizacaoEmpenho->getExercicio(),
                        $this->getSubject()->getFkSwCgm()->getNumcgm(),
                        true
                    );
                
                $contaContrapartida = $entityManager->getRepository('CoreBundle:Empenho\ContrapartidaAutorizacao')
                    ->findOneBy(
                        array(
                            'exercicio' => $autorizacaoEmpenho->getExercicio(),
                            'codEntidade' => $autorizacaoEmpenho->getFkOrcamentoEntidade()->getCodEntidade(),
                            'codAutorizacao' => $autorizacaoEmpenho->getCodAutorizacao(),
                        )
                    );
                
                if ($contaContrapartida) {
                    $formOptions['contaContrapartida']['data'] = $contaContrapartida->getContaContrapartida();
                }

                $formOptions['dtAutorizacao']['disabled'] = true;
            } else {
                if (! $this->getSubject()->getFkEmpenhoEmpenhos()->isEmpty()) {
                    $formOptions['codEntidade']['data'] = $this->getSubject()->getFkEmpenhoEmpenhos()->last()->getFkOrcamentoEntidade();
                }
            }
            $dtValidadeFinal = ($autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()) ? $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->getDtValidadeFinal() : new \DateTime("Dec 31 {$this->getExercicio()}");
            $formOptions['dtValidadeFinal']['data'] = $dtValidadeFinal;

            /** @var PreEmpenho $preEmpenho */
            $preEmpenho = $this->getSubject();
            $total = 0;
            /** @var ItemPreEmpenho $itemPreEmpenho */
            foreach ($preEmpenho->getFkEmpenhoItemPreEmpenhos() as $itemPreEmpenho) {
                $total += $itemPreEmpenho->getVlTotal();
            }

            $formOptions['total']['data'] = $total;
            $formOptions['totalReserva']['data'] = ($autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()) ? $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->getVlReserva() : 0;
        } else {
            $fkEmpenhoHistorico = $entityManager->getRepository(Historico::class)->findOneBy(['codHistorico' => self::COD_HISTORICO_PADRAO, 'exercicio' => $this->getExercicio()]);
            $formOptions['fkEmpenhoHistorico']['data'] = $fkEmpenhoHistorico;

            $formOptions['dtValidadeFinal']['data'] = new \DateTime("Dec 31 {$this->getExercicio()}");
        }


        $formMapper
            ->with('label.preEmpenho.dadosAutorizacao')
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add(
                    'total',
                    'hidden',
                    $formOptions['total']
                )
                ->add(
                    'totalReserva',
                    'hidden',
                    $formOptions['totalReserva']
                )
                ->add(
                    'codEntidade',
                    'entity',
                    $formOptions['codEntidade']
                )
                ->add(
                    'dtAutorizacao',
                    'sonata_type_date_picker',
                    $formOptions['dtAutorizacao']
                )
                ->add(
                    'codDespesa',
                    'choice',
                    $formOptions['codDespesa']
                )
                ->add(
                    'codClassificacao',
                    'choice',
                    $formOptions['codClassificacao']
                )
                ->add(
                    'saldoDotacao',
                    'money',
                    $formOptions['saldoDotacao']
                )
                ->add(
                    'numOrgao',
                    'choice',
                    $formOptions['numOrgao']
                )
                ->add(
                    'numUnidade',
                    'choice',
                    $formOptions['numUnidade']
                )
                ->add(
                    'fkSwCgm',
                    'sonata_type_model_autocomplete',
                    $formOptions['fkSwCgm'],
                    array(
                        'admin_code' => 'core.admin.filter.sw_cgm'
                    )
                )
                ->add(
                    'codCategoria',
                    'entity',
                    $formOptions['codCategoria']
                )
                ->add(
                    'contaContrapartida',
                    'choice',
                    $formOptions['contaContrapartida']
                )
                ->add(
                    'descricao',
                    'textarea',
                    $formOptions['descricao']
                )
                ->add(
                    'fkEmpenhoHistorico',
                    'entity',
                    $formOptions['fkEmpenhoHistorico']
                )
            ->end()
        ;

        $formMapper->with('label.preEmpenho.atributos');

        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            $type = "";
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            switch ($atributo->cod_tipo) {
                case 1:
                    $type = "number";
                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                    );
                    break;
                case 3:
                    $type = "choice";

                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                    $choices = array();

                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$desc] = $valor_padrao[$key];
                    }

                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'choices' => $choices,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                        'attr' => array(
                            'class' => 'select2-parameters'
                        ),
                        'placeholder' => 'label.selecione'
                    );
                    break;
                default:
                    $type = "text";
                    $formOptions[$field_name] = array(
                        'label' => $atributo->nom_atributo,
                        'required' => ! $atributo->nao_nulo,
                        'mapped' => false,
                    );
                    break;
            }

            if ($this->id($this->getSubject())) {
                if ($autorizacaoEmpenho) {
                    $data = $entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
                    ->findOneBy(
                        array(
                            'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                            'exercicio' => $autorizacaoEmpenho->getExercicio(),
                            'codModulo' => 10,
                            'codCadastro' => $atributo->cod_cadastro,
                            'codAtributo' => $atributo->cod_atributo,
                        ),
                        array(
                            'timestamp' => 'DESC'
                        )
                    );
                    
                    
                    if ($data) {
                        $formOptions[$field_name]['data'] = $data->getValor();
                    }
                }
            }

            $formMapper->add(
                $field_name,
                $type,
                $formOptions[$field_name]
            );
        }

        $formMapper->end();
        $formMapper->with('label.preEmpenho.dtValidadeFinal')
            ->add(
                'dtValidadeFinal',
                'sonata_type_date_picker',
                $formOptions['dtValidadeFinal']
            )
        ->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $numCgm, $formOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('codDespesa')) {
                    $form->remove('codDespesa');
                }

                if (isset($data['codEntidade']) && $data['codEntidade'] != "") {
                    $formOptions['codDespesa']['auto_initialize'] = false;
                    $formOptions['codDespesa']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getDotacaoOrcamentaria(
                        $data['exercicio'],
                        $numCgm->getFkSwCgm()->getNumcgm(),
                        (int) $data['codEntidade'],
                        true
                    );
                    
                    $codDespesa = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codDespesa',
                        'choice',
                        null,
                        $formOptions['codDespesa']
                    );

                    $form->add($codDespesa);
                }

                if ($form->has('codClassificacao')) {
                    $form->remove('codClassificacao');
                }

                if (isset($data['codDespesa']) && $data['codDespesa'] != "") {
                    $formOptions['codClassificacao']['auto_initialize'] = false;
                    $formOptions['codClassificacao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getDesdobramento(
                        $data['codDespesa'],
                        $data['exercicio'],
                        true
                    );

                    $codClassificacao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codClassificacao',
                        'choice',
                        null,
                        $formOptions['codClassificacao']
                    );

                    $form->add($codClassificacao);
                }

                if ($form->has('numOrgao')) {
                    $form->remove('numOrgao');
                }

                if (isset($data['codEntidade']) && $data['codEntidade'] != "") {
                    $formOptions['numOrgao']['auto_initialize'] = false;
                    $formOptions['numOrgao']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getOrgaoOrcamentario(
                        $data['exercicio'],
                        $data['codEntidade'],
                        $numCgm->getFkSwCgm()->getNumcgm(),
                        true
                    );

                    $numOrgao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'numOrgao',
                        'choice',
                        null,
                        $formOptions['numOrgao']
                    );

                    $form->add($numOrgao);
                }

                if ($form->has('numUnidade')) {
                    $form->remove('numUnidade');
                }

                if (isset($data['numOrgao']) && $data['numOrgao'] != "") {
                    $formOptions['numUnidade']['auto_initialize'] = false;
                    $formOptions['numUnidade']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getUnidadeOrcamentaria(
                        $data['codEntidade'],
                        $data['numOrgao'],
                        true
                    );

                    $numUnidade = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'numUnidade',
                        'choice',
                        null,
                        $formOptions['numUnidade']
                    );

                    $form->add($numUnidade);
                }

                if ($form->has('contaContrapartida')) {
                    $form->remove('contaContrapartida');
                }

                if (isset($data['fkSwCgm']) && $data['fkSwCgm'] != "") {
                    $formOptions['contaContrapartida']['auto_initialize'] = false;
                    $formOptions['contaContrapartida']['choices'] = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
                    ->getContrapartida(
                        $data['exercicio'],
                        $data['fkSwCgm'],
                        true
                    );

                    $contaContrapartida = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'contaContrapartida',
                        'choice',
                        null,
                        $formOptions['contaContrapartida']
                    );

                    $form->add($contaContrapartida);
                }
            }
        );
    }

    /**
     * @param PreEmpenho|null $preEmpenho
     * @return AutorizacaoAnulada|null
     */
    public function getAutorizacaoAnulada($preEmpenho = null)
    {
        if (!$preEmpenho) {
            $preEmpenho = $this->getSubject();
        }

        return ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoAnulada())
            ? $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoAnulada()
            : null;
    }

    public function getDespesa()
    {
        $this->despesa = array(
            'codDespesa' => '',
            'codClassificacao' => ''
        );
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $preEmpenhoDespesa = $entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
            )
        );
        
        if ($preEmpenhoDespesa) {
            $contaDespesa = $entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
            ->findOneBy(
                array(
                    'exercicio' => $preEmpenhoDespesa->getExercicio(),
                    'codConta' => $preEmpenhoDespesa->getCodConta(),
                )
            );
                
            $this->despesa['codDespesa'] = $preEmpenhoDespesa->getCodDespesa();
            $this->despesa['codClassificacao'] = $contaDespesa->getCodEstrutural() . " - " . $contaDespesa->getDescricao();
        }
        
        return $this->despesa;
    }

    public function getAtributos()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            $atributoEmpenhoValor = $entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
            ->findOneBy(
                array(
                    'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codModulo' => 10,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo,
                ),
                array(
                    'timestamp' => 'DESC'
                )
            );
            
            $data = null;
            if ($atributoEmpenhoValor) {
                $data = $atributoEmpenhoValor->getValor();
            }
            
            $valor = "&nbsp;";
            switch ($atributo->cod_tipo) {
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                    $choices = array();

                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$valor_padrao[$key]] = $desc;
                    }
                    
                    if (! is_null($data)) {
                        $valor = $choices[$data];
                    } else {
                        $valor = "";
                    }
                    break;
                default:
                    if (! is_null($data)) {
                        $valor = $data;
                    } else {
                        $valor = "";
                    }
                    break;
            }

            $this->atributos[$field_name] = array(
                'label' => $atributo->nom_atributo,
                'data' => $valor
            );
        }

        return $this->atributos;
    }

    public function getDtValidadeFinal()
    {
        $this->dtValidadeFinal = new \DateTime('last day of this year');
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codDespesa = $this->getDespesa();
        
        $reservaSaldos = null;
        
        if ($codDespesa['codDespesa'] != "") {
            /** @var PreEmpenho $preEmpenho */
            $preEmpenho = $this->getSubject();
            if ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->count()) {
                $reservaSaldos = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
            }
        }
        
        if ($reservaSaldos) {
            $this->dtValidadeFinal = $reservaSaldos->getDtValidadeFinal();
        }
        return $this->dtValidadeFinal;
    }

    public function getItemPreEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $itemPreEmpenhoList = $entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
            ->findBy(
                array(
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                    'fkEmpenhoPreEmpenho' => $this->getSubject()
                )
            );

        return $itemPreEmpenhoList;
    }

    public function getVlTotal()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $reservaSaldos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getReservaSaldoPerfil($this->getSubject());
        
        if (! $reservaSaldos) {
            return 0;
        }
        
        return $reservaSaldos->getVlReserva();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codPreEmpenho')
            ->add('implantado')
            ->add('descricao')
        ;
    }

    /**
     * @param PreEmpenho $preEmpenho
     */
    public function prePersist($preEmpenho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoModel = new PreEmpenhoModel($em);

        $container = $this->getConfigurationPool()->getContainer();
        /** @var Usuario $usuario */
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        /** @var TipoEmpenho $tipoEmpenho */
        $tipoEmpenho = $em->getRepository(TipoEmpenho::class)->findOneByCodTipo(1);

        $codPreEmpenho = $preEmpenhoModel->getUltimoPreEmpenho($this->getForm()->get('exercicio')->getData());

        $preEmpenho->setCodPreEmpenho($codPreEmpenho);
        $preEmpenho->setFkAdministracaoUsuario($usuario);
        $preEmpenho->setFkEmpenhoTipoEmpenho($tipoEmpenho);
    }

    /**
     * @param PreEmpenho $preEmpenho
     */
    public function postPersist($preEmpenho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        (new PreEmpenhoModel($em))->after($preEmpenho, $this->getForm());
        $this->forceRedirect($this->generateUrl('show', ['id' => $this->getObjectKey($preEmpenho)]));
    }

    /**
     * @param PreEmpenho $preEmpenho
     */
    public function postUpdate($preEmpenho)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        (new PreEmpenhoModel($em))->after($preEmpenho, $this->getForm());
        $this->forceRedirect($this->generateUrl('show', ['id' => $this->getObjectKey($preEmpenho)]));
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        $toString = "Autorização de Empenho";
        
        return $toString;
    }
}
