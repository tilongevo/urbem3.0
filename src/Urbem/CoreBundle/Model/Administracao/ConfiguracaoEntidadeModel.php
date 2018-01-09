<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model;

class ConfiguracaoEntidadeModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\ConfiguracaoEntidade");
    }

    public function saveEntidade($info)
    {
        $configuracaoEntidade = new ConfiguracaoEntidade();
        $configuracaoEntidade->setExercicio($info['exercicio']);
        $configuracaoEntidade->setCodEntidade($info['entidade']);
        $configuracaoEntidade->setParametro($info['parametro']);
        $configuracaoEntidade->setValor($info['valor']);
        $configuracaoEntidade->setCodModulo($info['modulo']);

        return $configuracaoEntidade;
    }

    /**
     * @param array $info
     * @return array
     */
    public function getResponsaveis(array $info)
    {
        return $this->repository->findBy(
            [
                'exercicio' => $info['exercicio'],
                'parametro' => 'responsavel',
                'codModulo' => $info['codModulo']
            ]
        );
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param int $codModulo
     * @return array
     */
    public function getDataFixaCompraDireta($exercicio, $codEntidade, $codModulo = 35)
    {
        return $this->repository->findOneBy(
            [
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'parametro' => 'data_fixa_compra_direta',
                'codModulo' => $codModulo
            ]
        );
    }

    /**
     * @param array $entidades
     * @param $financialYear
     * @return array
     */
    public function getCodOrgaoForExportFile(array $entidades, $financialYear)
    {
        $qb = $this->repository->createQueryBuilder('a');
        $result = $qb->where('a.exercicio = :exercicio')
            ->andWhere('a.codEntidade IN (:entidades)')
            ->andWhere('a.parametro = :parametro')
            ->setParameter('exercicio', $financialYear)
            ->setParameter('entidades', $entidades)
            ->setParameter('parametro', 'tcemg_codigo_orgao_entidade_sicom')
            ->getQuery()
            ->getResult();

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $parametro
     * @param $codModulo
     *
     * @return null|object|ConfiguracaoEntidade
     */
    public function getCurrentConfig($exercicio, $codEntidade, $parametro, $codModulo)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'parametro' => $parametro,
            'codModulo' => $codModulo
        ]);
    }
}
