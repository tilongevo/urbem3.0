<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Estagio\Grau;
use Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\GradeHorario;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Estagio\EntidadeIntermediadoraEstagioModel;
use Urbem\CoreBundle\Model\Estagio\EstagiarioEstagioBolsaModel;
use Urbem\CoreBundle\Model\Estagio\EstagiarioEstagioContaModel;
use Urbem\CoreBundle\Model\Estagio\EstagiarioEstagioLocalModel;
use Urbem\CoreBundle\Model\Estagio\EstagiarioEstagioModel;
use Urbem\CoreBundle\Model\Estagio\InstituicaoEnsinoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;

class EstagiarioEstagioAdmin extends AbstractOrganogramaSonata
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_estagiario_estagio';

    protected $baseRoutePattern = 'recursos-humanos/estagio/estagiario-estagio';

    protected $includeJs = [
        '/recursoshumanos/javascripts/estagio/estagioForm.js',
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('preencher_curso', 'preencher-curso');
        $collection->add('preencher_curso_by_grau', 'preencher-curso-by-grau');
        $collection->add('preencher_grau', 'preencher-grau');
        $collection->add('preencher_instituicao', 'preencher-instituicao');
        $collection->add('monta_recupera_grade', 'monta-recupera-grade');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $codEstagiario = $this->getRequest()->get('id');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codEstagiario = $formData['codEstagiario'];
        } else {
            $codEstagiario = $codEstagiario;
        }

        /** @var  EstagiarioEstagio $estagiarioEstagio */
        $estagiarioEstagio = $this->getSubject();

        $dados = $this->recuperaDadosForm($estagiarioEstagio);

        $fieldOptions['vinculoEstagio'] = [
            'choices' => [
                'label.estagio.instituicao_ensino' => 'i',
                'label.estagio.entidade_intermediadora' => 'e'
            ],
            'expanded' => true,
            'multiple' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata'],
            'data' => is_null($estagiarioEstagio->getVinculoEstagio()) ? 'i' : $estagiarioEstagio->getVinculoEstagio()
        ];

        $fieldOptions['intermediadoraEstagios'] = [
            'class' => EntidadeIntermediadora::class,
            'label' => 'label.estagio.entidade_intermediadora',
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'data' => isset($dados['entidadeIntermediadora']) ? $dados['entidadeIntermediadora'] : null
        ];

        $fieldOptions['instituicaoEnsino'] = [
            'label' => 'label.estagio.instituicao_ensino',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'choices' => isset($dados['instituicaoEnsino'])  ? $dados['instituicaoEnsino']['key_val'] : null ,
            'data' => $estagiarioEstagio->getCgmInstituicaoEnsino() ? $estagiarioEstagio->getCgmInstituicaoEnsino() : null
        ];

        $fieldOptions['curso'] = [
            'label' => 'label.estagio.curso',
            'mapped' => false,
            'choices' => isset($dados['curso']) ? $dados['curso']['key_val'] : null,
            'data' => isset($dados['curso']) ? $dados['curso']['val']: null
        ];

        $fieldOptions['dtInicio'] = [
            'label' => 'label.estagio.dt_inicial',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
        ];

        $fieldOptions['dtFinal'] = [
            'label' => 'label.estagio.dt_final',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'required' => false
        ];

        $fieldOptions['organogramaAtivo'] = [
            'label' => 'label.bem.organogramaAtivo',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'readonly' => true,
                'disabled' => true
            ]
        ];

        $fieldOptions['local'] = [
            'class' => Local::class,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'required' => false,
            'data' => isset($dados['local']) ? $dados['local'] : null
        ];

        $fieldOptions['grauCurso'] = [
            'label' => 'label.estagio.grau_curso',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => isset($dados['grau']) ? $dados['grau']['key_val'] : null,
            'data' => isset($dados['grau']) ? $dados['grau']['val'] : null
        ];

        $fieldOptions['valorBolsa'] = [
            'label' => 'label.vlBolsa',
            'mapped' => false,
            'required' => false,
            'data' => isset($dados['vlBolsa']) ? $dados['vlBolsa'] : null
        ];

        $fieldOptions['faltas'] = [
            'label' => 'label.estagio.dias_falta',
            'mapped' => false,
            'required' => false,
            'data' => isset($dados['falta']) ? $dados['falta'] : null
        ];

        $fieldOptions['mesAvaliacao'] = [
            'label' => 'label.estagio.mes_avaliacao',
            'mapped' => false,
            'required' => false,
            'data' => isset($dados['mesAvaliacao']) ? $dados['mesAvaliacao'] : null
        ];

        $fieldOptions['dtRenovacao'] = [
            'label' => 'label.dtRenovacao',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'required' => false
        ];

        $fieldOptions['grade'] = [
            'class' => GradeHorario::class,
            'label' => 'label.diaria.tipo',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr'=> [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codBanco'] = [
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Banco::class,
            'choice_label' => function (Banco $banco) {
                return "{$banco->getnumBanco()} - {$banco->getnomBanco()}";
            },
            'choice_value' => 'codBanco',
            'mapped' => false,
            'label' => 'label.fornecedor.codBanco',
            'placeholder' => 'label.selecione',
            'data' => isset($dados['codBanco']) ? $dados['codBanco'] : null
        ];

        $fieldOptions['codAgencia'] = [
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codBanco'
            ],
            'class' => Agencia::class,
            'choice_label' => function (Agencia $agencia) {
                return "{$agencia->getNumAgencia()} - {$agencia->getNomAgencia()}";
            },
            'choice_value' => 'codAgencia',
            'label' => 'label.fornecedor.codAgencia',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'data' => isset($dados['codAgencia']) ? $dados['codAgencia'] : null
        ];

        $fieldOptions['numConta'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'choice_value' => 'numContaCorrente',
            'label' => 'label.fornecedor.numConta',
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
            'data' => isset($dados['numConta']) ? $dados['numConta'] : null
        ];

        $fieldOptions['vinculoUpdate'] = [
            'mapped' => false,
            'data' => isset($dados['vinculoUpdate']) ? $dados['vinculoUpdate'] : null
        ];

        $formMapper
            //DADOS DO ESTÁGIO
            ->with('label.estagio.dados_contrato_estagio')
                ->add('codEstagiario', 'hidden', ['mapped' => false , 'data' => $codEstagiario])
                ->add('codEstagio', 'hidden', ['mapped' => false , 'data' => isset($dados['estagio']) ? $dados['estagio']: null])
                ->add('vinculoEstagio', 'choice', $fieldOptions['vinculoEstagio'])
                ->add('intermediadoraEstagios', 'entity', $fieldOptions['intermediadoraEstagios'])
                ->add('instituicaoEnsino', 'choice', $fieldOptions['instituicaoEnsino'])
                ->add('grauCurso', 'choice', $fieldOptions['grauCurso'])
                ->add('curso', 'choice', $fieldOptions['curso'])
                ->add('valorBolsa', 'text', $fieldOptions['valorBolsa'])
                ->add('faltas', 'text', $fieldOptions['faltas'])
                ->add('mesAvaliacao', 'text', $fieldOptions['mesAvaliacao'])
                ->add('anoSemestre', null, ['required' => true])
                ->add('dtInicio', 'datepkpicker', $fieldOptions['dtInicio'])
                ->add('dtFinal', 'datepkpicker', $fieldOptions['dtFinal'])
                ->add('dtRenovacao', 'datepkpicker', $fieldOptions['dtRenovacao'])
                ->add('funcao', null, ['label' => 'label.estagio.funcao'])
                ->add('objetivos', 'textarea', ['label' => 'label.estagio.objetivos', 'required' => false])
                ->add('vinculoUpdate', 'hidden', $fieldOptions['vinculoUpdate'])
            ->end()

            // INFORMAÇÕES BANCÁRIAS
            ->with('label.estagio.informacoesbancarias')
                ->add('codBanco', 'entity', $fieldOptions['codBanco'])
                ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
                ->add('numConta', 'entity', $fieldOptions['numConta'])
            ->end()

            // INFORMAÇÃO LOTAÇÃO
            ->with('label.estagio.informacao_lotacao');

        $this->createFormOrganograma($formMapper, $exibeOrganogramaAtivo = true);

        $formMapper
            ->add('local', 'entity', $fieldOptions['local'])
            ->end()
            ->with('label.estagio.quadro_horarios')
            ->add('fkPessoalGradeHorario', null, $fieldOptions['grade'])
            ->end()
            ->with('label.comprasDireta.items', [
                'class' => 'col s12 gradehorario-items'
            ])
            ->end();

        $estagio = $this;
        $instituicaoModel = new InstituicaoEnsinoModel($entityManager);
        /** @var EstagiarioEstagioModel $estagiarioEstagioModel */
        $estagiarioEstagioModel = new EstagiarioEstagioModel($entityManager);

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $estagio, $instituicaoModel, $estagiarioEstagioModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (!empty($data['intermediadoraEstagios'])) {
                    $instituicoes = $estagiarioEstagioModel
                        ->montaRecuperaInstituicoesDaEntidade($data['intermediadoraEstagios']);
                } else {
                    $instituicoes = $estagiarioEstagioModel
                        ->montaRecuperaRelacionamento();
                }

                if (isset($data['instituicaoEnsino']) && $data['instituicaoEnsino'] != "") {
                    $dados = array();
                    /** @var InstituicaoEnsino $instituicao */
                    foreach ($instituicoes as $instituicao) {
                        $choiceKey = (string) $instituicao->numcgm. " - ". $instituicao->nom_cgm;
                        $choiceValue = $instituicao->numcgm;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $instituicaoEnsino = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('instituicaoEnsino', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.estagio.instituicao_ensino',
                            'mapped' => false,
                        ]);

                    $form->add($instituicaoEnsino);
                }

                $instituicaocgm = $data['instituicaoEnsino'];
                if (isset($instituicaocgm) && $instituicaocgm != "") {
                    $dados = [];
                    $graus = $estagiarioEstagioModel->montaRecuperaGrausDeInstituicaoEnsino($instituicaocgm);

                    /** @var Grau $grau */
                    foreach ($graus as $grau) {
                        $choiceKey = (string) $grau->cod_grau . " - ". $grau->descricao;
                        $choiceValue = $grau->cod_grau;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $grauCurso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('grauCurso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.estagio.grau_curso',
                            'mapped' => false,
                        ]);

                    $form->add($grauCurso);
                }

                $codGrau = $data['grauCurso'];

                if (isset($codGrau) && $codGrau != "") {
                    $dados = [];
                    $cursos = $estagiarioEstagioModel->montaRecuperarCursos($instituicaocgm, $codGrau);

                    /** @var Grau $grau */
                    foreach ($cursos as $curso) {
                        $choiceKey = (string) $curso->cod_curso . " - ". $curso->nom_curso;
                        $choiceValue = $curso->cod_curso;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $curso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('curso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.estagio.curso',
                            'mapped' => false,
                        ]);

                    $form->add($curso);
                }
            }
        );
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function prePersist($estagiarioEstagio)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $codEstagiario = $form->get('codEstagiario')->getData();
        $estagiario = $this->getEntityManager()
            ->getRepository('CoreBundle:Estagio\Estagiario')
            ->findOneBy(['numcgm' => $codEstagiario]);

        $estagiarioEstagio->setFkEstagioEstagiario($estagiario);

        $codCurso = $form->get('curso')->getData();
        $cgm = $form->get('instituicaoEnsino')->getData();
        $curso = $this->getEntityManager()
            ->getRepository('CoreBundle:Estagio\CursoInstituicaoEnsino')
            ->findOneBy(['codCurso' => $codCurso, 'numcgm' => $cgm]);

        $estagiarioEstagio->setFkEstagioCursoInstituicaoEnsino($curso);

        $estagiarioEstagioModel = new EstagiarioEstagioModel($em);
        $param['cgm_estagiario'] = $estagiarioEstagio->getCgmEstagiario();
        $param['cod_curso'] = $estagiarioEstagio->getCodCurso();
        $param['cgm_instituicao_ensino'] = $estagiarioEstagio->getCgmInstituicaoEnsino();
        $codEstagio = $estagiarioEstagioModel->getNextCodConfiguracao($param);

        $orgaoNivel = $this->getOrgaoSelected();

        $estagiarioEstagio
            ->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao())
            ->setCodEstagio($codEstagio)
            ->setNumeroEstagio($codEstagio);
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function postPersist($estagiarioEstagio)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $local = $form->get('local')->getData();
        $intermediadora = $form->get('intermediadoraEstagios')->getData();
        $faltas = $form->get('faltas')->getData();
        $valorBolsa = $form->get('valorBolsa')->getData();
        $codBanco = $form->get('codBanco')->getData();
        $codAgencia = $form->get('codAgencia')->getData();
        $numConta = $form->get('numConta')->getData();

        if (!is_null($codAgencia)) {
            $estagiarioEstagioContaModel = new EstagiarioEstagioContaModel($em);
            $estagiarioEstagioContaModel->saveEstagiarioEstagioConta($estagiarioEstagio, $codAgencia, $numConta, $codBanco);
        }

        if (!is_null($local)) {
            $estagiarioEstagioModel = new EstagiarioEstagioLocalModel($em);
            $estagiarioEstagioModel->saveEstagiarioEstagioLocal($local, $estagiarioEstagio);
        }

        if (!is_null($intermediadora)) {
            $entidadeIntermediadoraEstagio = new EntidadeIntermediadoraEstagioModel($em);
            $entidadeIntermediadoraEstagio->saveEntidadeIntermediadoraEstagio($estagiarioEstagio, $intermediadora);
        }

        if (!is_null($valorBolsa)) {
            $vlBolsa = $estagiarioEstagio->getFkEstagioCursoInstituicaoEnsino()->getVlBolsa();

            $estagiarioEstagioBolsaModel = new EstagiarioEstagioBolsaModel($em);
            $estagiarioEstagioBolsaModel->saveEstagiarioEstagioBolsa($estagiarioEstagio, $faltas, $vlBolsa);
        }

        $this->redirectToUrl("/recursos-humanos/estagio/estagiario/{$this->getObjectKey($estagiarioEstagio->getFkEstagioEstagiario())}/show");
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function postRemove($estagiarioEstagio)
    {
        $this->redirectToUrl("/recursos-humanos/estagio/estagiario/{$this->getObjectKey($estagiarioEstagio->getFkEstagioEstagiario())}/show");
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     * @return string
     */
    public function toString($estagiarioEstagio)
    {
        $result = $estagiarioEstagio->getFkEstagioCursoInstituicaoEnsino()->getFkEstagioInstituicaoEnsino()->getFkSwCgmPessoaJuridica()->getNomFantasia();
        $result .= " - ".$estagiarioEstagio->getFkEstagioCursoInstituicaoEnsino()->getFkEstagioCurso()->getNomCurso();

        return $result;
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function preUpdate($estagiarioEstagio)
    {
        $form = $this->getForm();
        $vinculoUpdate = $form->get('vinculoUpdate')->getData();

        $estagiarioEstagio
            ->setVinculoEstagio($vinculoUpdate);
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     */
    public function postUpdate($estagiarioEstagio)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $codBanco = $form->get('codBanco')->getData();
        $codAgencia = $form->get('codAgencia')->getData();
        $numConta = $form->get('numConta')->getData();

        if (is_null($estagiarioEstagio->getFkEstagioEstagiarioEstagioConta()) && !is_null($codAgencia)) {
            $estagiarioEstagioContaModel = new EstagiarioEstagioContaModel($em);
            $estagiarioEstagioContaModel->saveEstagiarioEstagioConta($estagiarioEstagio, $codAgencia, $numConta, $codBanco);
        }

        $this->redirectToUrl("/recursos-humanos/estagio/estagiario/{$this->getObjectKey($estagiarioEstagio->getFkEstagioEstagiario())}/show");
    }

    /**
     * @param EstagiarioEstagio $estagiarioEstagio
     * @return array
     */
    private function recuperaDadosForm(EstagiarioEstagio $estagiarioEstagio)
    {
        $dados = [];

        if (!is_null($estagiarioEstagio->getCodEstagio())) {
            // Instituição Ensino
            $instiuicaoEnsinoValue = $estagiarioEstagio
                                        ->getFkEstagioCursoInstituicaoEnsino()
                                        ->getNumcgm();

            $instiuicaoEnsinoKey = (string) $estagiarioEstagio
                                                ->getFkEstagioCursoInstituicaoEnsino()
                                                ->getFkEstagioInstituicaoEnsino();

            $dados['instituicaoEnsino'] = [
                "val" => $instiuicaoEnsinoValue,
                "key_val" => [
                    $instiuicaoEnsinoKey => $instiuicaoEnsinoValue
                ]
            ];

            // Código do Estágio
            $instiuicaoEnsino[(string) $estagiarioEstagio
                ->getFkEstagioCursoInstituicaoEnsino()
                ->getFkEstagioInstituicaoEnsino()] = $estagiarioEstagio
                                                        ->getFkEstagioCursoInstituicaoEnsino()
                                                        ->getNumcgm();

            $dados['estagio'] = $estagiarioEstagio->getCodEstagio();

            // Curso
            $cursoValue = $estagiarioEstagio->getCodCurso();

            $cursoKey = (string) $cursoValue." - ".$estagiarioEstagio
                    ->getFkEstagioCursoInstituicaoEnsino()
                    ->getFkEstagioCurso()
                    ->getNomCurso();

            $dados['curso'] = [
                "val" => $cursoValue,
                "key_val" => [
                    $cursoKey => $cursoValue
                ]
            ];

            // Grau
            $grauValue = $estagiarioEstagio
                            ->getFkEstagioCursoInstituicaoEnsino()
                            ->getFkEstagioCurso()
                            ->getFkEstagioGrau()
                            ->getCodGrau();

            $grauKey = (string) $grauValue." - ";
            $grauKey .= (string) $estagiarioEstagio
                                    ->getFkEstagioCursoInstituicaoEnsino()
                                    ->getFkEstagioCurso()
                                    ->getFkEstagioGrau()
                                    ->getDescricao();

            $dados['grau'] = [
                "val" => $grauValue,
                "key_val" => [
                    $grauKey => $grauValue
                ]
            ];

            // Bolsa
            $dados['vlBolsa'] = $estagiarioEstagio
                                    ->getFkEstagioCursoInstituicaoEnsino()
                                    ->getVlBolsa();

            if ($estagiarioEstagio->getFkEstagioEstagiarioEstagioLocal()) {
                $dados['local'] = $estagiarioEstagio
                                        ->getFkEstagioEstagiarioEstagioLocal()
                                        ->getFkOrganogramaLocal();
            }

            // Monta JS com base no órgão cadastrado para este usuário
            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao($estagiarioEstagio->getFkOrganogramaOrgao()->getCodOrgao())
            );

            $dados['mesAvaliacao'] = $estagiarioEstagio
                                            ->getFkEstagioCursoInstituicaoEnsino()
                                            ->getFkEstagioCursoInstituicaoEnsinoMes()
                                            ->getFkAdministracaoMes()
                                            ->getDescricao();
        } else {
            $dados = null;
        }

        if ($estagiarioEstagio->getFkEstagioEntidadeIntermediadoraEstagios()->last()) {
            $dados['entidadeIntermediadora'] = $estagiarioEstagio
                                                    ->getFkEstagioEntidadeIntermediadoraEstagios()
                                                    ->last()
                                                    ->getFkEstagioEntidadeIntermediadora();
        }

        if ($estagiarioEstagio->getFkEstagioEstagiarioEstagioBolsas()->first()) {
            $dados['falta'] = $estagiarioEstagio->getFkEstagioEstagiarioEstagioBolsas()->first()->getFaltas();
        }

        if ($estagiarioEstagio->getFkEstagioEstagiarioEstagioLocal()) {
            $dados['local'] = $estagiarioEstagio->getFkEstagioEstagiarioEstagioLocal()->getFkOrganogramaLocal();
        }

        if ($estagiarioEstagio->getFkEstagioEstagiarioEstagioConta()) {
            $dados['codBanco'] = $estagiarioEstagio
                                    ->getFkEstagioEstagiarioEstagioConta()
                                    ->getFkMonetarioAgencia()
                                    ->getFkMonetarioBanco();

            $dados['codAgencia'] = $estagiarioEstagio->getFkEstagioEstagiarioEstagioConta()->getFkMonetarioAgencia();

            $dados['numConta'] = $estagiarioEstagio
                                    ->getFkEstagioEstagiarioEstagioConta()
                                    ->getFkMonetarioAgencia()
                                    ->getFkMonetarioContaCorrentes()->first();
        }

        if ($estagiarioEstagio->getVinculoEstagio()) {
            $dados['vinculoUpdate'] = $estagiarioEstagio->getVinculoEstagio();
        }

        return $dados;
    }
}
