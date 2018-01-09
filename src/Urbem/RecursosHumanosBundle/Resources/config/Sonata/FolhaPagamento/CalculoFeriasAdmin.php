<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Administracao\AcaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class CalculoFeriasAdmin extends CalculoSalarioAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_ferias';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/calculo-ferias';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codContrato')
            ->add('registro');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
        /** @var Contrato $contrato */
        $contrato = $this->getSubject();
        $contrato->inCodConfiguracao = ContratoModel::FOLHA_COD_CONFIGURACAO_FERIAS;
        $contrato->inCodAcao = AcaoModel::CALCULAR_FERIAS;
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('codContrato')
            ->add('registro');
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $contratoModel = new ContratoModel($entityManager);

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = true;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_FERIAS;

        $contratos = ['-1'];
        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO POR LOTAÇÃO
        if (isset($filter['lotacao']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                $filter['lotacao']['value'],
                []
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        // FILTRO POR LOCAL
        if (isset($filter['local']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                $filter['local']['value'],
                [],
                []
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        // FILTRO POR MATRICULA
        if (!empty($filter['codContrato']['value'])) {
            $contratos = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        // FILTRO POR EVENTO
        if (!empty($filter['evento']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                [],
                $filter['evento']['value']
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        return true;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions['calcularFerias'] = array(
            'label' => $this->trans('label.recursosHumanos.folhas.folhaFerias.calcular', array(), 'CoreBundle'),
            'ask_confirmation' => true,
        );

        return $actions;
    }
}
