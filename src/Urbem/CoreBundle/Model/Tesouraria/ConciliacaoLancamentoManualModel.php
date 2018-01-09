<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ConciliacaoLancamentoManualModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\ConciliacaoLancamentoManual');
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     */
    public function deleteByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao)
    {
        $conciliacao = $this->repository->findOneBy([
            'codPlano' => $conciliacao->getFkConciliacaoPlanoBanco()->getCodPlano(),
            'exercicio' => $conciliacao->getFkConciliacaoPlanoBanco()->getExercicio(),
            'mes' => $conciliacao->getMes()
        ]);

        if(!is_null($conciliacao)){
            $delete = $this->entityManager->remove($conciliacao);

            $configuracaoModel = new Model\Administracao\ConfiguracaoModel($this->entityManager);
            $configuracao = $configuracaoModel->pegaConfiguracao('cod_uf', 2, $conciliacao->getCodPlano());

            /*
             *  Conforme linha 411 do arquivo RTesourariaConciliacao.class.php
             */

            if(isset($configuracao['valor']) && $configuracao['valor'] == 5){
                if($delete){
                    $cLContabilModel = new ConciliacaoLancamentoContabilModel($this->entityManager);
                    $cLContabilModel->deleteByConciliacao($conciliacao);
                }
            }
        }
    }

    /**
     * @param Entity\Tesouraria\Conciliacao $conciliacao
     * @param array $arMovimentacao
     */
    public function saveByConciliacao(Entity\Tesouraria\Conciliacao $conciliacao, array $arMovimentacao)
    {
        $conciliacao = new ConciliacaoLancamentoManual();
        $conciliacao->setFkConciliacaoLancamentoManualConciliacao($conciliacao);
        $conciliacao->setSequencia($arMovimentacao['sequencia']);
        $conciliacao->setDtLancamento($arMovimentacao['dt_lancamento']);
        $conciliacao->setTipoValor($arMovimentacao['tipo_valor']);
        $conciliacao->setVlLancamento($arMovimentacao['vl_lancamento']);
        $conciliacao->setDescricao($arMovimentacao['descricao']);
        $conciliacao->setConciliado(true);
        $conciliacao->setDtConciliacao($conciliacao->getDtExtrato());
        $this->save($conciliacao);
    }
}
