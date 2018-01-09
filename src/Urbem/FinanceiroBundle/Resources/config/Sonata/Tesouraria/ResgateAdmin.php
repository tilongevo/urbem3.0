<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception;
use Sonata\AdminBundle\Route\RouteCollection;

class ResgateAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_resgate';
    protected $baseRoutePattern = 'financeiro/tesouraria/resgate';
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
                Model\Tesouraria\TransferenciaModel::RESGATE,
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
                    'label' => 'label.tesouraria.resgate.codLote',
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
                        $qb->where(sprintf('o.codTipo = %s', Model\Tesouraria\TransferenciaModel::RESGATE));
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
                    'label' => 'label.tesouraria.resgate.codLote',
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.resgate.codBoletim',
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.resgate.nomEntidade',
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.resgate.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => "money"
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

        $formMapper
            ->with('Filtro de boletim')
                ->add(
                    'entidade',
                    'choice',
                    [
                        'label' => 'label.tesouraria.resgate.nomEntidade',
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
                        'label' => 'label.tesouraria.resgate.codBoletim',
                        'mapped' => false,
                        'required' => false,
                        'choices' => $this->preSetPostToChoice("boletim", []),
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                    ]
                )
            ->end()
            ->with('Dados para resgate', ['class' => 'dados-arrecadacao'])
                ->add(
                    'codHistorico',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.resgate.codHistorico',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_historico_padrao'],
                        'req_params' => [
                            'tipoOperacao' => Model\Tesouraria\TransferenciaModel::RESGATE,
                        ]
                    ]
                )
                ->add(
                    'codPlanoDebito',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.resgate.contaDebito',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_outras_operacoes_get_contas_by_entidade'],
                        'req_params' => [
                            'codEntidade' => 'varJsCodEntidade'
                        ]
                    ]
                )
                ->add(
                    'codPlanoCredito',
                    'autocomplete',
                    [
                        'label' => 'label.tesouraria.resgate.contaCredito',
                        'multiple' => false,
                        'mapped' => false,
                        'route' => ['name' => 'tesouraria_outras_operacoes_get_contas_by_entidade'],
                        'req_params' => [
                            'codEntidade' => 'varJsCodEntidade'
                        ]
                    ]
                )
                ->add(
                    'valor',
                    'number',
                    [
                        'label' => 'label.tesouraria.resgate.valor',
                        'mapped' => false,
                        'attr' => [
                            'class' => 'money '
                        ],
                    ]
                )
                ->add(
                    'observacao',
                    'textarea',
                    [
                        'label' => 'label.tesouraria.resgate.observacao',
                        'mapped' => false,
                        'required' => false,
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

        $showMapper
            ->with("Resgate")
            ->add(
                'codLote',
                null,
                [
                    'label' => 'label.tesouraria.resgate.codLote'
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.resgate.codBoletim'
                ]
            )
            ->add(
                'dtBoletim',
                null,
                [
                    'label' => 'label.tesouraria.resgate.dtBoletim'
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.resgate.nomEntidade'
                ]
            )
            ->add(
                'codPlanoDebito',
                null,
                [
                    'label' => 'label.tesouraria.resgate.contaDebito'
                ]
            )
            ->add(
                'codPlanoCredito',
                null,
                [
                    'label' => 'label.tesouraria.resgate.contaCredito'
                ]
            )
            ->add(
                'codHistorico',
                null,
                [
                    'label' => 'label.tesouraria.resgate.codHistorico'
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => "label.tesouraria.resgate.valor",
                    'currency' => "BRL"
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => "label.tesouraria.resgate.observacao",
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
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();
        $valor = $formContent->valor;

        $contaDebito = $formContent->codPlanoDebito;
        $contaCredito = $formContent->codPlanoCredito;

        if ($valor <= 0) {
            $error = $this->translate("label.tesouraria.aplicacoes.validacoes.campoMaiorZero");
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }

        if ($contaDebito == $contaCredito) {
            $error = $this->translate("label.tesouraria.aplicacoes.validacoes.campoSimilar");
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }

        $paramsBoletim = [
            sprintf('cod_boletim = %s', $formContent->boletim),
            sprintf('cod_entidade = %s', $formContent->entidade),
        ];
        $boletim = new Model\Tesouraria\Boletim\BoletimModel($em);
        $boletim = current($boletim->getBoletins($paramsBoletim));
        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        // valida a utilização da rotina de encerramento do mês contábil
        $arrecadacaoModel = new Model\Tesouraria\ArrecadacaoModel($em);
        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $error = $this->translate("label.tesouraria.aplicacoes.validacoes.encerramentoMesContabil");
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }

    /**
     * @param Entity\Tesouraria\Transferencia $transferencia
     */
    public function saveRelationships($transferencia)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Tesouraria\Transferencia');
        $transferenciaRepository = $em->getRepository('CoreBundle:Tesouraria\Transferencia');
        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();

        $contaDebito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->codPlanoDebito, 'exercicio' => $exercicio]
        );
        $contaCredito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->codPlanoCredito, 'exercicio' => $exercicio]
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

        $transferenciaModel = new Model\Tesouraria\TransferenciaModel($em);
        $transferencia = $transferenciaModel->parseTransferencia(
            $transferencia,
            $formContent,
            $exercicio,
            $tipoMovimento = Model\Tesouraria\TransferenciaModel::RESGATE
        );

        // Processa Lancamento
        $sequencia = $transferenciaRepository->gerarLancamento($transferencia);

        $em->persist($transferencia);
        $em->flush();
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $transferencia = new Entity\Tesouraria\Transferencia();
            $this->saveRelationships($transferencia);

            $container->get('session')->getFlashBag()->add('success', "Resgate realizada");
            $this->forceRedirect(
                "/financeiro/tesouraria/resgate/list"
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Exception\Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/tesouraria/resgate/create"
            );
        }
    }
}
