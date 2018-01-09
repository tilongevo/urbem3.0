<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao;

/**
 * Class RequisicaoItensAnulacaoModel
 */
class RequisicaoItensAnulacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * RequisicaoItensAnulacaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(RequisicaoItensAnulacao::class);
    }

    /**
     * @param Requisicao $requisicao
     */
    public function removeAll(RequisicaoItem $requisicaoItem)
    {
        /** @var RequisicaoItensAnulacao $requisicaoItemAnulacao */
        foreach ($requisicaoItem->getFkAlmoxarifadoRequisicaoItensAnulacoes() as $requisicaoItemAnulacao) {
            $this->remove($requisicaoItemAnulacao);
        }
    }

    /**
     * @param RequisicaoAnulacao $requisicaoAnulacao
     * @param RequisicaoItem $requisicaoItem
     * @param $quantidade
     * @return RequisicaoItensAnulacao
     */
    public function anularItensRequisicao(
        RequisicaoAnulacao $requisicaoAnulacao,
        RequisicaoItem $requisicaoItem,
        $quantidade
    ) {
        $requisicaoItensAnulacao = new RequisicaoItensAnulacao();
        $requisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoItem($requisicaoItem);
        $requisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoAnulacao($requisicaoAnulacao);
        $requisicaoItensAnulacao->setQuantidade($quantidade);

        $this->save($requisicaoItensAnulacao);

        return $requisicaoItensAnulacao;
    }
}
