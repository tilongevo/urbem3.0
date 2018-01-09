<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

class LancamentoRequisicaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\LancamentoRequisicao::class);
    }

    /**
     * Constroi um objeto de LancamentoRequisicao usando dados de RequisicaoItem
     *
     * @param Almoxarifado\Requisicao $requisicao
     * @return Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     */
    public function buildOneBasedOnRequisicaoItem(Almoxarifado\RequisicaoItem $requisicaoItem)
    {
        $lancamentoRequisicao = new Almoxarifado\LancamentoRequisicao();
        $lancamentoRequisicao->setFkAlmoxarifadoRequisicaoItem($requisicaoItem);
        $lancamentoRequisicao->setExercicio($requisicaoItem->getExercicio());

        return $lancamentoRequisicao;
    }
}
