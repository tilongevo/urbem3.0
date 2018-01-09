<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\DiasSemana;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Economico\LicencaEspecial;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;
use Urbem\CoreBundle\Entity\Economico\ProcessoLicenca;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Economico\LicencaAtividadeModel;
use Urbem\CoreBundle\Model\Economico\LicencaDiasSemanaModel;
use Urbem\CoreBundle\Model\Economico\LicencaDocumentoModel;
use Urbem\CoreBundle\Model\Economico\LicencaEspecialModel;
use Urbem\CoreBundle\Model\Economico\LicencaModel;
use Urbem\CoreBundle\Model\Economico\LicencaObservacaoModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LicencaEspecialAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class LicencaEspecialAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_licenca_licenca_especial';
    protected $baseRoutePattern = 'tributario/cadastro-economico/licenca/licenca-especial';
    protected $includeJs = array(
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/economico/licenca-especial.js'
    );

    const MODELO_DOCUMENTO_TIPO_ALVARA = 1;
    const ALVARA_HORARIO_ESPECIAL = 'alvara_horario_especial';
    const ALVARA_SANITARIO_HORARIO_ESPECIAL = 'Alvará Sanitário - horário especial';

    /**
    * @param LicencaEspecial $licencaEspecial
    * @return BaixaLicenca|null
    */
    public function getSuspensao(LicencaEspecial $licencaEspecial)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(BaixaLicenca::class)->createQueryBuilder('o');

        $qb->andWhere('o.codLicenca = :codLicenca');
        $qb->setParameter('codLicenca', $licencaEspecial->getCodLicenca());

        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $licencaEspecial->getExercicio());

        $qb->andWhere('o.codTipo = :codTipo');
        $qb->setParameter('codTipo', BaixaLicencaAdmin::TIPO_SUSPENSAO);

        $qb->andWhere('(o.dtTermino IS NULL OR o.dtTermino > CURRENT_DATE())');

        $qb->orderBy('o.timestamp', 'DESC');

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            sprintf(
                '(SELECT COUNT(0) FROM %s bl WHERE bl.codLicenca = o.codLicenca AND bl.exercicio = o.exercicio AND bl.dtTermino IS NULL AND bl.codTipo IN (%d, %d)) = 0',
                BaixaLicenca::class,
                BaixaLicencaAdmin::TIPO_BAIXA,
                BaixaLicencaAdmin::TIPO_CASSACAO
            )
        );

        $query->andWhere('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        return $query;
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('imprimir', 'imprimir/'.$this->getRouterIdParameter());
        $collection->add('show_licenca_especial', sprintf('%s/show-licenca-especial', $this->getRouterIdParameter()));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codLicenca',
                null,
                [
                    'label' => 'label.economico.licenca.codLicenca'
                ]
            )
            ->add(
                'inscricaoEconomica',
                null,
                [
                    'label' => 'label.economico.licenca.inscricaoEconomica'
                ]
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere(sprintf('%s.inscricaoEconomica = :inscricaoEconomica', $alias));
                        $qb->setParameter('inscricaoEconomica', $value['value']);
                    },
                    'label' => 'label.economicoConsultaCadastroEconomico.cgm',
                ],
                'autocomplete',
                [
                    'class' => CadastroEconomico::class,
                    'route' => [
                        'name' => 'tributario_economico_cadastro_economico_api_inscricao_economica'
                    ],
                ]
            );
    }

    /**
     * @return null|string
     */
    public function getDiasSemana($param)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $dias = $em->getRepository(DiasSemana::class)
            ->findAll();
        $line = null;
        if ($param == 'checkbox') {
            foreach ($dias as $d) {
                $line .= "<td class='text-center'>";
                $line .= "<input type='checkbox' class='checkbox-sonata check-dias' name='custom_check_diasSemana[]' value='{$d->getCodDia()}' />";
                $line .= "</td>";
            }
        } elseif ($param == 'dias-semana') {
            foreach ($dias as $d) {
                $line .= "<th class='text-center nomes-dias'>{$d->getNomDia()}</th>";
            }
        }

        return $line;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codLicenca',
                null,
                [
                    'label' => 'label.economico.licenca.codLicenca'
                ]
            )
            ->add(
                'inscricaoEconomica',
                null,
                [
                    'label' => 'label.economico.licenca.inscricaoEconomica'
                ]
            )
            ->add(
                'fkEconomicoAtividadeCadastroEconomico.fkEconomicoAtividade',
                'text',
                [
                    'label' => 'label.economico.licenca.atividade'
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'licenca' => ['template' => 'TributarioBundle:Sonata/Economico/CRUD:list__action_licenca.html.twig'],
                ],
                'header_style' => 'width: 30%',
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions['codLicenca'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'label' => 'label.economico.licenca.numLicenca',
        ];

        $fieldOptions['inscricaoEconomica'] = [
            'label' => 'label.economico.licenca.inscricaoEconomica',
            'route' => [
                'name' => 'tributario_economico_cadastro_economico_api_inscricao_economica'
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'label' => 'label.economico.licenca.classificacao',
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters processo-classificacao'
            )
        ];

        $fieldOptions['fkSwAssunto'] = [
            'label' => 'label.economico.licenca.assunto',
            'class' => SwAssunto::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters processo-assunto'
            )
        ];

        $fieldOptions['processos'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
            'required' => false,
            'placeholder' => 'Selecione',
            'label' => 'label.economico.licenca.processo',
        ];

        $fieldOptions['ocorrenciaLicenca'] = [
            'label' => 'label.economico.licenca.observacoes',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['atividade'] = [
            'label' => false,
            'template' => 'TributarioBundle::Economico/Licenca/atividades.html.twig',
            'data' => null,
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select-atividade '
            ]
        ];

        $fieldOptions['modelo'] = [
            'label' => 'label.economico.licenca.modeloAlvara',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $repositoryModeloArqDocumento = $this->getDoctrine()->getRepository(ModeloArquivosDocumento::class);
        $alvarasDisponiveis = array(
            'sanitario' => self::ALVARA_SANITARIO_HORARIO_ESPECIAL,
            'atividade' => self::ALVARA_HORARIO_ESPECIAL
        );
        $modelosArqDoc = $repositoryModeloArqDocumento->getModeloArqDocumento(self::MODELO_DOCUMENTO_TIPO_ALVARA, $alvarasDisponiveis);
        $fieldOptions['modelo']['placeholder'] = 'label.selecione';
        $modelos = ArrayHelper::parseArrayToChoice($modelosArqDoc, 'cod_arquivo', 'nome_arquivo_swx');
        $fieldOptions['modelo']['choices'] = $modelos;
        $fieldOptions['modelo']['choice_label'] = function ($v) {
            return $v;
        };

        $formMapper
            ->with('label.economico.licencaHorarioEspecial.dadosLicencaHorarioEspecial');

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $fieldOptions['codLicenca']['data'] = $this->getSubject()->getCodLicenca();
            $formMapper->add('codLicenca', null, $fieldOptions['codLicenca']);

            $inscricaoEconomica = $this->getSubject()->getInscricaoEconomica();

            $licencaAtividade = (new LicencaAtividadeModel($em))
                ->getSwCgmByInscricaoEconomica($inscricaoEconomica);
            $licencaAtividade = reset($licencaAtividade);
            $fieldOptions['inscricaoEconomica']['data'] = sprintf('%d - %s', $licencaAtividade['inscricao_economica'], $licencaAtividade['nom_cgm']);
            $fieldOptions['inscricaoEconomica']['disabled'] = true;

            $codLicenca = $this->getSubject()->getCodLicenca();
            $processoLicenca = (new ProcessoLicencaModel($em))
                ->getProcessoLicencaByLicencaAndExercicio($codLicenca, $this->getExercicio());
            if ($processoLicenca) {
                $swProcesso = $processoLicenca->getFkSwProcesso();
                $fieldOptions['fkSwClassificacao']['data'] = $swProcesso->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $swProcesso->getFkSwAssunto();
                $fieldOptions['processos']['placeholder'] = (string) $swProcesso;
            }

            $fieldOptions['fkSwClassificacao']['disabled'] = true;
            $fieldOptions['fkSwAssunto']['disabled'] = true;
            $fieldOptions['processos']['disabled'] = true;

            $licencaObservacao = (new LicencaObservacaoModel($em))
                ->getLicencaObservacaoCodLicencaExercicio($codLicenca, $this->getExercicio());
            if ($licencaObservacao) {
                $fieldOptions['ocorrenciaLicenca']['data'] = $licencaObservacao->getObservacao();
            }
            $licencaDocumento = $em->getRepository(LicencaDocumento::class)
                ->findOneByCodLicenca($codLicenca);
            if ($licencaDocumento) {
                $codArquivo = $licencaDocumento->getNumAlvara();
                $repositoryModeloArqDocumento = $this->getDoctrine()->getRepository(ModeloArquivosDocumento::class);
                $res = $repositoryModeloArqDocumento->getModeloArqDocumentoByCodArquivo($codArquivo);
                $fieldOptions['modelo']['choice_attr'] = function ($nomeArquivo, $key, $index) use ($res) {
                    foreach ($res as $modArq) {
                        if ($modArq['nome_arquivo_swx'] == $nomeArquivo) {
                            return ['selected' => 'selected'];
                        }
                    }
                    return ['selected' => false];
                };
                $fieldOptions['modelo']['placeholder'] = false;
            }
        }

        $formMapper
                ->add(
                    'inscricaoEconomica',
                    'autocomplete',
                    $fieldOptions['inscricaoEconomica']
                )
                ->add(
                    'fkEconomicoLicenca.fkEconomicoLicencaObservacao.observacao',
                    'textarea',
                    $fieldOptions['ocorrenciaLicenca']
                )
            ->end()
            ->with('label.economico.licenca.processo')
                ->add(
                    'codClassificacao',
                    'entity',
                    $fieldOptions['fkSwClassificacao']
                )
                ->add(
                    'codAssunto',
                    'entity',
                    $fieldOptions['fkSwAssunto']
                )
                ->add(
                    'codProcesso',
                    'entity',
                    $fieldOptions['processos']
                )
            ->end()
            ->with('label.economico.licenca.validadeLicenca')
                ->add(
                    'dtInicio',
                    'sonata_type_date_picker',
                    [
                        'format' => 'dd/MM/yyyy',
                        'label' => 'label.economico.licenca.dataInicio',
                    ]
                )
                ->add(
                    'dtTermino',
                    'sonata_type_date_picker',
                    [
                        'format' => 'dd/MM/yyyy',
                        'label' => 'label.economico.licenca.dataTermino'
                    ]
                )
            ->end()
            ->with('label.economico.licenca.dadosAtividades')
                ->add(
                    'fkEconomicoAtividadeCadastroEconomico.fkEconomicoAtividade',
                    'customField',
                    $fieldOptions['atividade']
                )
            ->end()
            ->with('label.economico.licencaHorarioEspecial.dadosLicencaExercicioAtividades')
                ->add(
                    'diasSemana',
                    'customField',
                    [
                        'label' => false,
                        'template' => 'TributarioBundle::Economico/Licenca/diasSemana.html.twig',
                        'mapped' => false,
                        'data' => null
                    ]
                )
            ->end()
            ->with('label.economico.licenca.cabecalhoModelo')
                ->add(
                    'fkEconomicoLicenca.fkEconomicoLicencaDocumentos.fkAdministracaoModeloDocumentos',
                    'choice',
                    $fieldOptions['modelo']
                )
            ->end();

        if (!$this->isCurrentRoute('create')) {
            return;
        }

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new SwAssuntoModel($em);
        $admin = $this;

        //codAssunto
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.codAssunto',
                            'mapped' => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );
        //codProcesso
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $processoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (strpos($data['codAssunto'], '~')) {
                    list($codAssunto, $codClassificacao) = explode('~', $data['codAssunto']);
                } else {
                    $codAssunto = $data['codAssunto'];
                    $codClassificacao = $data['codClassificacao'];
                }

                if (isset($data['codProcesso']) && $data['codProcesso'] != "") {
                    $processos = $processoModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $processoCompleto = $processo->cod_processo_completo;
                        $processoAssunto = " | " . $processo->nom_assunto;

                        $choiceKey = $processoCompleto . $processoAssunto;
                        $choiceValue = $processo->cod_processo.'~'.$processo->ano_exercicio;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comProcesso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codProcesso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.procAdministrativo',
                            'mapped' => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codLicenca')
            ->add('exercicio')
            ->add('codAtividade')
            ->add('inscricaoEconomica')
            ->add('ocorrenciaAtividade')
            ->add('ocorrenciaLicenca')
            ->add('dtInicio')
            ->add('dtTermino');
    }

    /**
     * @param $hora
     * @return \DateTime|string
     */
    public function normalizaHora($hora)
    {
        $hora .= ':00';
        $hora = new \DateTime((string) $hora, new \DateTimeZone('UTC'));

        return $hora;
    }


    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');
        if ($ids_Atividade == '') {
            $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.atividade');
            $errorElement->with('fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
        $atividades = explode(',', $ids_Atividade);
        $isPrincipal = false;
        foreach ($atividades as $codAtividade) {
            $atividadeCadastroEconomico = $em->getRepository(AtividadeCadastroEconomico::class)
                ->findOneByCodAtividade($codAtividade);
            if ($atividadeCadastroEconomico) {
                $dtInicioAtividade = $atividadeCadastroEconomico->getDtInicio();
                $dtTerminoAtividade = $atividadeCadastroEconomico->getDtTermino();

                if ($dtInicioAtividade) {
                    if ($object->getDtInicio() < $dtInicioAtividade) {
                        $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.dataInicioAtividade');
                        $errorElement->with('dtInicio')->addViolation($mensagem)->end();
                        $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                    }
                }
                if ($dtTerminoAtividade) {
                    if ($object->getDtTermino() >= $dtTerminoAtividade) {
                        $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.dataTerminoAtividade');
                        $errorElement->with('dtTermino')->addViolation($mensagem)->end();
                        $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                    }
                }

                if ($atividadeCadastroEconomico->getPrincipal() && !$isPrincipal) {
                    $isPrincipal = true;
                }
            }
        }
        if (!$isPrincipal) {
            $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.licencaAtividade');
            $errorElement->with('fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
        $dataTermino = ($object) ? $object->getDtTermino() : null;
        if ($dataTermino) {
            if ($object->getDtInicio() >= $object->getDtTermino()) {
                $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.dataTermino');
                $errorElement->with('dtTermino')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        }

        $ids_HorariosSelecionados = $this->getRequest()->request->get('ids_HorariosSelecionados');
        if (stripos($ids_HorariosSelecionados, ',')) {
            $ids_HorariosSelecionados_arr = explode(',', $ids_HorariosSelecionados);
        } else {
            $ids_HorariosSelecionados_arr = array();
            array_push($ids_HorariosSelecionados_arr, $ids_HorariosSelecionados);
        }
        for ($i=0; $i<count($ids_HorariosSelecionados_arr); $i++) {
            if ($ids_HorariosSelecionados_arr[$i] != '') {
                list($codDia, $hrInicio, $hrTermino) = explode(';', $ids_HorariosSelecionados_arr[$i]);
                $hrInicio = $this->normalizaHora($hrInicio);
                $hrTermino = $this->normalizaHora($hrTermino);
                if ($hrInicio > $hrTermino) {
                    $mensagem = $this->getTranslator()->trans('label.economico.licencaHorarioEspecial.validate.horarioTermino');
                    $errorElement->with('diasSemana')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fklicenca = $object->getFkEconomicoLicenca();
        $licencaModel = new LicencaModel($em);
        $licenca = $em->getRepository(Licenca::class)
            ->findOneBy(['codLicenca' => $fklicenca->getCodLicenca(), 'exercicio' => $this->getExercicio()]);
        $licenca->setDtInicio($object->getDtInicio());
        $licenca->setDtTermino($object->getDtTermino());
        $object->setFkEconomicoLicenca($licenca);
        $licencaModel->update($licenca);

        $observacao = $this->getForm()
            ->get('fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao')->getData();
        if ($observacao) {
            $licencaObservacao = $em->getRepository(LicencaObservacao::class)
                ->findOneBy(['codLicenca' => $fklicenca->getCodLicenca(), 'exercicio' => $this->getExercicio()]);
            $licencaObservacaoModel = new LicencaObservacaoModel($em);
            if ($licencaObservacao) {
                $licencaObservacao->setObservacao($observacao);
                $licencaObservacaoModel->update($licencaObservacao);
            } else {
                $licencaObservacao = new LicencaObservacao();
                $licencaObservacao->setObservacao($observacao);
                $licencaObservacao->setFkEconomicoLicenca($licenca);
                $licencaObservacaoModel->save($licencaObservacao);
            }
        }

        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);
        $licencaDocumentoModel = new LicencaDocumentoModel($em);
        $nomDocumento = $formData['fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos'];
        $arquivoDocumento = $em->getRepository(ArquivosDocumento::class)
            ->findOneBy(['nomeArquivoSwx' => $nomDocumento]);
        $modeloArquivoDocumento = $em->getRepository(ModeloArquivosDocumento::class)
            ->findOneBy(['codArquivo' => $arquivoDocumento->getCodArquivo()]);
        $licencaDocumento = $em->getRepository(LicencaDocumento::class)
            ->findOneBy(['codLicenca' => $fklicenca->getCodLicenca(), 'exercicio' => $this->getExercicio(), 'codTipoDocumento' => self::MODELO_DOCUMENTO_TIPO_ALVARA]);
        $modeloDocumento = $em->getRepository(ModeloDocumento::class)
            ->findOneBy(['codDocumento' => $modeloArquivoDocumento->getCodDocumento(), 'codTipoDocumento' => self::MODELO_DOCUMENTO_TIPO_ALVARA]);
        $licencaDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
        $licencaDocumento->setFkEconomicoLicenca($licenca);
        $licencaDocumento->setNumAlvara($arquivoDocumento->getCodArquivo());
        $licencaDocumentoModel->update($licencaDocumento);

        $ids_HorariosSelecionados = $this->getRequest()->request->get('ids_HorariosSelecionados');
        if (stripos($ids_HorariosSelecionados, ',')) {
            $ids_HorariosSelecionados_arr = explode(',', $ids_HorariosSelecionados);
        } else {
            $ids_HorariosSelecionados_arr = array();
            array_push($ids_HorariosSelecionados_arr, $ids_HorariosSelecionados);
        }

        $licDiasSemanaArr = array();
        $licencaDiasSemanaModel = new LicencaDiasSemanaModel($em);
        for ($i=0; $i<count($ids_HorariosSelecionados_arr); $i++) {
            if ($ids_HorariosSelecionados_arr[$i] != '') {
                list($diaSemana, $hrInicio, $hrTermino) = explode(';', $ids_HorariosSelecionados_arr[$i]);
                $hrInicio = $this->normalizaHora($hrInicio);
                $hrTermino = $this->normalizaHora($hrTermino);
                $dia = $em->getRepository(DiasSemana::class)
                    ->findOneByCodDia($diaSemana);
                $licencaDiasSemana = $em->getRepository(LicencaDiasSemana::class)
                    ->findBy(['codLicenca' => $fklicenca->getCodLicenca(), 'exercicio' => $this->getExercicio()]);
                if ($licencaDiasSemana) {
                    foreach ($licencaDiasSemana as $lds) {
                        $licencaDiasSemanaModel->remove($lds);
                    }
                }
                $licDiasSemana = new LicencaDiasSemana();
                $licDiasSemana->setExercicio($this->getExercicio());
                $licDiasSemana->setFkEconomicoLicenca($licenca);
                $licDiasSemana->setHrInicio($hrInicio);
                $licDiasSemana->setHrTermino($hrTermino);
                $licDiasSemana->setFkAdministracaoDiasSemana($dia);
                array_push($licDiasSemanaArr, $licDiasSemana);
            }
        }
        $licencaDiasSemanaModel->updateLicenca($licDiasSemanaArr);

        $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');
        $atividades = explode(',', $ids_Atividade);
        $licencaEspecialModel = new LicencaEspecialModel($em);
        $licencaEspecialModel->updateLicencaEspecial($object, $atividades, $licenca->getCodLicenca());
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {

        $em = $this->modelManager->getEntityManager($this->getClass());
        $licencaEspecialModel = new LicencaEspecialModel($em);
        $licencaModel = new LicencaModel($em);
        $licenca = new Licenca();
        $codLicenca = $licencaModel->getLastLicencaByExercicio($this->getExercicio());
        $licenca->setCodLicenca($codLicenca);
        $licenca->setExercicio($this->getExercicio());
        $licenca->setDtInicio($object->getDtInicio());
        $licenca->setDtTermino($object->getDtTermino());
        $licencaModel->save($licenca);

        $object->setFkEconomicoLicenca($licenca);

        $codProcesso = $this->getForm()
            ->get('codProcesso')->getData();
        if ($codProcesso) {
            $codProcesso = explode('~', $codProcesso);
            $swProcesso = $em->getRepository(SwProcesso::class)
                ->findOneBy(['codProcesso' => $codProcesso[0], 'anoExercicio' => $codProcesso[1]]);
            $processoLicencaModel = new ProcessoLicencaModel($em);
            $processoLicenca = new ProcessoLicenca();
            $processoLicenca->setFkEconomicoLicenca($licenca);
            $processoLicenca->setFkSwProcesso($swProcesso);
            $processoLicencaModel->save($processoLicenca);
        }

        $observacao = $this->getForm()
            ->get('fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao')->getData();
        if ($observacao) {
            $licencaObservacaoModel = new LicencaObservacaoModel($em);
            $licencaObservacao = new LicencaObservacao();
            $licencaObservacao->setObservacao($observacao);
            $licencaObservacao->setFkEconomicoLicenca($licenca);
            $licencaObservacaoModel->save($licencaObservacao);
        }

        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);
        $inscricaoEconomica = $formData['inscricaoEconomica'];
        $ocorrenciaLicenca = $licencaEspecialModel->getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica);
        $object->setOcorrenciaLicenca(array_shift($ocorrenciaLicenca)['count']);

        $licencaDocumentoModel = new LicencaDocumentoModel($em);
        $nomDocumento = $formData['fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos'];
        $arquivoDocumento = $em->getRepository(ArquivosDocumento::class)
            ->findOneBy(['nomeArquivoSwx' => $nomDocumento]);
        $modeloArquivoDocumento = $em->getRepository(ModeloArquivosDocumento::class)
            ->findOneBy(['codArquivo' => $arquivoDocumento->getCodArquivo()]);
        $licencaDocumento = new LicencaDocumento();
        $modeloDocumento = $em->getRepository(ModeloDocumento::class)
            ->findOneBy(['codDocumento' => $modeloArquivoDocumento->getCodDocumento(), 'codTipoDocumento' => self::MODELO_DOCUMENTO_TIPO_ALVARA]);
        $licencaDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
        $licencaDocumento->setFkEconomicoLicenca($licenca);
        $licencaDocumento->setNumAlvara($arquivoDocumento->getCodArquivo());
        $licencaDocumentoModel->save($licencaDocumento);

        $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');
        $atividades = explode(',', $ids_Atividade);
        $licencaEspecialModel->saveLicencaEspecial($object, $atividades);

        $ids_HorariosSelecionados = $this->getRequest()->request->get('ids_HorariosSelecionados');
        if (stripos($ids_HorariosSelecionados, ',')) {
            $ids_HorariosSelecionados_arr = explode(',', $ids_HorariosSelecionados);
        } else {
            $ids_HorariosSelecionados_arr = array();
            array_push($ids_HorariosSelecionados_arr, $ids_HorariosSelecionados);
        }

        $licencaDiasSemanaModel = new LicencaDiasSemanaModel($em);
        for ($i=0; $i<count($ids_HorariosSelecionados_arr); $i++) {
            if ($ids_HorariosSelecionados_arr[$i] != '') {
                list($diaSemana, $hrInicio, $hrTermino) = explode(';', $ids_HorariosSelecionados_arr[$i]);
                $hrInicio = $this->normalizaHora($hrInicio);
                $hrTermino = $this->normalizaHora($hrTermino);
                $dia = $em->getRepository(DiasSemana::class)
                    ->findOneByCodDia($diaSemana);
                $licencaDiasSemana = new LicencaDiasSemana();
                $licencaDiasSemana->setExercicio($this->getExercicio());
                $licencaDiasSemana->setHrInicio($hrInicio);
                $licencaDiasSemana->setHrTermino($hrTermino);
                $licencaDiasSemana->setFkEconomicoLicenca($licenca);
                $licencaDiasSemana->setFkAdministracaoDiasSemana($dia);
                $licencaDiasSemanaModel->save($licencaDiasSemana);
            }
        }
        $container = $this->getContainer();
        $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.economico.licencaHorarioEspecial.sucesso', [
            '%codigo%' => $licenca->getCodLicenca()
        ]));
    }
}
