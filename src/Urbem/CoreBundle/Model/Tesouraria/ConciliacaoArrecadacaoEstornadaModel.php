<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ConciliacaoArrecadacaoEstornadaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada');
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
                $cLContabilModel = new ConciliacaoLancamentoContabilModel($this->entityManager);
                $cLContabilModel->deleteByConciliacao($conciliacao);
            }
        }
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     * @param Entity\Tesouraria\Arrecadacao $arrecadacao
     * @param array $arMovimentacao
     * @return Entity\Tesouraria\Conciliacao|ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function saveByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao, Entity\Tesouraria\Arrecadacao $arrecadacao, array $arMovimentacao)
    {
        $conciliacao = new ConciliacaoLancamentoArrecadacaoEstornada();
        $conciliacao->setFkConciliacaoLancamentoArrecadacaoEstornadaArrecadacaoEstornada($arrecadacao);
        $conciliacao->setFkConciliacaoLancamentoArrecadacaoEstornadaConciliacao($conciliacao);
        $conciliacao->setTipo($arMovimentacao['tipo_arrecadacao']);
        $this->save($conciliacao);
        return $conciliacao;
    }
}
