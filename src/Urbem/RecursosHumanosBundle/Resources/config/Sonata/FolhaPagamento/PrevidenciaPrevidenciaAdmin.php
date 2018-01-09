<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\FaixaDesconto;
use Urbem\CoreBundle\Entity\Folhapagamento\Previdencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat;
use Urbem\CoreBundle\Helper\NumberHelper;
use Urbem\CoreBundle\Model\Folhapagamento\FaixaDescontoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaPrevidenciaModel;

class PrevidenciaPrevidenciaAdmin extends AbstractSonataAdmin
{
    const RGPS_VALUE = 1;
    const ALIQUOTA_FAP_LIMIT_MIN = 0.5000;
    const ALIQUOTA_FAP_LIMIT_MAX = 2.0000;
    const ALIQUOTA_RAT_LIMIT = '1,2,3';
    const ALIQUOTA_LIMIT = 999;
    const PERCENTUAL_DESCONTO = 1000;

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_previdencia_previdencia';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/previdencia-previdencia';

    protected $includeJs = array(
        '/recursoshumanos/javascripts/folhapagamento/previdencia/previdencia-previdencia.js'
    );

    protected $model = PrevidenciaPrevidenciaModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao', null, ['label' => 'Descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('descricao', null, ['label' => 'Descricao'])
            ->add('aliquota', null, ['label' => 'Alíquota'])
            ->add('choiceTipoPrevidenciaValue', 'trans', ['label' => 'Tipo'])
            ->add('vigencia', null, ['label' => 'Vigência'])
        ;
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $percentDataRat = 0;
        $percentDataFap = 0;

        $previdenciaEventos = [];

        if (!is_null($id)) {
            /** @var PrevidenciaPrevidencia $previdenciaPrevidencia */
            $previdenciaPrevidencia = $this->getSubject();
            $em = $this->getDoctrine();

            /** @var PrevidenciaRegimeRat $regimePrevidencia */
            $regimePrevidencia = $previdenciaPrevidencia->getFkFolhapagamentoPrevidenciaRegimeRat();

            if ($regimePrevidencia) {
                $percentDataRat = $regimePrevidencia->getAliquotaRat();
                $percentDataFap = $regimePrevidencia->getAliquotaFap();
            }

            //PrevidenciaEvento
            $listaPrevidenciaEventos = $previdenciaPrevidencia->getFkFolhapagamentoPrevidenciaEventos();

            if (count($listaPrevidenciaEventos)) {
                $previdenciaEventos = [];
                foreach ($listaPrevidenciaEventos as $previdenciaEvento) {
                    /** @var PrevidenciaEvento $previdenciaEvento */
                    $previdenciaEventos[$previdenciaEvento->getCodTipo()] =
                        $em->getRepository(Evento::class)->findOneBy([
                                'codEvento' => $previdenciaEvento->getCodEvento()
                        ])
                    ;
                }
            }
        }

