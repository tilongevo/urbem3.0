<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;

/**
 * Class PerecivelModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class PerecivelModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var CatalogoItemRepository $repository */
    protected $repository = null;

    /**
     * PerecivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Perecivel::class);
    }

    /**
     * @param EstoqueMaterial $estoqueMaterial
     * @param \DateTime $dtFabricacao
     * @param \DateTime $dtValidade
     * @param string    $lote
     * @return Perecivel
     */
    public function findOrCreatePerecivel(
        EstoqueMaterial $estoqueMaterial,
        \DateTime $dtFabricacao,
        \DateTime $dtValidade,
        $lote
    ) {
        $perecivel = $this->repository->findOneBy([
            'fkAlmoxarifadoEstoqueMaterial' => $estoqueMaterial,
            'lote' => $lote
        ]);

        if (true == is_null($perecivel)) {
            $perecivel = new Perecivel();
            $perecivel->setFkAlmoxarifadoEstoqueMaterial($estoqueMaterial);
            $perecivel->setDtFabricacao($dtFabricacao);
            $perecivel->setDtValidade($dtValidade);
            $perecivel->setLote($lote);

            $this->save($perecivel);
        }

        return $perecivel;
    }

    /**
     * @deprecated
     * @trigger_error('Deprecated method, change to findOrCreatePerecivel')
     * @param EstoqueMaterial $estoqueMaterial
     * @param array                        $params
     * @return Perecivel
     */
    public function savePerecivel(EstoqueMaterial $estoqueMaterial, array $params)
    {
        $dtFabricacao = new \DateTime(($params['dtFabricacao']));
        $dtValidade = new \DateTime(($params['dtValidade']));

        return $this->findOrCreatePerecivel($estoqueMaterial, $dtFabricacao, $dtValidade, $params['lote']);
    }

    /**
     * @param EstoqueMaterial $estoqueMaterial
     * @return ArrayCollection
     */
    public function findPerecivelByEstoqueMaterial(EstoqueMaterial $estoqueMaterial)
    {
        $pereciveis = $this->repository->findBy([
            'fkAlmoxarifadoEstoqueMaterial' => $estoqueMaterial
        ]);

        return new ArrayCollection($pereciveis);
    }
}
