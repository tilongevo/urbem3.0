<?php
/**
 * Created by PhpStorm.
 * User: rcruz
 * Date: 8/19/16
 * Time: 13:42
 */

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;

class EnquadramentoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\Enquadramento");
    }
}
