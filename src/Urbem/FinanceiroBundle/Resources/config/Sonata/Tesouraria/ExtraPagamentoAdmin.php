<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\TransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception\Error;

/**
 * Class ExtraPagamentoAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria
 */
class ExtraPagamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_extra_pagamento';
    protected $baseRoutePattern = 'financeiro/tesouraria/extra-pagamento';
    protected $includeJs = ['/financeiro/javascripts/tesouraria/arrecadacao/arrecadacaoExtra.js'];

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    /**
     * Rotas Personalizadas
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where(
            sprintf(
                "o.codTipo = %s and o.exercicio = '%s'",
                TransferenciaModel::PAGAMENTO_EXTRA,
                $this->getExercicio()
            )
        );
        $query->orderBy('o.codLote', 'DESC');

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codLote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ],
                'entity',
                [
                    'class' => Entity\Tesouraria\Transferencia::class,
                    'choice_label' => function ($lote) {
                        /** @var Entity\Tesouraria\Transferencia $lote */
                        return $lote->getCodLote().'/'.
                        $lote->getExercicio();
                    },
                    'query_builder' => function ($em) {
                        /** @var QueryBuilder $qb */
                        $qb = $em->createQueryBuilder('o');
                        $qb->where(
                            sprintf(
                                "o.codTipo = %s and o.exercicio = '%s'",
                                TransferenciaModel::PAGAMENTO_EXTRA,
                                $this->getExercicio()
                            )
                        );
                        $qb->orderBy('o.codLote');
                        return $qb;
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            )
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
                'codlote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codBoletim',
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.nomEntidade',
                ]
            )
            ->add(
                'recurso',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codRecurso',
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.extraPagamento.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig']
                    ]
                ]
            )
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $entidadeModel = new Model\Orcamento\EntidadeModel($em);
        $entidades = ArrayHelper::parseArrayToChoice($entidadeModel->getEntidades($this->getExercicio()), 'nom_cgm', 'cod_entidade');

        $exercicio = $this->getExercicio();

        $fieldOptions = [];
        $fieldOptions['valor'] = [
            'label' => 'label.reciboExtra.valor',
            'attr' => [
                'class' => 'money '
            ],
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.reciboExtra.observacao',
            'required' => false,
            'mapped' => false,
        ];

        $formMapper
            ->with('Filtro de recibo')
                ->add(
                    'entidade',
                    'choice',
                    [
                        'choices' => $entidades,
                        'label' => 'label.reciboExtra.codEntidade',
                        'placeholder' => 'label.selecione',
                        'mapped' => false,
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                    ]
                )
                ->add(
                    'boletim',
                    'choice',
                    [
                        'label' => 'label.reciboExtra.codBoletim',
                        'mapped' => false,
                        'required' => false,
                        'choices' => $this->preSetPostToChoice("boletim", []),
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                    ]
                )
                ->add(
                    'codRecibo',
                    'number',
                    [
                        'label' => 'label.reciboExtra.codRecibo',
                        'mapped' => false,
                        'required' => false,
                    ]
                )
                ->add(
                    'btnBuscaRecibo',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'FinanceiroBundle:Tesouraria\Arrecadacao:buttonArrecadacaoExtra.html.twig',
                        'data' => []
                    ]
                )
            ->end()
            ->with('label.reciboExtra.dadosPagamentoExtra', ['class' => 'dados-arrecadacao'])
                ->add(
                    'codCredor',
                    'autocomplete',
                    [
                        'label' => 'label.reciboExtra.credor',
                        'multiple' => false,
                        'mapped' => false,
                        'required' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_credor']
                    ]
                )
                ->add(
                    'codRecurso',
                    'autocomplete',
                    [
                        'label' => 'label.reciboExtra.codRecurso',
                        'multiple' => false,
                        'mapped' => false,
                        'required' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_recurso']
                    ]
                )
                ->add(
                    'codHistorico',
                    'autocomplete',
                    [
                        'label' => 'label.reciboExtra.codHistorico',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_historico_padrao']
                    ]
                )
                ->add(
                    'contaDespesa',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.extraPagamento.contaDespesa',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_conta_despesa']
                    ]
                )
                ->add(
                    'contaCaixa',
                    'autocomplete',
                    [
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_conta_caixa'],
                        'req_params' => [
                            'codEntidade' => 'varJsCodEntidade'
                        ]
                    ]
                )
                ->add(
                    'valor',
                    'number',
                    $fieldOptions['valor']
                )
                ->add(
                    'observacao',
                    'textarea',
                    $fieldOptions['observacao']
                )
            ->end()
        ;
    }

    /**
     * @param $codHistorico
     * @return mixed
     */
    public function getDescHistorico($codHistorico)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $hist = $em->getRepository(Entity\Contabilidade\HistoricoContabil::class)->findOneBy(['codHistorico' => $codHistorico]);
        return $hist;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->customHeader = 'FinanceiroBundle::Tesouraria\Estorno\header.html.twig';

        $historico = $this->getSubject();
        $historicoVal = $this->getDescHistorico($historico->getCodHistorico());

        $showMapper
            ->with("Pagamento extra")
            ->add(
                'codRecibo',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codRecibo',
                ]
            )
            ->add(
                'codLote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codBoletim',
                ]
            )
            ->add(
                'dtBoletim',
                'date',
                [
                    'label' => 'label.tesouraria.extraPagamento.dtBoletim',
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.nomEntidade',
                ]
            )
            ->add(
                'nomCredor',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.credor',
                ]
            )
            ->add(
                'recurso',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codRecurso',
                ]
            )
            ->add(
                'planoDebito',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.contaDespesa',
                ]
            )
            ->add(
                'planoCredito',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.contaCredito',
                ]
            )
            ->add(
                'historico',
                'text',
                [
                    'label' => 'label.tesouraria.extraPagamento.codHistorico',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => $historicoVal
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.extraPagamento.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                'valorEstornado',
                'currency',
                [
                    'label' => 'label.tesouraria.extraPagamento.valorEstornado',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.observacao',
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Entity\Tesouraria\Transferencia $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();
        $valor = $formContent->valor;

        $paramsBoletim = [
            sprintf('cod_boletim = %s', $formContent->boletim),
            sprintf('cod_entidade = %s', $formContent->entidade),
        ];
        $boletim = new Model\Tesouraria\Boletim\BoletimModel($em);
        $boletim = current($boletim->getBoletins($paramsBoletim));
        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        // valida a utilização da rotina de encerramento do mês contábil
        $arrecadacaoModel = new ArrecadacaoModel($em);
        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.encerramentoMesContabil');
            $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        if ($valor <= 0) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.campoMaiorZero');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    /**
     * Realiza as modificações necessárias para a persistência dos dados
     *
     * @param Entity\Tesouraria\Transferencia $object
     * @param Form $form
     */
    public function saveRelationships($transferencia, $form)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $transferenciaRepository = $em->getRepository('CoreBundle:Tesouraria\Transferencia');

        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();

        $contaDebito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->contaDespesa, 'exercicio' => $exercicio]
        );
        $contaCredito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->contaCaixa, 'exercicio' => $exercicio]
        );

        $boletim = $em->getRepository(Entity\Tesouraria\Boletim::class)->findOneBy([
            'codBoletim' => $formContent->boletim,
            'exercicio' => $exercicio,
            'codEntidade' => $formContent->entidade
        ]);

        //PlanoAnalitica -> Conta Débito
        $transferencia->setFkContabilidadePlanoAnalitica($contaDebito);
        //PlanoAnalitica -> Conta Crédito
        $transferencia->setFkContabilidadePlanoAnalitica1($contaCredito);
        //Boletim
        $transferencia->setFkTesourariaBoletim($boletim);
        //Valor
        $transferencia->setValor($formContent->valor);
        //Observacao
        $transferencia->setObservacao($formContent->observacao);

        $arrecadacaoModel = new TransferenciaModel($em);
        $transferencia = $arrecadacaoModel->parseTransferencia($transferencia, $formContent, $exercicio, $tipoMovimento = TransferenciaModel::PAGAMENTO_EXTRA);

        // Processa Lancamento
        $sequencia = $transferenciaRepository->gerarLancamento($transferencia);

        $em->persist($transferencia);
        $em->flush();
    }

    /**
     * Função executada antes do Persist
     *
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $transferencia = new Entity\Tesouraria\Transferencia();
            $this->saveRelationships($transferencia, $this->getForm());

            $container->get('session')->getFlashBag()->add('success', "Item gravado com sucesso");
            $this->forceRedirect(
                "/financeiro/tesouraria/extra-pagamento/list"
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/tesouraria/extra-pagamento/create"
            );
        }
    }
}
