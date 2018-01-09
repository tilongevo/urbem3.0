<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Tesouraria\TransferenciaModel;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ArrecadacaoExtraAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes';
    protected $baseRoutePattern = 'financeiro/tesouraria/arrecadacao/extra-arrecadacoes';
    protected $includeJs = ['/financeiro/javascripts/tesouraria/arrecadacao/arrecadacaoExtra.js'];

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("delete");
        $collection->remove("export");
        $collection->remove("batch");
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where(
            sprintf(
                "o.codTipo = %s and o.exercicio = '%s'",
                TransferenciaModel::ARRECADACAO_EXTRA,
                $this->getExercicio()
            )
        );

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
                    'label' => "label.tesouraria.extraArrecadacao.codLote"
                ],
                'entity',
                [
                    'class' => Entity\Tesouraria\Transferencia::class,
                    'choice_label' => function ($lote) {

                        return $lote->getCodLote().'/'.
                        $lote->getExercicio();
                    },
                    'query_builder' => function ($em) {

                        $qb = $em->createQueryBuilder('o');
                        $qb->where(
                            sprintf(
                                "o.codTipo = %s and o.exercicio = '%s'",
                                TransferenciaModel::ARRECADACAO_EXTRA,
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
                'codLote',
                null,
                [
                    'label' => "label.tesouraria.extraArrecadacao.codLote"
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => "label.tesouraria.extraArrecadacao.codBoletim"
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => "label.tesouraria.extraArrecadacao.nomEntidade"
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => "label.tesouraria.extraArrecadacao.valorArrecadado",
                    'currency' => 'BRL',
                    'attr' =>
                    [
                        'class' => 'money '
                    ]
                ]
            )
            ->add(
                'valorEstornado',
                'currency',
                [
                    'label' => "label.tesouraria.extraArrecadacao.valorEstornado",
                    'currency' => 'BRL',
                    'attr' =>
                    [
                        'class' => 'money '
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
        $em = $this->modelManager->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entidadeModel = new EntidadeModel($em);
        $entidades = ArrayHelper::parseArrayToChoice($entidadeModel->getEntidades($this->getExercicio()), 'nom_cgm', 'cod_entidade');

        $formMapper
            ->with('Filtro de recibo')
                ->add(
                    'entidade',
                    'choice',
                    [
                        'choices' => $entidades,
                        'placeholder' => 'Selecione',
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
                        'label' => 'label.tesouraria.extraArrecadacao.codBoletim',
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
                        'label' => 'label.tesouraria.extraArrecadacao.codRecibo',
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
            ->with('Dados para Arrecadações', ['class' => 'dados-arrecadacao'])
                ->add(
                    'codCredor',
                    'autocomplete',
                    [
                        'label' => 'label.reciboExtra.credor',
                        'multiple' => false,
                        'mapped' => false,
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
                    'contaReceita',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.extraArrecadacao.contaReceita',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_conta_receita']
                    ]
                )
                ->add(
                    'contaCaixa',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.extraArrecadacao.contaCredito',
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
                    'text',
                    [
                        'label' => 'label.tesouraria.extraArrecadacao.valorArrecadado',
                        'mapped' => false,
                    ]
                )
                ->add(
                    'observacao',
                    'textarea',
                    [
                        'label' => "label.tesouraria.extraArrecadacao.observacao",
                        'mapped' => false,
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->customHeader = 'FinanceiroBundle::Tesouraria\Estorno\header.html.twig';

        $showMapper
            ->with("Arrecadações extra")
                ->add(
                    'codRecibo',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.codRecibo"
                    ]
                )
                ->add(
                    'codLote',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.codLote"
                    ]
                )
                ->add(
                    'codBoletim',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.codBoletim"
                    ]
                )
                ->add(
                    'dtBoletim',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.dtboletim"
                    ]
                )
                ->add(
                    'nomEntidade',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.nomEntidade"
                    ]
                )
                ->add(
                    'credor',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.credor"
                    ]
                )
                ->add(
                    'codRecurso',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.codRecurso"
                    ]
                )
                ->add(
                    'contaReceita',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.contaReceita"
                    ]
                )
                ->add(
                    'contaCreditoBanco',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.contaCredito"
                    ]
                )
                ->add(
                    'codHistorico',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.codHistorico"
                    ]
                )
                ->add(
                    'valor',
                    'currency',
                    [
                        'label' => "label.tesouraria.extraArrecadacao.valorArrecadado",
                        'currency' => 'BRL',
                        'attr' =>
                        [
                            'class' => 'money '
                        ]
                    ]
                )
                ->add(
                    'valorEstornado',
                    'currency',
                    [
                        'label' => "label.tesouraria.extraArrecadacao.valorEstornado",
                        'currency' => 'BRL',
                        'attr' =>
                        [
                            'class' => 'money '
                        ]
                    ]
                )
                ->add(
                    'observacao',
                    null,
                    [
                        'label' => "label.tesouraria.extraArrecadacao.observacao"
                    ]
                )
                ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param Entity\Tesouraria\Transferencia $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();
        $valor = $formContent->valor;

        $paramsBoletim = [
            sprintf('cod_boletim = %s', $formContent->boletim),
            sprintf('cod_entidade = %s', $formContent->entidade),
        ];
        $boletim = new BoletimModel($em);
        $boletim = current($boletim->getBoletins($paramsBoletim));
        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        // valida a utilização da rotina de encerramento do mês contábil
        $arrecadacaoModel = new ArrecadacaoModel($em);
        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraArrecadacao.validacoes.encerramentoMesContabil');
            $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        if ($valor <= 0) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraArrecadacao.validacoes.campoMaiorZero');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    public function saveRelationships($transferencia)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $transferenciaRepository = $em->getRepository('CoreBundle:Tesouraria\Transferencia');

        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();

        $contaDebito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->contaReceita, 'exercicio' => $exercicio]
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
        $valor = (float) preg_replace('/,/', '.', preg_replace('/\./', '', $formContent->valor, 1), 1);
        $transferencia->setValor($valor);
        //Observacao
        $transferencia->setObservacao($formContent->observacao);

        $arrecadacaoModel = new TransferenciaModel($em);
        $transferencia = $arrecadacaoModel->parseTransferencia($transferencia, $formContent, $exercicio, $tipoMovimento = TransferenciaModel::ARRECADACAO_EXTRA);

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
            $this->saveRelationships($transferencia);

            $container->get('session')->getFlashBag()->add('success', "Item gravado com sucesso");
            $this->forceRedirect(
                "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/list"
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Exception\Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/create"
            );
        }
    }
}
