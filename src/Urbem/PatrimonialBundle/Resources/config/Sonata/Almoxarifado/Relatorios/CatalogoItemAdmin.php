<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios;

use DateInterval;
use DateTime;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\TipoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\TipoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CatalogoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado\Relatorios
 */
class CatalogoItemAdmin extends AbstractAdmin
{
    const CATEGORIA_TODOS = 'todos';
    const CATEGORIA_INGRESSADO = 'ingressados';
    const CATEGORIA_NAO_INGRESSADO = 'nao-ingressados';
    const CATEGORIAS = [
        self::CATEGORIA_TODOS => 'Todos os itens',
        self::CATEGORIA_INGRESSADO => 'Já ingressados no estoque',
        self::CATEGORIA_NAO_INGRESSADO => 'Nunca ingressados no estoque',
    ];

    const PRIORIDADE_IMPRESCINDIVEL = 'imprescindivel';
    const PRIORIDADE_IMPORTANTE = 'importante';
    const PRIORIDADE_INTERMEDIARIA = 'intermediaria';
    const PRIORIDADE_MODERADA = 'moderada';
    const PRIORIDADE_POUCA_IMPORTANCIA = 'pouca-importancia';
    const PRIORIDADES = [
        self::PRIORIDADE_IMPRESCINDIVEL => 'Imprescindível',
        self::PRIORIDADE_IMPORTANTE => 'Importante',
        self::PRIORIDADE_INTERMEDIARIA => 'Importância Intermediária',
        self::PRIORIDADE_MODERADA => 'Moderada',
        self::PRIORIDADE_POUCA_IMPORTANCIA => 'Pouca Importância',
    ];

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

    const AGRUPAR_ITEM = 'item';
    const AGRUPAR_CENTRO_CUSTO = 'centro-custo';
    const AGRUPAR_CATALOGO = 'catalogo';
    const AGRUPAR_ALMOXARIFADO = 'almoxarifado';
    const AGRUPAR = [
        self::AGRUPAR_ITEM => 'Item',
        self::AGRUPAR_CENTRO_CUSTO => 'Centro de Custo',
        self::AGRUPAR_CATALOGO => 'Catálogo',
        self::AGRUPAR_ALMOXARIFADO => 'Almoxarifado',
    ];

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
    * @param CatalogoItem $catalogoItem
    * @return bool
    */
    public function getCategoria(CatalogoItem $catalogoItem)
    {
        return (bool) $catalogoItem->getFkAlmoxarifadoLancamentoMateriais()->count();
    }

    /**
    * @param int $codItem
    * @return int
    */
    public function getQtdSaida($codItem, $periodo = null, $periodoInicial = null, $periodoFinal = null)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository(CatalogoItem::class)->createQueryBuilder('o');

        $qb->join(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $qb->getRootAlias()), 'lm');

        $datagrid = $this->getDatagrid()->getValues();
        if (!empty($datagrid['periodo'])) {
            $periodo = $datagrid['periodo'];
            $periodoInicial = $datagrid['periodoInicial'];
            $periodoFinal = $datagrid['periodoFinal'];
        }

        $this->filterPeriodo($qb, $qb->getRootAlias(), '', $periodo, $periodoInicial, $periodoFinal);

        $qb->andWhere('lm.tipoNatureza = \'S\'');

        $qb->andWhere('lm.codItem = :codItem');
        $qb->setParameter('codItem', $codItem);

        $qb->resetDqlPart('select');
        $qb->addSelect('SUM(lm.quantidade) AS qtdSaida');

        return abs((int) $qb->getQuery()->getSingleScalarResult());
    }

    /**
    * @param $qb
    * @param $alias
    * @param $field
    * @param $value
    * @return bool
    */
    public function filterCategoria($qb, $alias, $field, $value)
    {
        $categoria = null;
        if (!is_array($value)) {
            $categoria = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $categoria = $value['value'];
        }

        if (!$categoria) {
            return false;
        }

        if ($categoria == $this::CATEGORIA_INGRESSADO && !in_array('lm', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $alias), 'lm');
        }

        if ($categoria == $this::CATEGORIA_NAO_INGRESSADO) {
            $qb->andWhere(
                sprintf(
                    '(SELECT COUNT(0) FROM %s nilm WHERE nilm.codItem = %s.codItem) = 0',
                    LancamentoMaterial::class,
                    $alias
                )
            );
        }

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
    public function filterPeriodo($qb, $alias, $field, $value, $periodoInicial = null, $periodoFinal = null)
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

        if (!in_array('lm', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $alias), 'lm');
        }

        $qb->join('lm.fkAlmoxarifadoNaturezaLancamento', 'nl');

        if ($startDate) {
            $qb->andWhere('nl.timestamp >= :startDate');
            $qb->setParameter('startDate', $startDate->format('Y-m-d'));
        }

        if ($endDate) {
            $qb->andWhere('nl.timestamp <= :endDate');
            $qb->setParameter('endDate', $endDate->format('Y-m-d'));
        }

        return true;
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
        $almoxarifados = null;
        if (!is_array($value)) {
            $almoxarifados = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $almoxarifados = $value['value'];
        }

        if (!$almoxarifados) {
            return false;
        }

        if (!in_array('lm', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $alias), 'lm');
        }

        if (!in_array('em', $qb->getAllAliases())) {
            $qb->join('lm.fkAlmoxarifadoEstoqueMaterial', 'em');
        }

        if (!in_array('a', $qb->getAllAliases())) {
            $qb->join('em.fkAlmoxarifadoAlmoxarifado', 'a');
        }

        $qb->andWhere(
            sprintf(
                'a.codAlmoxarifado IN (%s)',
                implode(',', $almoxarifados)
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
    public function filterCatalogo($qb, $alias, $field, $value)
    {
        $catalogos = null;
        if (!is_array($value)) {
            $catalogos = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $catalogos = $value['value'];
        }

        if (!$catalogos) {
            return false;
        }

        if (!in_array('cclassificacao', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoCatalogoClassificacao', $alias), 'cclassificacao');
        }

        $qb->andWhere(
            sprintf(
                'cclassificacao.codCatalogo IN (%s)',
                implode(',', $catalogos)
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
    public function filterCentroCusto($qb, $alias, $field, $value)
    {
        $centrosCusto = null;
        if (!is_array($value)) {
            $centrosCusto = $value;
        }

        if (is_array($value) && !empty($value['value'])) {
            $centrosCusto = $value['value'];
        }

        if (!$centrosCusto) {
            return false;
        }

        if (!in_array('lm', $qb->getAllAliases())) {
            $qb->join(sprintf('%s.fkAlmoxarifadoLancamentoMateriais', $alias), 'lm');
        }

        if (!in_array('em', $qb->getAllAliases())) {
            $qb->join('lm.fkAlmoxarifadoEstoqueMaterial', 'em');
        }

        if (!in_array('cc', $qb->getAllAliases())) {
            $qb->join('em.fkAlmoxarifadoCentroCusto', 'cc');
        }

        $qb->andWhere(
            sprintf(
                'cc.codCentro IN (%s)',
                implode(',', $centrosCusto)
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
    * @return Doctrine\ORM\QueryBuilder
    */
    public function getTiposItem()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoItemModel = new TipoItemModel($em);

        return $tipoItemModel->getTiposItem();
    }
}
