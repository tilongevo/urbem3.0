<?php

namespace Urbem\PrestacaoContasBundle\Service\SAGRES\Type;

use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\PrestacaoContasBundle\Helper\ExportAdjustmentHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;

class SAGRESFolhaPagamentoType extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_PERIODO_MOVIMENTACAO_NAME = 'codpermov';
    const COD_PERIODO_MOVIMENTACAO_LABEL = 'cod_periodo_movimentacao';

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParametersCollection();

        $exercicio = $this->factory->getSession()->getExercicio();

        ExportAdjustmentHelper::setFinancialYear($params, $exercicio);
        ExportAdjustmentHelper::setFirstDayAndLastDayMonth($params, $exercicio);

        $this->setCodPeriodoMovimentacao($params);

        $this->processInformationByData($params, parent::PROCESS_ENTIDADE);
        $this->processInformationByData($params, parent::PROCESS_FILES);
        $this->processInformationByData($params, parent::PROCESS_MONTH);

        return $params->exportDataAndValueToArray();
    }

    /**
     * @param DataCollection $params
     * @return DataCollection
     */
    protected function setCodPeriodoMovimentacao(DataCollection $params)
    {
        /** @var DataView $initialDateDataView */
        $initialDateDataView = $params->findObjectByName(FieldsAndData::INITIAL_DATE_NAME);

        /** @var DataView $finalDateDataView */
        $finalDateDataView = $params->findObjectByName(FieldsAndData::FINAL_DATE_NAME);

        $initialDate = \DateTime::createFromFormat('d/m/Y', $initialDateDataView->getValue());
        $finalDate = \DateTime::createFromFormat('d/m/Y', $finalDateDataView->getValue());

        $periodoMovimentacao = $this->getPeriodoMovimentacaoModel()->findCodPeriodoByInitialAndFinalDate($initialDate, $finalDate);

        $periodoMovimentacaoDateView = new DataView();
        $periodoMovimentacaoDateView->setName(self::COD_PERIODO_MOVIMENTACAO_NAME);
        $periodoMovimentacaoDateView->setValue($periodoMovimentacao->getCodPeriodoMovimentacao());
        $periodoMovimentacaoDateView->setLabel(self::COD_PERIODO_MOVIMENTACAO_LABEL);
        $periodoMovimentacaoDateView->setText($periodoMovimentacao->getCodPeriodoMovimentacao());

        $params->add($periodoMovimentacaoDateView);

        return $params;
    }

    /**
     * @return PeriodoMovimentacaoModel
     */
    private function getPeriodoMovimentacaoModel()
    {
        return new PeriodoMovimentacaoModel($this->factory->getEntityManager());
    }
}