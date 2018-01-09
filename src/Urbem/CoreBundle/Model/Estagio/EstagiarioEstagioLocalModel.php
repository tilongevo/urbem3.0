<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal;
use Urbem\CoreBundle\Entity\Organograma\Local;

class EstagiarioEstagioLocalModel extends AbstractModel
{
    protected $entityManager = null;

    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\EstagiarioEstagioLocal");
    }

    /**
     * @param Local $local
     * @param EstagiarioEstagio $estagiarioEstagio
     * @return EstagiarioEstagioLocal
     */
    public function saveEstagiarioEstagioLocal(Local $local, EstagiarioEstagio $estagiarioEstagio)
    {

        $estagioLocal = new EstagiarioEstagioLocal();
        $estagioLocal
            ->setFkOrganogramaLocal($local)
            ->setFkEstagioEstagiarioEstagio($estagiarioEstagio);

        $this->save($estagioLocal);

        return $estagioLocal;
    }
}
