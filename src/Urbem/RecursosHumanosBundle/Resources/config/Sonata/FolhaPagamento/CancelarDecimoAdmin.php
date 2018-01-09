<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConcessaoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\CargoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class CancelarDecimoAdmin extends CalculoSalarioAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_cancelar_decimo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/cancelar-decimo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/concederDecimo.js',
        ]));

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($entityManager);
        /** @var OrgaoModel $orgaoModel */
        $orgaoModel = new OrgaoModel($entityManager);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        $formGridOptions = [];

        $opcoes = [
            'cgm' => 'cgm_contrato',
            'lotacao' => 'lotacao',
            'local' => 'local',
            'Regime/Subdivisão/Cargo/Especialidade' => 'reg_sub_car_esp_grupo',
            'geral' => 'geral'
        ];

        $formGridOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        $formGridOptions['tipoChoices'] = [
            'choices' => $opcoes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                $nomcgm = $this->getServidor($contrato);

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true
            ],
            'mapped' => false
        ];

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['lotacaoChoices'] = [
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true
            ],
        ];

        $formGridOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['localChoices'] = [
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true,
            ],
        ];

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $inMesCalculoDecimo = (int) $configuracaoModel->getConfiguracao(
            'mes_calculo_decimo',
            Modulo::MODULO_FOLHAPAGAMENTO,
            true
        );

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $inMesCompetencia = (int) $periodoFinal->getDtFinal()->format('m');

        $rsSituacaoFolha = $periodoMovimentacao->recuperaUltimaFolhaSituacao();
        $opcoesFolha = [];
        if ($rsSituacaoFolha["situacao"] == "f" || $inMesCompetencia >= $inMesCalculoDecimo) {
            $opcoesFolha[] = true;
        }

        $formGridOptions['folha'] = [
            'label' => 'label.recursosHumanos.folhas.grid.folhaCancelar13',
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        $formGridOptions['folhaChoices'] = [
            'choices' => [
                '13º Salário' => false,
                'Salário' => true
            ],
            'choice_attr' => function ($folha, $key, $index) use ($opcoesFolha) {
                if (count($opcoesFolha) > 0 && $index == $opcoesFolha[0]) {
                    return [
                        'disabled' => true
                    ];
                } else {
                    return [
                        'disabled' => false
                    ];
                }
            },
            'placeholder' => 'Selecione',
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];

        /** @var Regime $regimes */
        $regimes = $entityManager->getRepository(Regime::class)->findAll();
        $regimesArray = [];
        /** @var Regime $regime */
        foreach ($regimes as $regime) {
            $regimesArray[$regime->getCodRegime() . " - " . $regime->getDescricao()] = $regime->getCodRegime();
        }

        $formGridOptions['regime'] = [
            'callback' => [$this, 'getSearchFilter'],
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.regime',
            'mapped' => false,
        ];

        $formGridOptions['regimeChoices'] = [
            'choices' => $regimesArray,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true,
            ]
        ];

        /** @var SubDivisao $subDivisoes */
        $subDivisoes = $entityManager->getRepository(SubDivisao::class)->findAll();
        $subDivisoesArray = [];
        /** @var SubDivisao $subDivisao */
        foreach ($subDivisoes as $subDivisao) {
            $subDivisoesArray[$subDivisao->getCodSubDivisao() . " - " . $subDivisao->getDescricao()] = $subDivisao->getCodSubDivisao();
        }

        $formGridOptions['subdivisao'] = [
            'callback' => [$this, 'getSearchFilter'],
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.subdivisao',
            'mapped' => false,
        ];

        $formGridOptions['subdivisaoChoices'] = [
            'choices' => $subDivisoesArray,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true,
            ],
        ];

        /** @var CargoModel $cargoModel */
        $cargoModel = new CargoModel($entityManager);
        $cargos = $cargoModel->consultaCargoSubDivisoes(array_values($subDivisoesArray));

        $formGridOptions['cargo'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.cargo',
            'callback' => [$this, 'getSearchFilter'],
            'mapped' => false,
        ];

        $formGridOptions['cargoChoices'] = [
            'choices' => $cargos,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true,
            ],
        ];

        /** @var Especialidade $especialidades */
        $especialidades = $entityManager->getRepository(Especialidade::class)->findAll();
        $especialidadesArray = [];
        /** @var Especialidade $especialidade */
        foreach ($especialidades as $especialidade) {
            $especialidadesArray[$especialidade->getCodEspecialidade() . " - " . $especialidade->getDescricao()] = $especialidade->getCodEspecialidade();
        }

        $formGridOptions['especialidade'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.especialidade',
            'callback' => [$this, 'getSearchFilter'],
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
        ];

        $formGridOptions['especialidadeChoices'] = [
            'choices' => $especialidadesArray,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
                'required' => true,
            ]
        ];

        $datagridMapper
            ->add(
                'tipo',
                'doctrine_orm_callback',
                $formGridOptions['tipo'],
                'choice',
                $formGridOptions['tipoChoices']
            )
            ->add(
                'codContrato',
                'doctrine_orm_callback',
                $formGridOptions['fkPessoalContratoServidor'],
                'autocomplete',
                $formGridOptions['fkPessoalContratoServidorChoices']
            )->add(
                'lotacao',
                'doctrine_orm_callback',
                $formGridOptions['lotacao'],
                'choice',
                $formGridOptions['lotacaoChoices']
            )->add(
                'local',
                'doctrine_orm_callback',
                $formGridOptions['local'],
                'entity',
                $formGridOptions['localChoices']
            )->add(
                'regime',
                'doctrine_orm_callback',
                $formGridOptions['regime'],
                'choice',
                $formGridOptions['regimeChoices']
            )->add(
                'subdivisao',
                'doctrine_orm_callback',
                $formGridOptions['subdivisao'],
                'choice',
                $formGridOptions['subdivisaoChoices']
            )->add(
                'cargo',
                'doctrine_orm_callback',
                $formGridOptions['cargo'],
                'choice',
                $formGridOptions['cargoChoices']
            )->add(
                'especialidade',
                'doctrine_orm_callback',
                $formGridOptions['especialidade'],
                'choice',
                $formGridOptions['especialidadeChoices']
            )->add(
                'folha',
                'doctrine_orm_callback',
                $formGridOptions['folha'],
                'choice',
                $formGridOptions['folhaChoices']
            );
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
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($entityManager);

        $contratosErro = $this->getRequest()->get('contratosErro');
        $codContratos = $this->getRequest()->get('codContratos');

        $contratosErroArray = $contratoModel->listContratosByCodContratos($contratosErro);
        $contratosArray = $contratoModel->listContratosByCodContratos($codContratos);

        $contrato = $this->getSubject();
        $contrato->contratosErro = $contratosErroArray;
        $contrato->contratos = $contratosArray;

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
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($entityManager);
        /** @var ConcessaoDecimoModel $concessaoDecimoModel */
        $concessaoDecimoModel = new ConcessaoDecimoModel($entityManager);
        $contratos = [];
        $params['stConfiguracao'] = 'cgm,oo,f,ef,l';
        $params['entidade'] = '';
        $params['exercicio'] = $this->getExercicio();

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        if (empty($periodoUnico)) {
            $message = $this->getTranslator()->trans('recursosHumanos.folhaSituacao.errors.periodoMovimentacaoNaoAberto', [], 'validators');
            $this->getRequest()->getSession()->getFlashBag()->add("error", $message);
            $this->redirectByRoute('folha_pagamento_folhas_index');
        }

        $situacao = (isset($filter['folha']['value']) && $filter['folha']['value'] == 0) ? 'false' : 'true';

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $stFiltro  = " WHERE concessao_decimo.cod_periodo_movimentacao = ".$periodoFinal->getCodPeriodoMovimentacao();
        $stFiltro .= "   AND concessao_decimo.folha_salario IS ".$situacao;

        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO GERAL
        if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
            unset($filter['lotacao']['value']);
            unset($filter['codContrato']['value']);
            unset($filter['local']['value']);

            $params['stTipoFiltro'] = 'geral';
            $params['stValoresFiltro']  = '';

            $contratosList = $this->getContratos($params, $stFiltro, $concessaoDecimoModel);

            if (!empty($contratosList)) {
                foreach ($contratosList as $contrato) {
                    $contratoArray[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratoArray)
                );
                return true;
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }
            return true;
        }

        // FILTRO POR REGIME SUBDIVISAO CARGO E ESPECIALIDADE
        if ($filter['tipo']['value'] == 'reg_sub_car_esp_grupo') {
            $params['stTipoFiltro'] = 'reg_sub_fun_esp';
            $params['stValoresFiltro'] = (isset($filter['regime']['value'])) ? implode(",", $filter['regime']['value']) . "#" : "#";
            $params['stValoresFiltro'] .= (isset($filter['subdivisao']['value'])) ? implode(",", $filter['subdivisao']['value']) . "#" : "#";
            $params['stValoresFiltro'] .= (isset($filter['cargo']['value'])) ? implode(",", $filter['cargo']['value']) . "#" : "#";
            $params['stValoresFiltro'] .= (isset($filter['especialidade']['value'])) ? implode(",", $filter['especialidade']['value']) . "#" : "#";

            $contratosList = $this->getContratos($params, $stFiltro, $concessaoDecimoModel);

            if (!empty($contratosList)) {
                foreach ($contratosList as $contrato) {
                    $contratoArray[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratoArray)
                );
                return true;
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }

            return true;
        }

        // FILTRO POR LOTAÇÃO
        if ($filter['tipo']['value'] == 'lotacao') {
            if (isset($filter['lotacao']['value'])) {
                $lotacao = implode(",", $filter['lotacao']['value']);
            } else {

                /** @var OrganogramaModel $organogramaModel */
                $organogramaModel = new OrganogramaModel($entityManager);
                /** @var OrgaoModel $orgaoModel */
                $orgaoModel = new OrgaoModel($entityManager);

                $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
                $codOrganograma = $resOrganograma['cod_organograma'];
                $dataFinal = $resOrganograma['dt_final'];
                $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

                $lotacaoArray = [];
                foreach ($lotacoes as $lotacao) {
                    $key = $lotacao->cod_orgao;
                    $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
                    $lotacaoArray[$value] = $key;
                }
                $lotacao = implode(",", $lotacaoArray);
            }

            $params['stTipoFiltro'] = 'lotacao';
            $params['stValoresFiltro']  = $lotacao;

            $contratosList = $this->getContratos($params, $stFiltro, $concessaoDecimoModel);

            if (!empty($contratosList)) {
                foreach ($contratosList as $contrato) {
                    $contratoArray[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratoArray)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }

            return true;
        }

        // FILTRO POR LOCAL
        if ($filter['tipo']['value'] == 'local') {
            if (isset($filter['local']['value'])) {
                $local = implode(",", $filter['local']['value']);
            } else {
                /** @var Local $locais */
                $locais = $entityManager->getRepository(Local::class)->findAll();
                foreach ($locais as $local) {
                    $localArray[] = $local->getCodLocal();
                }
                $local = implode(",", $localArray);
            }

            $params['stTipoFiltro'] = 'local';
            $params['stValoresFiltro']  = $local;

            $contratosList = $this->getContratos($params, $stFiltro, $concessaoDecimoModel);

            if (!empty($contratosList)) {
                foreach ($contratosList as $contrato) {
                    $contratoArray[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratoArray)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }
            return true;
        }

        // FILTRO POR MATRICULA
        if ($filter['tipo']['value'] == 'cgm_contrato') {
            if (!empty($filter['codContrato']['value'])) {
                $contratos = $filter['codContrato']['value'];
            } else {
                $contratoLista = $concessaoDecimoModel->montaRecuperaContratosConcessaoDecimo($periodoFinal->getCodPeriodoMovimentacao());

                $contratos = array();

                foreach ($contratoLista as $contrato) {
                    array_push(
                        $contratos,
                        $contrato['cod_contrato']
                    );
                }
            }
            $params['stTipoFiltro'] = 'contrato';
            $params['stValoresFiltro'] = implode(",", $contratos);

            $contratosList = $this->getContratos($params, $stFiltro, $concessaoDecimoModel);

            if (!empty($contratosList)) {
                foreach ($contratosList as $contrato) {
                    $contratoArray[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratoArray)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }

            return true;
        }
    }

    /**
     * @param $params
     * @param $stFiltro
     * @param ConcessaoDecimoModel $concessaoDecimoModel
     *
     * @return array
     */
    public function getContratos($params, $stFiltro, $concessaoDecimoModel)
    {
        $arContratos1 = $concessaoDecimoModel->recuperaContratosParaCancelar($params, $stFiltro);
        $arContratos2 = $concessaoDecimoModel->recuperaContratosParaCancelarPensionista($params, $stFiltro);
        $contratosList = [];
        switch (true) {
            case $arContratos1 != 0 and $arContratos2 != 0:
                $contratosList = array_merge($arContratos1, $arContratos2);
                break;
            case $arContratos1 != 0 and $arContratos2 == 0:
                $contratosList = array_merge($arContratos1);
                break;
            case $arContratos1 == 0 and $arContratos2 != 0:
                $contratosList = array_merge($arContratos2);
                break;
        }

        return $contratosList;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions['cancelarDecimo'] = [
            'label' => $this->trans('label.recursosHumanos.folhas.folhaDecimo.cancelar', [], 'CoreBundle'),
            'ask_confirmation' => true
        ];

        return $actions;
    }
}
