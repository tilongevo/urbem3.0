<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\CausaRescisao;

/**
 * Class CasoCausaModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class CausaRescisaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\Pessoal\CausaRescisaoRepository  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CausaRescisao::class);
    }

    /**
     * @param $filtro
     *
     * @return mixed
     */
    public function recuperaSefipRescisao($filtro)
    {
        return $this->repository->recuperaSefipRescisao($filtro);
    }
}
