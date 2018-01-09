<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\AbstractModel;

class CompraDiretaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\CompraDireta::class);
    }

    /**
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $codModalidade
     * @return mixed
     */
    public function getNextCodCompraDireta($codEntidade, $exercicioEntidade, $codModalidade)
    {
        return $this->repository->getNextCodCompraDireta($codEntidade, $exercicioEntidade, $codModalidade);
    }

    /**
     * Coloca os exercicios necessários na entidade
     *
     * @param Compras\CompraDireta $compraDireta
     * @return Compras\CompraDireta
     */
    public function setExercicios(Compras\CompraDireta $compraDireta)
    {
        $entidade = $compraDireta->getCodEntidade();
        $mapa = $compraDireta->getCodMapa();

        $compraDireta->setExercicioMapa($mapa->getExercicio());
        $compraDireta->setExercicioEntidade($entidade->getExercicio());

        return $compraDireta;
    }

    /**
     * Retorna a ProxyQuery com compras que não estejam anuladas
     *
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function getComprasNotInAnulacao(ProxyQuery $proxyQuery)
    {
        $queryCompraDiretaAnulacao = $this->entityManager->createQueryBuilder();

        $queryCompraDiretaAnulacao
            ->select("(CONCAT(cda.codCompraDireta,'~',cda.codEntidade,'~',cda.codModalidade,'~',cda.exercicioEntidade))")
            ->from(Compras\CompraDiretaAnulacao::class, 'cda');

        $proxyQuery->andWhere($proxyQuery->expr()->notIn("CONCAT({$proxyQuery->getRootAliases()[0]}.codCompraDireta,'~',{$proxyQuery->getRootAliases()[0]}.codEntidade,'~',{$proxyQuery->getRootAliases()[0]}.codModalidade,'~',{$proxyQuery->getRootAliases()[0]}.exercicioEntidade)", $queryCompraDiretaAnulacao->getDQL()));

        return $proxyQuery;
    }

    /**
     * Retorna IDs das autorizações e julgamento
     *
     * @param Compras\CompraDireta $compraDireta
     * @return ORM\QueryBuilder|null
     */
    public function getAutorizacoesAndJulgamentos(Compras\CompraDireta $compraDireta)
    {
        $mapaCotacaoModel = new MapaCotacaoModel($this->entityManager);
        $mapaCotacaoQueryBuilder = $mapaCotacaoModel->getCotacaoWithCompraDireta($compraDireta);

        $mapaCotacao = $mapaCotacaoQueryBuilder->getQuery()->getOneOrNullResult();

        if (is_null($mapaCotacao)) {
            return null;
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select([
                'julgamento.exercicio',
                '(julgamento.codCotacao)',
                'autorizacaoEmpenho.codAutorizacao',
                'autorizacaoEmpenho.exercicio'
            ])
            ->from(Compras\Julgamento::class, 'julgamento')
            ->join(
                Compras\JulgamentoItem::class,
                'julgamentoItem',
                'WITH',
                'julgamento.exercicio = julgamentoItem.exercicio AND ' .
                'julgamento.codCotacao = julgamentoItem.codCotacao'
            )
            ->join(
                Empenho\ItemPreEmpenhoJulgamento::class,
                'itemPreEmpenhoJulgamento',
                'WITH',
                'julgamentoItem.exercicio = itemPreEmpenhoJulgamento.exercicio AND ' .
                'julgamentoItem.codCotacao = itemPreEmpenhoJulgamento.codCotacao AND ' .
                'julgamentoItem.codItem = itemPreEmpenhoJulgamento.codItem AND ' .
                'julgamentoItem.lote = itemPreEmpenhoJulgamento.lote AND ' .
                'julgamentoItem.cgmFornecedor = itemPreEmpenhoJulgamento.cgmFornecedor'
            )
            ->join(
                Empenho\ItemPreEmpenho::class,
                'itemPreEmpenho',
                'WITH',
                'itemPreEmpenhoJulgamento.codPreEmpenho = itemPreEmpenho.codPreEmpenho AND ' .
                'itemPreEmpenhoJulgamento.exercicio = itemPreEmpenho.exercicio AND ' .
                'itemPreEmpenhoJulgamento.numItem = itemPreEmpenho.numItem'
            )
            ->join(
                Empenho\PreEmpenho::class,
                'preEmpenho',
                'WITH',
                'itemPreEmpenho.codPreEmpenho = preEmpenho.codPreEmpenho AND ' .
                'itemPreEmpenho.exercicio = preEmpenho.exercicio'
            )
            ->join(
                Empenho\AutorizacaoEmpenho::class,
                'autorizacaoEmpenho',
                'WITH',
                'preEmpenho.exercicio = autorizacaoEmpenho.exercicio AND ' .
                'preEmpenho.codPreEmpenho = autorizacaoEmpenho.codPreEmpenho'
            )
            ->leftJoin(
                Empenho\AutorizacaoAnulada::class,
                'autorizacaoAnulada',
                'WITH',
                'autorizacaoEmpenho.exercicio = autorizacaoAnulada.exercicio AND ' .
                'autorizacaoEmpenho.codEntidade = autorizacaoAnulada.codEntidade AND ' .
                'autorizacaoEmpenho.codAutorizacao = autorizacaoAnulada.codAutorizacao'
            )
            ->where('julgamento.codCotacao = :codCotacao')
            ->andWhere('julgamento.exercicio = :exercicio')
            ->groupBy('julgamento.exercicio, julgamento.codCotacao, autorizacaoEmpenho.codAutorizacao, autorizacaoEmpenho.exercicio')
            ->orderBy('autorizacaoEmpenho.codAutorizacao')
            ->setParameters([
                'exercicio' => $compraDireta->getExercicioMapa(),
                'codCotacao' => $mapaCotacao->getFkComprasCotacao()->getCodCotacao()
            ]);

        return $queryBuilder;
    }

    /*
     * Baseado no arquivo PRMANTERMAPACOMPRAS Linha 1609
     */
    public function getRecuperaTodos($codMapa, $exercicio)
    {
        return $this->repository->getRecuperaTodos($codMapa, $exercicio);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $exercicio
     * @return ProxyQuery
     */
    public function getRecuperaNaoHomologados(ProxyQuery $proxyQuery, $exercicio)
    {
        $compras = $this->repository->getRecuperaNaoHomologados();
        $aliases = $proxyQuery->getRootAliases();

        $ids = [];

        foreach ($compras as $comprasIds) {
            $ids[] = $comprasIds->cod_compra_direta;
        }

        $compras = $ids;
        $compras = (empty($compras) ? 0 : $compras);
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$aliases[0]}.codCompraDireta", $compras)
            )
            ->andWhere("{$aliases[0]}.exercicioEntidade = '" . $exercicio . "'");

        return $proxyQuery;
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $exercicio
     * @return ProxyQuery
     */
    public function getRecuperaNaoAutorizadas(ProxyQuery $proxyQuery, $exercicio)
    {
        $compras = $this->getListagemCompraDiretaEmissaoEmpenho($exercicio);

        $aliases = $proxyQuery->getRootAliases();
        $comprasArray = [];
        foreach ($compras as $comprasIds) {
            $comprasArray[] = $comprasIds->cod_compra_direta;
        }

        $compras = (empty($comprasArray) ? 0 : $comprasArray);
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$aliases[0]}.codCompraDireta", $compras)
            )
            ->andWhere(
                "{$aliases[0]}.exercicioEntidade = '" . $exercicio . "'"
            );

        return $proxyQuery;
    }

    /**
     * @param $exercicio
     * @param $cod_entidade
     * @param $cod_modalidade
     * @param $cod_compra_direta
     */
    public function montaRecuperaItensComStatus($exercicio, $cod_entidade, $cod_modalidade, $cod_compra_direta)
    {
        return $this->repository->montaRecuperaItensComStatus($exercicio, $cod_entidade, $cod_modalidade, $cod_compra_direta);
    }

    /**
     * @param $codCompraDireta
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $codModalidade
     * @return null|object
     */
    public function getOneCompraDireta($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade)
    {
        return $this->repository->findOneBy([
            'codCompraDireta' => $codCompraDireta,
            'codEntidade' => $codEntidade,
            'exercicioEntidade' => $exercicioEntidade,
            'codModalidade' => $codModalidade
        ]);
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @param $cgmFornecedor
     * @param $lote
     * @return mixed
     */
    public function deleteJulgamentoCompraDireta($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote)
    {
        $julgamentoItemModel = new JulgamentoItemModel($this->entityManager);
        $julgamentoItemModel->removeJulgamentoItem($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote);

        $cotacaoFornecedorModel = new CotacaoFornecedorItemDesclassificacaoModel($this->entityManager);
        $cotacaoFornecedorModel->removeCotacaoFornecedorItemDesclassificacao($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote);

        return $this->entityManager->getRepository(Compras\CotacaoAnulada::class)->insertCotacaoAnulada($codCotacao, $exercicio);
    }

    /**
     * @param string $exercicio
     * @return mixed
     */
    public function getListagemCompraDiretaEmissaoEmpenho($exercicio)
    {
        return $this->repository->getListagemCompraDiretaEmissaoEmpenho($exercicio);
    }

    /**
     * @param $cod_compra_direta
     * @param $cod_modalidade
     * @param $cod_entidade
     * @param $exercicio_entidade
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaMapaCompraDiretaJulgada($cod_compra_direta, $cod_modalidade, $cod_entidade, $exercicio_entidade)
    {
        return $this->repository->montaRecuperaMapaCompraDiretaJulgada($cod_compra_direta, $cod_modalidade, $cod_entidade, $exercicio_entidade);
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return mixed
     */
    public function montaRecuperaItensAgrupadosAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        return $this->repository->montaRecuperaItensAgrupadosAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return mixed
     */
    public function montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        return $this->repository->montaRecuperaInfoItensAgrupadosSolicitacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @param $fornecedor
     * @param $codDespesa
     * @param $codConta
     * @return mixed
     */
    public function montaRecuperaItensAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $fornecedor, $codDespesa, $codConta)
    {
        return $this->repository->montaRecuperaItensAutorizacao($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade, $fornecedor, $codDespesa, $codConta);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneCompraDiretaByCodMapaAndExercicio($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicioEntidade' => $exercicio,
            'codMapa' => $codMapa
        ]);
    }
}
