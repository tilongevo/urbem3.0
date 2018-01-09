<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoCredito;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfigurarLancamentoDespesaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_configurar_lancamento_despesa';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/configurar-lancamento-despesa';
    protected $includeJs = ['/financeiro/javascripts/contabilidade/configuracao/configurar_lancamento_despesa.js'];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFake')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFake')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param $array
     * @return array
     */
    public function parseData($array)
    {
        $listChoices = [];
        $listArray = [];
        foreach ($array as $valor) {
            $descricao = $valor['nom_conta'];
            $mascara = $valor['cod_estrutural'];
            $choiceValue = $valor['cod_conta'];
            $choiceKey = $mascara . " - " . $descricao;
            $listChoices[$choiceKey] = $choiceValue;
            $listArray[$choiceValue] = $choiceKey;
        }
        return [
            'listChoice' => $listChoices,
            'listArray' => $listArray
        ];
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager(ConfiguracaoLancamentoDebito::class);

        $contasDespesas = $em->getRepository(ContaDespesa::class)->findBy([
            'exercicio' => $this->getExercicio(),
        ], ['codEstrutural' => 'ASC']);

        $despesas = [];
        foreach ($contasDespesas as $contaDespesa) {
            $despesas[$contaDespesa->getCodEstrutural()] = $contaDespesa->getCodConta();
        }

        $despesasList = $em->getRepository(ContaDespesa::class)->getContaDespesaList();

        $despesasListChoices = [];
        $despesasListArray = [];
        foreach ($despesasList as $despesa) {
            $descricao = $despesa['descricao'];
            $mascara = $despesa['mascara_classificacao'];
            $choiceValue = $despesa['cod_conta'];
            $choiceKey = $mascara . " - " . $descricao;
            $despesasListChoices[$choiceKey] = $choiceValue;
            $despesasListArray[$choiceValue] = $choiceKey;
        }

        $debitoLiquidacaoLancamentoList = $em->getRepository(ContaDespesa::class)
            ->getContasByMascarasAndExercicio($this->getExercicio(), '');

        $contasArray = [];
        foreach ($debitoLiquidacaoLancamentoList as $contaDespesa) {
            $contasArray[$contaDespesa['cod_estrutural'] . ' - '. $contaDespesa['nom_conta']] = $contaDespesa['cod_conta'];
        }

        $debitoAlmoxarifadoLancamentoList = $em->getRepository(ContaDespesa::class)
            ->getContasByMascarasAndExercicio($this->getExercicio(), '3.3.1.1', true);
        $debitoAlmoxarifadoLancamentoInfo = $this->parseData($debitoAlmoxarifadoLancamentoList);
        $debitoAlmoxarifadoLancamentoChoice = $debitoAlmoxarifadoLancamentoInfo['listChoice'];

        $creditoAlmoxarifadoLancamentolist = $em->getRepository(ContaDespesa::class)
            ->getContasByMascarasAndExercicio($this->getExercicio(), '1.1.5.6', true);

        $creditoAlmoxarifadoLancamentoInfo = $this->parseData($creditoAlmoxarifadoLancamentolist);
        $creditoAlmoxarifadoLancamentoChoice = $creditoAlmoxarifadoLancamentoInfo['listChoice'];

        $formMapper
            ->with('label.listaDespesas')
                ->add(
                    'exercicio',
                    'hidden',
                    [
                        'mapped' => false,
                        'data' => $this->getExercicio(),
                    ]
                )
                ->add(
                    'listaDespesaFiltro',
                    ChoiceType::class,
                    [
                        'choices' => $despesasListChoices,
                        'label' => 'label.descricao',
                        'placeholder' => 'label.selecione',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                    ]
                )
            ->end()

            ->with('label.despesa')
                ->add(
                    'despesaFiltro',
                    ChoiceType::class,
                    [
                        'label' => 'label.descricao',
                        'placeholder' => 'label.selecione',
                        'attr' => array(
                            'class' => 'select2-parameters'
                        ),
                        'choice_value' => function ($value) {
                            return $value;
                        },
                        'required' => true,
                        'choices' => $despesas
                    ]
                )
            ->end()

            ->with('label.lancamentoLiquidacao')
                ->add(
                    'lancamento',
                    ChoiceType::class,
                    [
                        'label' => 'label.lancamentos',
                        'choices' => [
                            'label.despesaMaterialConsumo' => 1,
                            'label.despesaMaterialPermanente' => 2,
                            'label.despesaPessoal' => 3,
                            'label.demaisDespesas' => 4,
                        ],
                        'attr' => array(
                            'data-sonata-select2' => 'false',
                        ),
                        'mapped' => true,
                        'required' => true,
                        'placeholder' => 'label.selecione',
                    ]
                )
            ->end()

            ->with('label.contasParaLancamento')
                ->add(
                    'debitoLiquidacaoLancamento',
                    ChoiceType::class,
                    [
                        'label' => 'label.debito',
                        'placeholder' => 'label.selecione',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'choice_value' => function ($value) {
                            return $value;
                        },
                        'required' => false,
                        'choices' => $contasArray,

                    ]
                )
            ->add(
                'creditoLiquidacaoLancamento',
                ChoiceType::class,
                [
                    'label' => 'label.credito',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'choice_value' => function ($value) {
                        return $value;
                    },
                    'required' => false,
                    'choices' => $contasArray,
                ]
            )
            ->end()

            ->with('label.almoxarifadoContasParaLancamento')
                ->add(
                    'debitoAlmoxarifadoLancamento',
                    ChoiceType::class,
                    [
                        'label' => 'label.debito',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'required' => false,
                        'placeholder' => 'label.selecione',
                        'choices' => $debitoAlmoxarifadoLancamentoChoice,
                    ]
                )
                ->add(
                    'creditoAlmoxarifadoLancamento',
                    ChoiceType::class,
                    [
                        'label' => 'label.credito',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'required' => false,
                        'placeholder' => 'label.selecione',
                        'choices' => $creditoAlmoxarifadoLancamentoChoice,
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
        $showMapper
            ->add('codFake')
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $despesaFiltro = $this->getForm()->get('despesaFiltro')->getData();
        if (is_null($despesaFiltro)) {
            $error = $this->trans('financeiro.configurarLancamentoDespesa.despesaObrigatorio', [], 'flashes');
            $errorElement->with('despesaFiltro')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager(ConfiguracaoLancamentoDebito::class);

        try {
            $despesaFiltro = $this->getForm()->get('despesaFiltro')->getData();

            $contaDespesa = $em->getRepository(ContaDespesa::class)
                ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $despesaFiltro]);

            // Liquidacao - Debito
            $debitoLiquidacaoLancamento = $this->getForm()->get('debitoLiquidacaoLancamento')->getData();
            if ($debitoLiquidacaoLancamento) {
                $configuracaoLancamentoDebito = $em->getRepository(ConfiguracaoLancamentoDebito::class)
                    ->findOneBy([
                        'exercicio' => $this->getExercicio(),
                        'codConta' => $debitoLiquidacaoLancamento,
                        'tipo' => PlanoContaModel::TYPE_LIQUIDACAO,
                        'codContaDespesa' => $despesaFiltro
                    ]);

                // Liquidacao - Debito
                if (!$configuracaoLancamentoDebito) {
                    $configuracaoLancamentoDebito = new ConfiguracaoLancamentoDebito();
                }

                $planoContaObj = $em->getRepository(PlanoConta::class)
                    ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $debitoLiquidacaoLancamento]);

                $configuracaoLancamentoDebito->setTipo(PlanoContaModel::TYPE_LIQUIDACAO);
                $configuracaoLancamentoDebito->setEstorno(false);
                $configuracaoLancamentoDebito->setFkContabilidadePlanoConta($planoContaObj);
                $configuracaoLancamentoDebito->setFkOrcamentoContaDespesa($contaDespesa);
                $configuracaoLancamentoDebito->setRpps(false);

                $em->persist($configuracaoLancamentoDebito);
            }

            // Liquidacao - Credito
            $creditoLiquidacaoLancamento = $this->getForm()->get('creditoLiquidacaoLancamento')->getData();
            if ($creditoLiquidacaoLancamento) {
                $configuracaoLancamentoCredito = $em->getRepository(ConfiguracaoLancamentoCredito::class)
                    ->findOneBy([
                        'exercicio' => $this->getExercicio(),
                        'codConta' => $creditoLiquidacaoLancamento,
                        'tipo' => PlanoContaModel::TYPE_LIQUIDACAO,
                        'codContaDespesa' => $despesaFiltro
                    ]);

                if (!$configuracaoLancamentoCredito) {
                    $configuracaoLancamentoCredito = new ConfiguracaoLancamentoCredito();
                }

                $planoContaObj = $em->getRepository(PlanoConta::class)
                    ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $creditoLiquidacaoLancamento]);

                $configuracaoLancamentoCredito->setTipo(PlanoContaModel::TYPE_LIQUIDACAO);
                $configuracaoLancamentoCredito->setEstorno(true);
                $configuracaoLancamentoCredito->setFkContabilidadePlanoConta($planoContaObj);
                $configuracaoLancamentoCredito->setFkOrcamentoContaDespesa($contaDespesa);
                $configuracaoLancamentoCredito->setRpps(false);

                $em->persist($configuracaoLancamentoCredito);
            }

            // Almoxarifado - Debito
            if ($object->getDebitoAlmoxarifadoLancamento()) {
                $configuracaoLancamentoDebitoAlmoxarifado = $em->getRepository(ConfiguracaoLancamentoDebito::class)
                    ->findOneBy([
                        'exercicio' => $this->getExercicio(),
                        'codConta' => $object->getDebitoAlmoxarifadoLancamento(),
                        'tipo' => PlanoContaModel::TYPE_ALMOXARIFADO,
                        'codContaDespesa' => $despesaFiltro
                    ]);

                if (!$configuracaoLancamentoDebitoAlmoxarifado) {
                    $configuracaoLancamentoDebitoAlmoxarifado = new ConfiguracaoLancamentoDebito();
                }

                $planoContaObj = $em->getRepository(PlanoConta::class)
                    ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $object->getDebitoAlmoxarifadoLancamento()]);

                $configuracaoLancamentoDebitoAlmoxarifado->setExercicio($this->getExercicio());
                $configuracaoLancamentoDebitoAlmoxarifado->setTipo(PlanoContaModel::TYPE_ALMOXARIFADO);
                $configuracaoLancamentoDebitoAlmoxarifado->setEstorno(false);
                $configuracaoLancamentoDebitoAlmoxarifado->setFkContabilidadePlanoConta($planoContaObj);
                $configuracaoLancamentoDebitoAlmoxarifado->setFkOrcamentoContaDespesa($contaDespesa);
                $configuracaoLancamentoDebitoAlmoxarifado->setRpps(false);

                $em->persist($configuracaoLancamentoDebitoAlmoxarifado);
            }

            // Almoxarifado - Credito
            if ($object->getCreditoAlmoxarifadoLancamento()) {
                $configuracaoLancamentoCreditoAlmoxarifado = $em->getRepository(ConfiguracaoLancamentoCredito::class)
                    ->findOneBy([
                        'exercicio' => $this->getExercicio(),
                        'codConta' => $object->getCreditoAlmoxarifadoLancamento(),
                        'tipo' => PlanoContaModel::TYPE_ALMOXARIFADO,
                        'codContaDespesa' => $despesaFiltro
                    ]);

                if (!$configuracaoLancamentoCreditoAlmoxarifado) {
                    $configuracaoLancamentoCreditoAlmoxarifado = new ConfiguracaoLancamentoCredito();
                }

                $planoContaObj = $em->getRepository(PlanoConta::class)
                    ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $object->getCreditoAlmoxarifadoLancamento()]);

                $configuracaoLancamentoCreditoAlmoxarifado->setTipo(PlanoContaModel::TYPE_ALMOXARIFADO);
                $configuracaoLancamentoCreditoAlmoxarifado->setEstorno(true);
                $configuracaoLancamentoCreditoAlmoxarifado->setFkContabilidadePlanoConta($planoContaObj);
                $configuracaoLancamentoCreditoAlmoxarifado->setFkOrcamentoContaDespesa($contaDespesa);
                $configuracaoLancamentoCreditoAlmoxarifado->setRpps(false);

                $em->persist($configuracaoLancamentoCreditoAlmoxarifado);
            }

            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.configurarLancamentoDespesa.sucesso'));
            $this->forceRedirect('/financeiro/contabilidade/configuracao/configurar-lancamento-despesa/create');
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.configurarLancamentoDespesa.erro'));
            throw $e;
        }
    }
}
