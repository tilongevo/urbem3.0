<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\Natureza;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;
use Urbem\CoreBundle\Entity\Frota\Combustivel;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;

use Urbem\CoreBundle\Model\Contabilidade\ConfiguracaoLancamentoDebitoModel;
use Urbem\CoreBundle\Model\Contabilidade\LancamentoModel;
use Urbem\CoreBundle\Model\Orcamento\ContaDespesaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\ConfiguracaoLancamentoContaDespesaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoAutorizacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\MarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\AutorizacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\EfetivacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoModel;

use Urbem\CoreBundle\Repository\Patrimonio\Frota\VeiculoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SaidaAutorizacaoAbastecimentoAdmin
 */
class SaidaAutorizacaoAbastecimentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida-autorizacao-abastecimento';

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'timestamp'
    ];

    public $exibirBotaoIncluir = false;
    public $exibirBotaoExcluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit']);
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $filter = $this->request->get('filter');

        if (false == is_null($filter) && true == isset($filter['exercicio'])) {
            $exercicio = $filter['exercicio']['value'];
        }

        $proxyQuery = parent::createQuery($context);
        $proxyQuery = (new AutorizacaoModel($entityManager))
            ->getAutorizacoesSaidaAbastecimento($proxyQuery, $exercicio);

        return $proxyQuery;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $quantidadePesquisada = null;
        $exercicioPesquisado = $this->getExercicio();
        $valorPesquisado = null;

        $filter = $this->getDatagrid()->getValues();

        if (false == empty($filter['exercicio']['value'])) {
            $exercicioPesquisado = $filter['exercicio']['value'];
        }

        $datagridMapper
            ->add('codAutorizacao', null, [
                'label' => 'label.frotaManutencao.codAutorizacao'
            ])
            ->add('exercicio', 'doctrine_orm_callback', [
                'callback' => [$this, 'searchFilter']
            ], null, [
                'attr' => ['value' => $exercicioPesquisado],
                'data' => $exercicioPesquisado
            ])
            ->add('timestamp', 'doctrine_orm_callback', [
                'callback' => [$this, 'searchFilter'],
                'label' => 'label.autorizacao.timestamp'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy'
            ])
            ->add('fkFrotaVeiculoCombustiveis', 'doctrine_orm_callback', [
                'label' => 'label.autorizacao.combustivel'
            ], 'entity', [
                'class' => Combustivel::class,
                'mapped' =>  false
            ])
            ->add('fkFrotaVeiculo', null, [
                'label' => 'label.autorizacao.veiculo'
            ], null, [
                'query_builder' => function (VeiculoRepository $veiculoRepository) use ($exercicioPesquisado) {
                    $queryBuilder = $veiculoRepository->createQueryBuilder('veiculo');
                    $queryBuilder
                        ->join('veiculo.fkFrotaAutorizacoes', 'autorizacao')
                        ->where('autorizacao.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicioPesquisado)
                        ->orderBy('veiculo.codVeiculo')
                    ;

                    return $queryBuilder;
                }
            ])
        ;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param string     $alias
     * @param string     $field
     * @param array      $data
     * @return void|boolean
     */
    public function searchFilter(ProxyQuery $proxyQuery, $alias, $field, array $data)
    {
        if (!$data['value']) {
            return;
        }

        $filter = $this->getDatagrid()->getValues();

        if (false == empty($filter['timestamp']['value'])) {
            $proxyQuery
                ->andWhere("{$alias}.timestamp = :timestamp")
                ->setParameter('timestamp', $filter['timestamp']['value']);
        }

        if (false == empty($filter['fkFrotaVeiculoCombustiveis']['value'])) {
            $proxyQuery
                ->join("{$alias}.fkFrotaVeiculo", "veiculo")
                ->join("veiculo.fkFrotaVeiculoCombustiveis", "veiculoCombustiveis")
                ->andWhere("veiculoCombustiveis.codCombustivel = :cod_combustivel")
                ->setParameter("cod_combustivel", $filter['fkFrotaVeiculoCombustiveis']['value'])
            ;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $saidaAutorizacaoAbastecimentoTemplatePath =
            "PatrimonialBundle:Sonata/Almoxarifado/SaidaAutorizacaoAbastecimento/CRUD:";
        $codAutorizacaoTemplate = $saidaAutorizacaoAbastecimentoTemplatePath . "list__codAutorizacao.html.twig";
        $fkFrotaVeiculoCombustiveis = $saidaAutorizacaoAbastecimentoTemplatePath . "list__fkFrotaVeiculoCombustiveis.html.twig";

        $listMapper
            ->add('codAutorizacao', null, [
                'label' => 'label.autorizacao.autorizacao',
                'template' => $codAutorizacaoTemplate
            ])
            ->add('timestamp', 'date', [
                'label' => 'label.autorizacao.timestamp',
                'format' => 'd/m/Y'
            ])
            ->add('fkFrotaVeiculo.fkFrotaVeiculoCombustiveis', null, [
                'label' => 'label.autorizacao.combustivel',
                'template' => $fkFrotaVeiculoCombustiveis
            ])
            ->add('fkFrotaVeiculo', null, [
                'label' => 'label.autorizacao.veiculo'
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var Autorizacao $autorizacao */
        $autorizacao = $this->getSubject();

        /** @var Usuario $usuario */
        $usuario = $this->getCurrentUser();

        $aditionalData = (new AutorizacaoModel($entityManager))
            ->getAutorizacaoSaidaAbastecimento($autorizacao);

        $fieldOptions = [];

        $fielDadosAutorizacaoTemplate =
            'PatrimonialBundle:Sonata/Almoxarifado/SaidaAutorizacaoAbastecimento/CRUD:field__dadosAutorizacao.html.twig';

        $fielDadosItemTemplate =
            'PatrimonialBundle:Sonata/Almoxarifado/SaidaAutorizacaoAbastecimento/CRUD:field__dadosItem.html.twig';

        $catalogoItem = $autorizacao->getFkFrotaItem()->getFkAlmoxarifadoCatalogoItem();
        $catalogoItem->completarTanque = $autorizacao->getQuantidade() == 0 ? $this->trans('sim') : $this->trans('nao');
        $catalogoItem->saldo = $autorizacao->getQuantidade();

        $fieldOptions['dadosAutorizacao'] = [
            'data' => [
                'autorizacao' => $autorizacao,
                'usuario' => $usuario
            ],
            'label' => false,
            'mapped' => false,
            'template' => $fielDadosAutorizacaoTemplate
        ];

        $fieldOptions['km'] = [
            'attr' => ['class' => 'km '],
            'data' => $aditionalData['km'],
            'label' => 'label.frotaManutencao.km',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['almoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado::class,
            'label' => 'label.almoxarifado.requisicao.almoxarifado',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.observacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['dadosItem'] = [
            'data' => [
                'item' => $catalogoItem,
            ],
            'label' => false,
            'mapped' => false,
            'template' => $fielDadosItemTemplate
        ];

        $marcasQuery = (new MarcaModel($entityManager))->getMarcasInLancamentoMaterialQuery($catalogoItem);
        $marcaChoices = [];

        /** @var Marca $marca */
        foreach ($marcasQuery->getQuery()->getResult() as $marca) {
            $marcaChoices[(string) $marca] = $this->getObjectKey($marca);
        }

        $fieldOptions['marca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.autorizacao.codMarca',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $marcaChoices
        ];

        $fieldOptions['centroCusto'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => CentroCusto::class,
            'label' => 'label.autorizacao.codCentro',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => (new CentroCustoModel($entityManager))
                ->getCentroCustoInLancamentoMaterial($usuario->getFkSwCgm(), $catalogoItem)
        ];

        $fieldOptions['contaDespesa'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => ContaDespesa::class,
            'choice_label' => 'codEstrutural',
            'label' => 'label.almoxarifado.requisicao.devolucao.codContaDespesa',
            'mapped' => false,
            'query_builder' => (new ContaDespesaModel($entityManager))->getListaDeContasDepesas($exercicio),
            'placeholder' => 'label.selecione'
        ];

        $configuracaoLancamentoContaDespesaItem = (new ConfiguracaoLancamentoContaDespesaItemModel($entityManager))
            ->findConfiguracaoByCatalogoItemExercicio($catalogoItem, $exercicio);

        if (false == is_null($configuracaoLancamentoContaDespesaItem)) {
            $fieldOptions['contaDespesa']['data'] = $configuracaoLancamentoContaDespesaItem->getFkOrcamentoContaDespesa();
            $fieldOptions['contaDespesa']['disabled'] = true;
        }

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'required' => true,
            'mapped' => false
        ];

        $formMapper
            ->with('label.autorizacao.dadosAutorizacao')
                ->add('dadosAutorizacao', 'customField', $fieldOptions['dadosAutorizacao'])
                ->add('km', 'text', $fieldOptions['km'])
                ->add('almoxarifado', 'entity', $fieldOptions['almoxarifado'])
                ->add('observacao', 'textarea', $fieldOptions['observacao'])
            ->end()
            ->with('label.autorizacao.dadosItem')
                ->add('dadosItem', 'customField', $fieldOptions['dadosItem'])
                ->add('marca', 'choice', $fieldOptions['marca'])
                ->add('centroCusto', 'entity', $fieldOptions['centroCusto'])
                ->add('quantidade', 'text', $fieldOptions['quantidade'])
                ->add('contaDespesa', 'entity', $fieldOptions['contaDespesa'])
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param Autorizacao $autorizacao
     */
    public function validate(ErrorElement $errorElement, $autorizacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $codMarca = $form->get('marca')->getData();

        /** @var Marca $marca */
        $marca = $this->modelManager->find(Marca::class, $codMarca);

        /** @var CentroCusto $centroCusto */
        $centroCusto = $form->get('centroCusto')->getData();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $form->get('almoxarifado')->getData();

        /** @var ContaDespesa $contaDespesa */
        $contaDespesa = $form->get('contaDespesa')->getData();

        // Dados adicionais da autorizacao para essa tela
        $aditionalData = (new AutorizacaoModel($entityManager))
            ->getAutorizacaoSaidaAbastecimento($autorizacao);

        // Catalogo Item
        $catalogoItem = $autorizacao->getFkFrotaItem()->getFkAlmoxarifadoCatalogoItem();
        // Tipo Item
        $tipoItem = $catalogoItem->getFkAlmoxarifadoTipoItem();

        // Array Collection vazio para codigos estruturais de Conta Despesa
        $codigosEstruturais = new ArrayCollection();

        // Quantidade Autorizada para Abastecimento
        $quantidadeAutorizada = $autorizacao->getQuantidade();
        $quantidadeAutorizada = abs($quantidadeAutorizada);

        // Quantidade de Saida
        $quantidade = $form->get('quantidade')->getData();
        $quantidade = abs($quantidade);

        // Saldo em Estoque
        $resSaldoEstoque = (new RequisicaoItemModel($entityManager))
            ->getSaldoEstoque($almoxarifado, $catalogoItem, $marca, $centroCusto);
        $resSaldoEstoque = reset($resSaldoEstoque);
        $saldoEstoque = abs($resSaldoEstoque['saldo_estoque']);

        // Quilometragem inserida
        $quilometragem = $form->get('km')->getData();
        $quilometragem = abs($quilometragem);

        // Quilometragem atual
        $quilometragemAtual = $aditionalData['km'];
        $quilometragemAtual = abs($quilometragemAtual);

        if (false == is_null($contaDespesa)) {
            // Contas de Debito
            $contasDebito = (new ConfiguracaoLancamentoDebitoModel($entityManager))->getContasDebitoCredito($contaDespesa);

            if (count($contasDebito) < 1) {
                $contasDespesas = $this->modelManager->findBy(ContaDespesa::class, [
                    'codConta' => $contaDespesa->getCodConta()
                ]);
                $contasDespesas = new ArrayCollection($contasDespesas);

                // Popula variavel de Codigos Estruturais
                $codigosEstruturais = $contasDespesas->map(function (ContaDespesa $contaDespesa) {
                    return $contaDespesa->getCodEstrutural();
                });
            }
        } else {
            // Valida se o tipo de item e material ou perecivel
            if ($tipoItem == 'material' || $tipoItem == 'perecivel') {
                $message = $this->trans('abastecimento.errors.desobramentoLancamentoContabilIgualZero', [], 'validators');
                $errorElement->with('dadosAutorizacao')->addViolation($message)->end();
            }
        }

        // Verifica de o array de codigos estruturais nao esta limpo
        if (false == $codigosEstruturais->isEmpty()) {
            $message = $this->trans('abastecimento.errors.desdobramentoNaoConfiguradoParaLancamentoContabil', [
                '%desdobramentos%' => implode(', ', $codigosEstruturais->toArray())
            ], 'validators');

            $errorElement->with('dadosAutorizacao')->addViolation($message)->end();
        }

        // Quantidade nao pode ser Maior que Zero (0)
        if ($quantidade == 0) {
            $message = $this->trans('abastecimento.errors.quantidadeIgualZero', [], 'validators');
            $errorElement->with('quantidade')->addViolation($message)->end();
        }

        // Quantidade Autorizada for Maior que Zero (0)
        if ($quantidadeAutorizada > 0) {
            // Quantidade de Saida nao pode ser Maior que Quantidade Autorizada
            if ($quantidade != $quantidadeAutorizada) {
                $message =
                    $this->trans('abastecimento.errors.quantidadeAutorizadaDiferenteQuantidadeSaida', [], 'validators');
                $errorElement->with('quantidade')->addViolation($message)->end();
            }
        }

        // Quantidade maior que Saldo em Estoque
        if ($quantidade > $saldoEstoque) {
            $message = $this->trans('abastecimento.errors.quantidadeSaidaMaiorQueSaldoEstoque', [], 'validators');
            $errorElement->with('quantidade')->addViolation($message)->end();
        }

        // Quilometragem inserida menor que Atual
        if ($quilometragem < $quilometragemAtual) {
            $message = $this->trans('abastecimento.errors.quilometragemInseridaMenorQueAtual', [
                '%quilometragem_atual%' => $quilometragemAtual
            ], 'validators');
            $errorElement->with('km')->addViolation($message)->end();
        }
    }


    /**
     * @param Autorizacao $autorizacao
     */
    public function preUpdate($autorizacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $usuario = $this->getCurrentUser();

        $exercicio = $this->getExercicio();
        $quantidade = $form->get('quantidade')->getData();
        $quilometragem = $form->get('km')->getData();
        $observacao = $form->get('observacao')->getData();

        $codMarca = $form->get('marca')->getData();

        /** @var Marca $marca */
        $marca = $this->modelManager->find(Marca::class, $codMarca);

        /** @var CentroCusto $centroCusto */
        $centroCusto = $form->get('centroCusto')->getData();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $form->get('almoxarifado')->getData();

        /** @var ContaDespesa $contaDespesa */
        $contaDespesa = $form->get('contaDespesa')->getData();

        $veiculo = $autorizacao->getFkFrotaVeiculo();
        $frotaItem = $autorizacao->getFkFrotaItem();
        $catalogoItem = $frotaItem->getFkAlmoxarifadoCatalogoItem();

        $manutencao = (new ManutencaoModel($entityManager))
            ->buildManutencao($veiculo, $exercicio, $quilometragem, $observacao);

        $manutencaoItem = (new ManutencaoItemModel($entityManager))
            ->buildManutencaoItem($manutencao, $frotaItem, $quilometragem);

        $efetivacao = (new EfetivacaoModel($entityManager))
            ->buildEfetivacao($autorizacao, $manutencao);

        $natureza = (new NaturezaModel($entityManager))
            ->getOneNaturezaByCodNaturezaAndTipoNatureza(Natureza::AUTORIZACAO_ABASTECIMENTO, Natureza::SAIDA);

        $almoxarife = (new AlmoxarifeModel($entityManager))
            ->findByUsuario($usuario);

        $naturezaLancamento = (new NaturezaLancamentoModel($entityManager))
            ->create($natureza, $almoxarife, $exercicio);

        $catalogoItemMarca = (new CatalogoItemMarcaModel($entityManager))
            ->findOrCreateCatalogoItemMarca($catalogoItem->getCodItem(), $marca->getCodMarca());

        $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
            ->findOrCreateEstoqueMaterial(
                $catalogoItemMarca->getCodItem(),
                $catalogoItemMarca->getCodMarca(),
                $centroCusto->getCodCentro(),
                $almoxarifado->getCodAlmoxarifado()
            );

        $lancamentoMaterial = (new LancamentoMaterialModel($entityManager))
            ->findOrCreateLancamentoMaterial(
                $estoqueMaterial,
                $catalogoItem,
                $naturezaLancamento,
                $quantidade,
                $manutencaoItem->getValor());

        $lancamentoAutorizacao = (new LancamentoAutorizacaoModel($entityManager))
            ->saveLancamentoAutorizacao($lancamentoMaterial, $autorizacao);

        if (false == is_null($contaDespesa)) {
            $configuracaoLancamentoContaDespesaItem = (new ConfiguracaoLancamentoContaDespesaItemModel($entityManager))
                ->buildOneBasedOnAutorizacaoAbastecimento($catalogoItem, $contaDespesa);

            $nomLote = sprintf(
                "Saída por Autorização de Abastecimento do item %d, Autorização %d",
                $frotaItem->getCodItem(),
                $autorizacao->getCodAutorizacao()
            );

            $dtLote = (new \DateTime())->format('d/m/Y');
            $tipoLote = 'X';

            $lancamentoRepository = (new LancamentoModel($entityManager))
                ->montaInsereLote(
                    $exercicio,
                    $centroCusto,
                    $tipoLote,
                    $nomLote,
                    $dtLote
                );
        }
    }
}
