<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\NivelServico;
use Urbem\CoreBundle\Entity\Tcepb\PlanoAnaliticaRelacionamento;

/**
 * Class NivelServicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class NivelServicoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ProdutoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(NivelServico::class);
    }

    /**
     * @param $codVigencia
     * @return null|object
     */
    public function getNivelSuperior($codVigencia)
    {
        return $this->repository->findOneByCodVigencia($codVigencia, array('codNivel' => 'DESC'));
    }

    /**
     * @return mixed
     */
    public function nextCodNivel()
    {
        return $this->repository->nextCodNivelServico();
    }

    /**
     * @param $codNivel
     * @return mixed
     */
    public function getNivelServico($codNivel)
    {
        return $this->repository->findOneByCodNivel($codNivel);
    }
}
