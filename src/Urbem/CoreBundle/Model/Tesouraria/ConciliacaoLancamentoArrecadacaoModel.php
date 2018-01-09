<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ConciliacaoLancamentoArrecadacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\ConciliacaoLancamentoArrecadacao');
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     */
    public function deleteByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao)
    {
        $conciliacaoArrecadacao = $this->repository->findOneBy([
            'codPlano' => $conciliacao->getFkConciliacaoPlanoBanco()->getCodPlano(),
            'exercicioConciliacao' => $conciliacao->getFkConciliacaoPlanoBanco()->getExercicio(),
            'mes' => $conciliacao->getMes()
        ]);

        if(!is_null($conciliacao)){
            $delete = $this->entityManager->remove($conciliacao);

            if($delete){
                $cAEstornadaModel = new ConciliacaoArrecadacaoEstornadaModel($this->entityManager);
                $cAEstornadaModel->deleteByConciliacao($conciliacao);
            }
        }
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     * @param Entity\Tesouraria\Arrecadacao $arrecadacao
     * @param array $arMovimentacao
     * @return Entity\Tesouraria\Conciliacao|ConciliacaoLancamentoArrecadacao
     */
    public function saveByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao, Entity\Tesouraria\Arrecadacao $arrecadacao, array $arMovimentacao)
    {
        $conciliacao = new ConciliacaoLancamentoArrecadacao();
        $conciliacao->setFkConciliacaoLancamentoArrecadacaoConciliacao($conciliacao);
        $conciliacao->setFkConciliacaoLancamentoArrecadacaoArrecadacao($arrecadacao);
        $conciliacao->setTipo($arMovimentacao['tipo_arrecadacao']);
        $this->save($conciliacao);
        return $conciliacao;
    }
}
