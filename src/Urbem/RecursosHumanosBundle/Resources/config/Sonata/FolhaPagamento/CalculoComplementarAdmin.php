<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\Complementar;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ContratoServidor;

class CalculoComplementarAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_complementar';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/calculo-complementar';
    protected $exibirMensagemFiltro = false;
    protected $exibirBotaoIncluir = false;

    const COD_FILTRAR_CGM_MATRICULA = 'cgm_contrato';
    const COD_FILTRAR_LOTACAO = 'lotacao';
    const COD_FILTRAR_GERAL = 'geral';

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere("1 = 0");
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/calculoComplementar.js',
        ]));

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $dtAtual = new \DateTime();

        $resOrganograma = (new OrganogramaModel($em))->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $lotacoes = (new OrgaoModel($em))->montaRecuperaOrgaos($dtAtual->format('Y-m-d'), $codOrganograma);

        $lotacaoOptions = array();
        foreach ($lotacoes as $lotacao) {
            $lotacaoOptions[$lotacao->cod_orgao] = sprintf('%s - %s', $lotacao->cod_estrutural, $lotacao->descricao);
        }

        $opcoes = [
            self::COD_FILTRAR_CGM_MATRICULA => 'label.recursosHumanos.contratoServidorComplementar.cgmmatricula',
            self::COD_FILTRAR_LOTACAO => 'label.recursosHumanos.contratoServidorComplementar.lotacao',
            self::COD_FILTRAR_GERAL => 'label.recursosHumanos.contratoServidorComplementar.geral'
        ];

        $datagridMapper
            ->add(
                'tipo',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.filtrar',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter']
                ],
                'choice',
                [
                    'choices' => array_flip($opcoes),
                    'expanded' => false,
                    'multiple' => false,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'required' => true,
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codContrato',
                'doctrine_orm_callback',
                [
                    'label' => 'label.matricula',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'autocomplete',
                [
                    'class' => Contrato::class,
                    'route' => [
                        'name' => 'carrega_contrato_decimo'
                    ],
                    'disabled' => true,
                    'multiple' => true,
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom ', 'required' => true]
                ]
            )
            ->add(
                'lotacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.lotacao',
                    'callback' => [$this, 'getSearchFilter'],
                    'required' => true
                ],
                'choice',
                [
                    'choices' => array_flip($lotacaoOptions),
                    'expanded' => false,
                    'multiple' => true,
                    'disabled' => true,
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom ', 'required' => true],
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        /** @var EntityManager $entityManager */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $folhaComplementarModel = new FolhaComplementarModel($em);
        $complementar = $folhaComplementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());

        if (is_null($complementar)) {
            $message = $this->getTranslator()->trans('rh.folhas.folhaComplementar.errors.calculoFolhaComplementarNaoAberta', [], 'validators');
            $this->getRequest()->getSession()->getFlashBag()->add("error", $message);
            $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_complementar_create');
        }

        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codContrato',
                null,
                [
                    'label' => 'label.codContrato',
                ]
            )
            ->add(
                'nomCgm',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                ]
            )
            ->add(
                'registro',
                null,
                [
                    'label' => 'label.matricula',
                ]
            );
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
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
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

        /** @var Complementar $complementar */
        $complementar = $entityManager->getRepository(Complementar::class)->findOneBy([
            'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao()
        ], ['codComplementar' => 'DESC']);

        if ($filter['tipo']['value'] == self::COD_FILTRAR_GERAL) {
            $result = $contratoModel->montaRecuperaContratosCalculoComplementar($periodoFinal->getCodPeriodoMovimentacao(), $complementar->getCodComplementar(), $filter['tipo']['value'], null);
        } elseif (($filter['tipo']['value'] == self::COD_FILTRAR_CGM_MATRICULA) && (isset($filter['codContrato']['value']))) {
            $result = $contratoModel->montaRecuperaContratosCalculoComplementar($periodoFinal->getCodPeriodoMovimentacao(), $complementar->getCodComplementar(), $filter['tipo']['value'], $filter['codContrato']['value']);
        } elseif (($filter['tipo']['value'] == self::COD_FILTRAR_LOTACAO) && (isset($filter['lotacao']['value']))) {
            $result = $contratoModel->montaRecuperaContratosCalculoComplementar($periodoFinal->getCodPeriodoMovimentacao(), $complementar->getCodComplementar(), $filter['tipo']['value'], $filter['lotacao']['value']);
        }

        $codContratos = array();
        foreach ($result as $contrato) {
            array_push(
                $codContratos,
                $contrato['cod_contrato']
            );
        }

        if (count($codContratos)) {
            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $codContratos)
            );
        } else {
            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere('1 = 0');
        }
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions['calcularComplementar'] = array(
            'label' => $this->trans('label.recursosHumanos.folhas.folhaComplementar.calcular', array(), 'CoreBundle'),
            'ask_confirmation' => true,
        );

        return $actions;
    }

    /**
     * @param Contrato $contrato
     *
     * @return string
     */
    public function getServidor($contrato)
    {
        if (is_null($contrato)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoServidor)) {
            return $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
                . " - "
                . $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        /** @var ContratoPensionista $contratoPensionista */
        $contratoPensionista = $entityManager->getRepository(ContratoPensionista::class)->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoPensionista)) {
            return $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getNumcgm()
                . " - "
                . $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        return '';
    }
}
