<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\Orcamento\Funcao;
use Urbem\CoreBundle\Entity\Orcamento\Subfuncao;
use Urbem\CoreBundle\Entity\Orcamento\Programa;
use Urbem\CoreBundle\Entity\Orcamento\Pao;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model\Ppa\AcaoModel;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Doctrine\ORM\EntityManager;

class DespesaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_elaboracao_orcamento_despesa';
    protected $baseRoutePattern = 'financeiro/orcamento/elaboracao-orcamento/despesa';
    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/elaboracaoorcamento/despesa.js'
    );
    protected $exibirBotaoIncluir = false;
    
    private $inExercicico = null;
    
    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'list', 'delete', 'edit']);
        $collection->add('acao_list', 'listar-acao');
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codDespesa'));
        
        $datagridMapper
        ->add('codEntidade', null, ['label' => 'label.planoconta.entidade'], 'entity', [
            'class' => Entidade::class,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function ($entityManager) {
                return $entityManager
                ->createQueryBuilder('e')
                ->where('e.exercicio = :exercicio')
                ->setParameter(':exercicio', $this->getExercicio())
                ->orderBy('e.codEntidade', 'ASC');
            }
        ])
        ->add('codDespesa', null, ['label' => 'label.despesa'], 'entity', [
            'class' => Despesa::class,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($entityManager) {
                return $entityManager
                ->createQueryBuilder('re')
                ->where('re.exercicio = :exercicio')
                ->setParameter(':exercicio', $this->getExercicio())
                ->orderBy('re.codDespesa', 'ASC');
            },
            'attr' => [
                'class' => 'selecione2-parameters '
            ]
        ])
        ->add('codRecurso', null, ['label' => 'label.suplementacao.recurso'], 'entity', [
            'class' => Recurso::class,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($entityManager) {
            return $entityManager
                ->createQueryBuilder('rec')
                ->where('rec.exercicio = :exercicio')
                ->setParameter(':exercicio', $this->getExercicio())
                ->orderBy('rec.codRecurso', 'ASC');
            },
            'attr' => [
                'class' => 'selecione2-parameters '
            ]
        ])
        ->add('vlOriginal', null, ['label' => 'label.suplementacao.valor'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        
        $listMapper
            ->add('codDespesa', null, ['label' => 'label.elaboracaoDespesa.despesa'])
            ->add('fkOrcamentoContaDespesa.descricao', null, ['label' => 'label.planoconta.nomConta'])
            ->add('fkOrcamentoRecurso.nomRecurso', null, ['label' => 'label.suplementacao.recurso'])
            ->add('dtCriacao', null, ['label' => 'label.dtCriacao'])
            ->add('vlOriginal', 'currency', ['label' => 'label.suplementacao.valor', 'currency' => 'BRL', 'attr' => 'money '])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        
        $request = $this->getRequest();
        $isEdit = $this->id($this->getSubject());
        $hasConfigDespesa = false;
        $configDespesa = [];
        
        $em = $this->modelManager
        ->getEntityManager($this->getClass());
        
        if ($isEdit) {
            $despesa = $this->getSubject();
            $this->inExercicico = $despesa->getExercicio();
        } else {
            $this->inExercicico = $this->getExercicio();
            if ($request->request->has('incluir_despesa')) {
                $hasConfigDespesa = true;
                $configDespesa = $this->_loadConfigFromAcaoDespesa($request->request->get('incluir_despesa'));
            } else {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.elaboracaoDespesa.requisicaoInvalida'));
                $em->clear();
                return $this->redirectByRoute('urbem_financeiro_orcamento_elaboracao_orcamento_despesa_acao_list');
            }
        }
        
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $formOptions = [];
        
        $this->_buildConfigDespesaFields($formOptions, $em, $hasConfigDespesa, $configDespesa);
        
        $formOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.planoconta.entidade',
            'placeholder' => 'label.selecione',
            'class' => Entidade::class,
            'query_builder' => function ($em) {
            return $em
                ->createQueryBuilder('o')
                ->where('o.exercicio = :exercicio')
                ->setParameter(':exercicio', $this->inExercicico)
                ->orderBy('o.codEntidade', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $formOptions['fkOrcamentoRecurso'] = [
            'label' => 'label.suplementacao.recurso',
            'placeholder' => 'label.selecione',
            'class' => Recurso::class,
            'query_builder' => function ($em) {
                return $em
                    ->createQueryBuilder('rec')
                    ->where('rec.exercicio = :exercicio')
                    ->setParameter(':exercicio', $this->inExercicico)
                    ->orderBy('rec.codRecurso', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $formOptions['despesa'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'FinanceiroBundle::Orcamento/ElaboracaoOrcamento/Despesa/edit.html.twig',
            'data' => [
                'itens' => null,
                'lancamentos' => null,
                'errors' => null,
                'tipo' => null
            ],
            'attr' => [
                'class' => ''
            ]
        ];
        
        $formOptions['vlOriginal'] = [
            'label' => 'label.elaboracaoDespesa.valorDotacao',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        ];
        
        if (isset($despesa)) {
            $this->exibirBotaoExcluir = false;
            /** @var Receita $receita */
            
            $formOptions['fkOrcamentoUnidade']['disabled'] = true;
            $formOptions['fkOrcamentoFuncao']['disabled'] = true;
            $formOptions['fkOrcamentoSubfuncao']['disabled'] = true;
            $formOptions['fkOrcamentoPrograma']['disabled'] = true;
            $formOptions['fkOrcamentoPao']['disabled'] = true;
            
            $formOptions['codConta']['data'] = $despesa->getFkOrcamentoContaDespesa()->getCodConta();
            
            $periodos = $despesa->getFkOrcamentoPrevisaoDespesas();
            $total = $despesa->getVlOriginal();

            switch (date('m')) {
                case '1':
                case '2':
                    $periodoAtual = 1;
                    break;
                case '3':
                case '4':
                    $periodoAtual = 2;
                    break;
                case '5':
                case '6':
                    $periodoAtual = 3;
                    break;
                case '7':
                case '8':
                    $periodoAtual = 4;
                    break;
                case '9':
                case '10':
                    $periodoAtual = 5;
                    break;
                case '11':
                case '12':
                    $periodoAtual = 6;
                    break;
            }
            
            $formOptions['despesa']['data'] = [
                'exercicioAtual' => $this->getExercicio(),
                'periodoAtual' => $periodoAtual,
                'itens' => $periodos,
                'total' => $total
            ];
        }
        
        $formMapper
        ->with('label.elaboracaoDespesa.dadosDespesa')
        ->add(
            'fkOrcamentoUnidade',
            null,
            $formOptions['fkOrcamentoUnidade']
        )
        ->add(
            'fkOrcamentoFuncao',
            'entity',
            $formOptions['fkOrcamentoFuncao']
        )
        ->add(
            'fkOrcamentoSubfuncao',
            'entity',
            $formOptions['fkOrcamentoSubfuncao']
        )
        ->add(
            'fkOrcamentoPrograma',
            'entity',
            $formOptions['fkOrcamentoPrograma']
        )
        ->add(
            'fkOrcamentoPao',
            'entity',
            $formOptions['fkOrcamentoPao']
        )
        ->add(
            'codConta',
            'choice',
            $formOptions['codConta']
        )
        ->end()
        ->with('label.elaboracaoDespesa.recursosEstimados')
        ->add(
            'fkOrcamentoRecurso',
            'entity',
            $formOptions['fkOrcamentoRecurso']
        )
        ->add(
            'fkOrcamentoEntidade',
            null,
            $formOptions['fkOrcamentoEntidade'],
            ['admin_code' => 'financeiro.admin.entidade']
        )
        ->add(
            'vlOriginal',
            'money',
            $formOptions['vlOriginal']
        )
        ->end();
                                
        $formMapper
        ->with('label.elaboracaoDespesa.registrosMetas')
        ->add(
            'receita',
            'customField',
            $formOptions['despesa']
        );
    }
    
    private function _buildConfigDespesaFields(Array &$formOptions, EntityManager $em, $hasDespesaConfig = false, Array $despesaConfig = [])
    {
        $formOptions['fkOrcamentoUnidade'] = [
            'label' => 'label.elaboracaoDespesa.orgaoUnidade',
            'placeholder' => 'label.selecione',
            'class' => Unidade::class,
            'choice_label' => function(Unidade $unidade){
            return sprintf(
                '%d - %s - %s',
                $unidade->getNumUnidade(),
                $unidade->getFkOrcamentoOrgao()->getNomOrgao(),
                $unidade->getNomUnidade()
                );
            },
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('o')
            ->where('o.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->inExercicico)
            ->orderBy('o.numUnidade', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $formOptions['fkOrcamentoFuncao'] = [
            'label' => 'label.elaboracaoDespesa.funcao',
            'placeholder' => 'label.selecione',
            'class' => Funcao::class,
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('o')
            ->where('o.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->inExercicico)
            ->orderBy('o.codFuncao', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $formOptions['fkOrcamentoSubfuncao'] = [
            'label' => 'label.elaboracaoDespesa.subfuncao',
            'placeholder' => 'label.selecione',
            'class' => Subfuncao::class,
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('o')
            ->where('o.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->inExercicico)
            ->orderBy('o.codSubfuncao', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
            ];
        
        $formOptions['fkOrcamentoPrograma'] = [
            'label' => 'label.elaboracaoDespesa.programa',
            'placeholder' => 'label.selecione',
            'class' => Programa::class,
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('o')
            ->where('o.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->inExercicico)
            ->orderBy('o.codPrograma', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        $formOptions['fkOrcamentoPao'] = [
            'label' => 'label.elaboracaoDespesa.pao',
            'placeholder' => 'label.selecione',
            'class' => Pao::class,
            'query_builder' => function ($em) {
            return $em
            ->createQueryBuilder('o')
            ->where('o.exercicio = :exercicio')
            ->setParameter(':exercicio', $this->inExercicico)
            ->orderBy('o.numPao', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
        
        if ($hasDespesaConfig) {
            $formOptions['fkOrcamentoUnidade']['data'] = $despesaConfig['unidade'];
            $formOptions['fkOrcamentoFuncao']['data'] = $despesaConfig['funcao'];
            $formOptions['fkOrcamentoSubfuncao']['data'] = $despesaConfig['subfuncao'];
            $formOptions['fkOrcamentoPrograma']['data'] = $despesaConfig['programa'];
            $formOptions['fkOrcamentoPao']['data'] = $despesaConfig['pao'];
        }
        
        $despesaModel = new DespesaModel($em);
        $classificacaoArr = $despesaModel->getClassificacoesDespesa($this->inExercicico);
        
        $rubricasArr = [];
        
        foreach ($classificacaoArr as $row) {
            $rubricasArr[$row['cod_conta']] = "{$row['mascara_classificacao']} - {$row['descricao']}";
        }
        
        $formOptions['codConta'] = [
            'label' => 'label.elaboracaoDespesa.rubrica',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($rubricasArr),
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $showMapper
            ->add('exercicio')
            ->add('codDespesa')
            ->add('codEntidade')
            ->add('codPrograma')
            ->add('codConta')
            ->add('numPao')
            ->add('numOrgao')
            ->add('numUnidade')
            ->add('codRecurso')
            ->add('codFuncao')
            ->add('codSubfuncao')
            ->add('vlOriginal')
            ->add('dtCriacao')
        ;
    }
    
    /**
     * @param Despesa $despesa
     */
    public function prePersist($despesa)
    {
        $form = $this->getForm();
        
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        
        $codDespesa = $em->getRepository($this->getClass())
        ->getNewCodDespesa($this->getExercicio());
        $despesa->setCodDespesa($codDespesa);
        
        /** @var ContaReceita $contaReceita */
        $contaDespesa = $em->getRepository(ContaDespesa::class)
        ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $this->getForm()->get('codConta')->getData()]);
        $despesa->setFkOrcamentoContaDespesa($contaDespesa);
        
        for ($i = 1; $i <= 6; $i++) {
            $prevPeriodo = new PrevisaoDespesa();
            $prevPeriodo->setPeriodo($i);
            $prevPeriodo->setCodDespesa($codDespesa);
            $prevPeriodo->setVlPrevisto($this->getRequest()->get('vl_'.$i));
            $despesa->addFkOrcamentoPrevisaoDespesas($prevPeriodo);
        }
    }
    
    /**
     * @param Despesa $despesa
     */
    public function preUpdate($despesa)
    {
        /** @var PrevisaoReceita $previsaoDespesa */
        foreach ($despesa->getFkOrcamentoPrevisaoDespesas() as $previsaoDespesa) {
            $previsaoDespesa->setVlPrevisto($this->getRequest()->get('vl_' . $previsaoDespesa->getPeriodo()));
        }
    }
    
    /**
     * @param Despesa $despesa
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($despesa)
    {
        $container = $this->getConfigurationPool()->getContainer();
        
        $em = $this->modelManager
        ->getEntityManager($this->getClass());
        
        $despesaModel = new DespesaModel($em);
        
        $lancamentos = [];
        $anoExercicio = $despesa->getExercicio();
        $act = 'create';
        
        for ($i = 1;$i <= 11;$i++) {
            if ($i == 11) {
                $act = 'drop';
            } elseif ($i > 1) {
                $act = 'continue';
            }
            
            $delimitador = [
                'periodoIni' => date("01/m/Y", strtotime($anoExercicio."-".$i)),
                'periodoFim' => date("t/m/Y", strtotime($anoExercicio."-".($i+1))),
                'reduzidoIni' => $despesa->getCodDespesa(),
                'reduzidoFim' => $despesa->getCodDespesa()
            ];
            $i++;
            
            $lancamento = $despesaModel->getBalanceteDespesa(
                $anoExercicio,
                ' AND od.cod_entidade = 2 ',
                $delimitador,
                '',
                $despesa->getNumOrgao(),
                $despesa->getNumUnidade(),
                $act
            );
            
            if ($lancamento) {
                $lancamentos[] = $lancamento;
            }
        }
        
        if (count($lancamentos)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.elaboracaoDespesa.erroExcluir'));
            $em->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
    
    private function _loadConfigFromAcaoDespesa($acao)
    {
        $em = $this->modelManager
        ->getEntityManager($this->getClass());
        
        $acaoModel = new AcaoModel($em);
        
        $despesaConfig = $acaoModel->recuperaConfigDespesa($acao['exercicio'], $acao['codAcao'], $acao['codAno']);
        $despesaConfig = $despesaConfig[0];
        
        $orgao = $em->getRepository(Orgao::class)->findOneBy(['exercicio' => $acao['exercicio'], 'numOrgao' => $despesaConfig['num_orgao']]);
        $unidade = $em->getRepository(Unidade::class)->findOneBy(['exercicio' => $acao['exercicio'], 'numUnidade' => $despesaConfig['num_unidade']]);
        $funcao = $em->getRepository(Funcao::class)->findOneBy(['exercicio' => $acao['exercicio'], 'codFuncao' => $despesaConfig['cod_funcao']]);
        $subfuncao = $em->getRepository(Subfuncao::class)->findOneBy(['exercicio' => $acao['exercicio'], 'codSubfuncao' => $despesaConfig['cod_subfuncao']]);
        $programa = $em->getRepository(Programa::class)->findOneBy(['exercicio' => $acao['exercicio'], 'codPrograma' => $despesaConfig['cod_programa']]);
        $pao = $em->getRepository(Pao::class)->findOneBy(['exercicio' => $acao['exercicio'], 'numPao' => $despesaConfig['num_pao']]);
        
        return [
            'orgao' => $orgao,
            'unidade' => $unidade,
            'funcao' => $funcao,
            'subfuncao' => $subfuncao,
            'programa' => $programa,
            'pao' => $pao,
        ];
    }
}