        $formMapper
            ->with('DadosPrevidencia')
           ->add(
               'descricao',
               null,
               [
                   'label' => 'label.descricao',
                   'required' => 'true'
               ]
           )
           ->add(
               'aliquota',
               'number',
               [
                   'label' => 'label.folhapagamento.previdenciaPrevidencia.aliquota',
                   'required' => 'true',
                   'attr' => [
                       'class' => 'percent '
                   ],
               ]
           )
           ->add(
               'tipoPrevidencia',
               'choice',
               [
                   'choices' => [
                       'label.previdenciaTipoOficial' => 'o',
                       'label.previdenciaTipoPrivada' => 'p',
                   ],
                   'label' => 'label.folhapagamento.previdenciaPrevidencia.tipoPrevidencia',
                   'required' => 'true',
                   'attr' => [
                       'class' => 'select2-parameters'
                   ],
                   'placeholder' => 'label.selecione'
               ]
           )
           ->add(
               'fkFolhapagamentoPrevidencia',
               'sonata_type_admin',
               [
                    'label' => false
                ],
               [
                    'admin_code' => 'recursos_humanos.admin.previdencia'
                ]
           )
           ->end()
            ->with('Vigencia')
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'nullable' => false
                ],
                [
                    'label' => 'label.vigencia'
                ]
            )
            ->end()
           ->with(
               'Aliquota',
               [
                   'class' => 'aliquota-group'
               ]
           )
           ->add(
               'aliquota_rat',
               'number',
               [
                    'data' => $percentDataRat,
                    'mapped' => false,
                    'label' => 'Aliquiota RAT (%)',
                    'attr' => [
                        'class' => 'percent '
                    ],
                ],
               []
           )
           ->add(
               'aliquota_fap',
               'number',
               [
                    'data' => $percentDataFap,
                    'mapped' => false,
                    'label' => 'Aliquiota FAP (%)',
                    'attr' => [
                        'class' => 'percent '
                    ],
                ],
               []
           )
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'class' => 'mergin-help ',
                    ],
                ],
                ['label' => 'Vigência']
            )
           ->end()
           ->with('label.folhapagamento.previdenciaPrevidencia.eventoDesconto')
            ->add(
                'cod_evento_d_cod',
                'hidden',
                [
                    'mapped' => false,
                    'required' => true,
                    'data' => array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO, $previdenciaEventos)
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO]->getCodEvento()
                        : '',
                ]
            )
            ->add(
                'cod_evento_d',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.codEvento',
                    'attr' => ['size' => '2', 'class'=>'codEvento '],
                    'required' => 'true',
                    'data' => (array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO, $previdenciaEventos))
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO]->getCodigo()
                        : '',
                ],
                []
            )
            ->add(
                'desc_evento_d',
                'text',
                [
                    'data' => (array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO, $previdenciaEventos))
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_DESCONTO]->getDescricao()
                        : '',
                    'mapped' => false,
                    'label' => 'label.descricao',
                    'attr' => [
                        'data-next' => 'button_d',
                        'readonly' => true,
                    ],
                ],
                []
            )
           ->end()
           ->with('label.folhapagamento.previdenciaPrevidencia.eventoBase')
            ->add(
                'cod_evento_b_cod',
                'hidden',
                [
                    'mapped' => false,
                    'required' => true,
                    'data' => (array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE, $previdenciaEventos))
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE]->getCodEvento()
                        : '',
                ]
            )
            ->add(
                'cod_evento_b',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.codEvento',
                    'attr' => ['size' => '2', 'class'=>'codEvento '],
                    'required' => 'true',
                    'data' => (array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE, $previdenciaEventos))
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE]->getCodigo()
                        : '',
                ],
                []
            )
            ->add(
                'desc_evento_b',
                'text',
                [
                    'data' => (array_key_exists(PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE, $previdenciaEventos))
                        ? $previdenciaEventos[PrevidenciaPrevidenciaModel::EVENTO_TIPO_BASE]->getDescricao()
                        : '',
                    'mapped' => false,
                    'label' => 'label.descricao',
                    'attr' => [
                        'data-next' => 'button_b',
                        'readonly' => true,
                    ],
                ],
                []
            )
           ->end()
           ->with('label.folhapagamento.faixaDeDesconto.faixaDesconto')
           ->add(
               'fkFolhapagamentoFaixaDescontos',
               'sonata_type_collection',
               [
                    'by_reference' => false,
                    'label' => false
                ],
               [
                    'edit' => 'inline',
                    'inline' => 'table',
                ]
           )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('descricao', null, ['label' => 'Descricao'])
            ->add('aliquota', null, ['label' => 'Alíquota'])
            ->add('choiceTipoPrevidenciaValue', 'trans', ['label' => 'Tipo'])
            ->add('codPrevidencia.codPrevidencia.codRegimePrevidencia', null, ['label' => 'Regime Previdenciário'])
            ->add('vigencia', null, ['label' => 'Vigência'])
            ->add('codPrevidenciaFaixa', null, ['label' => 'Faixa de desconto'])
        ;
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    private function saveAliquota($previdenciaPrevidencia)
    {
        // save aliquota?
        if (! $this->getForm()->get('fkFolhapagamentoPrevidencia')->getData()) {
            return ;
        }

        $tipoAliquota = $this->getForm()
            ->get('fkFolhapagamentoPrevidencia')
            ->getData()
            ->getCodRegimePrevidencia()
        ;

        if (self::RGPS_VALUE != $tipoAliquota) { // must be RGPS
            return;
        }

        $model = new PrevidenciaPrevidenciaModel($this->getDoctrine());

        $model->saveAliquota($previdenciaPrevidencia, $this->getForm(), $this->getAdminRequestId());
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    public function prePersist($previdenciaPrevidencia)
    {
        $nextPrevidenciaCode = $this->getDoctrine()
            ->getRepository(Previdencia::class)
            ->getNextPrevidenciaCode();
        $previdenciaPrevidencia->setCodPrevidencia($nextPrevidenciaCode);

        $previdenciaPrevidencia->setAliquota(
            NumberHelper::floatToDatabase($this->getForm()->get('aliquota')->getData())
        );

        $previdenciaPrevidencia->getFkFolhapagamentoPrevidencia()
            ->setCodPrevidencia($nextPrevidenciaCode);

        foreach ($previdenciaPrevidencia->getFkFolhapagamentoFaixaDescontos() as $faixaDesconto) {
            $previdenciaPrevidencia->removeFkFolhapagamentoFaixaDesconto($faixaDesconto);
        }

        $this->saveRelationships($previdenciaPrevidencia);
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    private function saveEvents($previdenciaPrevidencia)
    {
        $model = new PrevidenciaPrevidenciaModel($this->getDoctrine());
        $model->saveEvents($previdenciaPrevidencia, $this->getForm(), $this->getAdminRequestId());
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    public function postPersist($previdenciaPrevidencia)
    {
        $em = $this->getDoctrine();
        $model = new FaixaDescontoModel($em);

        $faixaDescontos = $this->getForm()->get('fkFolhapagamentoFaixaDescontos')->getData()->toArray();

        /** @var FaixaDesconto $faixaDesconto */
        foreach ($faixaDescontos as $faixaDesconto) {
            if (null === $faixaDesconto->getCodFaixa()) {
                $faixaDesconto->setCodFaixa(
                    $model->getNextFaixaDescontoCode()
                );
                $em->persist($faixaDesconto);
                $em->flush();
            }
        }

        $this->saveAliquota($previdenciaPrevidencia);
        $this->saveEvents($previdenciaPrevidencia);
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    public function preUpdate($previdenciaPrevidencia)
    {
        $em = $this->getDoctrine();
        foreach ($this->getForm()->get('fkFolhapagamentoFaixaDescontos') as $faixaDescontoForm) {
            if ($faixaDescontoForm->get('_delete')->getData()) {
                $previdenciaPrevidencia->removeFkFolhapagamentoFaixaDesconto($faixaDescontoForm->getData());
            }
        }
        $model = new FaixaDescontoModel($em);
        /** @var FaixaDesconto $faixaDesconto */
        $nextCodFaixaDesconto = $model->getNextFaixaDescontoCode();
        foreach ($previdenciaPrevidencia->getFkFolhapagamentoFaixaDescontos() as $faixaDesconto) {
            if (null === $faixaDesconto->getCodFaixa()) {
                $faixaDesconto->setCodFaixa($nextCodFaixaDesconto);
                $nextCodFaixaDesconto++;
            }
        }
        $this->saveAliquota($previdenciaPrevidencia);
        $this->saveEvents($previdenciaPrevidencia);
    }

    /**
     * @param PrevidenciaPrevidencia $previdenciaPrevidencia
     */
    public function saveRelationships($previdenciaPrevidencia)
    {
        $this->checkSelectedDeleteInListCollecion(
            $previdenciaPrevidencia,
            'fkFolhapagamentoFaixaDescontos',
            'setCodPrevidencia'
        );
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $previdenciaPrevidencia)
    {
        /** @var PrevidenciaPrevidencia $previdenciaPrevidencia */
        $faixasDesconto = $previdenciaPrevidencia->getFkFolhapagamentoFaixaDescontos();

        if ($previdenciaPrevidencia->getAliquota() > self::ALIQUOTA_LIMIT) {
            $error = $this->translate("errors.rh.folhapagamento.previdenciaPrevidenciaAliquotaAlta");
            $errorElement->with('codPrevidenciaFaixa.0.percentualDesconto')->addViolation($error)->end();
        }

        if ($previdenciaPrevidencia->getFkFolhapagamentoPrevidencia()->getCodRegimePrevidencia() == self::RGPS_VALUE) {
            $form = $this->getForm();
            $aliquotaRat = NumberHelper::floatToDatabase($form->get('aliquota_rat')->getData());
            $aliquotaFap = NumberHelper::floatToDatabase($form->get('aliquota_fap')->getData());

            if (!in_array($aliquotaRat, explode(',', self::ALIQUOTA_RAT_LIMIT))) {
                $error = $this->translate("errors.rh.folhapagamento.previdenciaRegimeRat.aliquotaRatForaDoLimite");
                $errorElement->with('codPrevidenciaFaixa.0.percentualDesconto')->addViolation($error)->end();
            }

            if ($aliquotaFap < self::ALIQUOTA_FAP_LIMIT_MIN || $aliquotaFap > self::ALIQUOTA_FAP_LIMIT_MAX) {
                $error = $this->translate("errors.rh.folhapagamento.previdenciaRegimeRat.aliquotaFapForaDoLimite");
                $errorElement->with('codPrevidenciaFaixa.0.percentualDesconto')->addViolation($error)->end();
            }
        }

        if ($faixasDesconto) {
            foreach ($faixasDesconto as $faixa) {
                /** @var FaixaDesconto $faixa */
                if ($faixa->getPercentualDesconto() >= self::PERCENTUAL_DESCONTO) {
                    $error = $this->translate("errors.rh.folhapagamento.previdenciaFaixaPagamentoPorcentagemAlta");
                    $errorElement->with('codPrevidenciaFaixa.0.percentualDesconto')->addViolation($error)->end();
                }
            }
        }
    }
}
