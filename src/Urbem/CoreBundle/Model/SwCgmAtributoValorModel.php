<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class SwCgmAtributoValorModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Entity\SwCgmAtributoValor::class);
    }

    public function getValorAtributo($numcgm, $cod_atributo)
    {
        $query = $this->entityManager->createQueryBuilder();
        return $query->select('SwCgmAtributoValor.valor')
            ->from('CoreBundle:SwCgmAtributoValor', 'SwCgmAtributoValor')
            ->where('SwCgmAtributoValor.numcgm = :numcgm')
            ->andWhere('SwCgmAtributoValor.codAtributo = :cod_atributo')
            ->setParameter('numcgm', $numcgm)
            ->setParameter('cod_atributo', $cod_atributo)
            ->getQuery()
            ->getResult();
    }

    public function getNumCgm($numCgm)
    {
        return $this->repository->findByNumcgm($numCgm);
    }

    /**
     * @param Entity\SwCgm $swCgm
     * @param bool         $flush
     */
    public function remove($swCgm, $flush = true)
    {
        $swCgmAtributoValorCollection = $this->repository->findBy([
            'numcgm' => $swCgm
        ]);

        if (!is_null($swCgmAtributoValorCollection)) {
            foreach ($swCgmAtributoValorCollection as $swCgmAtributoValor) {
                parent::remove($swCgmAtributoValor, $flush);
            }
        }
    }
}
