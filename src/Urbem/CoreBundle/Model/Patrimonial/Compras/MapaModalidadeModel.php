<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\MapaRepository;

/**
 * Class MapaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class MapaModalidadeModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var MapaRepository|null */
    protected $repository = null;

    /**
     * MapaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaModalidade::class);
    }

    /**
     * @param Compras\Mapa $mapa
     * @param Compras\Modalidade $modalidade
     * @return null|object|Compras\MapaModalidade
     */
    public function buildOne(Compras\Mapa $mapa, Compras\Modalidade $modalidade)
    {
        $mapaModalidade = $this->repository->findOneBy([
            'fkComprasModalidade' => $modalidade,
            'fkComprasMapa' => $mapa,
        ]);

        if (true == is_null($mapaModalidade)) {
            $mapaModalidade = new Compras\MapaModalidade();
            $mapaModalidade->setFkComprasMapa($mapa);
            $mapaModalidade->setFkComprasModalidade($modalidade);

            $this->save($mapaModalidade);
        }

        return $mapaModalidade;
    }
}
