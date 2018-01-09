<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\PrevidenciaRegimeRatRepository;

class PrevidenciaRegimeRatModel extends Model
{
    protected $entityManager = null;
    /** @var PrevidenciaRegimeRatRepository|null */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PrevidenciaRegimeRat::class);
    }

    /**
     * @return mixed
     */
    public function recuperaAliquotaSefip()
    {
        return $this->repository->recuperaAliquotaSefip();
    }
}
