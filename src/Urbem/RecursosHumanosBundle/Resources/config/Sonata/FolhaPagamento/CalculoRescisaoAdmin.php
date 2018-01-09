<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;
use Urbem\RecursosHumanosBundle\RecursosHumanosBundle;

class CalculoRescisaoAdmin extends CalculoSalarioAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/calculo-rescisao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper, GeneralFilterAdmin::RECURSOSHUMANOS_FOLHA_REGISTRAREVENTORESCISAOCONTRATO);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.recursosHumanos.folhas.grid.matricula',
            'callback' => [$this, 'getSearchFilter'],
        ];
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
        $contrato->inCodConfiguracao = ContratoModel::FOLHA_COD_CONFIGURACAO_RESCISAO;
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper;
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
        /** @var ContratoModel $contratoModel */
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

        $paramsBo["boAtivos"] = false;
        $paramsBo["boAposentados"] = false;
        $paramsBo["boRescindidos"] = true;
        $paramsBo["boPensionistas"] = false;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_RESCISAO;

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
        if (isset($filter['matricula']['value'])) {
            $contratos = $filter['matricula']['value'];

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

        $queryBuilder->resetDQLPart('join');
        $queryBuilder->join(ContratoServidorPeriodo::class, 'periodo', 'with', "periodo.codContrato = {$alias}.codContrato");
        $queryBuilder->andWhere("periodo.codPeriodoMovimentacao = :periodoMovimentacao");
        $queryBuilder->setParameter('periodoMovimentacao', (int) $periodoFinal->getCodPeriodoMovimentacao());

        return true;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions['calcularRescisao'] = array(
            'label' => $this->trans('label.recursosHumanos.folhas.folhaRescisao.calcular', array(), 'CoreBundle'),
            'ask_confirmation' => true,
        );

        return $actions;
    }
}
