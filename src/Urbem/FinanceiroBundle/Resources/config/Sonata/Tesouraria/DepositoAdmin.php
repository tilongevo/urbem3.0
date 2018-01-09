<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Exception;
use Sonata\AdminBundle\Route\RouteCollection;

class DepositoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_deposito';
    protected $baseRoutePattern = 'financeiro/tesouraria/deposito';
    protected $includeJs = ['/financeiro/javascripts/tesouraria/arrecadacao/arrecadacaoExtra.js'];

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoVoltar = false;

    /**
     * Rotas Personalizadas
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'detalhe',
            sprintf('detalhe/%s', $this->getRouterIdParameter())
        );
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
        }

        $query->where(
            sprintf(
                "o.codTipo = %s and o.exercicio = '%s'",
                Model\Tesouraria\TransferenciaModel::DEPOSITO,
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
                    'label' => 'label.tesouraria.depositos.codLote',
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
                        $qb->where(sprintf('o.codTipo = %s', Model\Tesouraria\TransferenciaModel::DEPOSITO));
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
                    'label' => "label.tesouraria.depositos.codLote"
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => "label.tesouraria.depositos.codBoletim"
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => "label.tesouraria.depositos.nomEntidade"
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.depositos.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => "money"
                    ]
                ]
            )
            ->add(
                '_action',
                'actions',
                ['actions' => array(
                    'detalhe' => array('template' => 'FinanceiroBundle::Tesouraria/OutrasOperacoes/Deposito/list__action_detalhe.html.twig')
                )]
            );
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
            ->with('label.tesouraria.depositos.dados')
            ->add(
                'entidade',
                'choice',
                [
                    'label' => "label.tesouraria.depositos.nomEntidade",
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
                    'label' => "label.tesouraria.depositos.codBoletim",
                    'mapped' => false,
                    'required' => true,
                    'choices' => $this->preSetPostToChoice("boletim", []),
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                ]
            )
            ->end()
            ->with(' ', ['class' => 'dados-arrecadacao'])
            ->add(
                'contaPlanoCredito',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.depositos.contaCredito',
                    'multiple' => false,
                    'mapped' => false,
                    'route' => ['name' => 'tesouraria_outras_operacoes_get_contas_by_entidade'],
                    'req_params' => [
                        'codEntidade' => 'varJsCodEntidade',
                        'tipoOperacao' => Model\Tesouraria\TransferenciaModel::DEPOSITO,
                    ]
                ]
            )
            ->add(
                'contaPlanoDebito',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.depositos.contaDebito',
                    'multiple' => false,
                    'mapped' => false,
                    'route' => ['name' => 'tesouraria_outras_operacoes_get_contas_by_entidade'],
                    'req_params' => [
                        'codEntidade' => 'varJsCodEntidade',
                        'tipoOperacao' => Model\Tesouraria\TransferenciaModel::DEPOSITO,
                    ]
                ]
            )
            ->add(
                'codHistorico',
                'autocomplete',
                [
                    'label' => 'label.tesouraria.depositos.codHistorico',
                    'multiple' => false,
                    'mapped' => false,
                    'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_historico_padrao'],
                    'req_params' => [
                        'codEntidade' => 'varJsCodEntidade',
                        'tipoOperacao' => Model\Tesouraria\TransferenciaModel::DEPOSITO,
                    ]
                ]
            )
            ->add(
                'valor',
                'number',
                [
                    'label' => 'label.tesouraria.depositos.valor',
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
                    'label' => "label.tesouraria.depositos.observacao",
                    'mapped' => false,
                    'required' => false,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost($formSonata = true);
        $exercicio = $this->getExercicio();
        $valor = $formContent->valor;

        $contaDebito = $formContent->contaPlanoDebito;
        $contaCredito = $formContent->contaPlanoCredito;
        
        if ($valor <= 0) {
            $error = $this->getTranslator()->trans("label.tesouraria.depositos.validacoes.campoMaiorZero");
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }

        if ($contaDebito == $contaCredito) {
            $error = $this->getTranslator()->trans("label.tesouraria.depositos.validacoes.campoSimilar", array('%numeroConta%' => $contaCredito));
            $errorElement->with('conta')->addViolation($error)->end();
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
            $error = $this->getTranslator()->trans("label.tesouraria.aplicacoes.validacoes.encerramentoMesContabil");
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
            ['codPlano' => $formContent->contaPlanoDebito, 'exercicio' => $exercicio]
        );
        $contaCredito = $em->getRepository(Entity\Contabilidade\PlanoAnalitica::class)->findOneBy(
            ['codPlano' => $formContent->contaPlanoCredito, 'exercicio' => $exercicio]
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
            $tipoMovimento = Model\Tesouraria\TransferenciaModel::DEPOSITO
        );

        // Processa Lancamento
        $sequencia = $transferenciaRepository->gerarLancamento($transferencia);

        $em->persist($transferencia);
        $em->flush();

        return $transferencia;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $transferencia = new Entity\Tesouraria\Transferencia();
            $transferencia = $this->saveRelationships($transferencia);
            $message = $this->getTranslator()->trans('label.tesouraria.depositos.sucesso', array('%codLote%' => $transferencia->getCodLote(), '%exercicio%' => $transferencia->getExercicio()));
            $container->get('session')->getFlashBag()->add('success', $message);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Exception\Error::ERROR_PERSIST_DATA);
        } finally {
            $this->forceRedirect("/financeiro/tesouraria/deposito/create");
        }
    }
    
    /**
     * @param $object
     * @return string
     */
    public function toString($object)
    {
        return $object->getCodRecurso()
            ? $object
            : $this->getTranslator()->trans('label.tesouraria.depositos.transferencia');
    }
}
