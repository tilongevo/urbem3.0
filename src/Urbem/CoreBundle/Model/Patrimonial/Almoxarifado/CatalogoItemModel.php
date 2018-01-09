<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\OrdemRepository;

/**
 * Class CatalogoItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CatalogoItemModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var CatalogoItemRepository $repository
     */
    protected $repository = null;

    /**
     * CatalogoItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\CatalogoItem");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $EstoqueMaterialRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\EstoqueMaterial");
        $resEM = $EstoqueMaterialRepository->findOneByCodItem($object->getCodItem());

        $RequisicaoItemRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\RequisicaoItem");
        $resRI = $RequisicaoItemRepository->findOneByCodItem($object->getCodItem());

        $LocalizacaoFisicaItemRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\LocalizacaoFisicaItem");
        $resLFI = $LocalizacaoFisicaItemRepository->findOneByCodItem($object->getCodItem());

        $PedidoTransferenciaItemRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\PedidoTransferenciaItem");
        $resPTI = $PedidoTransferenciaItemRepository->findOneByCodItem($object->getCodItem());

        $LancamentoMaterialRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\LancamentoMaterial");
        $resLM = $LancamentoMaterialRepository->findOneByCodItem($object->getCodItem());

        $RequisicaoItensAnulacaoRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\RequisicaoItensAnulacao");
        $resRIA = $RequisicaoItensAnulacaoRepository->findOneByCodItem($object->getCodItem());

        $CatalogoItemMarcaRepository = $this->entityManager->getRepository("CoreBundle:Almoxarifado\\CatalogoItemMarca");
        $resIM = $CatalogoItemMarcaRepository->findOneByCodItem($object->getCodItem());

        $MapaItemRepository = $this->entityManager->getRepository("CoreBundle:Compras\\MapaItem");
        $resMI = $MapaItemRepository->findOneByCodItem($object->getCodItem());

        $CotacaoItemRepository = $this->entityManager->getRepository("CoreBundle:Compras\\CotacaoItem");
        $resCI = $CotacaoItemRepository->findByCodItem($object->getCodItem());

        return is_null($resEM) && is_null($resRI) && is_null($resLFI) && is_null($resPTI) && is_null($resLM) && is_null($resRIA) && is_null($resIM) && is_null($resMI);
    }

    public function getCatalogoClassificacao($params)
    {
        return $this->repository->getCatalogoClassificacao($params);
    }

    public function getAtributosClassificacao($params)
    {
        return $this->repository->getAtributosClassificacao($params);
    }

    /**
     * @param Almoxarifado\CatalogoClassificacao $classificacao
     * @return ORM\QueryBuilder
     */
    public function getCatalogoItemByClassificacaoQuery(Almoxarifado\CatalogoClassificacao $classificacao)
    {
        $result = $this->repository->getCatalogoItemByClassificacao([
            $classificacao->getCodCatalogo()->getCodCatalogo(),
            $classificacao->getCodClassificacao(),
            $classificacao->getCodEstrutural()
        ]);

        $itemIds = [];

        foreach ($result as $res) {
            $itemIds[] = $res['cod_item'];
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('catalogoItem')
            ->from(Almoxarifado\CatalogoItem::class, 'catalogoItem')
            ->orderBy('catalogoItem.descricao')
        ;

        if (count($itemIds) > 0) {
            $queryBuilder->where(
                $queryBuilder->expr()->in('catalogoItem.codItem', $itemIds)
            );
        } else {
            $queryBuilder->where('1 = 2');
        }

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado\CatalogoClassificacao $classificacao
     * @return array
     */
    public function getCatalogoItemByClassificacao(Almoxarifado\CatalogoClassificacao $classificacao)
    {
        $queryBuilder = $this->getCatalogoItemByClassificacaoQuery($classificacao);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $codItem
     * @return null|Almoxarifado\CatalogoItem
     */
    public function getOneByCodItem($codItem)
    {
        return $this->repository->findOneBy([
            'codItem' => $codItem
        ]);
    }


    /**
     * @param Almoxarifado\CatalogoItem $mapaItem
     * @return Almoxarifado\CatalogoItem
     */
    public function montaValorUltimaCompra(Almoxarifado\CatalogoItem $catalogoItem)
    {
        $result = $this->repository->getValorUltimaCompraCatalogoItem([
            'cod_item' => $catalogoItem->getCodItem()
        ]);

        $catalogoItem->vlUltimaCompra = !empty($result) ? $result['vl_unitario_ultima_compra'] : null;

        return $catalogoItem;
    }

    /**
     * @param Compras\CotacaoFornecedorItem $cotacaoFornecedorItem
     * @return Compras\CotacaoFornecedorItem
     */
    public function montaValorUnitario(Compras\CotacaoFornecedorItem $cotacaoFornecedorItem)
    {
        /** @var CatalogoItemRepository $catalogoItemRepository */
        $catalogoItemRepository = $this->entityManager->getRepository(Almoxarifado\CatalogoItem::class);

        $cotacaoModel = new CotacaoModel($this->entityManager);
        /** @var Compras\Cotacao $cotacao */
        $cotacao = $cotacaoModel->getCotacao($cotacaoFornecedorItem->getCodCotacao(), $cotacaoFornecedorItem->getExercicio());

        $result = $catalogoItemRepository->getValorUnitario([
            'exercicio_mapa' => $cotacao->getFkComprasMapaCotacoes()->first()->getExercicioMapa(),
            'cod_mapa' => $cotacao->getFkComprasMapaCotacoes()->first()->getCodMapa(),
            'cod_item' => $cotacaoFornecedorItem->getCodItem(),
            'lote' => $cotacaoFornecedorItem->getLote()
        ]);

        $cotacaoFornecedorItem->vlUnitario = !empty($result) ? $result['vl_unitario'] : null;

        return $cotacaoFornecedorItem;
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function getAtributoDinamicoQuery()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('attrDinamico')
            ->from(Administracao\AtributoDinamico::class, 'attrDinamico')
            ->where('attrDinamico.codModulo = :codModulo')
            ->andWhere('attrDinamico.codCadastro = :codCadastro')
            ->setParameters([
                'codModulo' => Administracao\Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO,
                'codCadastro' => Administracao\Cadastro::CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_ESTOQUE_MATERIAL_VALOR
            ])
        ;

        return $queryBuilder;
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @return ORM\QueryBuilder
     */
    public function getAtributoDinamicoUsingCatalogoItemQuery(Almoxarifado\CatalogoItem $catalogoItem)
    {
        $queryBuilder = $this->getAtributoDinamicoQuery();
        $rootAlias = $queryBuilder->getRootAlias();

        $attrCatalogoItemJoin = "{$rootAlias}.codAtributo = attrCatalogoItem.codAtributo AND ";
        $attrCatalogoItemJoin .= "{$rootAlias}.codCadastro = attrCatalogoItem.codCadastro AND ";
        $attrCatalogoItemJoin .= "{$rootAlias}.codModulo = attrCatalogoItem.codModulo";

        $queryBuilder
            ->join(Almoxarifado\AtributoCatalogoClassificacao::class, 'attrCatalogoItem', 'WITH', $attrCatalogoItemJoin)
            ->andWhere('attrCatalogoItem.codCatalogo = :codCatalogo')
            ->andWhere('attrCatalogoItem.codClassificacao = :codClassificacao')
            ->setParameter('codCatalogo', $catalogoItem->getCodCatalogo())
            ->setParameter('codClassificacao', $catalogoItem->getCodClassificacao())
        ;

        return $queryBuilder;
    }

    /**
     * @param $q
     * @return ORM\QueryBuilder
     */
    public function searchByDescricaoQuery($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('catalogoItem');
        $queryBuilder
            ->where('LOWER(catalogoItem.descricao) LIKE LOWER(:descricao)')
            ->orWhere('LOWER(catalogoItem.descricaoResumida) LIKE LOWER(:descricao)')
            ->setParameter('descricao', "%{$q}%")
        ;

        return $queryBuilder;
    }

    /**
     * @param string $q
     * @return array
     */
    public function searchByDescricao($q)
    {
        return $this->searchByDescricaoQuery($q)->getQuery()->getResult();
    }

    /**
     * @param string $q
     * @return array
     */
    public function searchByDescricaoExcetoServicos($q)
    {
        $queryBuilder = $this->searchByDescricaoQuery($q);
        $rootAlias = $queryBuilder->getRootAlias();

        $queryBuilder
            ->join("{$rootAlias}.fkAlmoxarifadoTipoItem", "tipoItem")
            ->andWhere("{$rootAlias}.ativo = :ativo", "tipoItem.alias <> :alias")
            ->setParameter("alias", "servico")
            ->setParameter("ativo", true)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $q
     * @param $codAlmoxarifado
     * @return ORM\QueryBuilder
     */
    public function searchByDescricaoWithAlmoxarifadoQuery($q, $codAlmoxarifado)
    {
        $queryBuilder = $this->getItensLancamentoMaterialQuery([
            'cod_almoxarifado' => $codAlmoxarifado
        ], " AND spfc.cod_almoxarifado = :cod_almoxarifado");

        $queryDescricao = 'LOWER(catalogoItem.descricao) LIKE LOWER(:descricao) ';
        $queryDescricao .= 'OR LOWER(catalogoItem.descricaoResumida) LIKE LOWER(:descricao)';

        $queryBuilder
            ->andWhere($queryDescricao)
            ->orWhere('STRING(catalogoItem.codItem) LIKE :descricao')
            ->setParameter('descricao', "%{$q}%")
        ;

        return $queryBuilder;
    }

    /**
     * Recupera objeto QueryBuilder com Catalogo de Itens
     * que estao cadastrados em Lancamento Material e nao sao Itens de Serviço
     *
     * @param array $params
     * @param string $where
     * @return ORM\QueryBuilder
     */
    public function getItensLancamentoMaterialQuery(array $params = [], $where = "")
    {
        $tipoItemRepository = $this->entityManager->getRepository(Almoxarifado\TipoItem::class);
        /** @var Almoxarifado\TipoItem  $tipoItemServico */
        $tipoItemServico = $tipoItemRepository->findOneBy(['descricao' => 'Serviço']);
        /** @var Almoxarifado\TipoItem  $tipoItemNaoInformado */
        $tipoItemNaoInformado = $tipoItemRepository->findOneBy(['descricao' => 'Não Informado']);

        $params = array_merge($params, [
            'tipo_servico' => $tipoItemServico->getCodTipo(),
            'tipo_nao_informado' => $tipoItemNaoInformado->getCodTipo()
        ]);

        $where .= " AND aci.cod_tipo <> :tipo_servico  AND aci.cod_tipo <> :tipo_nao_informado";

        $results = $this->repository->getItensLancamentoMaterial($params, $where);

        $ids = [];
        foreach ($results as $result) {
            $ids[] = $result['cod_item'];
        }

        $ids = empty($ids) ? 0 : $ids ;

        $queryBuilder = $this->repository->createQueryBuilder('catalogoItem');
        $queryBuilder->where(
            $queryBuilder->expr()->in('catalogoItem.codItem', $ids)
        );

        return $queryBuilder;
    }

    /**
     * @param Compras\OrdemItem $ordemItem
     * @return null|Almoxarifado\CatalogoItem
     */
    public function findCatalogoItemByOrdemItem(Compras\OrdemItem $ordemItem)
    {
        /** @var OrdemRepository $ordemRepository */
        $ordemRepository = $this->entityManager->getRepository(Compras\Ordem::class);

        $ordemRepositoryResult = $ordemRepository->montaRecuperaItensNotaOrdemCompra(
            $ordemItem->getTipo(),
            $ordemItem->getExercicio(),
            $ordemItem->getCodOrdem(),
            $ordemItem->getCodEntidade(),
            $ordemItem->getCodItem()
        );

        $codItem = null;
        foreach ($ordemRepositoryResult as $result) {
            if ($result->num_item == $ordemItem->getNumItem()) {
                $codItem = $result->cod_item;
            }
        }

        return $codItem ? $this->repository->find($codItem) : new Almoxarifado\CatalogoItem();
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaAlmoxarifadoCatalogoItemQuery($paramsWhere)
    {
        return $this->repository->carregaAlmoxarifadoCatalogoItemQuery($paramsWhere);
    }


    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaAlmoxarifadoCatalogoUnidadeQuery($codItem)
    {
        return $this->repository->carregaAlmoxarifadoCatalogoUnidadeQuery($codItem);
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaAlmoxarifadoSaldoCentroCustoQuery($codCentro, $codItem)
    {
        return $this->repository->carregaAlmoxarifadoSaldoCentroCustoQuery($codCentro, $codItem);
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param array $atributosDinamicos
     */
    public function saveAlmoxarifadoAtributoCatalogoClassificacaoItemValores(&$catalogoItem, $atributosDinamicos)
    {
        $atributoDinamicoModel = new AtributoDinamicoModel($this->entityManager);

        /** @var Almoxarifado\AtributoCatalogoClassificacaoItemValor $atributoValor */
        foreach ($catalogoItem->getFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores() as $atributoValor) {
            $fkAtributo = $atributoValor->getFkAlmoxarifadoAtributoCatalogoClassificacao();

            $valor = $atributoDinamicoModel->processaAtributoDinamicoUpdate($fkAtributo, $atributosDinamicos);

            $atributoValor->setValor($valor);
        }

        $acFkAtributo = $catalogoItem->getFkAlmoxarifadoCatalogoClassificacao()->getFkAlmoxarifadoAtributoCatalogoClassificacoes();
        $fkAtributos = [];
        foreach ($acFkAtributo as $fkAtributo) {
            $codAtributo = $fkAtributo->getCodAtributo();
            $fkAtributos[$codAtributo] = $fkAtributo;
        }

        if (count($fkAtributos)) {
            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                $fkAtributo = $fkAtributos[$codAtributo];

                $valor = $atributoDinamicoModel->processaAtributoDinamicoPersist($fkAtributo, $valorAtributo);

                $objFkAtributo = new Almoxarifado\AtributoCatalogoClassificacaoItemValor();
                $objFkAtributo->setFkAlmoxarifadoCatalogoItem($catalogoItem);
                $objFkAtributo->setFkAlmoxarifadoAtributoCatalogoClassificacao($fkAtributo);
                $objFkAtributo->setValor($valor);

                $catalogoItem->addFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores($objFkAtributo);
            }
        }
    }
}
