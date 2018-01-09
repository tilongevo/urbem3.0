<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\PedidoTransferenciaRepository;

/**
 * Class AlmoxarifeModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class AlmoxarifeModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * AlmoxarifeModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\Almoxarife::class);
    }

    /**
     * @param Almoxarifado\Almoxarife $almoxarife
     * @return bool
     */
    public function canRemove(Almoxarifado\Almoxarife $almoxarife)
    {
        /** @var PedidoTransferenciaRepository $PedidoTransferenciaRepository */
        $PedidoTransferenciaRepository = $this->entityManager->getRepository(Almoxarifado\PedidoTransferencia::class);
        $resPt = $PedidoTransferenciaRepository->findOneBy([
            'fkAlmoxarifadoAlmoxarife' => $almoxarife
        ]);

        $NaturezaLancamentoRepository = $this->entityManager->getRepository(Almoxarifado\NaturezaLancamento::class);
        $resNl = $NaturezaLancamentoRepository->findOneBy([
            'fkAlmoxarifadoAlmoxarife' => $almoxarife
        ]);

        return is_null($resPt) && is_null($resNl);
    }

    /**
     * @param integer $cgmAlmoxarife
     * @return null|Administracao\Usuario
     * @throws \Exception
     */
    public function getUsuarioByCgmAlmoxarife($cgmAlmoxarife)
    {
        $entityManager = $this->entityManager;

        return $entityManager
            ->getRepository(Administracao\Usuario::class)
            ->findOneBy([
                'numcgm' => $cgmAlmoxarife
            ]);
    }

    /**
     * @param Administracao\Usuario $usuario
     * @return null|Almoxarifado\Almoxarife
     */
    public function findByUsuario(Administracao\Usuario $usuario)
    {
        $almoxarife = $this->repository->find($usuario->getNumcgm());

        return $almoxarife;
    }
}
