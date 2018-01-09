<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Administracao\AssinaturaRepository;

/**
 * Class AssinaturaModel
 * @package Urbem\CoreBundle\Model\Administracao
 */
class AssinaturaModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;
    /** @var AssinaturaRepository $repository */
    protected $repository = null;

    /**
     * AssinaturaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\Assinatura");
    }

    /**
     * @return DateTimeMicrosecondPK
     */
    public function getLastTimestamp()
    {
        $assinatura = $this->repository->findOneBy(array(), array('timestamp' => 'DESC'));

        if (null === $assinatura) {
            return new DateTimeMicrosecondPK();
        }

        return $assinatura->getTimestamp();
    }

    /**
     * @param $exercicio
     * @param $params
     * @return array
     */
    public function carregaAdministracaoAssinatura($exercicio, $params)
    {
        return $this->repository->carregaAdministracaoAssinatura($exercicio, $params);
    }

    public function carregaAssinaturas($exercicio, $codEntidade, $codModulo)
    {
        return $this->repository->carregaListaAssinaturas($exercicio, $codEntidade, $codModulo);
    }

    /**
     * @param $exercicio
     * @param $codModulo
     * @return array
     */
    public function carregaListaAssinaturasAberturaInventario($exercicio, $codModulo)
    {
        return $this->repository->carregaListaAssinaturasAberturaInventario($exercicio, $codModulo);
    }

    /**
     * @param $exercicio
     * @param $assinatura
     * @param $entidade
     * @return array
     */
    public function getListaAssinatura($exercicio, $entidade)
    {
        return $this->repository->getListaAssinatura($exercicio, $entidade);
    }
}
