<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras\Relatorios;

use DateInterval;
use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CompraEstoqueAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras\Relatorios
 */
class CompraEstoqueAdmin extends AbstractAdmin
{
    const PERIODO_DOZE_MESES = 'doze-meses';
    const PERIODO_SEIS_MESES = 'seis-meses';
    const PERIODO_UM_MES = 'um-mes';
    const PERIODO_DEFINIR = 'definir';
    const PERIODOS = [
        self::PERIODO_DOZE_MESES => '12 meses',
        self::PERIODO_SEIS_MESES => '6 meses',
        self::PERIODO_UM_MES => '1 mês',
        self::PERIODO_DEFINIR => 'Definir Período',
    ];

    protected $baseRouteName = 'urbem_patrimonial_compras_relatorios_compra_estoque';
    protected $baseRoutePattern = 'patrimonial/compras/relatorios/compras-estoque';
    protected $includeJs = ['/patrimonial/javascripts/compras/relatorios/compra-estoque.js'];
    protected $exibirBotaoIncluir = false;

    /**
     * CatalogoItemSinteticoAdmin constructor.
     * @param $code
     * @param $class
     * @param $baseControllerName
     */
    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, CatalogoItem::class, $baseControllerName);
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('api_item', 'api/item');

        $collection->clearExcept(['list', 'export', 'api_item']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $qb->where(sprintf('%s.codItem IS NULL', $qb->getRootAlias()));
        }

        $qb->join(sprintf('%s.fkComprasSolicitacaoItens', $qb->getRootAlias()), 'si');
        $qb->join('si.fkComprasSolicitacao', 's');
        $qb->join('s.fkComprasSolicitacaoHomologada', 'sh');

        return $qb;
    }

    /**
     * @param $qb
     */
    public function applyFilters($qb, array $filter = [])
    {
        if (empty($filter)) {
            $filter = $this->getDatagrid()->getValues();
        }

        $alias = $qb->getRootAlias();

        $qb->join(sprintf('%s.fkComprasSolicitacaoItens', $qb->getRootAlias()), 'si');
        $qb->join('si.fkComprasSolicitacao', 's');
        $qb->join('s.fkComprasSolicitacaoHomologada', 'sh');

        $this->filterAlmoxarifado($qb, $alias, '', $filter['almoxarifado']);
        $this->filterCentroCusto($qb, $alias, '', $filter['centroCusto']);
        $this->filterPeriodoSolicitacao($qb, $alias, '', $filter['periodo'], $filter['periodoInicial'], $filter['periodoFinal']);
        $this->filterPeriodoLancamentoMaterial($qb, $alias, '', $filter['periodo'], $filter['periodoInicial'], $filter['periodoFinal']);
        $this->filterStatusSolicitacao($qb, $alias, '', $filter['statusSolicitacao']);
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterAlmoxarifado($qb, $alias, $field, $value)
    {
        $almoxarifado = null;
        if (!is_array($value)) {
            $almoxarifado = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $almoxarifado = $value['value'];
        }

        if (!$almoxarifado) {
            return false;
        }

        if (!in_array('s', $qb->getAllAliases())) {
            $qb->join('si.fkComprasSolicitacao', 's');
        }

        $qb->andWhere('s.codAlmoxarifado = :codAlmoxarifado');
        $qb->setParameter('codAlmoxarifado', $almoxarifado);

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterCentroCusto($qb, $alias, $field, $value)
    {
        $codCentro = null;
        if (!is_array($value)) {
            $codCentro = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $codCentro = $value['value'];
        }

        if (!$codCentro) {
            return false;
        }

        $qb->andWhere('si.codCentro = :codCentro');
        $qb->setParameter('codCentro', $codCentro);

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterPrioridade($qb, $alias, $field, $value)
    {
        $prioridade = null;
        if (!is_array($value)) {
            $prioridade = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $prioridade = $value['value'];
        }

        if (!$prioridade) {
            return false;
        }

        $qb->andWhere(sprintf('%s.prioridade = :prioridade', $alias));
        $qb->setParameter('prioridade', $prioridade);

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterTipoItem($qb, $alias, $field, $value)
    {
        $tipoItem = null;
        if (!is_array($value)) {
            $tipoItem = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $tipoItem = $value['value'];
        }

        if (!$tipoItem) {
            return false;
        }

        if (!in_array('ti', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoTipoItem', $alias), 'ti');
        }

        $qb->andWhere('ti.codTipo = :codTipo');
        $qb->setParameter('codTipo', $tipoItem);

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @param string|null $periodoInicial
    * @param string|null $periodoFinal
    * @return bool
    */
    public function filterPeriodoSolicitacao($qb, $alias, $field, $value, $periodoInicial = null, $periodoFinal = null)
    {
        $periodos = $this->getPeriodos($qb, $value, $periodoInicial, $periodoFinal);
        if (!in_array('s', $qb->getAllAliases())) {
            $qb->join('si.fkComprasSolicitacao', 's');
        }

        if ($periodos['startDate']) {
            $qb->andWhere('s.timestamp >= :startDate');
            $qb->setParameter('startDate', $periodos['startDate']->format('Y-m-d'));
        }

        if ($periodos['endDate']) {
            $qb->andWhere('s.timestamp <= :endDate');
            $qb->setParameter('endDate', $periodos['endDate']->format('Y-m-d'));
        }

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @param string|null $periodoInicial
    * @param string|null $periodoFinal
    * @return bool
    */
    public function filterPeriodoLancamentoMaterial($qb, $alias, $field, $value, $periodoInicial = null, $periodoFinal = null)
    {
        $periodos = $this->getPeriodos($qb, $value, $periodoInicial, $periodoFinal);
        if (!in_array('lm', $qb->getAllAliases())) {
            $qb->join('ci.fkAlmoxarifadoLancamentoMateriais', 'lm');
        }

        if ($periodos['startDate']) {
            $qb->andWhere('lm.timestamp >= :startDate');
            $qb->setParameter('startDate', $periodos['startDate']->format('Y-m-d'));
        }

        if ($periodos['endDate']) {
            $qb->andWhere('lm.timestamp <= :endDate');
            $qb->setParameter('endDate', $periodos['endDate']->format('Y-m-d'));
        }

        return true;
    }

    /**
    * @param $qb
    * @param $value
    * @param string|null $periodoInicial
    * @param string|null $periodoFinal
    * @return array
    */
    public function getPeriodos($qb, $value, $periodoInicial = null, $periodoFinal = null)
    {
        $periodo = null;
        if (!is_array($value)) {
            $periodo = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $periodo = $value['value'];

            $datagrid = $this->getDatagrid()->getValues();
            $periodoInicial = $datagrid['periodoInicial']['value'];
            $periodoFinal = $datagrid['periodoFinal']['value'];
        }

        if (!$periodo) {
            return false;
        }

        $startDate = null;
        $endDate = null;

        if ($periodo == $this::PERIODO_DOZE_MESES) {
            $startDate = (new DateTime())->sub(new DateInterval('P12M'));
        }

        if ($periodo == $this::PERIODO_SEIS_MESES) {
            $startDate = (new DateTime())->sub(new DateInterval('P6M'));
        }

        if ($periodo == $this::PERIODO_UM_MES) {
            $startDate = (new DateTime())->sub(new DateInterval('P1M'));
        }

        if ($periodo == $this::PERIODO_DEFINIR && $periodoInicial) {
            $startDate = (new DateTime())->createFromFormat('d/m/Y', $periodoInicial);
        }

        if ($periodo == $this::PERIODO_DEFINIR && $periodoFinal) {
            $endDate = (new DateTime())->createFromFormat('d/m/Y', $periodoFinal);
        }

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterItem($qb, $alias, $field, $value)
    {
        $itens = null;
        if (!is_array($value)) {
            $itens = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $itens = $value['value'];
        }

        if (!$itens) {
            return false;
        }

        $qb->andWhere(
            sprintf(
                '%s.codItem IN (%s)',
                $alias,
                implode(',', $itens)
            )
        );

        return true;
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterStatusSolicitacao($qb, $alias, $field, $value)
    {
        $statusSolicitacao = null;
        if (!is_array($value)) {
            $statusSolicitacao = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $statusSolicitacao = $value['value'];
        }

        if (!$statusSolicitacao) {
            return false;
        }

        if (!in_array('s', $qb->getAllAliases())) {
            $qb->join('si.fkComprasSolicitacao', 's');
        }

        $qb->andWhere('s.status = :status');
        $qb->setParameter('status', $statusSolicitacao);

        return true;
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdItensSolicitados(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(si.quantidade) AS quantidade');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return float
    */
    public function getValorReservado(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->join('si.fkComprasSolicitacaoItemDotacoes', 'sid');

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(sid.vlReserva) AS vlReserva');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdSolicitacoesAtendidas(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->resetDqlPart('select');
        $qb->addSelect('COUNT(s.codSolicitacao) AS numSolicitacoes');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        $qb->andWhere(
            sprintf(
                '(SELECT COUNT(0) FROM %s sia WHERE sia.exercicio = si.exercicio AND sia.codEntidade = si.codEntidade AND sia.codSolicitacao = si.codSolicitacao AND sia.codCentro = si.codCentro AND sia.codItem = si.codItem AND sia.quantidade = si.quantidade) = 0',
                SolicitacaoItemAnulacao::class
            )
        );

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdItensComprados(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(si.quantidade) AS quantidade');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        $qb->andWhere(
            sprintf(
                '(SELECT COUNT(0) FROM %s sia WHERE sia.exercicio = si.exercicio AND sia.codEntidade = si.codEntidade AND sia.codSolicitacao = si.codSolicitacao AND sia.codCentro = si.codCentro AND sia.codItem = si.codItem AND sia.quantidade = si.quantidade) = 0',
                SolicitacaoItemAnulacao::class
            )
        );

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdEntrada(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(lm.quantidade) AS quantidade');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        $qb->andWhere('lm.tipoNatureza = :tipoNatureza');
        $qb->setParameter('tipoNatureza', 'E');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdSaida(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(lm.quantidade) AS quantidade');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        $qb->andWhere('lm.tipoNatureza = :tipoNatureza');
        $qb->setParameter('tipoNatureza', 'S');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return float
    */
    public function getValorGasto(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->join('si.fkComprasSolicitacaoItemDotacoes', 'sid');

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(sid.vlReserva) AS vlReserva');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        $qb->andWhere(
            sprintf(
                '(SELECT COUNT(0) FROM %s sia WHERE sia.exercicio = si.exercicio AND sia.codEntidade = si.codEntidade AND sia.codSolicitacao = si.codSolicitacao AND sia.codCentro = si.codCentro AND sia.codItem = si.codItem AND sia.quantidade = si.quantidade) = 0',
                SolicitacaoItemAnulacao::class
            )
        );

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return int
    */
    public function getQtdItensAnulados(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->join('si.fkComprasSolicitacaoItemAnulacoes', 'sia');

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(sia.quantidade) AS quantidade');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @param CatalogoItem $catalogoItem
    * @return float
    */
    public function getQtdValorAnulado(CatalogoItem $catalogoItem)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('ci');

        $this->applyFilters($qb);

        $qb->join('si.fkComprasSolicitacaoItemAnulacoes', 'sia');

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(sia.vlTotal) AS vlTotal');

        $qb->andWhere('ci.codItem = :codItem');
        $qb->setParameter('codItem', $catalogoItem->getCodItem());

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
    * @return Doctrine\ORM\QueryBuilder
    */
    public function getTiposItem()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoItemModel = new TipoItemModel($em);

        return $tipoItemModel->getTiposItem();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['almoxarifado'] = [
            'class' => Almoxarifado::class,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['centroCusto'] = [
            'class' => CentroCusto::class,
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['prioridade'] = [
            'choices' => array_flip(CatalogoItem::PRIORIDADES_LIST),
            'placeholder' => 'Todas',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['tipoItem'] = [
            'class' => TipoItem::class,
            'query_builder' => (new TipoItemModel($em))->getTiposItem(),
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['periodo'] = [
            'choices' => array_flip($this::PERIODOS),
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $fieldOptions['periodoInicial'] = [
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
        ];

        $fieldOptions['item'] = [
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico_api_item'],
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $fieldOptions['statusSolicitacao'] = [
            'choices' => array_flip(Solicitacao::STATUS_LIST),
            'placeholder' => 'Todos',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
        ];

        $datagridMapper
            ->add(
                'almoxarifado',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterAlmoxarifado'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.almoxarifado',
                ],
                'entity',
                $fieldOptions['almoxarifado']
            )
            ->add(
                'centroCusto',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterCentroCusto'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.centroCusto',
                ],
                'entity',
                $fieldOptions['centroCusto']
            )
            ->add(
                'prioridade',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterPrioridade'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.prioridade',
                ],
                'choice',
                $fieldOptions['prioridade']
            )
            ->add(
                'fkAlmoxarifadoTipoItem',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterTipoItem'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.tipoItem',
                ],
                'entity',
                $fieldOptions['tipoItem']
            )
            ->add(
                'periodo',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterPeriodoSolicitacao'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.periodo',
                ],
                'choice',
                $fieldOptions['periodo']
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                [
                    'callback' => function () {
                    },
                    'label' => 'label.comprasRelatoriosCompraEstoque.periodoInicial',
                ],
                'datepkpicker',
                $fieldOptions['periodoInicial']
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                [
                    'callback' => function () {
                    },
                    'label' => 'label.comprasRelatoriosCompraEstoque.periodoFinal',
                ],
                'datepkpicker',
                $fieldOptions['periodoInicial']
            )
            ->add(
                'item',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterItem'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.item',
                ],
                'autocomplete',
                $fieldOptions['item']
            )
            ->add(
                'statusSolicitacao',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'filterStatusSolicitacao'],
                    'label' => 'label.comprasRelatoriosCompraEstoque.statusSolicitacao',
                ],
                'choice',
                $fieldOptions['statusSolicitacao']
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $this->prioridades = CatalogoItem::PRIORIDADES_LIST;

        $listMapper
            ->add('codItem', null, ['label' => 'label.comprasRelatoriosCompraEstoque.item'])
            ->add(
                'descricao',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__descricao.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.descricao',
                ]
            )
            ->add(
                'qtdItensSolicitados',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_itens_solicitados.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdItensSolicitados',
                ]
            )
            ->add(
                'valorReservado',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__valor_reservado.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.valorReservado',
                ]
            )
            ->add(
                'qtdSolicitacoesAtendidas',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_solicitacoes_atendidas.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdSolicitacoesAtendidas',
                ]
            )
            ->add(
                'qtdItensComprados',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_itens_comprados.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdItensComprados',
                ]
            )
            ->add(
                'qtdEntrada',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_entrada.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdEntrada',
                ]
            )
            ->add(
                'qtdSaida',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_saida.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdSaida',
                ]
            )
            ->add(
                'valorGasto',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__valor_gasto.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.valorGasto',
                ]
            )
            ->add(
                'qtdItensAnulados',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__qtd_itens_anulados.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.qtdItensAnulados',
                ]
            )
            ->add(
                'valorAnulado',
                'template',
                [
                    'template' => 'PatrimonialBundle:Sonata\Compras\Relatorios\CompraEstoque\CRUD:list__valor_anulado.html.twig',
                    'label' => 'label.comprasRelatoriosCompraEstoque.valorAnulado',
                ]
            );
    }
}
