<?php


namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal\ContratoPensionistaCasoCausaRepository;

class ContratoPensionistaCasoCausaModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var ContratoPensionistaCasoCausaRepository|null
     */
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\ContratoPensionistaCasoCausa");
    }

    /**
     * @param $stFiltroContratos
     * @param $stOrdem
     * @return array
     */
    public function recuperaTermoRescisao($stFiltroContratos, $stOrdem, $exercicio, $periodoMovimentacao)
    {
        return $this->repository->recuperaTermoRescisao($stFiltroContratos, $stOrdem, $exercicio, $periodoMovimentacao);
    }
}
