<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoOrgao;

class ConfiguracaoOrgaoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoOrgao::class);
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $tipoResponsavel
     * @param SwCgm $cgm
     * @return null|object|ConfiguracaoOrgao
     */
    public function getCurrentConfig($codEntidade, $exercicio, $tipoResponsavel, $numCgm)
    {
        return $this->repository->findOneBy([
            'codEntidade' => $codEntidade,
            'exercicio' => $exercicio,
            'tipoResponsavel' => $tipoResponsavel,
            'numCgm' => $numCgm
        ]);
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     */
    public function deleteByCodEntidadeAndExercicio($codEntidade, $exercicio)
    {
        $this->repository
            ->createQueryBuilder('configuracaoOrgao')
            ->delete(ConfiguracaoOrgao::class, 'configuracaoOrgao')
            ->andWhere('configuracaoOrgao.codEntidade = :codEntidade')
            ->andWhere('configuracaoOrgao.exercicio = :exercicio')
            ->setParameters([
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ])->getQuery()->execute();
    }

    /**
     * @param Entidade $entidade
     * @return array|ConfiguracaoOrgao
     */
    public function getByEntidade(Entidade $entidade)
    {
        return $this->repository->findBy([
            'codEntidade' => $entidade->getCodEntidade(),
            'exercicio' => $entidade->getExercicio(),
        ]);
    }
}
