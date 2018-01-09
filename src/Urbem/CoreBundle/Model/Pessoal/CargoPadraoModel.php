<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Pessoal\CargoPadraoRepository;

class CargoPadraoModel extends AbstractModel
{
    protected $entityManager = null;
    private $cargoPadraoRepository = null;

    /**
     * @var CargoPadraoRepository
     */
    protected $repository = null;

    /**
     * CargoPadraoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CargoPadrao");
    }


    /**
     * @param $codCargo
     * @return mixed
     */
    public function getCargoPadraoByCodCargo($codCargo)
    {
        $return = $this->repository->findOneByCodCargo($codCargo);
        return $return;
    }

    public function getCargoPadraoByCodCargoCodPadrao($codCargo, $codPadrao)
    {
        $return = $this->repository->findOneBy(
            array('codCargo' => $codCargo, 'codPadrao' => $codPadrao)
        );
        return $return;
    }


    /**
     * @return array
     */
    public function getPadraoByTimestamp()
    {
        return $this->repository->getPadraoByTimestamp();
    }
}
