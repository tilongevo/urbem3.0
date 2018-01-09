<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\ItemPreEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AlmoxarifeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoOrdemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoBemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoPerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaLancamentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\NaturezaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\NotaFiscalFornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\NotaFiscalFornecedorOrdemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class EntradaComprasOrdemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class EntradaComprasOrdemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_entrada_compras_ordem';
    protected $baseRoutePattern = 'patrimonial/compras/entrada-compras-ordem';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit']);
        $collection->add('get_itens_nota_ordem_compra', 'get-itens-nota-ordem-compra/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(['codOrdem']);

        $exercicio = $this->getExercicio();
        $usuario = $this->getCurrentUser();

        $datagridMapper
            ->add('codEntidade', 'doctrine_orm_callback', [
                'admin_code' => 'financeiro.admin.entidade',
                'callback' => [$this, 'searchFilter'],
                'label' => 'label.ordem.entidade',
            ], 'entity', [
                'class' => Orcamento\Entidade::class,
                'choice_label' => 'fkSwCgm.nomCgm',
                'choice_value' => 'codEntidade',
                'attr' => ['class' => 'select2-parameters '],
                'query_builder' => function (EntidadeRepository $repository) use ($exercicio, $usuario) {
                    $queryBuilder = $repository->createQueryBuilder('entidade');
                    $queryBuilder
                        ->join('entidade.fkOrcamentoUsuarioEntidades', 'permissoes')
                        ->join('permissoes.fkAdministracaoUsuario', 'usuario')
                        ->where('usuario = :usuario')
                        ->andWhere('entidade.exercicio = :exercicio')
                        ->setParameter('usuario', $usuario)
                        ->setParameter('exercicio', $exercicio);

                    return $queryBuilder;
                }
            ])
            ->add('exercicio', 'doctrine_orm_callback', [
                'callback' => [$this, 'searchFilter'],
                'label' => 'label.exercicio'
            ]);
    }

    /**
     * @param ProxyQuery|QueryBuilder $queryBuilder
     * @param string $alias
     * @param string $field
     * @param array $data
     * @return bool|void
     */
    public function searchFilter($queryBuilder, $alias, $field, $data)
    {
        if (!$data['value']) {
            return;
        }

        $filter = $this->getDatagrid()->getValues();

        if (false == empty($filter['codEntidade']['value'])
            && false == empty($filter['exercicio']['value'])
        ) {
            $queryBuilder
                ->andWhere("{$alias}.codEntidade = :codEntidade")
                ->andWhere("{$alias}.exercicio = :exercicio")
                ->setParameter('codEntidade', $filter['codEntidade']['value'])
                ->setParameter('exercicio', $filter['exercicio']['value']);
        }
    }

    /**
     * @param string $context
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Ordem');
        $ordemModel = new OrdemModel($em);
        $query = parent::createQuery($context);

        $filters = $this->getRequest()->query->get('filter');

        if (false == is_null($filters['exercicio']) && false == is_null($filters['codEntidade'])) {
            $query = $ordemModel->getListaEntradaComprasOrdem($query, $filters['exercicio']['value']);
        } else {
            $query->andWhere('1 = 0');
        }

        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkEmpenhoEmpenho', null, [
                'admin_code' => 'financeiro.admin.consultar_empenho',
                'label' => 'label.ordem.codEmpenho',
                'class' => 'CoreBundle:Empenho\Empenho',
                'associated_property' => function (Empenho\Empenho $empenho) {
                    return $empenho->getCodEmpenho() . '/' . $empenho->getExercicio();
                }
            ], null, [])
            ->add('fkEmpenhoEmpenho.fkOrcamentoEntidade.fkSwCgm.nomCgm', 'text', ['label' => 'label.ordem.entidade'])
            ->add('codOrdemExercicio', null, ['label' => 'label.ordem.codOrdem'])
            ->add('nomTipo', null, ['label' => 'label.ordem.tipo'])
            ->add('timestamp', 'date', [
                'label' => 'label.ordem.dtOrdem',
                'format' => 'd/m/Y'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                ]
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getObjectIdentifier()]);

        /** @var Compras\Ordem $ordem */
        $ordem = $this->getSubject();

        /** @var Compras\NotaFiscalFornecedorOrdem $notaFiscalFornecedorOrdem */
        $notaFiscalFornecedorOrdem = $ordem->getFkComprasNotaFiscalFornecedorOrdens()->isEmpty() ?
            null : $ordem->getFkComprasNotaFiscalFornecedorOrdens()->last();

        /** @var ORM\EntityManager $em */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ordemModel = new OrdemModel($entityManager);
        $ordens = $ordemModel->montaRecuperaItensNotaOrdemCompra(
            $ordem->getTipo(),
            $ordem->getExercicio(),
            $ordem->getCodOrdem(),
            $ordem->getCodEntidade()
        );

        if (false == is_null($notaFiscalFornecedorOrdem)) {
            $swCgmModel = new SwCgmModel($entityManager);
            $notaFiscalFornecedorOrdem->fkSwCgm =
                $swCgmModel->findOneByNumcgm($notaFiscalFornecedorOrdem->getCgmFornecedor());

            $entidadeModel = new EntidadeModel($entityManager);
            $notaFiscalFornecedorOrdem->fkOrcamentoEntidade =
                $entidadeModel->findOneByCodEntidade($notaFiscalFornecedorOrdem->getCodEntidade());

            $ordem->notaFiscalFornecedorOrdem = $notaFiscalFornecedorOrdem;
        }

        $ordem->ordensRelacionadas = $ordens;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $ordemModel = new OrdemModel($em);
        $empenhos = $ordemModel->getEmpenhosAtivos($this->getExercicio());

        $arrEmpenhos = ['Selecione' => 0];
        foreach ($empenhos as $empenho) {
            $arrKey = sprintf('%d/%s', $empenho['cod_empenho'], $empenho['exercicio_empenho']);
            $arrEmpenhos[$arrKey] = $empenho['cod_empenho'];
        }

        // Dados Ordem
        $fieldOptions['entidade'] = [
            'label' => 'label.ordem.entidade',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ]
        ];

        $fieldOptions['fornecedor'] = [
            'label' => 'label.ordem.fornecedor',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ]
        ];

        // Item
        $fieldOptions['item'] = [
            'label' => 'label.ordem.item',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codEntidade'] = [];
        $fieldOptions['exercicioEmpenho'] = [];

        $now = new \DateTime();

        // Assinaturas
        $fieldOptions['dtNotaFiscal'] = [
            'label' => 'label.ordem.dtNotaFiscal',
            'required' => false,
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'dp_max_date' => $now,
            'data' => $now
        ];
        $fieldOptions['numeroNotaFiscal'] = [
            'label' => 'label.ordem.numeroNotaFiscal',
            'required' => true,
            'mapped' => false
        ];
        $fieldOptions['numeroSerie'] = [
            'label' => 'label.ordem.numeroSerie',
            'required' => true,
            'mapped' => false
        ];
        $fieldOptions['observacaoNotaFiscal'] = [
            'label' => 'label.ordem.observacaoNotaFiscal',
            'required' => false,
            'mapped' => false,
        ];

        /** @var Compras\Ordem $ordem */
        $ordem = $this->getSubject();

        /** @var Compras\OrdemItem $ordemItem */
        $ordemItem = $em->getRepository('CoreBundle:Compras\OrdemItem')
            ->findOneBy([
                'codOrdem' => $ordem->getCodOrdem()
            ]);

        /** @var SwCgm $beneficiario */
        $beneficiario = $ordemItem->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getFkSwCgm();

        /** @var Empenho\Empenho $empenho */
        $empenho = $ordem->getFkEmpenhoEmpenho();

        $itens = $ordemModel->montaRecuperaItensNotaOrdemCompra(
            $ordem->getTipo(),
            $ordem->getExercicio(),
            $ordem->getCodOrdem(),
            $ordem->getCodEntidade()
        );

        // Processa codEmpenho
        $fieldOptions['empenho'] = [
            'label' => 'label.ordem.codEmpenho',
            'attr' => ['readonly' => true],
            'mapped' => false,
            'data' => sprintf('%d/%s', $ordem->getCodEmpenho(), $ordem->getExercicioEmpenho())
        ];

        // Processa Tipo
        $fieldOptions['nomTipo'] = [
            'label' => 'label.ordem.tipo',
            'attr' => ['readonly' => true],
            'data' => $ordem->getNomTipo()
        ];

        // Dados Ordem
        $fieldOptions['exercicioEmpenho']['data'] = $ordem->getExercicioEmpenho();
        $fieldOptions['entidade']['data'] =
            sprintf('%d - %s', $empenho->getCodEntidade(), $empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm());
        $fieldOptions['codEntidade']['data'] = $ordem->getCodEntidade();

        $fieldOptions['fornecedor']['data'] =
            sprintf('%d - %s', $beneficiario->getNumcgm(), $beneficiario->getNomCgm());
        $fieldOptions['fornecedorHidden']['mapped'] = false;
        $fieldOptions['fornecedorHidden']['data'] = $beneficiario->getNumcgm();
        $fieldOptions['codOrdem']['data'] = $ordem->getCodOrdem();
        $fieldOptions['exercicio']['data'] = $ordem->getExercicio();

        $formMapper
            ->with('label.ordem.dadosOrdem')
            ->add('empenho', ($this->id($ordem) ? 'text' : 'choice'), $fieldOptions['empenho'])
            ->add('codOrdem', 'hidden', $fieldOptions['codOrdem'])
            ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
            ->add('codEntidade', 'hidden', $fieldOptions['codEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
            ->add('entidade', 'text', $fieldOptions['entidade'])
            ->add('exercicioEmpenho', 'hidden', $fieldOptions['exercicioEmpenho'])
            ->add('fornecedor', 'text', $fieldOptions['fornecedor'])
            ->add('fornecedorHidden', 'hidden', $fieldOptions['fornecedorHidden'])
            ->add('nomTipo', 'text', $fieldOptions['nomTipo'])
            ->end();

        $formMapper
            ->with('label.ordem.dadosNotaFiscal')
            ->add('dtNotaFiscal', 'sonata_type_date_picker', $fieldOptions['dtNotaFiscal'])
            ->add('numeroNotaFiscal', 'text', $fieldOptions['numeroNotaFiscal'])
            ->add('numeroSerie', 'text', $fieldOptions['numeroSerie'])
            ->add('observacaoNotaFiscal', 'textarea', $fieldOptions['observacaoNotaFiscal'])
            ->end();

        $formMapper
            ->add('fkComprasOrdemItens', 'sonata_type_collection', [
                'btn_add' => false,
                'label' => 'label.ordem.itensAtendidos',
                'type_options' => [
                    'delete' => false,
                    'delete_options' => [
                        'type' => 'hidden',
                        'type_options' => [
                            'mapped' => false,
                            'required' => false,
                        ]
                    ]
                ]
            ], [
                'edit' => 'inline',
                'inline' => 'accordion',
                'sortable' => 'numItem'
            ]);

        $this->setIncludeJs([
            '/patrimonial/javascripts/almoxarifado/entradaItemFoto.js',
            '/patrimonial/javascripts/compras/entrada-compras-ordem-item.js'
        ]);
    }

    /**
     * @param Compras\Ordem $ordem
     */
    public function preValidate($ordem)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $hasError = false;
        $container = $this->getContainer();
        $itensNota = 0;

        /** @var Form $fkComprasOrdemItensForm */
        foreach ($form->get('fkComprasOrdemItens') as $fkComprasOrdemItensForm) {
            /** @var Compras\OrdemItem $ordemItem */
            $ordemItem = $fkComprasOrdemItensForm->getNormData();

            $catalogoItemModel = new CatalogoItemModel($em);
            $ordemModel = new OrdemModel($em);

            if (true == $fkComprasOrdemItensForm->get('incluir')->getData()) {
                $itensNota++;
                $catalogoItem = $catalogoItemModel->findCatalogoItemByOrdemItem($ordemItem);
                $ordemItemInfo = $ordemModel->getItemEntrada($ordem, $catalogoItem);

                // Valida se foi inserido um valor maior do que o que permitido para o item
                $quantidadeSolicitada = $fkComprasOrdemItensForm->get('quantidade')->getData();

                if ($quantidadeSolicitada > $ordemItemInfo->qtde_disponivel_oc) {
                    $message =
                        $this->trans('entradaOrdem.errors.qtdeSolicitadaMaiorQueDisponivel', [], 'validators');

                    $container->get('session')->getFlashBag()->add('error', $message);

                    $hasError = true;
                }

                // Valida se já existe uma placa de identificação com o mesmo número
                if ('patrimonio' == $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias()
                    && true == (int) $fkComprasOrdemItensForm->get('placaIdentificacao')->getData()) {
                    $numeroPlaca = $fkComprasOrdemItensForm->get('numeroPlaca')->getData();

                    $bemModel = new BemModel($em);
                    $isAvailable = $bemModel->checkNumPlacaIsAvailable($numeroPlaca);

                    if (false == $isAvailable) {
                        $numeroPlaca = $bemModel->getAvailableNumPlaca();
                        $message = $this->trans('entradaOrdem.errors.numeroPlacaExistente', [
                            ':sugestao' => $bemModel->getAvailableNumPlaca()
                        ], 'validators');

                        $container->get('session')->getFlashBag()->add('error', $message);

                        $hasError = true;
                    }
                }
            }
        }

        // Valida se há itens na nota
        if (0 == $itensNota) {
            $message = $this->trans('entradaOrdem.errors.semItensNaNota', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            $hasError = true;
        }

        // Verifica se há algum erro, caso haja, retorna a página de edição
        if (true == $hasError) {
            $routeName = $this->baseRouteName . '_edit';

            $this->redirectByRoute($routeName, ['id' => $this->getObjectKey($ordem)]);
        }
    }

    /**
     * @param Compras\Ordem $ordem
     * @return RedirectResponse
     */
    public function preUpdate($ordem)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $form = $this->getForm();
        $exercicio = $ordem->getExercicio();
        $usuarioLogado = $this->getCurrentUser();
        $formData['tipo'] = substr($formData['nomTipo'], 0, 1);

        list($codEmpenho, $exercicioEmpenho) = explode('/', $formData['empenho']);
        $codEntidade = $formData['codEntidade'];

        $almoxarifeModel = new AlmoxarifeModel($em);
        $catalogoItemModel = new CatalogoItemModel($em);
        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($em);
        $empenhoModel = new EmpenhoModel($em);
        $estoqueMaterialModel = new EstoqueMaterialModel($em);
        $lancamentoMaterialModel = new LancamentoMaterialModel($em);
        $fornecedorModel = new FornecedorModel($em);
        $naturezaLancamentoModel = new NaturezaLancamentoModel($em);
        $naturezaModel = new NaturezaModel($em);
        $notaFiscalFornecedorModel = new NotaFiscalFornecedorModel($em);
        $notaFiscalFornecedorOrdemModel = new NotaFiscalFornecedorOrdemModel($em);
        $ordemModel = new OrdemModel($em);

        /*  Faz a inserção na tabela almoxarifado.natureza_lancamento
            Entrada por Ordem de Compra pela tabela almoxarifado.natureza
            é representada por 'tipo_natureza = E e cod_Natureza = 1' */
        $natureza = $naturezaModel->getOneNaturezaByCodNaturezaAndTipoNatureza(1, 'E');
        $almoxarife = $almoxarifeModel->findByUsuario($usuarioLogado);

        $naturezaLancamento = $naturezaLancamentoModel->create($natureza, $almoxarife, $exercicio);

        $fornecedor = $fornecedorModel->getFornecedor($formData['fornecedorHidden']);

        // Faz a inclusão na tabela compras.nota_fiscal_fornecedor
        $nfFornecedor = $notaFiscalFornecedorModel->buildOne($fornecedor, $naturezaLancamento, $formData);

        // Faz a inclusão na tabela compras.nota_fiscal_fornecedor_ordem
        $nfFornecedorOrdem = $notaFiscalFornecedorOrdemModel->buildOne($nfFornecedor, $ordem);

        $empenho = $empenhoModel->getEmpenho([
            'codEntidade' => $codEntidade,
            'codEmpenho' => $codEmpenho,
            'exercicio' => $exercicioEmpenho
        ]);

        $ordem->setFkEmpenhoEmpenho($empenho);

        /** @var Form $fkComprasOrdemItensForm */
        foreach ($form->get('fkComprasOrdemItens') as $fkComprasOrdemItensForm) {
            if (true == $fkComprasOrdemItensForm->get('incluir')->getData()) {
                /** @var Compras\OrdemItem $ordemItem */
                $ordemItem = $fkComprasOrdemItensForm->getViewData();

                $catalogoItem = $catalogoItemModel->findCatalogoItemByOrdemItem($ordemItem);
                $ordemItemInfo = $ordemModel->getItemEntrada($ordem, $catalogoItem);

                /** @var Almoxarifado\Marca $marca */
                $marca = $fkComprasOrdemItensForm->get('codMarca')->getData();

                /** @var Almoxarifado\CentroCusto $centroCusto */
                $centroCusto = $fkComprasOrdemItensForm->get('codCentro')->getData();

                /** @var Almoxarifado\Almoxarifado $almoxarifado */
                $almoxarifado = $fkComprasOrdemItensForm->get('codAlmoxarifado')->getData();

                /*
                 * Verifica se ha um cadastro em almoxarifado.catalogo_item_marca,
                 * se nao o codigo abaixo efetua o cadastro
                 */
                $catalogoItemMarca = $catalogoItemMarcaModel
                    ->findOrCreateCatalogoItemMarca($catalogoItem->getCodItem(), $marca->getCodMarca());

                /*
                 * Verifica se ha um cadastro em almoxarifado.estoque_material,
                 * se nao o codigo abaixo efetua o cadastro
                 */
                $estoqueMaterial = $estoqueMaterialModel->findOrCreateEstoqueMaterial(
                    $catalogoItem->getCodItem(),
                    $marca->getCodMarca(),
                    $centroCusto->getCodCentro(),
                    $almoxarifado->getCodAlmoxarifado()
                );

                $quantidade = $fkComprasOrdemItensForm->get('quantidade')->getData();
                $valorMercado = $ordemItemInfo->vl_empenhado * $quantidade;
                $complemento = $fkComprasOrdemItensForm->get('complemento')->getData();

                /*
                 * Efetua um lancamento de material
                 */
                $lancamentoMaterial = $lancamentoMaterialModel
                    ->findOrCreateLancamentoMaterial($estoqueMaterial, $catalogoItem, $naturezaLancamento, $quantidade, $valorMercado);

                $alias = $catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias();

                if (false == empty($complemento)) {
                    $lancamentoMaterial->setComplemento($complemento);
                    $lancamentoMaterialModel->save($lancamentoMaterial);
                }

                if ('perecivel' == $alias) {
                    $perecivelModel = new PerecivelModel($em);
                    $perecivel = $perecivelModel->findOrCreatePerecivel(
                        $lancamentoMaterial->getFkAlmoxarifadoEstoqueMaterial(),
                        $fkComprasOrdemItensForm->get('dtFabricacao'),
                        $fkComprasOrdemItensForm->get('dtValidade'),
                        $fkComprasOrdemItensForm->get('lote')
                    );

                    $lancamentoPerecivelModel = new LancamentoPerecivelModel($em);
                    $lancamentoPerecivelModel->findOrCreateLancamentoPerecivel($lancamentoMaterial, $perecivel);
                }

                if ('patrimonio' == $alias) {
                    $bemModel = new BemModel($em);
                    $lancamentoBem = new LancamentoBemModel($em);

                    $numeroPlaca = $fkComprasOrdemItensForm->get('numeroPlaca')->getData();
                    $placaIdentificacao = (int) $fkComprasOrdemItensForm->get('placaIdentificacao')->getData();

                    $bem = $bemModel
                        ->buildOneBemFromLancamentoMaterial($lancamentoMaterial, $catalogoItem, $placaIdentificacao, $numeroPlaca);

                    $bemModel->save($bem);
                    $lancamentoBem->findOrCreateLancamentoBem($lancamentoMaterial, $bem);
                }

                $itemPreEmpenho = $ordemItem->getFkEmpenhoItemPreEmpenho();

                $itemPreEmpenhoModel = new ItemPreEmpenhoModel($em);
                $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithCatalogoItem($itemPreEmpenho, $catalogoItem);
                $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithCentroCusto($itemPreEmpenho, $centroCusto);
                $itemPreEmpenhoModel->checkAndUpdateItemPreEmpenhoWithMarca($itemPreEmpenho, $marca);

                $ordemItemModel = new OrdemItemModel($em);
                $ordemItemModel->checkAndUpdateItemPreEmpenhoWithCatalogoItemMarca($ordemItem, $catalogoItemMarca);
                $ordemItemModel->checkAndUpdateItemPreEmpenhoWithCentroCusto($ordemItem, $centroCusto);


                $lancamentoOrdemModel = new LancamentoOrdemModel($em);
                $lancamentoOrdem = $lancamentoOrdemModel->findOrCreateLancamentoOrdem($lancamentoMaterial, $ordemItem);
            }
        }

        $routeName = $this->baseRouteName . '_list';
        return $this->redirectByRoute($routeName);
    }
}
