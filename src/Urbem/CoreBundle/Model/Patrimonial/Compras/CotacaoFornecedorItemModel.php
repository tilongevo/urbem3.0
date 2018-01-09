<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca;
use Urbem\CoreBundle\Entity\Beneficio\Fornecedor;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\CotacaoFornecedorItemRepository;

class CotacaoFornecedorItemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var CotacaoFornecedorItemRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository('CoreBundle:Compras\CotacaoFornecedorItem');
    }

    public function getItemInfo($codCotacao, $exercicioCotacao, $codItem)
    {
        $mapaCotacao = $this->entityManager->getRepository('CoreBundle:Compras\MapaCotacao')->findOneBy([
            'codCotacao' => $codCotacao,
            'exercicioCotacao' => $exercicioCotacao
        ]);

        $mapaItem = $this->entityManager->getRepository('CoreBundle:Compras\MapaItem')->findOneBy([
            'codMapa' => $mapaCotacao->getFkComprasMapa()->getCodMapa(),
            'exercicio' => $mapaCotacao->getFkComprasMapa()->getExercicio(),
            'codItem' => $codItem
        ]);

        return $mapaItem;
    }

    /**
     * @param integer $cod_cotacao
     * @param string $exercicio
     * @param integer $cod_item
     * @param integer $cgm_fornecedor
     * @param integer $lote
     * @return mixed
     */
    public function montaRecuperaItensFornecedor($cod_cotacao, $exercicio, $cod_item, $cgm_fornecedor, $lote)
    {
        return $this->repository->montaRecuperaItensFornecedor($cod_cotacao, $exercicio, $cod_item, $cgm_fornecedor, $lote);
    }

    /**
     * @param $cod_item
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaValorItemUltimaCompra($cod_item, $exercicio)
    {
        return $this->repository->montaRecuperaValorItemUltimaCompra($cod_item, $exercicio);
    }

    /**
     * @param $exercicioMapa
     * @param $codMapa
     * @return mixed
     */
    public function montaRecuperaItensCotacaoJulgadosCompraDireta($exercicioMapa, $codMapa)
    {
        return $this->repository->montaRecuperaItensCotacaoJulgadosCompraDireta($exercicioMapa, $codMapa);
    }

    /**
     * @param array $cotacao
     * @return null|Compras\CotacaoFornecedorItem
     */
    public function getOne(array $cotacao)
    {
        /** @var Compras\CotacaoFornecedorItem|null $cotacaoFornecedorItem */
        $cotacaoFornecedorItem = $this->repository->find($cotacao);

        return $cotacaoFornecedorItem;
    }

    /**
     * @param $exercicio
     * @param $cotacao
     * @param $fornecedor
     * @param $item
     * @return null|object
     */
    public function findExists($exercicio, $cotacao, $fornecedor, $item)
    {
        $cotacaoFornecedorItem = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codCotacao' => $cotacao,
            'codItem' => $item,
            'cgmFornecedor' => $fornecedor,
        ]);

        return $cotacaoFornecedorItem;
    }
}
