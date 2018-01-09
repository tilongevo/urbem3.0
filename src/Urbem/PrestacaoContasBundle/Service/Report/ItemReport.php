<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Urbem\PrestacaoContasBundle\Model\ItemModel;
use Urbem\PrestacaoContasBundle\Model\EntidadesModel;

/**
 * Class ItemReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
class ItemReport extends AbstractReport
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

        $itens = [];
        if (count($entidades) > 0) {
            $itens = (new ItemModel($this->entityManager))
                ->getDadosExportacao($exercicio, $dataInicial, $dataFinal, $entidades);
        }

        return $this->selectColumnsToReport($itens, [
            'numero_empenho',
            'cod_entidade',
            'exercicio',
            'data',
            'numero_item',
            'descricao',
            'unidade',
            'quantidade',
            'valor',
            'sinal_valor',
            'complemento',
        ]);
    }
}
