<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Administracao\AcaoRepository;
use Urbem\CoreBundle\Entity\Administracao\Acao;

/**
 * Class AcaoModel
 * @package Urbem\CoreBundle\Model\Administracao
 */
class AcaoModel extends AbstractModel
{
    const FIELD_NOM_ACAO = 'nomAcao';
    const CALCULAR_DECIMO = 1667;
    const CALCULAR_SALARIO = 1369;
    const CALCULAR_FOLHA_COMPLEMENTAR = 1416;
    const CALCULAR_FERIAS = 1520;
    const CALCULAR_RESCISAO = 1683;
    const COBRAR_DIVIDA_ATIVA = 1648;

    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var AcaoRepository $repository
     */
    protected $repository = null;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Acao::class);
    }

    /**
     * @param string $nomAcao
     * @return Acao
     * @throws \Exception
     */
    public function findOrdemByNomAcao($nomAcao)
    {
        $filter = [self::FIELD_NOM_ACAO => $nomAcao];
        $result = $this->repository->findAcao($filter);
        if (empty($result)) {
            throw new \Exception(ERROR::VALUE_NOT_FOUND);
        }

        return array_shift($result);
    }
}
