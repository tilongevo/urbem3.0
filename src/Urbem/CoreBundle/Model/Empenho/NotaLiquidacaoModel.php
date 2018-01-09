<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Model;

class NotaLiquidacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Empenho\\NotaLiquidacao");
    }

    public function getProximoCodNota($codEntidade, $exercicio)
    {
        return $this->repository->getProximoCodNota($codEntidade, $exercicio);
    }

    public function populaNotaLiquidacao($object, $dataForm, $exercicio, $uniqid)
    {
        $codNota = $this->repository->getProximoCodNota($object->getCodEntidade(), $object->getExercicio());

        $dtLiquidacao = \DateTime::createFromFormat("d/m/Y", $dataForm[$uniqid]['dtLiquidacao']);
        $dtVencimento = \DateTime::createFromFormat("d/m/Y", $dataForm[$uniqid]['dtVencimento']);

        $notaLiquidacao = new NotaLiquidacao();
        $notaLiquidacao->setCodNota($codNota);
        $notaLiquidacao->setFkEmpenhoEmpenho($object);
        $notaLiquidacao->setExercicio($object->getExercicio());
        $notaLiquidacao->setCodEntidade($object->getCodEntidade());
        $notaLiquidacao->setExercicioEmpenho($exercicio);
        $notaLiquidacao->setDtLiquidacao($dtLiquidacao);
        $notaLiquidacao->setDtVencimento($dtVencimento);
        $notaLiquidacao->setObservacao('observação');

        return $notaLiquidacao;
    }
}
