<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AssentamentoSefipModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function canRemove($object)
    {

        $causaRescisaoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CausaRescisao");
        $res = $causaRescisaoRepository->findOneBy(['codSefipSaida' => $object->getCodSefip()]);

        return is_null($res);
    }
}
