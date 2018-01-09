<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Parametro;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\EstoqueMaterialModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoHomologadaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;

/**
 * Class RequisicaoItemAdmin
 */
class RequisicaoItemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_requisicao_item';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/requisicao-item';

    protected $includeJs = ['/patrimonial/javascripts/almoxarifado/requisicao-item.js'];

    protected $model = RequisicaoItemModel::class;

    protected $exibirBotaoVoltarNoList = false;
    protected $exibirBotaoExcluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'delete', 'list']);
        $collection->add('search_marcas', 'search/marcas/{cod_almoxarifado}/{cod_item}');
        $collection->add('search_centro_custo', 'search/centros-custo/{cod_almoxarifado}/{cod_item}/{cod_marca}');
        $collection->add('search_centro_custo_geral', 'search/centros-custo-geral/{cod_almoxarifado}/{cod_item}/{cod_marca}');
        $collection->add('search_saldo_estoque', 'search/saldo-estoque/{cod_almoxarifado}/{cod_item}/{cod_marca}/{cod_centro}');
    }

    /**
     * @return null|Requisicao
     */
    private function getRequisicao()
    {
        /** @var RequisicaoItem $requisicaoItem */
        $requisicaoItem = $this->subject;
        $requisicao = null;

        /** Rota atual */
        $actualRoute = $this->request->get('_sonata_name');

        /** Determina qual a fonte da chave de Requisicao */
        switch ($actualRoute) {
            case ($this->baseRouteName . "_create"):
                $requisicaoObjectKey = $this->request->get('requisicao');
                break;
            case ($this->baseRouteName . "_edit"):
                /** @var RequisicaoItem $requisicaoItem */
                $requisicaoItem = $this->subject;
                $requisicaoObjectKey = $this->getObjectKey($requisicaoItem->getFkAlmoxarifadoRequisicao());

                $disabled = true;
                break;
        }

        /** Recupera chave da requisiçao salva em um campo quando o metodo for POST */
        if (true == $this->request->isMethod('POST')) {
            $formData = $this->request->get($this->getUniqid());
            $requisicaoObjectKey = $formData['requisicao'];
        }

        /** Recupera requisicao caso a chave tenha sido 'setada' */
        if (true == isset($requisicaoObjectKey)) {
            /** @var Requisicao $requisicao */
            $requisicao = $this->modelManager->find(Requisicao::class, $requisicaoObjectKey);
            $requisicaoItem->setFkAlmoxarifadoRequisicao($requisicao);
        }

        return $requisicao;
    }

    /**
     * @param FormMapper $formMapper
     * @param array $fieldOptions
     */
    protected function configureEditFormFields(FormMapper $formMapper, array &$fieldOptions)
    {
        /** @var RequisicaoItem $requisicaoItem */
        $requisicaoItem = $this->getSubject();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var Almoxarifado $almoxarifado */
        $almoxarifado = $this->modelManager->find(Almoxarifado::class, $requisicaoItem->getCodAlmoxarifado());

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());

        /** @var CentroCusto $centroCusto */
        $centroCusto = $this->modelManager->find(CentroCusto::class, $requisicaoItem->getCodCentro());

        /** @var Marca $marca */
        $marca = $this->modelManager->find(Marca::class, $requisicaoItem->getCodMarca());

        $result = (new RequisicaoItemModel($entityManager))
            ->getSaldoEstoque($almoxarifado, $catalogoItem, $marca, $centroCusto);

        $result = reset($result);

        $fieldOptions['item']['data'] = $catalogoItem;

        $fieldOptions['marca']['data'] = $marca;
        $fieldOptions['marca']['choices'] = (new RequisicaoItemModel($entityManager))
            ->searchMarcasForRequisicao($almoxarifado, $catalogoItem);

        unset($fieldOptions['marca']['disabled']);

        $fieldOptions['centro_custo']['data'] = $centroCusto;
        $fieldOptions['centro_custo']['attr']['class'] .= ' unlock';
        $fieldOptions['centro_custo']['choices'] = (new RequisicaoItemModel($entityManager))
            ->searchCentrosCustoForRequisicao($almoxarifado, $catalogoItem, $marca, $this->getCurrentUser());

        unset($fieldOptions['centro_custo']['disabled']);

        $fieldOptions['saldo']['data'] = number_format($result['saldo_estoque'], 4, ',', '');
        $fieldOptions['quantidade']['data'] = $requisicaoItem->getQuantidade();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $admin = $this;

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $requisicao = $this->getRequisicao();
        $disableField = $this->request->get('_sonata_name') == ($this->baseRouteName . '_edit') ? true : false;

        $fieldOptions = [];

        $fieldOptions['requisicao'] = [
            'data' => (true == is_null($requisicao)) ? null : $this->getObjectKey($requisicao),
            'mapped' => false
        ];

        $fieldOptions['item'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => CatalogoItem::class,
            'disabled' => $disableField,
            'json_choice_label' => function (CatalogoItem $catalogoItem) {
                return sprintf(
                    '%09d - %s - %s',
                    $catalogoItem->getCodItem(),
                    $catalogoItem->getFkAdministracaoUnidadeMedida()->getNomUnidade(),
                    $catalogoItem->getDescricao()
                );
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) use ($entityManager, $admin) {
                    /** @var Requisicao $requisicao */
                    $requisicao = $admin->modelManager->find(Requisicao::class, $request->get('requisicao'));

                    $requisicaoItensIncluidosQuery = $entityManager->createQueryBuilder();
                    $requisicaoItensIncluidosQuery
                        ->select('requisicaoItens.codItem')
                        ->from(RequisicaoItem::class, 'requisicaoItens')
                        ->where('requisicaoItens.exercicio = :exercicio')
                        ->andWhere('requisicaoItens.codRequisicao = :codRequisicao')
                        ->andWhere('requisicaoItens.codAlmoxarifado = :codAlmoxarifado');

                    $customCatalogoItemQuery = (new RequisicaoItemModel($entityManager))
                        ->searchCatalogoItemForRequisicaoQuery($requisicao->getFkAlmoxarifadoAlmoxarifado());

                    $rootAlias = $customCatalogoItemQuery->getRootAlias();

                    $customCatalogoItemQuery
                        ->andWhere(
                            $customCatalogoItemQuery->expr()->like(
                                $customCatalogoItemQuery->expr()->lower("{$rootAlias}.descricao"),
                                $customCatalogoItemQuery->expr()->lower(":searchQuery")
                            )
                        )
                        ->andWhere(
                            $customCatalogoItemQuery
                                ->expr()
                                ->notIn("{$rootAlias}.codItem", $requisicaoItensIncluidosQuery->getDQL())
                        )
                        ->setParameter("searchQuery", "%{$request->get('q')}%")
                        ->setParameter('exercicio', $requisicao->getExercicio())
                        ->setParameter('codRequisicao', $requisicao->getCodRequisicao())
                        ->setParameter('codAlmoxarifado', $requisicao->getCodAlmoxarifado());

                    return $customCatalogoItemQuery;
                },
            'label' => 'label.almoxarifado.requisicao.codigoUnidadeDescricao',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
            'req_params' => [
                'requisicao' => false == is_null($requisicao) ? $this->getObjectKey($requisicao) : null
            ]
        ];

        $fieldOptions['marca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [],
            'class' => Marca::class,
            'disabled' => true,
            'label' => 'label.almoxarifado.marca',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true
        ];

        $fieldOptions['centro_custo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [],
            'class' => CentroCusto::class,
            'disabled' => true,
            'label' => 'label.almoxarifado.codCentro',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
        ];

        $fieldOptions['saldo'] = [
            'attr' => [
                'class' => 'quantity ',
                'readonly' => 'readonly',
            ],
            'label' => 'label.almoxarifado.requisicao.saldo',
            'mapped' => false,
            'required' => false,
            'data' => 0
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity '],
            'data' => 0
        ];

        $configuracao = (new ConfiguracaoModel($entityManager))
            ->pegaConfiguracao(
                Parametro::HOMOLOGACAO_AUTOMATICA_REQUISICAO,
                Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
                false == is_null($requisicao) ? $requisicao->getExercicio() : false
            );

        $configuracao = reset($configuracao);
        if (false == is_null($requisicao)
            && true == isset($configuracao['valor'])
            && true == ("true" === $configuracao['valor'])
        ) {
            $fieldOptions['hasHomologacaoAutomatica']['data'] = true;
        }

        $fieldOptions['hasHomologacaoAutomatica']['mapped'] = false;

        $fieldOptions['makeHomologacaoAutomatica'] = [
            'data' => false,
            'mapped' => false
        ];

        if (false == $this->getRequest()->isMethod('GET')) {
            /** @var RequisicaoItem $requisicaoItem */
            $requisicaoItem = $this->getSubject();

            $formData = $this->getRequest()->request->get($this->getUniqid());

            $requisicaoItem->setCodItem($formData['item']);
            $requisicaoItem->setCodMarca($formData['marca']);
            $requisicaoItem->setCodCentro($formData['centro_custo']);
        }

        if ($this->request->get('_sonata_name') == ($this->baseRouteName . '_edit')
            || false == $this->getRequest()->isMethod('GET')) {
            $this->configureEditFormFields($formMapper, $fieldOptions);
        }

        $formMapper
            ->with('Item da Requisição')
                ->add('requisicao', 'hidden', $fieldOptions['requisicao'], [
                    'admin_code' => 'patrimonial.admin.requisicao'
                ])
                ->add('item', 'autocomplete', $fieldOptions['item'])
                ->add('marca', 'entity', $fieldOptions['marca'])
                ->add('centro_custo', 'entity', $fieldOptions['centro_custo'])
                ->add('saldo', 'text', $fieldOptions['saldo'])
                ->add('quantidade', 'text', $fieldOptions['quantidade'])

                // Campos para validaçao de homologaçao automatica
                ->add('has_homologacao_automatica', 'hidden', $fieldOptions['hasHomologacaoAutomatica'])
                ->add('make_homologacao_automatica', 'hidden', $fieldOptions['makeHomologacaoAutomatica'])
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param RequisicaoItem $requisicaoItem
     */
    public function validate(ErrorElement $errorElement, $requisicaoItem)
    {
        $form = $this->getForm();
        $saldo = $form->get('saldo')->getData();
        $quantidade = $requisicaoItem->getQuantidade();
        $catalogoItem = $form->get('item')->getData();

        if (abs($saldo) < abs($quantidade)) {
            $message = $this->trans('requisicao_item.errors.quantidadeMaiorQueOSaldo', [
                '%quantidade_anular%' => $quantidade,
                '%saldo_estoque%' => $saldo,
                '%catalogo_item%' => (string) $catalogoItem
            ], 'validators');

            $errorElement->with('quantidade')->addViolation($message)->end();
        }

        if (0 == abs($quantidade)) {
            $message = $this->trans('requisicao_item.errors.quantidadeIgualAZero', [
                '%catalogo_item%' => (string) $catalogoItem
            ], 'validators');

            $errorElement->with('quantidade')->addViolation($message)->end();
        }
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     */
    public function persistEstoqueMaterial(RequisicaoItem $requisicaoItem)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->request->get($this->getUniqid());

        $formData['item'] = true == isset($formData['item']) ? $formData['item'] : $requisicaoItem->getCodItem() ;

        $estoqueMaterial = (new EstoqueMaterialModel($entityManager))
            ->findOrCreateEstoqueMaterial(
                $formData['item'],
                $formData['marca'],
                $formData['centro_custo'],
                $requisicaoItem->getCodAlmoxarifado()
            );

        $requisicaoItem->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return Response
     */
    public function redirectBackToRequisicaoShow(RequisicaoItem $requisicaoItem)
    {
        $requisicao = $requisicaoItem->getFkAlmoxarifadoRequisicao();
        $routeName = 'urbem_patrimonial_almoxarifado_requisicao_show';

        return $this->redirectByRoute($routeName, [
            'id' => $this->id($requisicao)
        ]);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     */
    public function prePersist($requisicaoItem)
    {
        $this->persistEstoqueMaterial($requisicaoItem);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return Response
     */
    public function postPersist($requisicaoItem)
    {
        $formData = $this->request->get($this->getUniqid());

        if (true == $formData['make_homologacao_automatica']) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $requisicao = $requisicaoItem->getFkAlmoxarifadoRequisicao();
            $usuario = $this->getCurrentUser();

            $requisicaoHomologada = (new RequisicaoHomologadaModel($entityManager))
                ->homologaRequisicao($requisicao, $usuario);
        }

        return $this->redirectBackToRequisicaoShow($requisicaoItem);
    }

    /**.
     * @param RequisicaoItem $requisicaoItem
     */
    public function preUpdate($requisicaoItem)
    {
        $this->persistEstoqueMaterial($requisicaoItem);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return Response
     */
    public function postUpdate($requisicaoItem)
    {
        $formData = $this->request->get($this->getUniqid());

        if (true == $formData['make_homologacao_automatica']) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $requisicao = $requisicaoItem->getFkAlmoxarifadoRequisicao();
            $usuario = $this->getCurrentUser();

            $requisicaoHomologada = (new RequisicaoHomologadaModel($entityManager))
                ->homologaRequisicao($requisicao, $usuario);
        }

        return $this->redirectBackToRequisicaoShow($requisicaoItem);
    }

    /**
     * @param RequisicaoItem $requisicaoItem
     * @return Response
     */
    public function postRemove($requisicaoItem)
    {
        return $this->redirectBackToRequisicaoShow($requisicaoItem);
    }
}
