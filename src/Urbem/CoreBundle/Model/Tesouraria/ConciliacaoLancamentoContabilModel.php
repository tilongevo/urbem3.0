<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ConciliacaoLancamentoContabilModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\ConciliacaoLancamentoContabil');
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     */
    public function deleteByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao)
    {
        $conciliacao = $this->repository->findOneBy([
            'codPlano' => $conciliacao->getFkConciliacaoPlanoBanco()->getCodPlano(),
            'exercicioConciliacao' => $conciliacao->getFkConciliacaoPlanoBanco()->getExercicio(),
            'exercicio' => $conciliacao->getFkConciliacaoPlanoBanco()->getExercicio(),
            'mes' => $conciliacao->getMes()
        ]);

        if(!is_null($conciliacao)){
            $delete = $this->entityManager->remove($conciliacao);

            if($delete){
                $cAEstornadaModel = new ConciliacaoLancamentoManualModel($this->entityManager);
                $cAEstornadaModel->deleteByConciliacao($conciliacao);
            }
        }
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     * @param Entity\Contabilidade\ValorLancamento $valorLancamento
     * @return ConciliacaoLancamentoContabil
     */
    public function saveByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao, Entity\Contabilidade\ValorLancamento $valorLancamento)
    {
        $this->deleteByConciliacao($conciliacao);
        $lancamentoContabil = new ConciliacaoLancamentoContabil();
        $lancamentoContabil->setFkConciliacaoLancamentoContabilConciliacao($conciliacao);
        $lancamentoContabil->setFkConciliacaoLancamentoContabilValorLancamento($valorLancamento);
        $this->save($lancamentoContabil);
        return $lancamentoContabil;
    }
}
