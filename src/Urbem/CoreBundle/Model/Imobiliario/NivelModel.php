<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;

class NivelModel extends AbstractModel
{
    const INICIAL = 1;
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Nivel::class);
    }

    /**
     * @param Nivel $object
     * @return bool
     */
    public function canRemove($object)
    {
        // Verifica se é o último da hierarquia ou se possui referências cadastradas no sistema
        if (!$this->isUltimoNivelHierarquia($object->getFkImobiliarioVigencia(), $object)) {
            return false;
        } elseif ($object->getFkImobiliarioLocalizacaoNiveis()->count()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param Nivel $nivel
     * @return bool
     */
    public function isUltimoNivelHierarquia(Nivel $nivel)
    {
        return $nivel->getFkImobiliarioVigencia()->getFkImobiliarioNiveis()->last() === $nivel;
    }

    /**
     * @param Vigencia $vigencia
     * @return int
     */
    public function getProximoCodNivel(Vigencia $vigencia)
    {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->select('MAX(o.codNivel) AS lastCodNivel');
        $qb->where('o.codVigencia = :codVigencia');
        $qb->setParameter('codVigencia', $vigencia->getCodVigencia());
        $result = $qb->getQuery()->getSingleResult();

        return ($result['lastCodNivel'])
            ? $result['lastCodNivel'] + self::INICIAL
            : self::INICIAL;
    }
}
