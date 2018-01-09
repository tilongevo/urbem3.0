<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Model\InterfaceModel;

class UnidadeModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Unidade");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $licitacaoRepository = $this->entityManager->getRepository(Licitacao::class);
        $resultLicitacao = $licitacaoRepository->findBy([
            'numUnidade' => $object->getNumUnidade(),
            'exercicio' => $object->getExercicio()
        ]);
        $empenhoAnulado = $this->entityManager->getRepository(EmpenhoAnulado::class);
        if (count($object->getFkOrcamentoDespesas())) {
            foreach ($object->getFkOrcamentoDespesas() as $despesas) {
                $resultEmpenhoAnulado = $empenhoAnulado->findBy([
                    'codEntidade' => $despesas->getFkOrcamentoEntidade()->getCodEntidade(),
                ]);
            }
        }
        return (empty($resultLicitacao) && empty($resultEmpenhoAnulado));
    }

    /**
     * @param $numUnidade
     * @param $numOrgao
     * @param $exercicio
     * @return array
     */
    public function getUnidadesByNumUnidadeNumOrgao($numUnidade, $numOrgao, $exercicio)
    {
        $em = $this->entityManager;

        $qb = $em->getRepository('CoreBundle:Orcamento\Unidade')
            ->createQueryBuilder('u');
        $qb->innerJoin('CoreBundle:Orcamento\Orgao', 'o', 'WITH', 'u.numOrgao = o.numOrgao');
        $qb->where('u.numUnidade = :numUnidade');
        $qb->andWhere('o.numOrgao = :numOrgao');
        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameters([
            'numUnidade' => $numUnidade,
            'numOrgao' => $numOrgao,
            'exercicio' => $exercicio
        ]);

        $unidades = $qb->getQuery()->getResult();

        return $unidades;
    }

    /**
     * @param $numUnidade
     * @param $numOrgao
     * @param $exercicio
     * @return null|object|\Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getOneByUnidadeOrgaoExercicio($numUnidade, $numOrgao, $exercicio)
    {
        return  $this->entityManager->getRepository('CoreBundle:Orcamento\Unidade')->findOneBy(
            [
                'numUnidade' => $numUnidade,
                'numOrgao' => $numOrgao,
                'exercicio' => $exercicio
            ]
        );
    }

    /**
     * @param $params['numOrgao', 'exercicio' (, 'numUnidade')]
     * @return array de \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function findBy($params)
    {
        return $this->repository->findBy(
            $params
        );
    }
}
