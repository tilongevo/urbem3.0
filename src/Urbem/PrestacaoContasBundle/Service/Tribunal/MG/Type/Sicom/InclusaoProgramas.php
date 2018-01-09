<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Type\Sicom;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Administracao\AcaoModel;
use Urbem\PrestacaoContasBundle\Enum\FieldsAndData;
use Urbem\PrestacaoContasBundle\Helper\ExportAdjustmentHelper;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataView;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\Entity\BI\DataCollection;

/**
 * Class InclusaoProgramas
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Type\Sicom
 */
class InclusaoProgramas extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const NOM_ACAO = 'Inclusão de Programas';

    const ORGAO_INCAMP_NAME = 'orgao_incamp';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return parent::dynamicBlockJs();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function processParameters()
    {
        try {
            $params = parent::processParametersCollection();

            $exercicio = $this->factory->getSession()->getExercicio();

            ExportAdjustmentHelper::setFinancialYear($params, $exercicio);
            ExportAdjustmentHelper::setFirstDayAndLastDayMonth($params, $exercicio);

            $this->processInformationByData($params, parent::PROCESS_ENTIDADE);
            $this->processInformationByData($params, parent::PROCESS_FILES);
            $this->processInformationByData($params, parent::PROCESS_MONTH);

            $this->setOrgao($params, $exercicio);
            $this->setOrgaoIncamp($params);

            return $params->exportDataAndValueToArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        return [
            'response' => true
        ];
    }

    /**
     * @param DataCollection $params
     * @return DataCollection
     */
    private function setOrgaoIncamp(DataCollection $params)
    {
        $ordem = $this->getAcaoModel()->findOrdemByNomAcao(self::NOM_ACAO);

        $orgaoIncamp = new DataView();
        $orgaoIncamp->setName(self::ORGAO_INCAMP_NAME);
        $orgaoIncamp->setValue($ordem->getOrdem());
        $orgaoIncamp->setLabel($orgaoIncamp->getName());
        $orgaoIncamp->setText($ordem->getOrdem());
        $params->add($orgaoIncamp);

        return $params;
    }

    /**
     * @param DataCollection $params
     * @param $financialYear
     * @return DataCollection
     */
    private function setOrgao(DataCollection $params, $financialYear)
    {
        $orgao = implode(',', $this->getOrgao($params, $financialYear));
        $orgaoDataView = new DataView();
        $orgaoDataView->setName(FieldsAndData::GOVERNMENT_AGENCY_NAME);
        $orgaoDataView->setValue($orgao);
        $orgaoDataView->setLabel($orgaoDataView->getName());
        $orgaoDataView->setText($orgao);
        $params->add($orgaoDataView);

        return $params;
    }

    /**
     * @param DataCollection $params
     * @param $financialYear
     * @return array
     */
    private function getOrgao(DataCollection $params, $financialYear)
    {
        $entidadeArray = $this->getEntidadeArray($params);
        $result = $this->getConfiguracaoEntidadeModel()->getCodOrgaoForExportFile($entidadeArray, $financialYear);
        $orgao = [];

        /** @var \Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade $item */
        foreach ($result as $item) {
            $orgao[] = $item->getValor();
       }

       return $orgao;
    }

    /**
     * @param DataCollection $params
     * @return array
     */
    private function getEntidadeArray(DataCollection $params)
    {
        $entidadeDataView = $params->findObjectByName(FieldsAndData::ENTIDADE_NAME);

        return explode(',', $entidadeDataView->getValue());
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        parent::view($formMapper, $objectAdmin);
    }

    /**
     * @return ConfiguracaoEntidadeModel
     */
    protected function getConfiguracaoEntidadeModel()
    {
        return new ConfiguracaoEntidadeModel($this->factory->getEntityManager());
    }

    /**
     * @return AcaoModel
     */
    protected function getAcaoModel()
    {
        return new AcaoModel($this->factory->getEntityManager());
    }
}