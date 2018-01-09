<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Pessoal\CargoSubDivisaoRepository;

class CargoSubDivisaoModel extends AbstractModel
{

    protected $entityManager = null;

    /**
     * @var CargoSubDivisaoRepository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\CargoSubDivisao");
    }

    public function getCargoSubDivisaoPorTimestamp($info, $codCargo)
    {
        return $this->repository->getCargoSubDivisaoPorTimestamp($info, $codCargo);
    }

    public function getVagasOcupadasCargo($codRegime, $codSubDivisao, $codEspecialidade)
    {
        return $this->repository->getVagasOcupadasCargo($codRegime, $codSubDivisao, $codEspecialidade);
    }
    
    /**
     * @param array $arrSubDivisoes
     * @param int $anoCompetencia
     * @return array
     */
    public function getCargosPorSubDivisaoPerioro(Array $arrSubDivisoes, $anoCompetencia)
    {
        return $this->repository->getCargosPorSubDivisaoPerioro($arrSubDivisoes, $anoCompetencia);
    }
}
