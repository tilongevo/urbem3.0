<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Urbem\CoreBundle\Entity\Beneficio\Beneficiario;
use Urbem\CoreBundle\Entity\Beneficio\ModalidadeConvenioMedico;
use Urbem\CoreBundle\Entity\Beneficio\TipoConvenioMedico;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Entity\Cse\GrauParentesco;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BeneficiarioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_beneficiario';

    protected $baseRoutePattern = 'recursos-humanos/beneficio/beneficiario';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add(
                'fkSwCgm.nomCgm',
                '',
                [
                    'label' => 'label.beneficio.planoDeSaude.nomeBeneficiario',
                ]
            )
            ->add(
                'dtInicio',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy',
                    ],
                    'label' => 'label.beneficio.planoDeSaude.inicioBeneficio'
                ]
            )
            ->add(
                'dtFim',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.beneficio.planoDeSaude.fimBeneficio'
                ]
            )
            ->add('valor', '', ['label' => 'label.planoSaude.vrDesconto'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkSwCgm',
                'entity',
                [
                    'class' => SwCgm::class,
                    'choice_label' => 'nom_cgm',
                    'label' => 'label.beneficio.planoDeSaude.beneficiario',
                    'placeholder' => 'Selecione',
                ]
            )
            ->add('dtInicio', 'date', ['label' => 'label.beneficio.planoDeSaude.inicioBeneficio', 'sortable' => false])
            ->add('dtFim', 'date', ['label' => 'label.beneficio.planoDeSaude.fimBeneficio', 'sortable' => false])
            ->add('valor', 'number', ['label' => 'label.planoSaude.vrDesconto', 'sortable' => false])
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

        /** @var Beneficiario $beneficiario */
        $beneficiario = $this->getSubject();

        $fieldOptions['codContrato'] = array(
            'label' => 'label.gerarAssentamento.inContrato',
            'route' => array(
                'name' => 'carrega_contrato'
            ),
            'class' => 'CoreBundle:Pessoal\Contrato',
            'json_choice_label' => function ($contrato) {
                return $contrato->getRegistro()
                . " - "
                . $contrato->getCodContrato()
                . " - "
                . $contrato->getFkPessoalContratoServidor()
                    ->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()
                    ->getFkSwCgmPessoaFisica()
                    ->getFkSwCgm()
                    ->getNomcgm();
            },
            'data' => $beneficiario->getFkPessoalContrato(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );

        $formMapper
            ->with('Matrícula')
            ->add(
                'codContrato',
                'autocomplete',
                $fieldOptions['codContrato']
            )
            ->end()
            ->with('Beneficiário')
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                [
                    'class' => SwCgm::class,
                    'property' => 'nomCgm',
                    'label' => 'label.beneficio.planoDeSaude.beneficiario',
                    'to_string_callback' => function (SwCgm $cgm) {
                        return strtoupper(
                            sprintf('%s - %s', $cgm->getNumcgm(), $cgm->getNomCgm())
                        );
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm',
                ]
            )
            ->add(
                'fkComprasFornecedor',
                'sonata_type_model_autocomplete',
                [
                    'class' => 'CoreBundle:Compras\Fornecedor',
                    'property' => 'nomCgm',
                    'label' => 'label.beneficio.planoDeSaude.fornecedor',
                    'to_string_callback' => function (Fornecedor $fornecedor) {
                        $cgm = $fornecedor->getFkSwCgm();
                        return strtoupper(
                            sprintf('%s - %s', $cgm->getNumcgm(), $cgm->getNomCgm())
                        );
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ],
                [
                    'admin_code' => 'core.admin.filter.fornecedor',
                ]
            )
            ->add(
                'fkBeneficioModalidadeConvenioMedico',
                'entity',
                [
                    'class' => ModalidadeConvenioMedico::class,
                    'choice_label' => 'descricao',
                    'choice_value' => 'cod_modalidade',
                    'placeholder' => 'Selecione',
                    'label' => 'label.beneficio.planoDeSaude.modalidade',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ]
                ]
            )
            ->add(
                'fkBeneficioTipoConvenioMedico',
                'entity',
                [
                    'class' => TipoConvenioMedico::class,
                    'choice_label' => 'descricao',
                    'choice_value' => 'descricao',
                    'placeholder' => 'Selecione',
                    'label' => 'label.beneficio.planoDeSaude.tipoConvenio',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ]
                ]
            )
                ->add(
                    'codigoUsuario',
                    'text',
                    [
                        'label' => 'label.beneficio.planoDeSaude.codUsuario',
                    ]
                )
                ->add(
                    'fkCseGrauParentesco',
                    'entity',
                    [
                        'class' => GrauParentesco::class,
                        'label' => 'label.beneficio.planoDeSaude.grauDeParentesco',
                        'choice_label' => 'nom_grau',
                        'choice_value' => 'cod_grau',
                        'placeholder' => 'Selecione',
                        'attr' => [
                            'class' => 'select2-parameters ',
                        ]
                    ]
                )
            ->add(
                'dtInicio',
                'sonata_type_date_picker',
                [
                    'label' => 'label.beneficio.planoDeSaude.inicioBeneficio',
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'dtFim',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.beneficio.planoDeSaude.fimBeneficio',
                    'required' => false,
                ]
            )
            ->add(
                'valor',
                'money',
                [
                    'label' => 'label.planoSaude.vrDesconto',
                    'grouping' => false,
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money ',
                    ]
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
            ->add('fkSwCgm', 'entity', array(
                'class' => SwCgm::class,
                'label' => 'label.beneficio.planoDeSaude.beneficiario',
            ))
            ->add(
                'fkComprasFornecedor',
                'entity',
                [
                    'class' => Fornecedor::class,
                    'choice_label' => 'cgm_fornecedor',
                    'label' => 'label.beneficio.planoDeSaude.fornecedor',
                    'placeholder' => 'Selecione',
                    'admin_code' => 'patrimonial.admin.fornecedor',
                ]
            )
            ->add(
                'fkBeneficioModalidadeConvenioMedico',
                'entity',
                [
                    'class' => ModalidadeConvenioMedico::class,
                    'choice_label' => 'descricao',
                    'label' => 'label.beneficio.planoDeSaude.modalidade',
                ]
            )
            ->add(
                'fkBeneficioTipoConvenioMedico',
                'entity',
                [
                    'class' => TipoConvenioMedico::class,
                    'choice_label' => 'descricao',
                    'label' => 'label.beneficio.planoDeSaude.tipoConvenio',
                ]
            )
                ->add('codigoUsuario', 'text', ['label' => 'label.beneficio.planoDeSaude.codUsuario'])
                ->add('dtInicio', 'date', ['label' => 'label.beneficio.planoDeSaude.inicioBeneficio'])
                ->add('dtFim', 'date', ['label' => 'label.beneficio.planoDeSaude.fimBeneficio'])
                ->add('valor', 'number', ['label' => 'label.beneficio.planoDeSaude.valorDesconto'])
                ;
    }

    /**
     * @param Beneficiario $beneficiario
     */
    public function prePersist($beneficiario)
    {
        $em = $this->getDoctrine();

        $contrato = $this->getForm()
            ->get('codContrato')
            ->getData()
        ;

        $periodoMovimentacao = (new PeriodoMovimentacao())
            ->setDtInicial($beneficiario->getDtInicio())
            ->setDtFinal($beneficiario->getDtFim())
        ;

        $em->persist($periodoMovimentacao);

        $beneficiario->setFkPessoalContrato($contrato);
        $beneficiario->setFkFolhapagamentoPeriodoMovimentacao($periodoMovimentacao);

        $em->persist($contrato);
        $em->persist($beneficiario);
    }
}
