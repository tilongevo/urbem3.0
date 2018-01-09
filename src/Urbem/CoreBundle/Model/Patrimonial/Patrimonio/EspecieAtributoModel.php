<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo;

class EspecieAtributoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\EspecieAtributo");
    }

    public function salvar(EspecieAtributo $especieAtributo)
    {
        $this->save($especieAtributo);
    }
}
