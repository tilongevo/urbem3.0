<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoDebito;
use Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoLancamentoReceitaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_configurar_lancamento_receita';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/configurar-lancamento-receita';
    protected $includeJs = [
        '/financeiro/javascripts/contabilidade/configuracao/configurar_lancamento_receita.js'
    ];

    const ESTORNO_LANCAMENTO = true;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('estorno')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('estorno')
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager(ConfiguracaoLancamentoDebito::class);

        $contasReceita = $em->getRepository(ContaReceita::class)
            ->getContaReceitaListByExercicio($this->getExercicio());

        $contasReceitaList = [];
        foreach ($contasReceita as $conta) {
            $contasReceitaList[$conta['cod_estrutural'] . ' - '. $conta['descricao']] = $conta['cod_conta'];
        }

        $contas = $em->getRepository(PlanoConta::class)
            ->getContaCreditoLancamentoListByExercicioAndCodEstrutural($this->getExercicio(), '', false);

        $contasList = [];
        foreach ($contas as $conta) {
            $contasList[$conta['cod_estrutural'] . ' - '. $conta['nom_conta']] = $conta['cod_conta'];
        }

        $formMapper
            ->with('label.registros')
                ->add(
                    'exercicio',
                    'hidden',
                    [
                        'mapped' => false,
                        'data' => $this->getExercicio(),
                    ]
                )
                ->add(
                    'codContaReceita',
                    'choice',
                    [
                        'label' => 'label.codigo',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'required' => true,
                        'placeholder' => 'label.selecione',
                        'choices' => $contasReceitaList,
                    ]
                )
            ->end()
            ->with('label.lancamentoReceita')
                ->add(
                    'lancamento',
                    'choice',
                    [
                        'label' => 'label.lancamentos',
                        'choices' => [
                            'label.selecione' => 0,
                            'label.arrecadacaoDireta' => 1,
                            'label.operacoesCredito' => 2,
                            'label.aliencacaoBensMoveisImoveis' => 3,
                            'label.dividaAtiva' => 4,
                        ],
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'mapped' => false,
                        'required' => true
                    ]
                )
            ->end()
            ->with('label.contaLancamento')
                ->add(
                    'codConta',
                    ChoiceType::class,
                    [
                        'label' => 'label.credito',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        ),
                        'placeholder' => 'label.selecione',
                        'required' => true,
                        'choices' => $contasList,
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
            ->add('exercicio')
            ->add('estorno')
        ;
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
            $codContaReceita = $this->getForm()->get('codContaReceita')->getData();
            $contaReceita = $em->getRepository(ContaReceita::class)
                ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $codContaReceita]);

            $codConta = $this->getForm()->get('codConta')->getData();
            if (!$codConta) {
                $codConta = $this->getRequest()->request->get('codConta_');
                $codConta = (int) $codConta;
            }

            $planoConta = $em->getRepository(PlanoConta::class)
                ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $codConta]);

            $configuracaoLancamentoReceita = $em->getRepository(ConfiguracaoLancamentoReceita::class)
                ->findOneBy(
                    [
                        'exercicio' => $this->getExercicio(),
                        'codConta' => $codConta,
                        'codContaReceita' => $contaReceita->getCodConta()
                    ]
                );
            if (!$configuracaoLancamentoReceita) {
                $configuracaoLancamentoReceita = new ConfiguracaoLancamentoReceita();
                $configuracaoLancamentoReceita->setFkOrcamentoContaReceita($contaReceita);
                $configuracaoLancamentoReceita->setFkContabilidadePlanoConta($planoConta);
                $configuracaoLancamentoReceita->setEstorno(self::ESTORNO_LANCAMENTO);
                $em->persist($configuracaoLancamentoReceita);
                $em->flush();
            }

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.configurarLancamentoReceita.sucesso'));
            $this->forceRedirect('/financeiro/contabilidade/configuracao/configurar-lancamento-receita/create');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.configurarLancamentoReceita.erro'));
            throw $e;
        }
    }
}
