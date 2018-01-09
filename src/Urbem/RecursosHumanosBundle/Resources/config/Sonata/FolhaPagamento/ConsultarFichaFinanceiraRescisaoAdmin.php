<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class ConsultarFichaFinanceiraRescisaoAdmin extends ConsultarFichaFinanceiraAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/consulta-ficha-financeira-rescisao';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/dataGridConsultaFichaFinanceiraRescisao.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $formGridOptions['tipoCalculo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipoCalculo',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],

        ];

        $defaultValue = 4;

        $formGridOptions['tipoCalculoChoices'] = [
            'choices' => [
                "Salário" => "1",
                "Férias" => "2",
                "13 Salário" => "3",
                "Rescisão" => "4",
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione',
            'choice_attr' => function ($tipoCalculo, $key, $index) use ($defaultValue) {
                if ($index == $defaultValue) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            },
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];


        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper->remove('tipoCalculo');

        $datagridMapper->add('tipoCalculo', 'doctrine_orm_callback', $formGridOptions['tipoCalculo'], 'choice', $formGridOptions['tipoCalculoChoices']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        parent::configureListFields($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codContrato')
            ->add('registro')
        ;
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

        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);

        $mes = $filter['competenciaMeses']['value'];
        $ano = $filter['competenciaAno']['value'];

        $mes = ((int) $mes < 10) ? "0" . (int) $mes : $mes;
        $dtCompetencia = $mes . "/" . $ano;
        $stFiltro = " AND to_char(dt_final, 'mm/yyyy') = '" . $dtCompetencia . "'";
        $rsPeriodoMovimentacao = $periodoMovimentacao->recuperaPeriodoMovimentacaoDaCompetencia($stFiltro);

        $codPeriodoMovimentacao = $rsPeriodoMovimentacao['cod_periodo_movimentacao'];

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = "R";

        $contratos = ['-1'];
        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO POR MATRICULA
        if ($filter['codContrato']['value']) {
            $contratos[] = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        // FILTRO POR EVENTO
        if (!empty($filter['evento']['value'])) {
            $eventos[] = $filter['evento']['value'];

            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $codPeriodoMovimentacao,
                '',
                [],
                [],
                $eventos
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

        if (!empty($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('join');

            $queryBuilder->innerJoin("{$queryBuilder->getRootAliases()[0]}.fkFolhapagamentoContratoServidorPeriodos", "cs");
            $queryBuilder->andWhere("cs.codPeriodoMovimentacao = {$codPeriodoMovimentacao}");
        }

        return true;
    }
}
