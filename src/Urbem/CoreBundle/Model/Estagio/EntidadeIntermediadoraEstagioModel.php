<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora;
use Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;

class EntidadeIntermediadoraEstagioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * EntidadeIntermediadoraEstagioModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\EntidadeIntermediadoraEstagio");
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     * @param EntidadeIntermediadora $entidadeIntermediadora
     * @return EntidadeIntermediadoraEstagio
     */
    public function saveEntidadeIntermediadoraEstagio(EstagiarioEstagio $estagiarioEstagio, EntidadeIntermediadora $entidadeIntermediadora)
    {
        $entidadeIntermediadoraEstagio = new entidadeIntermediadoraEstagio();
        $entidadeIntermediadoraEstagio
            ->setFkEstagioEntidadeIntermediadora($entidadeIntermediadora)
            ->setFkEstagioEstagiarioEstagio($estagiarioEstagio);

        $this->save($entidadeIntermediadoraEstagio);

        return $entidadeIntermediadoraEstagio;
    }
}
