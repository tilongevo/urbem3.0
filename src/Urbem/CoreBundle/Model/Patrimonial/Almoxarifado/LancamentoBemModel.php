<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;

/**
 * Class LancamentoBemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoBemModel extends AbstractModel
{
    protected $entityManager;

    /** @var ORM\EntityRepository $repository */
    protected $repository;

    /**
     * OrdemItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(LancamentoBem::class);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     * @param Bem                $bem
     * @return LancamentoBem
     */
    public function findOrCreateLancamentoBem(LancamentoMaterial $lancamentoMaterial, Bem $bem)
    {
        $lancamentoBem = $this->repository->findOneBy([
            'fkAlmoxarifadoLancamentoMaterial' => $lancamentoMaterial,
            'fkPatrimonioBem' => $bem
        ]);

        if (true == is_null($lancamentoBem)) {
            $lancamentoBem = new LancamentoBem();
            $lancamentoBem->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
            $lancamentoBem->setFkPatrimonioBem($bem);

            $this->save($lancamentoBem);
        }

        return $lancamentoBem;
    }
}
