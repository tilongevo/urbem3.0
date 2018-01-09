<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho;
use Urbem\CoreBundle\Model;

class LancamentoEmpenhoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\LancamentoEmpenho");
    }

    public function populaLancamentoEmpenho($object, $codLote, $exercicio, $sequencia, $tipo)
    {
        $lancamentoEmpenho = new LancamentoEmpenho();
        $lancamentoEmpenho->setExercicio($exercicio);
        $lancamentoEmpenho->setCodLote($codLote);
        $lancamentoEmpenho->setSequencia($sequencia);
        $lancamentoEmpenho->setCodEntidade($object->getCodEntidade());
        $lancamentoEmpenho->setTipo($tipo);

        return $lancamentoEmpenho;
    }
}
