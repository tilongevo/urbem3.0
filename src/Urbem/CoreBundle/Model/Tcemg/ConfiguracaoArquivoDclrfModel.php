<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoArquivoDclrf;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Tcemg\ConfiguracaoArquivoDclrfRepository;

/**
 * Class ConfiguracaoArquivoDclrfModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class ConfiguracaoArquivoDclrfModel extends AbstractModel
{
    const FIELD_MES_REFERENCIA = 'mesReferencia';

    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ConfiguracaoArquivoDclrfRepository $repository
     */
    protected $repository = null;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoArquivoDclrf::class);
    }

    /**
     * @param string $exercicio
     * @param null $mes
     * @return ConfiguracaoArquivoDclrf
     */
    public function findByExercicioAndMes($exercicio, $mes = null)
    {
        $configuracao = new ConfiguracaoArquivoDclrf();
        $filter = [self::FIELD_EXERCICIO => $exercicio];
        if ($mes) {
            $filter[self::FIELD_MES_REFERENCIA] = (int) $mes;
        }

        $qb = $this->repository->findConfiguracaoArquivoDclrf($filter);
        $result = $qb->getQuery()->getResult();
        if (empty($result)) {

            return $configuracao;
        }

        return array_shift($result);
    }
}
