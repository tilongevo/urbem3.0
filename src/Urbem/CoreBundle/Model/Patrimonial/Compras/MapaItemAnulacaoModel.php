<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;

class MapaItemAnulacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaItemAnulacao::class);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapaItemAnulacao($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa,
        ]);
    }
}
