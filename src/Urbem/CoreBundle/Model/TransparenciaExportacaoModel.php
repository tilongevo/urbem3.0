<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\NoResultException;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\TransparenciaExportacao;

/**
 * Class TransparenciaExportacaoModel
 *
 * @package Urbem\CoreBundle\Model
 */
class TransparenciaExportacaoModel extends AbstractModel
{
    /** @var \Doctrine\ORM\EntityRepository */
    protected $repository;

    /**
     * TransparenciaExportacaoModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(TransparenciaExportacao::class);
    }

    /**
     * @param TransparenciaExportacao $transparenciaExportacao
     * @param                         $status
     * @param null                    $log
     */
    public function setStatus(TransparenciaExportacao $transparenciaExportacao, $status, $log = null)
    {
        $transparenciaExportacao->setStatus($status);
        $transparenciaExportacao->setLog($log);

        $this->save($transparenciaExportacao);
    }

    /**
     * @param \DateTime $timestamp
     * @param string    $arquivo
     * @param string    $status
     *
     * @return TransparenciaExportacao
     */
    public function buildOne(\DateTime $timestamp, $arquivo, $status)
    {
        $transparenciaExportacao = new TransparenciaExportacao();

        $transparenciaExportacao->setTimestamp($timestamp);
        $transparenciaExportacao->setArquivo($arquivo);
        $transparenciaExportacao->setStatus($status);

        $this->save($transparenciaExportacao);

        return $transparenciaExportacao;
    }

    /**
     * @param TransparenciaExportacao $transparenciaExportacao
     * @param                         $arquivo
     * @param                         $status
     */
    public function updateOne(TransparenciaExportacao $transparenciaExportacao, $arquivo, $status)
    {
        $transparenciaExportacao
            ->setStatus($status)
            ->setArquivo($arquivo);

        $this->save($transparenciaExportacao);
    }

    /**
     * @return null|object|TransparenciaExportacao
     */
    public function getLastTransparenciaExportacao()
    {
        return $this->repository->findOneBy([], ['id' => 'DESC']);
    }

    /**
     * Recupera um objeto TransparenciaExportacao por data.
     *
     * @param \DateTime $date
     *
     * @return null|TransparenciaExportacao
     * @throws \Exception
     */
    public function getTransparenciaExportacaoByDate(\DateTime $date)
    {
        $queryBuilder = $this->repository->createQueryBuilder('te');
        $queryBuilder
            ->where('DATE(te.timestamp) = :date')
            ->setParameters([
                'date' => $date->format('Y-m-d')
            ])
            ->setParameter('date', $date->format('Y-m-d'))
            ->orderBy('te.id', 'DESC')
        ;

        $result = $queryBuilder->getQuery()->getResult();

        try {
            return !isset($result[0]) ? null : $result[0] ;
        } catch (NoResultException $noResultException) {
            throw new \Exception($noResultException, TransparenciaExportacao::STATUS_FALHA_GERADO);
        }
    }

    /**
     * @return bool
     */
    public function removeLastTransparenciaExportacao()
    {
        $transparenciaExportacao = $this->getLastTransparenciaExportacao();

        if (is_null($transparenciaExportacao)) {
            return false;
        }

        $this->remove($transparenciaExportacao, true);

        return true;
    }
}
