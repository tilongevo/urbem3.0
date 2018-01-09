<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem;
use Urbem\CoreBundle\Model;

class NotaLiquidacaoItemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\\NotaLiquidacaoItem");
    }

    public function populaNotaLiquicaoItem($object, $notaLiquidacao, $numItem, $valor, $exercicio)
    {
        $itemPreEmpenho = $this->entityManager->getRepository('CoreBundle:Empenho\\ItemPreEmpenho')
            ->findOneBy([
                'codPreEmpenho' => $object->getFkEmpenhoPreEmpenho()->getCodPreEmpenho(),
                'numItem' => $numItem
            ]);

        $notaLiquidacaoItem = new NotaLiquidacaoItem();
        $notaLiquidacaoItem->setExercicio($notaLiquidacao->getExercicio());
        $notaLiquidacaoItem->setCodNota($notaLiquidacao->getCodNota());
        $notaLiquidacaoItem->setFkEmpenhoNotaLiquidacao($notaLiquidacao);
        $notaLiquidacaoItem->setNumItem($numItem);
        $notaLiquidacaoItem->setExercicioItem($exercicio);
        $notaLiquidacaoItem->setCodPreEmpenho($object->getCodPreEmpenho());
        $notaLiquidacaoItem->setVlTotal($valor);
        $notaLiquidacaoItem->setFkEmpenhoItemPreEmpenho($itemPreEmpenho);

        return $notaLiquidacaoItem;
    }
}
