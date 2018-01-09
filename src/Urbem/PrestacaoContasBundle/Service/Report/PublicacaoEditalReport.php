<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;
use Urbem\PrestacaoContasBundle\Model\PublicacaoEditalModel;

/**
 * Class PublicacaoEditalReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class PublicacaoEditalReport extends AbstractReport
{
    /**
     * {@inheritdoc}
     */
    public function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $entidadesModel = new EntidadesModel($this->entityManager);
        $entidades = $entidadesModel->getEntidades($exercicio);
        $entidades = array_map(function (array $entidade) {
            return $entidade['cod_entidade'];
        }, $entidades);

        $publicacoesEdital = [];
        if (count($entidades) > 0) {
            $publicacoesEdital = (new PublicacaoEditalModel($this->entityManager))
                ->getDadosExportacao($exercicio, $entidades, $dataInicial, $dataFinal);
        }

        return $this->selectColumnsToReport($publicacoesEdital, [
            'exercicio_edital',
            'num_edital',
            'exercicio_licitacao',
            'cod_licitacao',
            'cod_entidade',
            'modalidade',
            'veiculo_publicacao',
            'data_publicacao',
            'observacao',
        ]);
    }
}
