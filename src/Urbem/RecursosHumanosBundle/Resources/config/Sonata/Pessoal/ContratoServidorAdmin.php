<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Urbem\AdministrativoBundle\Helper\Constants\TipoAtributo;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Folhapagamento\Padrao;
use Urbem\CoreBundle\Entity\Folhapagamento\Sindicato;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor;
use Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\Categoria;
use Urbem\CoreBundle\Entity\Pessoal\Conselho;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\FormaPagamento;
use Urbem\CoreBundle\Entity\Pessoal\GradeHorario;
use Urbem\CoreBundle\Entity\Pessoal\Ocorrencia;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\TipoAdmissao;
use Urbem\CoreBundle\Entity\Pessoal\TipoPagamento;
use Urbem\CoreBundle\Entity\Pessoal\VinculoEmpregaticio;
use Urbem\CoreBundle\Helper\NumberHelper;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\CargoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Model\Pessoal\EspecialidadeModel;
use Urbem\CoreBundle\Model\Pessoal\SubDivisaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ContratoServidor as ContratoServidorConstants;

class ContratoServidorAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_contrato_servidor';
    protected $baseRoutePattern = 'recursos-humanos/servidor/contrato';
    protected $model = null;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','list']);
        $collection->add('consulta_subdivisao_regime', 'consulta-subdivisao-regime', [], [], [], '', [], ['POST']);
        $collection->add('consulta_cargo_subdivisao', 'consulta-cargo-subdivisao', [], [], [], '', [], ['POST']);
        $collection->add('consulta_especialidade_cargo_subdivisao', 'consulta-especialidade-cargo-subdivisao', [], [], [], '', [], ['POST']);
        $collection->add('consulta_informacoes_salariais', 'consulta-informacoes-salariais', [], [], [], '', [], ['POST']);
        $collection->add('calcula_salario', 'calcula-salario', [], [], [], '', [], ['POST']);
        $collection->add('recuperaGradeHorario', 'recupera-grade');
    }

    /**
     * @param FormMapper $formMapper
     * @param array $fieldOptions
     */
    public function addEventListenerPreSubmit(FormMapper $formMapper, array $fieldOptions)
    {
        $entityManager = $this->getDoctrine();

        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $fieldOptions, $entityManager) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    // Informações do Cargo
                    if (isset($data['fkPessoalRegime']) && !empty($data['fkPessoalRegime'])) {
                        $fieldOptions['codSubDivisao']['auto_initialize'] = false;
                        $fieldOptions['codSubDivisao']['choices'] = (new SubDivisaoModel($entityManager))
                        ->consultaSubDivisaoRegime($data['fkPessoalRegime'], true);

                        $codSubDivisao = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codSubDivisao', 'choice', null, $fieldOptions['codSubDivisao']);

                        $form->add($codSubDivisao);
                    }

                    if (isset($data['codSubDivisao']) && !empty($data['codSubDivisao'])) {
                        $fieldOptions['codCargo']['auto_initialize'] = false;
                        $fieldOptions['codCargo']['choices'] = (new CargoModel($entityManager))
                        ->consultaCargoSubDivisao($data['codSubDivisao'], true);

                        $codCargo = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codCargo', 'choice', null, $fieldOptions['codCargo']);

                        $form->add($codCargo);
                    }

                    if (isset($data['codCargo']) && !empty($data['codCargo'])) {
                        $fieldOptions['codEspecialidade']['auto_initialize'] = false;
                        $fieldOptions['codEspecialidade']['choices'] = (new EspecialidadeModel($entityManager))
                        ->consultaEspecialidadeCargoSubDivisao($data['codSubDivisao'], $data['codCargo'], true);

                        $codEspecialidade = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codEspecialidade', 'choice', null, $fieldOptions['codEspecialidade']);

                        $form->add($codEspecialidade);
                    }

                    // Informações da Função
                    if (isset($data['codRegimeFuncao']) && !empty($data['codRegimeFuncao'])) {
                        $fieldOptions['codSubDivisaoFuncao']['auto_initialize'] = false;
                        $fieldOptions['codSubDivisaoFuncao']['choices'] = (new SubDivisaoModel($entityManager))
                        ->consultaSubDivisaoRegime($data['codRegimeFuncao'], true);

                        $codSubDivisaoFuncao = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codSubDivisaoFuncao', 'choice', null, $fieldOptions['codSubDivisaoFuncao']);

                        $form->add($codSubDivisaoFuncao);
                    }

                    if (isset($data['codSubDivisaoFuncao']) && !empty($data['codSubDivisaoFuncao'])) {
                        $fieldOptions['codCargoFuncao']['auto_initialize'] = false;
                        $fieldOptions['codCargoFuncao']['choices'] = (new CargoModel($entityManager))
                        ->consultaCargoSubDivisao($data['codSubDivisaoFuncao'], true);

                        $codCargoFuncao = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codCargoFuncao', 'choice', null, $fieldOptions['codCargoFuncao']);

                        $form->add($codCargoFuncao);
                    }

                    if (isset($data['codCargoFuncao']) && !empty($data['codCargoFuncao'])) {
                        $fieldOptions['codEspecialidadeFuncao']['auto_initialize'] = false;
                        $fieldOptions['codEspecialidadeFuncao']['choices'] = (new EspecialidadeModel($entityManager))
                        ->consultaEspecialidadeCargoSubDivisao($data['codSubDivisaoFuncao'], $data['codCargoFuncao'], true);

                        $codEspecialidadeFuncao = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codEspecialidadeFuncao', 'choice', null, $fieldOptions['codEspecialidadeFuncao']);

                        $form->add($codEspecialidadeFuncao);
                    }

                    // Banco e Agência
                    if (isset($data['codBancoSalario']) && !empty($data['codBancoSalario'])) {
                        $fieldOptions['codAgenciaSalario']['auto_initialize'] = false;
                        $fieldOptions['codAgenciaSalario']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data) {
                                $teste = $entityRepository
                                    ->createQueryBuilder('a')
                                    ->where('a.codBanco = :codBanco')
                                    ->setParameter('codBanco', $data['codBancoSalario']);
                                return $teste;
                            };
                        $codAgenciaSalario = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codAgenciaSalario', 'entity', null, $fieldOptions['codAgenciaSalario']);

                        $form->add($codAgenciaSalario);
                    }

                    if (isset($data['codBancoFgts']) && !empty($data['codBancoFgts'])) {
                        $fieldOptions['codAgenciaFgts']['auto_initialize'] = false;
                        $fieldOptions['codAgenciaFgts']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data) {
                                $teste = $entityRepository
                                    ->createQueryBuilder('a')
                                    ->where('a.codBanco = :codBanco')
                                    ->setParameter('codBanco', $data['codBancoFgts']);
                                return $teste;
                            };
                        $codAgenciaFgts = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codAgenciaFgts', 'entity', null, $fieldOptions['codAgenciaFgts']);

                        $form->add($codAgenciaFgts);
                    }
                }
            )
        ;
    }

    /**
     * @param FormMapper $formMapper
     * @param array $fieldOptions
     */
    public function addEventListenerPreSetData(FormMapper $formMapper, array $fieldOptions)
    {
        $entityManager = $this->getDoctrine();

        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formMapper, $fieldOptions, $entityManager) {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $subject = $this->getSubject();

                    $fieldOptions['codSubDivisao']['auto_initialize'] = false;
                    $fieldOptions['codSubDivisao']['choices'] = (new SubDivisaoModel($entityManager))
                    ->consultaSubDivisaoRegime($subject->getFkPessoalRegime()->getCodRegime(), true);

                    $codSubDivisao = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codSubDivisao', 'choice', null, $fieldOptions['codSubDivisao']);

                    $form->add($codSubDivisao);

                    $fieldOptions['codCargo']['auto_initialize'] = false;
                    $fieldOptions['codCargo']['choices'] = (new CargoModel($entityManager))
                    ->consultaCargoSubDivisao($subject->getFkPessoalSubDivisao()->getCodSubDivisao(), true);

                    $codCargo = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codCargo', 'choice', null, $fieldOptions['codCargo']);

                    $form->add($codCargo);

                    $fieldOptions['codEspecialidade']['auto_initialize'] = false;
                    $fieldOptions['codEspecialidade']['choices'] = (new EspecialidadeModel($entityManager))
                    ->consultaEspecialidadeCargoSubDivisao(
                        $subject->getFkPessoalSubDivisao()->getCodSubDivisao(),
                        $subject->getFkPessoalCargo()->getCodCargo(),
                        true
                    );

                    $codEspecialidade = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codEspecialidade', 'choice', null, $fieldOptions['codEspecialidade']);

                    $form->add($codEspecialidade);

                    $codSubDivisaoFuncaoValor = $subject->getFkPessoalContratoServidorSubDivisaoFuncoes()
                    ->last()->getCodSubDivisao();

                    $fieldOptions['codSubDivisaoFuncao']['auto_initialize'] = false;
                    $fieldOptions['codSubDivisaoFuncao']['choices'] = (new SubDivisaoModel($entityManager))
                    ->consultaSubDivisaoRegime(
                        $subject->getFkPessoalContratoServidorRegimeFuncoes()->last()->getCodRegime(),
                        true
                    );
                    $fieldOptions['codSubDivisaoFuncao']['data'] = $codSubDivisaoFuncaoValor;

                    $codSubDivisaoFuncao = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codSubDivisaoFuncao', 'choice', null, $fieldOptions['codSubDivisaoFuncao']);

                    $form->add($codSubDivisaoFuncao);

                    $codCargoFuncaoValor = $subject->getFkPessoalContratoServidorFuncoes()
                    ->last()->getCodCargo();

                    $fieldOptions['codCargoFuncao']['auto_initialize'] = false;
                    $fieldOptions['codCargoFuncao']['choices'] = (new CargoModel($entityManager))
                    ->consultaCargoSubDivisao(
                        $codSubDivisaoFuncaoValor,
                        true
                    );
                    $fieldOptions['codCargoFuncao']['data'] = $codCargoFuncaoValor;

                    $codCargoFuncao = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codCargoFuncao', 'choice', null, $fieldOptions['codCargoFuncao']);

                    $form->add($codCargoFuncao);

                    $fieldOptions['codEspecialidadeFuncao']['auto_initialize'] = false;
                    $fieldOptions['codEspecialidadeFuncao']['choices'] = (new EspecialidadeModel($entityManager))
                    ->consultaEspecialidadeCargoSubDivisao($codSubDivisaoFuncaoValor, $codCargoFuncaoValor, true);

                    $codEspecialidadeFuncao = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codEspecialidadeFuncao', 'choice', null, $fieldOptions['codEspecialidadeFuncao']);

                    $form->add($codEspecialidadeFuncao);

                    $contaFgts = $this->getSubject()->getFkPessoalContratoServidorContaFgts();

                    $fieldOptions['codAgenciaFgts']['auto_initialize'] = false;
                    if ($contaFgts) {
                        $fieldOptions['codAgenciaFgts']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data, $contaFgts) {
                                $codAgenciaFgts = $entityRepository
                                    ->createQueryBuilder('a')
                                    ->where('a.codBanco = :codBanco')
                                    ->setParameter('codBanco', $contaFgts->getfkMonetarioAgencia()->getCodBanco());
                                return $codAgenciaFgts;
                            };

                        $fieldOptions['codAgenciaFgts']['data'] = $contaFgts->getFkMonetarioAgencia();
                    }

                    $codAgenciaFgts = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAgenciaFgts', 'entity', null, $fieldOptions['codAgenciaFgts']);

                    $form->add($codAgenciaFgts);

                    $contaSalario = $this->getSubject()->getFkPessoalContratoServidorContaSalario();
                    if ($contaSalario) {
                        $fieldOptions['codAgenciaSalario']['auto_initialize'] = false;
                        $fieldOptions['codAgenciaSalario']['query_builder'] =
                            function (EntityRepository $entityRepository) use ($data, $contaSalario) {
                                $teste = $entityRepository
                                    ->createQueryBuilder('a')
                                    ->where('a.codBanco = :codBanco')
                                    ->setParameter('codBanco', $contaSalario->getFkMonetarioAgencia()->getCodBanco());
                                return $teste;
                            };
                        $fieldOptions['codAgenciaSalario']['data'] = $contaSalario->getFkMonetarioAgencia();
                        $codAgenciaSalario = $formMapper->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('codAgenciaSalario', 'entity', null, $fieldOptions['codAgenciaSalario']);

                        $form->add($codAgenciaSalario);
                    }
                }
            )
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/contratoservidor/form--bancoagencia.js',
            '/recursoshumanos/javascripts/pessoal/contratoservidor/form--contrato-servidor.js',
            '/recursoshumanos/javascripts/pessoal/contratoservidor/form--cargofuncao.js'
        ]));

        $entityManager = $this->getDoctrine();

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['servidor'] = [
            'mapped' => false,
            'data' => $id
        ];

        $fieldOptions['nrCartaoPonto'] = [
            'label' => 'label.contratoServidor.cartaoPonto'
        ];

        $fieldOptions['ativo'] = [
            'label' => 'label.situacao'
        ];

        $fieldOptions['dtNomeacao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtNomeacao',
            'mapped' => false
        ];

        $fieldOptions['fkNormasNorma'] = [
            'class' => Norma::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->getNormasPorExercicio($this->getExercicio(), $term);
            },
            'label' => 'label.atoNomeacao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['dtPosse'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtPosse',
            'mapped' => false
        ];

        $fieldOptions['dtAdmissao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtAdmissao',
            'mapped' => false
        ];

        $fieldOptions['dtInicioProgressao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtInicioProgressao',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['dtValidadeExame'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.validadeExameMedico',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['fkPessoalTipoAdmissao'] = [
            'class' => TipoAdmissao::class,
            'choice_label' => 'descricao',
            'label' => 'label.tipoAdmissao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['fkPessoalVinculoEmpregaticio'] = [
            'class' => VinculoEmpregaticio::class,
            'choice_label' => 'descricao',
            'label' => 'label.vinculoEmpregaticio',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['fkPessoalCategoria'] = [
            'class' => Categoria::class,
            'choice_label' => 'descricao',
            'label' => 'label.categoria',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codOcorrencia'] = [
            'mapped' => false,
            'class' => Ocorrencia::class,
            'choice_label' => 'descricao',
            'label' => 'label.contratoServidor.classificacaoAgentesNocivos',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['fkPessoalRegime'] = [
            'class' => Regime::class,
            'choice_label' => 'descricao',
            'label' => 'label.contratoServidor.regime',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codSubDivisao'] = [
            'choices' => [],
            'label' => 'label.contratoServidor.subdivisao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codCargo'] = [
            'choices' => [],
            'label' => 'label.codCargo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codEspecialidade'] = [
            'choices' => [],
            'label' => 'label.contratoServidor.especialidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['codRegimeFuncao'] = [
            'class' => Regime::class,
            'choice_label' => 'descricao',
            'label' => 'label.contratoServidor.regime',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['codSubDivisaoFuncao'] = [
            'choices' => [],
            'label' => 'label.contratoServidor.subdivisao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['codCargoFuncao'] = [
            'choices' => [],
            'label' => 'label.codCargo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['codEspecialidadeFuncao'] = [
            'choices' => [],
            'label' => 'label.contratoServidor.especialidade',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['horasMensais'] = [
            'mapped' => false,
            'attr' => [
                'class' => 'decimal ',
            ],
            'constraints' => [
                new Assert\GreaterThan(0)
            ]
        ];

        $fieldOptions['horasSemanais'] = [
            'mapped' => false,
            'attr' => [
                'class' => 'decimal ',
            ],
            'constraints' => [
                new Assert\GreaterThan(0)
            ]
        ];

        $fieldOptions['codPadrao'] = [
            'mapped' => false,
            'class' => Padrao::class,
            'choice_label' => function (Padrao $padrao) {
                return $padrao->getCodPadrao()
                . " - "
                . $padrao->getDescricao()
                . " - "
                . $padrao->getFkFolhapagamentoPadraoPadroes()->last()->getValor()
                ;
            },
            'query_builder' => function (EntityRepository $er) {
                $codPadraoLegado = $er->getPadraoFilter();

                $ids = [];
                foreach ($codPadraoLegado as $codPadrao) {
                    $ids[] = $codPadrao->cod_padrao;
                }

                return $er->createQueryBuilder('p')
                    ->andWhere('p.codPadrao IN (:ids)')
                    ->setParameter('ids', $ids)
                    ->orderBy('p.descricao', 'ASC');
            },
            'label' => 'label.padrao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'required' => false,
        ];

        $fieldOptions['salario'] = [
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
            ],
            'label' => 'label.salario',
            'constraints' => [
                new Assert\GreaterThan(0)
            ]
        ];

        $fieldOptions['vigencia'] = [
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'label' => 'label.servidor.dtVigenciaSalario'
        ];

        $fieldOptions['codFormaPagamento'] = [
            'mapped' => false,
            'class' => FormaPagamento::class,
            'choice_label' => 'descricao',
            'label' => 'label.formaPagamento',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codBancoSalario'] = [
            'class' => Banco::class,
            'choice_label' => function (Banco $banco) {
                return $banco->getNumBanco() . " - " . $banco->getNomBanco();
            },
            'label' => 'label.banco',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['codAgenciaSalario'] = [
            'class' => Agencia::class,
            'choice_label' => function (Agencia $agencia) {
                return $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia();
            },
            'choice_value' => 'codAgencia',
            'label' => 'label.agencia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['nrContaSalario'] = [
            'label' => 'label.contaCredito',
            'attr' => [
                'class' => 'numeric ',
                'maxlength' => 15,
            ],
            'mapped' => false,
        ];

        $fieldOptions['fkPessoalTipoPagamento'] = [
            'class' => TipoPagamento::class,
            'choice_label' => 'descricao',
            'label' => 'label.tipoPagamento',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codTipoSalario'] = [
            'choices' => (new ContratoServidorModel($entityManager))
            ->listaTipoSalario(),
            'label' => 'label.tipoSalario',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['adiantamento'] = [
            'label' => 'label.contratoServidor.adiantamento'
        ];

        $fieldOptions['codLocal'] = [
            'mapped' => false,
            'required' => false,
            'class' => Local::class,
            'choice_label' => 'descricao',
            'label' => 'label.local',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['dtOpcaoFgts'] = [
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtOpcaoFgts'
        ];

        $fieldOptions['codBancoFgts'] = [
            'class' => Banco::class,
            'choice_label' => function (Banco $banco) {
                return $banco->getNumBanco() . " - " . $banco->getNomBanco();
            },
            'label' => 'label.banco',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codAgenciaFgts'] = [
            'class' => Agencia::class,
            'choice_label' => 'nomAgencia',
            'choice_value' => 'codAgencia',
            'label' => 'label.agencia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['nrContaFgts'] = [
            'label' => 'label.contaCredito',
            'attr' => [
                'class' => 'numeric ',
                'maxlength' => 15,
            ],
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['fkPessoalGradeHorario'] = [
            'class' => GradeHorario::class,
            'choice_label' => 'descricao',
            'label' => 'label.contratoServidor.tipo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['numcgmSindicato'] = [
            'mapped' => false,
            'required' => false,
            'class' => Sindicato::class,
            'label' => 'label.cgmSindicato',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'choice_attr' => function ($val, $key, $index) {
                // adds a class like attending_yes, attending_no, etc
                return ['data-dtdatabase' => $val->getDataBase()];
            },
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['dtDatabase'] = [
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'label' => 'label.folhapagamento.sindicato.dataBase',
        ];

        $fieldOptions['codConselho'] = [
            'mapped' => false,
            'required' => false,
            'class' => Conselho::class,
            'choice_label' => 'descricao',
            'label' => 'label.conselho.modulo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codPrevidencia'] = [
            'mapped' => false,
            'choices' => (new PrevidenciaModel($entityManager))->getPrevidenciaChoices(true),
            'label' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'multiple' => true
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['fkPessoalRegime']['disabled'] = true;
            $fieldOptions['codSubDivisao']['disabled'] = true;
            $fieldOptions['codCargo']['disabled'] = true;
            $fieldOptions['codEspecialidade']['disabled'] = true;

            /** @var ContratoServidorNomeacaoPosse $contratoServidorNomeacaoPosse */
            $contratoServidorNomeacaoPosse = $this
                                                ->getSubject()
                                                ->getFkPessoalContratoServidorNomeacaoPosses()
                                                ->last();

            $fieldOptions['dtNomeacao']['data'] = $contratoServidorNomeacaoPosse->getDtNomeacao();
            $fieldOptions['dtPosse']['data'] = $contratoServidorNomeacaoPosse->getDtPosse();
            $fieldOptions['dtAdmissao']['data'] = $contratoServidorNomeacaoPosse->getDtAdmissao();

            $contratoServidorInicioProgressao = $this->getSubject()
            ->getFkPessoalContratoServidorInicioProgressoes();

            if (! $contratoServidorInicioProgressao->isEmpty()) {
                $fieldOptions['dtInicioProgressao']['data'] = $contratoServidorInicioProgressao
                ->last()->getDtInicioProgressao();
            }

            $contratoServidorExameMedico = $this->getSubject()
            ->getFkPessoalContratoServidorExameMedicos();

            if (! $contratoServidorExameMedico->isEmpty()) {
                $fieldOptions['dtValidadeExame']['data'] = $contratoServidorExameMedico
                ->last()->getDtValidadeExame();
            }

            $fieldOptions['codOcorrencia']['data'] = $this->getSubject()
            ->getFkPessoalContratoServidorOcorrencias()->last()->getFkPessoalOcorrencia();

            $fieldOptions['codRegimeFuncao']['data'] = $this->getSubject()
            ->getFkPessoalContratoServidorRegimeFuncoes()->last()->getFkPessoalRegime();

            $contratoServidorSalario = $this->getSubject()
            ->getFkPessoalContratoServidorSalarios()->last();

            $fieldOptions['horasMensais']['data'] = $contratoServidorSalario->getHorasMensais();
            $fieldOptions['horasSemanais']['data'] = $contratoServidorSalario->getHorasSemanais();
            $fieldOptions['salario']['data'] = $contratoServidorSalario->getSalario();
            $fieldOptions['vigencia']['data'] = $contratoServidorSalario->getVigencia();
            $fieldOptions['codFormaPagamento']['data'] = $this
                                                            ->getSubject()
                                                            ->getFkPessoalContratoServidorFormaPagamentos()
                                                            ->last()
                                                            ->getFkPessoalFormaPagamento();

            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao(
                    $this->getSubject()->getFkPessoalContratoServidorOrgoes()->last()->getCodOrgao()
                )
            );

            $contaFgts = $this->getSubject()->getFkPessoalContratoServidorContaFgts();

            if ($contaFgts) {
                $fieldOptions['codBancoFgts']['data'] = $contaFgts->getFkMonetarioAgencia()->getFkMonetarioBanco();
                $fieldOptions['nrContaFgts']['data'] = $contaFgts->getNrConta();
            }

            $contratoServidorSindicato = $this->getSubject()->getFkPessoalContratoServidorSindicato();

            if ($contratoServidorSindicato) {
                $fieldOptions['numcgmSindicato']['data'] = $contratoServidorSindicato
                ->getFkFolhapagamentoSindicato();
            }

            $contaSalario = $this->getSubject()->getFkPessoalContratoServidorContaSalario();
            if ($contaSalario) {
                $fieldOptions['codBancoSalario']['data'] = $contaSalario->getFkMonetarioAgencia()
                ->getFkMonetarioBanco();
                $fieldOptions['nrContaSalario']['data'] = $contaSalario->getNrConta();
            }

            $padrao = $this->getSubject()->getFkPessoalContratoServidorPadroes();

            if (! $padrao->isEmpty()) {
                $fieldOptions['codPadrao']['data'] = $padrao->last()->getFkFolhapagamentoPadrao();
            }

            $local = $this->getSubject()->getFkPessoalContratoServidorLocais();

            if (! $local->isEmpty()) {
                $fieldOptions['codLocal']['data'] = $local->last()->getFkOrganogramaLocal();
            }

            $conselho = $this->getSubject()->getFkPessoalContratoServidorConselho();

            if ($conselho) {
                $fieldOptions['codConselho']['data'] = $conselho->getFkPessoalConselho();
            }

            $fieldOptions['codPrevidencia']['data'] = (new ContratoServidorModel($entityManager))
            ->getCurrentContratoServidorPrevidencia($this->getSubject());
        }

        $formMapper
            ->with('label.contratoServidor.informacoesContratuais')
                ->add(
                    'servidor',
                    'hidden',
                    $fieldOptions['servidor']
                )
                ->add(
                    'nrCartaoPonto',
                    null,
                    $fieldOptions['nrCartaoPonto']
                )
                ->add(
                    'ativo',
                    null,
                    $fieldOptions['ativo']
                )
                ->add(
                    'dtNomeacao',
                    'sonata_type_date_picker',
                    $fieldOptions['dtNomeacao']
                )
                ->add(
                    'fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkNormasNorma']
                )
                ->add(
                    'dtPosse',
                    'sonata_type_date_picker',
                    $fieldOptions['dtPosse']
                )
                ->add(
                    'dtAdmissao',
                    'sonata_type_date_picker',
                    $fieldOptions['dtAdmissao']
                )
                ->add(
                    'dtInicioProgressao',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicioProgressao']
                )
                ->add(
                    'dtValidadeExame',
                    'sonata_type_date_picker',
                    $fieldOptions['dtValidadeExame']
                )
                ->add(
                    'fkPessoalTipoAdmissao',
                    'entity',
                    $fieldOptions['fkPessoalTipoAdmissao']
                )
                ->add(
                    'fkPessoalVinculoEmpregaticio',
                    'entity',
                    $fieldOptions['fkPessoalVinculoEmpregaticio']
                )
                ->add(
                    'fkPessoalCategoria',
                    'entity',
                    $fieldOptions['fkPessoalCategoria']
                )
                ->add(
                    'codOcorrencia',
                    'entity',
                    $fieldOptions['codOcorrencia']
                )
            ->end()
            ->with('label.contratoServidor.informacoesCargo')
                ->add(
                    'fkPessoalRegime',
                    'entity',
                    $fieldOptions['fkPessoalRegime']
                )
                ->add(
                    'codSubDivisao',
                    'choice',
                    $fieldOptions['codSubDivisao']
                )
                ->add(
                    'codCargo',
                    'choice',
                    $fieldOptions['codCargo']
                )
                ->add(
                    'codEspecialidade',
                    'choice',
                    $fieldOptions['codEspecialidade']
                )
            ->end()
            ->with('label.contratoServidor.informacoesFuncao')
                ->add(
                    'codRegimeFuncao',
                    'entity',
                    $fieldOptions['codRegimeFuncao']
                )
                ->add(
                    'codSubDivisaoFuncao',
                    'choice',
                    $fieldOptions['codSubDivisaoFuncao']
                )
                ->add(
                    'codCargoFuncao',
                    'choice',
                    $fieldOptions['codCargoFuncao']
                )
                ->add(
                    'codEspecialidadeFuncao',
                    'choice',
                    $fieldOptions['codEspecialidadeFuncao']
                )
            ->end()
            ->with('label.contratoServidor.informacoesSalariais')
                ->add(
                    'horasMensais',
                    'text',
                    $fieldOptions['horasMensais']
                )
                ->add(
                    'horasSemanais',
                    'text',
                    $fieldOptions['horasSemanais']
                )
                ->add(
                    'codPadrao',
                    'entity',
                    $fieldOptions['codPadrao']
                )
                ->add(
                    'salario',
                    'money',
                    $fieldOptions['salario']
                )
                ->add(
                    'vigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['vigencia']
                )
                ->add(
                    'codFormaPagamento',
                    'entity',
                    $fieldOptions['codFormaPagamento']
                )
                ->add(
                    'codFormaPagamento',
                    'entity',
                    $fieldOptions['codFormaPagamento']
                )
                ->add(
                    'codBancoSalario',
                    'entity',
                    $fieldOptions['codBancoSalario']
                )
                ->add(
                    'codAgenciaSalario',
                    'entity',
                    $fieldOptions['codAgenciaSalario']
                )
                ->add(
                    'nrContaSalario',
                    'text',
                    $fieldOptions['nrContaSalario']
                )
                ->add(
                    'fkPessoalTipoPagamento',
                    'entity',
                    $fieldOptions['fkPessoalTipoPagamento']
                )
                ->add(
                    'codTipoSalario',
                    'choice',
                    $fieldOptions['codTipoSalario']
                )
                ->add(
                    'adiantamento',
                    null,
                    $fieldOptions['adiantamento']
                )
            ->end()
            ->with('label.contratoServidor.informacoesLotacao');

            $this->createFormOrganograma($formMapper, true);

            $formMapper
                ->add(
                    'codLocal',
                    'entity',
                    $fieldOptions['codLocal']
                )
            ->end()
            ->with('label.contratoServidor.informacoesFgts')
                ->add('dtOpcaoFgts')
                ->add(
                    'dtOpcaoFgts',
                    'sonata_type_date_picker',
                    $fieldOptions['dtOpcaoFgts']
                )
                ->add(
                    'codBancoFgts',
                    'entity',
                    $fieldOptions['codBancoFgts']
                )
                ->add(
                    'codAgenciaFgts',
                    'entity',
                    $fieldOptions['codAgenciaFgts']
                )
                ->add(
                    'nrContaFgts',
                    'text',
                    $fieldOptions['nrContaFgts']
                )
            ->end()
            ->with('label.contratoServidor.quadroHorario')
                ->add(
                    'fkPessoalGradeHorario',
                    'entity',
                    $fieldOptions['fkPessoalGradeHorario']
                )
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 gradehorario-items'
            ])
            ->end()
            ->with('label.contratoServidor.dadosSindicato')
                ->add(
                    'numcgmSindicato',
                    'entity',
                    $fieldOptions['numcgmSindicato']
                )
                ->add(
                    'dtDatabase',
                    'text',
                    $fieldOptions['dtDatabase']
                )
            ->end()
            ->with('label.contratoServidor.conselhoProfissional')
                ->add(
                    'codConselho',
                    'entity',
                    $fieldOptions['codConselho']
                )
                ->add(
                    'fkPessoalContratoServidorConselho',
                    'sonata_type_admin',
                    [
                        'required' => false,
                        'label' => false
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ],
                    null
                )
            ->end()
            ->with('label.contratoServidor.previdencia')
                ->add(
                    'codPrevidencia',
                    'choice',
                    $fieldOptions['codPrevidencia']
                )
            ->end()
            ->with('label.atributos')
        ;

        $atributosDinamicos = (new AtributoDinamicoModel($entityManager))
        ->getAtributosDinamicosPorModuloQuery(
            ContratoServidorConstants::CODMODULO,
            ContratoServidorConstants::CODCADASTRO
        )->getQuery()->getResult();

        if ($this->id($this->getSubject())) {
            if (! $this->getSubject()->getFkPessoalAtributoContratoServidorValores()->isEmpty()) {
                $atributosDinamicos = $this->getSubject()->getFkPessoalAtributoContratoServidorValores();
            }
        }

        foreach ($atributosDinamicos as $atributoDinamico) {
            if ($atributoDinamico instanceof AtributoContratoServidorValor) {
                $options['data'] = ($atributoDinamico->getValor() == "" ? null : $atributoDinamico->getValor());
                $this->configureFormFieldsAtributoDinamico(
                    $formMapper,
                    $atributoDinamico->getFkAdministracaoAtributoDinamico(),
                    $options
                );
            } else {
                $this->configureFormFieldsAtributoDinamico($formMapper, $atributoDinamico);
            }
        }

        $formMapper
            ->end()
        ;

        $this->addEventListenerPreSubmit($formMapper, $fieldOptions);

        if ($this->id($this->getSubject())) {
            $this->addEventListenerPreSetData($formMapper, $fieldOptions);
        }
    }

    /**
     * Constrói campos de atributo dinamico para edição.
     *
     * @param FormMapper       $formMapper
     * @param AtributoDinamico $atributoDinamico
     * @param array            $options
     */
    public function configureFormFieldsAtributoDinamico(FormMapper $formMapper, AtributoDinamico $atributoDinamico, array $options = [])
    {
        $baseFieldOptions = [
            'label'    => $atributoDinamico->getNomAtributo(),
            'mapped'   => false,
            'required' => false
        ];

        $fieldName = sprintf('%s_atributoDinamico', $atributoDinamico->getCodAtributo());

        switch ($atributoDinamico->getCodTipo()) {
            case TipoAtributo::NUMERICO:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'number', $options);
                break;
            case TipoAtributo::TEXTO:
                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::LISTA:
            case TipoAtributo::LISTA_MULTIPLA:
                $choices = [];

                /** @var AtributoValorPadrao $atributoValorPadrao */
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    $optionLabel = $atributoValorPadrao->getValorPadrao();
                    $optionValue = $atributoValorPadrao->getCodValor();

                    $choices[$optionLabel] = $optionValue;
                }

                $baseFieldOptions['choices'] = $choices;
                $baseFieldOptions['multiple'] = ($atributoDinamico->getCodTipo() == TipoAtributo::LISTA_MULTIPLA);

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'choice', $options);
                break;
            case TipoAtributo::DATA:
                $baseFieldOptions['format'] = 'dd/MM/yyyy';

                $options = array_merge($options, $baseFieldOptions);
                if (isset($options['data']) && ! empty($options['data'])) {
                    $options['data'] = \DateTime::createFromFormat('d/m/Y', $options['data']);
                }

                $formMapper->add($fieldName, 'sonata_type_date_picker', $options);
                break;
            case TipoAtributo::NUMERICO_2:
                $options = array_merge($options, $baseFieldOptions);

                if (isset($options['data'])) {
                    $options['data'] = abs($options['data']);
                }

                $formMapper->add($fieldName, 'text', $options);
                break;
            case TipoAtributo::TEXTO_LONGO:
                $baseFieldOptions['attr']['class'] = 'money ';

                $options = array_merge($options, $baseFieldOptions);

                $formMapper->add($fieldName, 'textArea', $options);
                break;
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $contratoServidor
     */
    public function validate(ErrorElement $errorElement, $contratoServidor)
    {
        $form = $this->getForm();

        $entityManager = $this->getDoctrine();

        if (! NumberHelper::isValidNumber($form->get('horasMensais')->getData(), 5, 2)) {
            $message = $this->trans('contratoServidor.errors.horasMensais');
            $errorElement->with('horasMensais')->addViolation($message)->end();
        }

        if (! NumberHelper::isValidNumber($form->get('horasSemanais')->getData(), 5, 2)) {
            $message = $this->trans('contratoServidor.errors.horasSemanais');
            $errorElement->with('horasSemanais')->addViolation($message)->end();
        }

        if (! NumberHelper::isValidNumber($form->get('salario')->getData(), 14, 2)) {
            $message = $this->trans('contratoServidor.errors.salario');
            $errorElement->with('salario')->addViolation($message)->end();
        }

        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $cargoVagas = $entityManager->getRepository(CargoSubDivisao::class)
        ->getVagasOcupadasCargo(
            $form->get('fkPessoalRegime')->getData()->getCodRegime(),
            $form->get('codSubDivisao')->getData(),
            $form->get('codCargo')->getData(),
            $periodoFinal->getCodPeriodoMovimentacao()
        );

        if ($cargoVagas == 0) {
            $message = $this->trans('contratoServidor.errors.codCargo');
            $errorElement->with('codCargo')->addViolation($message)->end();
        }

        $codEspecialidade = $form->get('codEspecialidade')->getData();
        if ($codEspecialidade) {
            $especialidadeVagas = $entityManager->getRepository(Especialidade::class)
            ->getVagasDisponiveisEspecialidade(
                $form->get('fkPessoalRegime')->getData()->getCodRegime(),
                $form->get('codSubDivisao')->getData(),
                $codEspecialidade,
                $periodoFinal->getCodPeriodoMovimentacao()
            );

            if ($especialidadeVagas == 0) {
                $message = $this->trans('contratoServidor.errors.codEspecialidade');
                $errorElement->with('codEspecialidade')->addViolation($message)->end();
            }
        }

        $cargoFuncaoVagas = $entityManager->getRepository(CargoSubDivisao::class)
        ->getVagasOcupadasCargo(
            $form->get('codRegimeFuncao')->getData()->getCodRegime(),
            $form->get('codSubDivisaoFuncao')->getData(),
            $form->get('codCargoFuncao')->getData(),
            $periodoFinal->getCodPeriodoMovimentacao()
        );

        if ($cargoFuncaoVagas == 0) {
            $message = $this->trans('contratoServidor.errors.codCargoFuncao');
            $errorElement->with('codCargoFuncao')->addViolation($message)->end();
        }

        $codEspecialidadeFuncao = $form->get('codEspecialidadeFuncao')->getData();
        if ($codEspecialidadeFuncao) {
            $especialidadeFuncaoVagas = $entityManager->getRepository(Especialidade::class)
            ->getVagasDisponiveisEspecialidade(
                $form->get('codRegimeFuncao')->getData()->getCodRegime(),
                $form->get('codSubDivisaoFuncao')->getData(),
                $codEspecialidadeFuncao,
                $periodoFinal->getCodPeriodoMovimentacao()
            );

            if ($especialidadeFuncaoVagas == 0) {
                $message = $this->trans('contratoServidor.errors.codEspecialidadeFuncao');
                $errorElement->with('codEspecialidadeFuncao')->addViolation($message)->end();
            }
        }

        if ($form->get('dtNomeacao')->getData() > $form->get('dtPosse')->getData()) {
            $message = $this->trans('contratoServidor.errors.dtPosse');
            $errorElement->with('dtPosse')->addViolation($message)->end();
        }
    }

    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * @param mixed $contratoServidor
     */
    public function prePersist($contratoServidor)
    {
        $entityManager = $this->getDoctrine();

        (new ContratoServidorModel($entityManager))
            ->buildContratoServidor(
                $contratoServidor,
                $this->getForm(),
                $this->getOrgaoSelected(),
                $this->getConfigurationPool()->getContainer()->get('translator')
            );
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($contratoServidor)
    {
        $entityManager = $this->getDoctrine();

        (new AssentamentoGeradoContratoServidorModel($entityManager))
            ->gerarAssentamento($contratoServidor, $this->getConfigurationPool()->getContainer()->get('translator'));
        $this->redirect($contratoServidor->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor());
    }

    public function preUpdate($contratoServidor)
    {
        $entityManager = $this->getDoctrine();

        (new ContratoServidorModel($entityManager))
            ->updateContratoServidor(
                $contratoServidor,
                $this->getForm(),
                $this->getOrgaoSelected(),
                $this->getConfigurationPool()->getContainer()->get('translator')
            );
    }

    /**
     * {@inheritDoc}
     */
    public function postUpdate($contratoServidor)
    {
        $entityManager = $this->getDoctrine();

        (new AssentamentoGeradoContratoServidorModel($entityManager))
            ->gerarAssentamento($contratoServidor, $this->getConfigurationPool()->getContainer()->get('translator'));
        $this->redirect($contratoServidor->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor());
    }

    /**
     * {@inheritDoc}
     */
    public function toString($contratoServidor)
    {
        return $this->trans('label.contratoServidor.contrato');
    }
}
