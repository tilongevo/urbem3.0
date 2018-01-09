<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Licitacao\ConvenioAditivosRepository;

/**
 * Class ConvenioAditivosModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ConvenioAditivosModel implements Model\InterfaceModel
{
    /** @var EntityManager */
    private $entityManager;
    
    /** @var ConvenioAditivosRepository */
    protected $repository;

    /**
     * MarcaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConvenioAditivos::class);
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        // Implements canRemove
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @deprecated Use o metodo 'setNumAditivo'.
     *
     * @param ConvenioAditivos $convenioAditivos
     *
     * @return int identifier
     */
    public function getAvailableIdentifier($convenioAditivos)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("o.numAditivo") . " AS identifier"
            )
            ->from(ConvenioAditivos::class, 'o')
            ->where("o.exercicioConvenio = '{$convenioAditivos->getExercicioConvenio()}'")
            ->andWhere('o.numConvenio = '.$convenioAditivos->getNumConvenio())
            ->andWhere("o.exercicio = '{$convenioAditivos->getExercicio()}'")
        ;
        return $queryBuilder->getQuery()->getSingleScalarResult() + 1;
    }

    /**
     * @param ConvenioAditivos $convenioAditivos
     */
    public function setNumAditivo(ConvenioAditivos $convenioAditivos)
    {
        $numAditivo = $this->repository->nextVal('num_aditivo', [
            'exercicio_convenio' => $convenioAditivos->getExercicioConvenio(),
            'num_convenio' => $convenioAditivos->getNumConvenio(),
            'exercicio' => $convenioAditivos->getExercicio()
        ]);

        $convenioAditivos->setNumAditivo($numAditivo);
    }
}
