<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Previdencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\PrevidenciaEventoRepository;

class PrevidenciaEventoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var PrevidenciaEventoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PrevidenciaEvento::class);
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function recuperaEventosDePrevidenciaPorContrato($stFiltro = false)
    {
        return $this->repository->recuperaEventosDePrevidenciaPorContrato($stFiltro);
    }
}
