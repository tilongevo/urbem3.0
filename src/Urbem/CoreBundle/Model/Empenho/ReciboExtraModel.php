<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class ReciboExtraModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Tesouraria\\ReciboExtra");
    }

    public function canRemove($object)
    {
    }

    public function getProximoCodReciboExtra($exercicio, $codEntidade, $tipoRecibo)
    {
        $em = $this->entityManager;

        $reciboExtra = $em->getRepository('CoreBundle:Tesouraria\ReciboExtra')
            ->findOneBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'tipoRecibo' => $tipoRecibo
            ], ['codReciboExtra' => 'DESC']);
        if ($reciboExtra) {
            $codReciboExtra = $reciboExtra->getCodReciboExtra() + 1;
        } else {
            $codReciboExtra = 1;
        }
        return $codReciboExtra;
    }

    public function getReciboExtra($paramsWhere)
    {
        return $this->repository->findReciboExtra($paramsWhere);
    }
}
