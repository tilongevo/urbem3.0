<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Folhapagamento\UltimoRegistroEventoComplementarRepository;

class UltimoRegistroEventoComplementarModel extends AbstractModel
{
    protected $em;
    /** @var UltimoRegistroEventoComplementarRepository  */
    protected $repository;

    /**
     * UltimoRegistroEventoComplementarModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('CoreBundle:Folhapagamento\UltimoRegistroEventoComplementar');
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return array
     */
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        return $this->repository->montaRecuperaRelacionamento($filtro, $ordem);
    }
}
