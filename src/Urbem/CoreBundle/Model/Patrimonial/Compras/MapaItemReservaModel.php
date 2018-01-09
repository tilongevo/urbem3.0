<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Compras\MapaItem;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\MapaItemReservaRepository;

class MapaItemReservaModel extends AbstractModel
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
        /** @var MapaItemReservaRepository repository */
        $this->repository = $this->entityManager->getRepository(Compras\MapaItemReserva::class);
    }

    /**
     * @param $stItens
     * @param $codMapa
     * @param $exercicioMapa
     * @param $codSolicitacao
     * @param $exercicioSolicitacao
     * @return mixed
     */
    public function montaRecuperaReservas($stItens, $codMapa, $exercicioMapa, $codSolicitacao, $exercicioSolicitacao)
    {
        return $this->repository->montaRecuperaReservas($stItens, $codMapa, $exercicioMapa, $codSolicitacao, $exercicioSolicitacao);
    }

    /**
     * @param Compras\MapaItemDotacao $mapaItemDotacao
     * @param ReservaSaldos $reservaSaldosx
     */
    public function saveMapaItemReserva(Compras\MapaItemDotacao $mapaItemDotacao, ReservaSaldos $reservaSaldos)
    {
        $obTComprasMapaItemReserva = new Compras\MapaItemReserva();
        $obTComprasMapaItemReserva->setFkComprasMapaItemDotacao($mapaItemDotacao);
        $obTComprasMapaItemReserva->setFkOrcamentoReservaSaldos($reservaSaldos);
        $this->save($obTComprasMapaItemReserva);
    }

    /**
     * @param Compras\MapaItemDotacao $mapaItemDotacao
     * @param ReservaSaldos           $reservaSaldos
     *
     * @return Compras\MapaItemReserva
     */
    public function buildOne(Compras\MapaItemDotacao $mapaItemDotacao, ReservaSaldos $reservaSaldos)
    {
        $mapaItemReserva = new Compras\MapaItemReserva();
        $mapaItemReserva->setFkComprasMapaItemDotacao($mapaItemDotacao);
        $mapaItemReserva->setFkOrcamentoReservaSaldos($reservaSaldos);

        $this->entityManager->persist($mapaItemReserva);

        return $mapaItemReserva;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapaItemReserva($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicioMapa' => $exercicio,
            'codMapa' => $codMapa,
        ]);
    }
}
