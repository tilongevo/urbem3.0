<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\Repository\Licitacao\VeiculosPublicidadeRepository;

class VeiculosPublicidadeModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;

    /** @var VeiculosPublicidadeRepository|null $repository */
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(VeiculosPublicidade::class);
    }

    /**
     * @param VeiculosPublicidade $veiculosPublicidade
     * @return boolean
     */
    public function canRemove($veiculosPublicidade)
    {
        $publicacaoConvenios = $veiculosPublicidade->getFkLicitacaoPublicacaoConvenios();
        if (false == $publicacaoConvenios->isEmpty()) {
            return false;
        }

        $publicacaoEditais = $veiculosPublicidade->getFkLicitacaoPublicacaoEditais();
        if (false == $publicacaoEditais->isEmpty()) {
            return false;
        }

        $publicacaoContratos = $veiculosPublicidade->getFkLicitacaoPublicacaoContratos();
        if (false == $publicacaoContratos->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $paramsWhere
     * @return mixed
     */
    public function carregaVeiculosPublicidadeJson($paramsWhere)
    {
        return $this->repository->carregaVeiculosPublicidadeJson($paramsWhere);
    }
}
