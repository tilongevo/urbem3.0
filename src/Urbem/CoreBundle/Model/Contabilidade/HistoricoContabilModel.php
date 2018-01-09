<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Contabilidade\HistoricoContabilRepository;

class HistoricoContabilModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var HistoricoContabilRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\HistoricoContabil");
    }

    public function getHistoricoContabil($exercicio, $nomHistorico)
    {
        return $this->repository->findHistoricoContabil($exercicio, $nomHistorico);
    }

    public function getAllHistoricoContabil($nomHistorico)
    {
        return $this->repository->findAllHistoricoContabil($nomHistorico);
    }

    public function getHistoricoByExericicioAndNomHistorico($exercicio, $nomHistorico)
    {
        return $this->repository->findOneBy(['exercicio' => $exercicio, 'nomHistorico' => $nomHistorico]);
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function getLastCodHistorico($exercicio)
    {
        return $this->repository->getLastCodHistorico($exercicio);
    }

    /**
     * @param $exercicio
     * @return null|object
     */
    public function getCodHistorico($exercicio)
    {
        return $this->repository->findBy(['exercicio' => $exercicio]);
    }
}
