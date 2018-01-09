<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

class DeducaoDependenteModel extends AbstractModel
{
    protected $em = null;
    protected $repository = null;

    /**
     * DeducaoDependenteModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('CoreBundle:Folhapagamento\DeducaoDependente');
    }

    /**
     * @param $numcgm
     * @param $codPeriodoMovimentacao
     * @param $codTipo
     * @return null|object|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependente
     */
    public function recuperaDecucaoDependente($numcgm, $codPeriodoMovimentacao, $codTipo)
    {
        return $this->repository->findOneBy([
            'numcgm' => $numcgm,
            'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
            'codTipo' => $codTipo
        ]);
    }
}
