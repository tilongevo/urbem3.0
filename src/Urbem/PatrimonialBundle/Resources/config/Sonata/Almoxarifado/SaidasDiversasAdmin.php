<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Entity\Frota\Item;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\AtributoEstoqueMaterialValorModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoEntidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\ConfiguracaoLancamentoContaDespesaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoManutencaoFrotaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LancamentoMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PerecivelModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\SaidaDiversaModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class SaidasDiversasAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class SaidasDiversasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_diversas';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida/diversas';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/base.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/init.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/almoxarifado.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/item.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/item-frota.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/item-atributo-dinamico.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/marca.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/centro.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/item-perecivel.js',
        '/patrimonial/javascripts/almoxarifado/saidas-diversas/validate.js'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->label = 'label.almoxarifado.requisicao.requisicao';

        $this->setBreadCrumb();

        $fieldOptions = [];
        $fieldOptions['exercicio'] = [
            'data' => [
                'exercicio' => $this->getExercicio()
            ],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata\Almoxarifado\SaidasDiversas\CRUD:field__exercicio.html.twig'
        ];

        $fieldOptions['almoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Almoxarifado::class,
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.entradaDiversos.observacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['requisitante'] = [
            'data' => [
                'requisitante' => (string) $this->getCurrentUser()
            ],
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata\Almoxarifado\SaidasDiversas\CRUD:field__requisitante.html.twig'
        ];

        // Autocomplete custom
        $fieldOptions['solicitante'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) {
                    $queryBuilder = $repo->createQueryBuilder('swcgm');

                    $queryBuilder
                        ->where(
                            $queryBuilder->expr()->like(
                                $queryBuilder->expr()->lower('swcgm.nomCgm'),
                                $queryBuilder->expr()->lower(':term')
                            )
                        )
                        ->setParameter('term', '%'.$term.'%')
                        ->orderBy('swcgm.nomCgm')
                    ;

                    return $queryBuilder;
                },
            'label' => 'label.saidaDiversas.solicitante',
            'mapped' => false
        ];

        $formMapper
            ->add('exercicio', 'customField', $fieldOptions['exercicio'])
            ->add('almoxarifado', 'entity', $fieldOptions['almoxarifado'])
            ->add('observacao', 'textarea', $fieldOptions['observacao'])
            ->add('requisitante', 'customField', $fieldOptions['requisitante'])
            ->add('solicitante', 'autocomplete', $fieldOptions['solicitante'])

            ->add('fkAlmoxarifadoLancamentoMateriais', 'sonata_type_collection', [
                'label' => false
            ], [
                'edit' => 'inline',
                'admin_code' => 'patrimonial.admin.saidas_diversas_item'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $form = $this->getForm();
        $itensRequisicao = 0;

        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $fkAlmoxarifadoLancamentoMaterialForm) {
            if (!$fkAlmoxarifadoLancamentoMaterialForm->get('_delete')->getData()) {
                $itensRequisicao++;
            }
        }

        if ($itensRequisicao == 0) {
            $message = $this->trans('saida_diversos.errors.semItensNaNota', [], 'validators');
            $errorElement->with('fkAlmoxarifadoLancamentoMateriais')->addViolation($message)->end();
        }
    }


    /**
     * Antes de concluir o cadastro de LancamentoMaterial,
     * é feita uma verificaçao se o item é perecivel.
     *
     * @param NaturezaLancamento $naturezaLancamento
     */
    public function prePersist($naturezaLancamento)
    {
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $form->get('almoxarifado')->getData();

        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $index => $fkAlmoxarifadoLancamentoMateriaisForm) {
            /** @var LancamentoMaterial $lancamentoMaterial */
            $lancamentoMaterial = $fkAlmoxarifadoLancamentoMateriaisForm->getNormData();

            /** @var CatalogoItem $catalogoItem */
            $catalogoItem = $fkAlmoxarifadoLancamentoMateriaisForm->get('fkAlmoxarifadoCatalogoItem')->getData();

            /** @var Marca $marca */
            $marca = $fkAlmoxarifadoLancamentoMateriaisForm->get('marca')->getData();

            /** @var CentroCusto $centroCusto */
            $centroCusto = $fkAlmoxarifadoLancamentoMateriaisForm->get('centro')->getData();

            $quantidade = $fkAlmoxarifadoLancamentoMateriaisForm->get('quantidade')->getData();

            /** @var EstoqueMaterial $estoqueMaterial */
            $estoqueMaterial = (new EstoqueMaterialModel($entityManager))->findEstoqueMaterial(
                $catalogoItem->getCodItem(),
                $marca->getCodMarca(),
                $centroCusto->getCodCentro(),
                $almoxarifado->getCodAlmoxarifado()
            );

            if ($catalogoItem->getFkAlmoxarifadoTipoItem()->getAlias() == 'perecivel') {
                $quantidades = $fkAlmoxarifadoLancamentoMateriaisForm->get('quantidadePerecivel')->getData();

                $pereciveis = (new PerecivelModel($entityManager))
                    ->findPerecivelByEstoqueMaterial($estoqueMaterial);

                /** @var Perecivel $perecivel */
                foreach ($pereciveis as $perecivel) {
                    $quantidade = $quantidades[$perecivel->getLote()];
                }
            }

            $observacao = $form->get('observacao')->getData();

            $lancamentoMaterialModel = new LancamentoMaterialModel($entityManager);

            $lancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);
            $lancamentoMaterial->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);

            $lancamentoMaterial->setComplemento($observacao);
            $lancamentoMaterial->setQuantidade(($quantidade * -1));

            $valorUnitario = $lancamentoMaterialModel->getSaldoValorUnitario($catalogoItem);
            $valorResto = $lancamentoMaterialModel->getRestoValor($catalogoItem);

            $valorMercado = ($valorUnitario * $quantidade) + ($valorResto * -1);

            $lancamentoMaterial->setValorMercado($valorMercado);
        }
    }

    /**
     * @param CatalogoItem $catalogoItem
     * @param ContaDespesa $contaDespesa
     * @param LancamentoMaterial $lancamentoMaterial
     * @param CentroCustoEntidade $centroCustoEntidade
     */
    protected function persistConfiguracaoLancamentoContaDespesaItem(CatalogoItem $catalogoItem,
                                                                     ContaDespesa $contaDespesa,
                                                                     LancamentoMaterial $lancamentoMaterial,
                                                                     CentroCustoEntidade $centroCustoEntidade
    ) {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager(NaturezaLancamento::class);

        (new ConfiguracaoLancamentoContaDespesaItemModel($entityManager))
            ->buildOne($catalogoItem, $contaDespesa);

        $complementoNomLote = sprintf(
            'Saída Diversa do item %s, Saída %s/%s.',
            $catalogoItem,
            $lancamentoMaterial->getCodLancamento(),
            $lancamentoMaterial->getExercicioLancamento()
        );

        (new SaidaDiversaModel($entityManager))
            ->performContabilidadeAlmoxarifadoLancamento([
                'exercicio' => $lancamentoMaterial->getExercicioLancamento(),
                'cod_conta_despesa' => $contaDespesa->getCodConta(),
                'valor' => ($lancamentoMaterial->getValorMercado() * -1),
                'complemento' => $complementoNomLote,
                'tipo_lote' => 'X',
                'nom_lote' => $complementoNomLote,
                'dt_lote' => (new \DateTime())->format('d/m/Y'),
                'cod_entidade' => $centroCustoEntidade->getCodEntidade()
            ]);
    }

    /**
     * @param array $atributosDinamicos
     * @param CatalogoItem $catalogoItem
     * @param LancamentoMaterial $lancamentoMaterial
     */
    protected function persistAtributosDinamicos(array $atributosDinamicos,
                                                 CatalogoItem $catalogoItem,
                                                 LancamentoMaterial $lancamentoMaterial
    ) {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager(NaturezaLancamento::class);

        foreach ($atributosDinamicos as $atributoCatalogoItemObjectKey => $atributoDinamico) {
            /** @var AtributoCatalogoItem $atributoCatalogoItem */
            $atributoCatalogoItem = $modelManager
                ->find(AtributoCatalogoItem::class, implode(ModelManager::ID_SEPARATOR, [
                    $catalogoItem->getCodItem(),
                    $atributoCatalogoItemObjectKey,
                    Cadastro::CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_ESTOQUE_MATERIAL_VALOR,
                    Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO
                ]));

            $valor = (new AtributoDinamicoModel($entityManager))
                ->processaAtributoDinamicoPersist($atributoCatalogoItem, $atributoDinamico);

            (new AtributoEstoqueMaterialValorModel($entityManager))
                ->saveAtributoEstoqueMaterialValor($atributoCatalogoItem, $lancamentoMaterial, $valor);
        }
    }

    /**
     * @param Veiculo $veiculo
     * @param CatalogoItem $catalogoItem
     * @param LancamentoMaterial $lancamentoMaterial
     */
    protected function persistFrotaManutencao(Veiculo $veiculo,
                                              CatalogoItem $catalogoItem,
                                              LancamentoMaterial $lancamentoMaterial
    ) {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager(NaturezaLancamento::class);

        $form = $this->getForm();

        $observacao = $form->get('observacao')->getData();
        $quilometragem = $form->get('km')->getData();

        $manutencao = (new ManutencaoModel($entityManager))
            ->buildManutencao($veiculo, $this->getExercicio(), $quilometragem, $observacao);

        $valorMercado = $lancamentoMaterial->getValorMercado();
        $quantidade = $lancamentoMaterial->getQuantidade();

        $item = $modelManager->find(Item::class, $catalogoItem->getCodItem());

        (new ManutencaoItemModel($entityManager))
            ->buildOne($manutencao, $item, $quantidade, $valorMercado);

        (new LancamentoManutencaoFrotaModel($entityManager))
            ->buildOne($lancamentoMaterial, $manutencao);
    }

    /**
     * Apos o cadastro de NaturezaLancamento e LancamentoMaterial,
     * é feita a inserçao, caso haja, de valores de atirbutos dinamicos.
     *
     * @param NaturezaLancamento $naturezaLancamento
     */
    public function preUpdate($naturezaLancamento)
    {
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $saidaDiversa = new SaidaDiversaModel($entityManager);

        $requestAtributosDinamicos = $this->getRequest()->get('atributoDinamico');

        /** @var SwCgm $solicitante */
        $solicitante = $form->get('solicitante')->getData();

        foreach ($form->get('fkAlmoxarifadoLancamentoMateriais') as $index => $fkAlmoxarifadoLancamentoMateriaisForm) {
            /** @var LancamentoMaterial $lancamentoMaterial */
            $lancamentoMaterial = $fkAlmoxarifadoLancamentoMateriaisForm->getNormData();

            $observacao = $form->get('observacao')->getData();

            $saidaDiversa->create($lancamentoMaterial, $solicitante, $observacao);

            /** @var CatalogoItem $catalogoItem */
            $catalogoItem = $fkAlmoxarifadoLancamentoMateriaisForm->get('fkAlmoxarifadoCatalogoItem')->getData();

            /** @var CentroCusto $centroCusto */
            $centroCusto = $fkAlmoxarifadoLancamentoMateriaisForm->get('centro')->getData();

            $centroCustoEntidade = (new CentroCustoEntidadeModel($entityManager))
                ->getCentroCustoByCodCentro($centroCusto);

            if (!is_null($centroCustoEntidade)) {
                /** @var ContaDespesa $contaDespesa */
                $contaDespesa = $fkAlmoxarifadoLancamentoMateriaisForm->get('desdobramento')->getData();

                $this->persistConfiguracaoLancamentoContaDespesaItem(
                    $catalogoItem,
                    $contaDespesa,
                    $lancamentoMaterial,
                    $centroCustoEntidade
                );
            }

            if (false == empty($requestAtributosDinamicos)) {
                $indexAtributoDinamico = implode('_', [$catalogoItem->getCodItem(), $index]);
                $atributosDinamicos = $requestAtributosDinamicos[$indexAtributoDinamico];

                if (true == isset($atributosDinamicos)) {
                    $this->persistAtributosDinamicos($atributosDinamicos, $catalogoItem, $lancamentoMaterial);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return "Saida Diversas";
    }
}
