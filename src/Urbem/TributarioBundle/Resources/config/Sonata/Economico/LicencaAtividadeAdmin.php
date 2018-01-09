<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Admin\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;
use Urbem\CoreBundle\Entity\Economico\ProcessoLicenca;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Economico\AtividadeCadastroEconomicoModel;
use Urbem\CoreBundle\Model\Economico\LicencaAtividadeModel;
use Urbem\CoreBundle\Model\Economico\LicencaDocumentoModel;
use Urbem\CoreBundle\Model\Economico\LicencaModel;
use Urbem\CoreBundle\Model\Economico\LicencaObservacaoModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LicencaAtividadeAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class LicencaAtividadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_licenca_licenca_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/licenca/licenca-atividade';
    protected $includeJs = array(
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/economico/licenca-atividade.js'
    );

    const MODELO_DOCUMENTO_TIPO_ALVARA = 1;
    const ALVARA_ATIVIDADE = 'alvara_atividade';
    const ALVARA_SANITARIO_ATIVIDADE = 'Alvará Sanitário - por atividade';

    /**
     * @param LicencaAtividade $licencaAtividade
     * @return BaixaLicenca|null
     */
    public function getSuspensao(LicencaAtividade $licencaAtividade)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(BaixaLicenca::class)->createQueryBuilder('o');

        $qb->andWhere('o.codLicenca = :codLicenca');
        $qb->setParameter('codLicenca', $licencaAtividade->getCodLicenca());

        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $licencaAtividade->getExercicio());

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
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('imprimir', 'imprimir/' . $this->getRouterIdParameter());
        $collection->add('show_licenca_atividades', sprintf('%s/show-licenca-atividades', $this->getRouterIdParameter()));
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
            ]);
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
            ],
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
                'class' => 'select2-parameters select-modelo '
            ]
        ];

        $repositoryModeloArqDocumento = $this->getDoctrine()->getRepository(ModeloArquivosDocumento::class);
        $alvarasDisponiveis = array(
            'sanitario' => self::ALVARA_SANITARIO_ATIVIDADE,
            'atividade' => self::ALVARA_ATIVIDADE
        );
        $modelosArqDoc = $repositoryModeloArqDocumento->getModeloArqDocumento(self::MODELO_DOCUMENTO_TIPO_ALVARA, $alvarasDisponiveis);
        $fieldOptions['modelo']['placeholder'] = 'label.selecione';
        $modelos = ArrayHelper::parseArrayToChoice($modelosArqDoc, 'cod_arquivo', 'nome_arquivo_swx');
        $fieldOptions['modelo']['choices'] = $modelos;
        $fieldOptions['modelo']['choice_label'] = function ($v) {
            return $v;
        };

        $formMapper
            ->with('label.economico.licenca.dadosLicenca');

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
                    'label' => 'label.economico.licenca.dataTermino',
                    'required' => false
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
        $atividadeModel = new AtividadeCadastroEconomicoModel($em);

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
                        $choiceValue = $processo->cod_processo . '~' . $processo->ano_exercicio;

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

        $formMapper->getFormBuilder()->addEventListener(
          FormEvents::PRE_SUBMIT,
          function (FormEvent $event) use ($formMapper, $admin, $em) {
              $form = $event->getForm();
              $data = $event->getData();

              $qb = $em->getRepository(CadastroEconomico::class)->createQueryBuilder('ce');
              $qb->leftJoin(
                  CadastroEconomicoAutonomo::class,
                  'cea',
                  'WITH',
                  sprintf('%s.inscricaoEconomica = cea.inscricaoEconomica', $qb->getRootAlias())
              );
              $qb->leftJoin(
                  CadastroEconomicoEmpresaFato::class,
                  'ceef',
                  'WITH',
                  sprintf('%s.inscricaoEconomica = ceef.inscricaoEconomica', $qb->getRootAlias())
              );
              $qb->leftJoin(
                  CadastroEconomicoEmpresaDireito::class,
                  'ceed',
                  'WITH',
                  sprintf('%s.inscricaoEconomica = ceed.inscricaoEconomica', $qb->getRootAlias())
              );

              $qb->join(
                  SwCgm::class,
                  'cgm',
                  'WITH',
                  'cgm.numcgm = COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm)'
              );

              $qb->where('LOWER(cgm.nomCgm) LIKE :nomCgm');
              $qb->orWhere('cgm.numcgm = :numcgm');
              $qb->orWhere('cgm.numcgm = :numcgm');
              $qb->orWhere(sprintf('%s.inscricaoEconomica = :inscricaoEconomica', $qb->getRootAlias()));

              $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($data['inscricaoEconomica'])));
              $qb->setParameter('numcgm', sprintf('%d', $data['inscricaoEconomica']));
              $qb->setParameter('inscricaoEconomica', sprintf('%d', $data['inscricaoEconomica']));

              $qb->orderBy('cgm.nomCgm', 'ASC');

              foreach ((array) $qb->getQuery()->getResult() as $inscricaoEconomica) {
                  $dados[$inscricaoEconomica->getInscricaoEconomica()] = (string) $inscricaoEconomica;
              }

              $comInscricaoEconomica = $formMapper->getFormBuilder()
                  ->getFormFactory()
                  ->createNamed('inscricaoEconomica', 'choice', null, [
                      'label' => 'label.economico.licenca.inscricaoEconomica',
                      'attr' => ['class' => 'select2-parameters '],
                      'auto_initialize' => false,
                      'choices' => array_flip($dados),
                      'mapped' => false
                  ]

                  );

              $form->add($comInscricaoEconomica);

          }
        );

        $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formMapper, $ids_Atividade, $atividadeModel) {
                $form = $event->getForm();
                if ($ids_Atividade) {
                    $atividades = explode(',', $ids_Atividade);

                    $dados = array();
                    foreach($atividades as $codAtividade) {
                        $dados[$codAtividade] = $codAtividade;
                    }

                    $comAtividade = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAtividade','choice', null, [
                            'attr' => ['class' => 'select2-parameters hidden'],
                            'choices' => $dados,
                            'label' => false,
                            'auto_initialize' => false,
                            'mapped' => false
                        ]);
                    $form->add($comAtividade);
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
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');

        if (!$ids_Atividade && $this->isCurrentRoute('create')) {
            $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.atividade');
            $errorElement->with('fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        if ($ids_Atividade) {
            $atividades = explode(',', $ids_Atividade);
            $isPrincipal = false;

            foreach ($atividades as $codAtividade) {
                $atividadeCadastroEconomico = $em->getRepository(AtividadeCadastroEconomico::class)
                    ->findOneByCodAtividade($codAtividade);

                if ($atividadeCadastroEconomico) {
                    $licencaAtividade = $em->getRepository(LicencaAtividade::class)
                        ->findOneBy(['inscricaoEconomica' => $object->getinscricaoEconomica(), 'exercicio' => $this->getExercicio(), 'codAtividade' => $codAtividade]);

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
                    if ($licencaAtividade) {
                        $idAtividades[] = $codAtividade = $codAtividade;
                    }
                }
            }

            if (isset($idAtividades) && $this->isCurrentRoute('create')) {
                $mensagem = $this->getTranslator()->trans(
                    'label.economico.licenca.validate.atividadeUso',
                    [ '%codAtividade%' => implode(", ", $idAtividades) ]
                );
                $errorElement->with('fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if (!$isPrincipal && $this->isCurrentRoute('create')) {
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

        if($this->isCurrentRoute('create')){
            $ids_Atividade = $this->getRequest()->request->get('ids_CodAtividade');
            $atividades = explode(',', $ids_Atividade);
            $licencaAtividadeModel = new LicencaAtividadeModel($em);
            $licencaAtividadeModel->updateLicencaAtividades($object, $atividades, $licenca->getCodLicenca());
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $licencaAtividadeModel = new LicencaAtividadeModel($em);
        $licencaModel = new LicencaModel($em);
        $licenca = new Licenca();
        $codLicenca = $licencaModel->getLastLicencaByExercicio($this->getExercicio());
        $licenca->setCodLicenca($codLicenca);
        $licenca->setExercicio($this->getExercicio());
        $licenca->setDtInicio($object->getDtInicio());
        $licenca->setDtTermino($object->getDtTermino());
        $licencaModel->save($licenca);

        $container = $this->getContainer();

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
        $ocorrenciaLicenca = $licencaAtividadeModel->getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica);
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
        $licencaAtividadeModel->saveLicencaAtividades($object, $atividades);
        $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.economico.licenca.sucesso', [
            '%codigo%' => $licenca->getCodLicenca()
        ]));
    }
}
