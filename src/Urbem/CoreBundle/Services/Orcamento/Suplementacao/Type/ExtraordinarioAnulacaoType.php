<?php

namespace Urbem\CoreBundle\Services\Orcamento\Suplementacao\Type;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\SuplementacaoModel;
use Urbem\CoreBundle\Services\Orcamento\Suplementacao\Lancamento;

class ExtraordinarioAnulacaoType extends LancamentoType
{
    public function execute(Lancamento $lancamento)
    {
        try {
            $empenhoModel = new EmpenhoModel($lancamento->entityManager);
            $codLote = $empenhoModel->fnInsereLote(
                $lancamento->getExercicio(),
                $lancamento->getEntidade(),
                'S',
                $lancamento->getDescricaoDecreto(),
                date('d/m/Y')
            );

            $lancamento->setCodLote($codLote);

            $tipo = 'Extraordinario';

            $suplementacaoModel = new SuplementacaoModel($lancamento->entityManager);
            $sequencia = $suplementacaoModel->orcamentoAnulacaoSuplementacoesCreditoExtraordinario(
                $lancamento->getExercicio(),
                $lancamento->getValor(),
                $lancamento->getDescricaoDecreto(),
                $codLote,
                'S',
                $lancamento->getEntidade(),
                $tipo
            );

            $lancamento->setSequencia($sequencia);

            return true;
        } catch (ForeignKeyConstraintViolationException $e) {
            $lancamento->entityManager->getConnection()->rollback();
            $lancamento->session->getFlashBag()->add('error', 'Erro ao gerar lançamentos de suplementação');
        }
    }
}
