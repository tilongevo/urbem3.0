<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class ClassificacaoAssentamentoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ClassificacaoAssentamento");
    }

    public function canRemove($object)
    {
        $AssentamentoAssentamentoRepository = $this->entityManager->getRepository("CoreBundle:Pessoal\\AssentamentoAssentamento");
        $res = $AssentamentoAssentamentoRepository->findOneByCodClassificacao($object->getCodClassificacao());

        return is_null($res);
    }
}
