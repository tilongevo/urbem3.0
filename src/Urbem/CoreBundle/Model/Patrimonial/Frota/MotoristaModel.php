<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class MotoristaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\Motorista");
    }

    public function canRemove($object)
    {
        $utilizacaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Utilizacao");
        $resUt = $utilizacaoRepository->findOneBy([
            'fkFrotaMotorista'=>$object
        ]);

        $infracaoRepository = $this->entityManager->getRepository("CoreBundle:Frota\\Infracao");
        $resIn = $infracaoRepository->findOneBy(['fkFrotaVeiculo'=>$object]);

        return is_null($resUt) && is_null($resIn);
    }

    public function getMotoristaVeiculo($id)
    {
        return $this->repository->getMotoristaVeiculo($id);
    }

    /**
     * @param Entity\Frota\Motorista $motorista
     */
    public function removeMotoristaVeiculo($motorista)
    {
        foreach ($motorista->getFkFrotaMotoristaVeiculos() as $motoristaVeiculo) {
            $this->remove($motoristaVeiculo);
        }
    }

    public function updateCgmMotorista($cgm, $numcnh, $validadecnh, $categoriacnh)
    {
        return $this->repository->updateCgmMotorista($cgm, $numcnh, $validadecnh, $categoriacnh);
    }
}
