<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento;
use Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor;
use Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\BaixaLicenca;
use Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Economico\LicencaDiversaModel;
use Urbem\CoreBundle\Model\Economico\LicencaModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LicencaDiversaAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class LicencaDiversaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_licenca_licenca_diversa';
    protected $baseRoutePattern = 'tributario/cadastro-economico/licenca/licenca-diversa';
    protected $exibirBotaoExcluir = false;
    protected $includeJs = [
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/economico/licenca-diversa.js'
    ];

    const MODELO_DOCUMENTO_TIPO_ALVARA = 1;

    /**
     * @param LicencaDiversa $licencaDiversa
     * @return BaixaLicenca|null
     */
    public function getSuspensao(LicencaDiversa $licencaDiversa)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(BaixaLicenca::class)->createQueryBuilder('o');

        $qb->andWhere('o.codLicenca = :codLicenca');
        $qb->setParameter('codLicenca', $licencaDiversa->getCodLicenca());

        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $licencaDiversa->getExercicio());

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
            );
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('imprimir', 'imprimir/' . $this->getRouterIdParameter());
        $collection->add('api_elemento_tipo_licenca', 'api/elementos-tipo-licenca');
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
                'fkEconomicoTipoLicencaDiversa',
                'text',
                [
                    'label' => 'label.economico.outrasLicencas.tipoLicenca'
                ]
            )
            ->add(
                'fkSwCgm',
                null,
                [
                    'label' => 'cgm'
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

        $fieldOptions['swcgm'] = [
            'label' => 'label.cgm',
            'mapped' => false,
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

        $fieldOptions['licencaObservacao'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economico.licenca.observacoes',
        ];

        $fieldOptions['modelo'] = [
            'class' => ArquivosDocumento::class,
            'mapped' => false,
            'choice_value' => 'codArquivo',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters modelo-documento '
            ],
            'label' => 'label.economico.licenca.modeloAlvara',
        ];

        $fieldOptions['dtInicio'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economico.licenca.dataInicio',
            'mapped' => false,
            'data' => null
        ];

        $fieldOptions['dtTermino'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economico.licenca.dataTermino',
            'required' => false,
            'mapped' => false,
            'data' => null
        ];

        $formMapper
            ->with('label.economico.licenca.dadosLicenca');

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $fieldOptions['codLicenca']['data'] = $this->getSubject()->getCodLicenca();
            $formMapper->add('codLicenca', null, $fieldOptions['codLicenca']);

            $numCgm = $this->getSubject()->getNumCgm();
            $swCgm = $em->getRepository(SwCgm::class)
                ->findOneByNumcgm($numCgm);
            $fieldOptions['swcgm']['data'] = $swCgm;
            $fieldOptions['swcgm']['disabled'] = true;

            $processoLicenca = (new ProcessoLicencaModel($em))
                ->getProcessoLicencaByLicencaAndExercicio($this->getSubject()->getCodLicenca(), $this->getExercicio());
            if ($processoLicenca) {
                $swProcesso = $em->getRepository(SwProcesso::class)
                    ->findOneByCodProcesso($processoLicenca->getCodProcesso());
                $fieldOptions['fkSwClassificacao']['data'] = $swProcesso->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $swProcesso->getFkSwAssunto();
                $fieldOptions['processos']['placeholder'] = (string) $swProcesso;
            }

            $fieldOptions['fkSwClassificacao']['disabled'] = true;
            $fieldOptions['fkSwAssunto']['disabled'] = true;
            $fieldOptions['processos']['disabled'] = true;

            $licenca = $em->getRepository(Licenca::class)
                ->findOneBy(['codLicenca' => $this->getSubject()->getCodLicenca(), 'exercicio' => $this->getSubject()->getExercicio()]);

            if ($licencaObservacao = $licenca->getFkEconomicoLicencaObservacao()) {
                $fieldOptions['licencaObservacao']['data'] = $licencaObservacao->getObservacao();
            }

            $fieldOptions['modelo']['data'] = $licenca->getFkEconomicoLicencaDocumentos()->last()->getFkAdministracaoModeloDocumento()->getFkAdministracaoModeloArquivosDocumentos()->last()->getFkAdministracaoArquivosDocumento();

            $fieldOptions['dtInicio']['data'] = ($licenca) ? $licenca->getDtInicio() : null;
            $fieldOptions['dtTermino']['data'] = ($licenca && $licenca->getDtTermino()) ? $licenca->getDtTermino() : null;
        }

        if (!$this->getSubject()->getCodLicenca()) {
            $formMapper->add(
                'fkEconomicoTipoLicencaDiversa',
                null,
                [
                    'label' => 'label.economico.outrasLicencas.tipoLicenca',
                    'placeholder' => 'label.selecione',
                    'required' => true,
                    'query_builder' => function (EntityRepository $em) {
                        return $em->createQueryBuilder('o')
                            ->orderBy('o.codTipo', 'ASC');
                    },
                ]
            );
        }

        $formMapper
            ->add(
                'swcgm',
                'autocomplete',
                $fieldOptions['swcgm']
            )
            ->add(
                'fkEconomicoLicenca.fkEconomicoLicencaObservacao.observacao',
                'textarea',
                $fieldOptions['licencaObservacao']
            )
            ->end();

        if (!$this->getSubject()->getCodLicenca()) {
            $formMapper
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
                ->end();
        }

        $formMapper
            ->with('label.imobiliarioLicenca.validadeLicenca')
            ->add(
                'fkEconomicoLicenca.dtInicio',
                'sonata_type_date_picker',
                $fieldOptions['dtInicio']
            )
            ->add(
                'fkEconomicoLicenca.dtTermino',
                'sonata_type_date_picker',
                $fieldOptions['dtTermino']
            )
            ->add(
                'modeloDocumento',
                'entity',
                $fieldOptions['modelo']
            )
            ->end();

        if (!$this->getSubject()->getCodLicenca()) {
            $formMapper
                ->with('label.economico.outrasLicencas.elementoBaseCalculo')
                ->add(
                    'fkEconomicoElementoTipoLicencaDiversa',
                    'entity',
                    [
                        'class' => ElementoTipoLicencaDiversa::class,
                        'mapped' => false,
                        'choice_label' => function (ElementoTipoLicencaDiversa $elementoTipoLicencaDiversa) {
                            return (string) $elementoTipoLicencaDiversa->getFkEconomicoElemento()->getNomElemento();
                        },
                        'required' => false,
                        'placeholder' => 'label.selecione',
                        'attr' => [
                            'class' => 'select2-parameters ',
                        ],
                        'label' => 'label.ElementoAtividadeCadastroEconomicoAdmin.elemento',
                    ]
                )
                ->end();
        }

        $formMapper
            ->with('label.economico.outrasLicencas.cabecalhoAtributo')
            ->add('atributosDinamicos', 'text', ['mapped' => false, 'required' => false])
            ->end();

        if (!$this->isCurrentRoute('create')) {
            return;
        }

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new SwAssuntoModel($em);
        $admin = $this;

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
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['documento']['data'] = $this->getSubject()->getFkEconomicoLicenca()->getFkEconomicoLicencaDocumentos()->last()->getFkAdministracaoModeloDocumento()->getNomeArquivoAgt();
        $showMapper
            ->with('label.economico.outrasLicencas.dados')
            ->add('codLicenca', null, array('label' => 'label.economico.licenca.numLicenca'))
            ->add('exercicio', null, array('label' => 'label.exercicio'))
            ->add('_fkEconomicoTipoLicencaDiversa', null, array('label' => 'label.economico.outrasLicencas.tipoLicenca'))
            ->add('fkSwCgm', null, array('label' => 'label.cgm'))
            ->add('fkEconomicoLicenca.fkEconomicoLicencaObservacao.observacao', null, array('label' => 'label.economico.licenca.observacoes'))
            ->add('fkEconomicoLicenca.dtInicio', null, array('label' => 'label.economico.licenca.dataInicio'))
            ->add('fkEconomicoLicenca.dtTermino', null, array('label' => 'label.economico.licenca.dataTermino'))
            ->add('licencasDiversa', 'customField', array('label' => '', 'template' => 'TributarioBundle::Economico/Licenca/show_licencas_diversa.html.twig'))
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $dataInicio = $this->getForm()
            ->get('fkEconomicoLicenca__dtInicio')->getData();
        $dataTermino = $this->getForm()
            ->get('fkEconomicoLicenca__dtTermino')->getData();
        if ($dataTermino) {
            if ($dataInicio >= $dataTermino) {
                $mensagem = $this->getTranslator()->trans('label.economico.licenca.validate.dataTermino');
                $errorElement->with('dtTermino')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $licencaDiversaModel = new LicencaDiversaModel($em);
        $licencaModel = new LicencaModel($em);
        $codLicenca = $licencaModel
            ->getLastLicencaByExercicio($this->getExercicio());
        $dtInicio = $this->getForm()
            ->get('fkEconomicoLicenca__dtInicio')->getData();
        $dtTermino = $this->getForm()
            ->get('fkEconomicoLicenca__dtTermino')->getData();
        $licenca = $licencaModel->saveLicencaDiversa($codLicenca, $this->getExercicio(), $dtInicio, $dtTermino);
        $object->setFkEconomicoLicenca($licenca);

        $codProcesso = $this->getForm()
            ->get('codProcesso')->getData();

        if ($codProcesso) {
            $licencaModel->saveProcessoLicenca($licenca, $codProcesso);
        }

        $observacao = $this->getForm()
            ->get('fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao')->getData();
        if ($observacao) {
            $licencaModel->saveLicencaObservacao($observacao, $licenca);
        }

        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $codArquivo = $formData['modeloDocumento'];
        $licencaModel->saveLicencaDocumento($codArquivo, self::MODELO_DOCUMENTO_TIPO_ALVARA, $licenca);

        $numSwCgm = $formData['swcgm'];
        $result = $licencaDiversaModel->getSwCgmByInscricaoEconomica($numSwCgm);
        $swCgm = $em->getRepository(SwCgm::class)
            ->findOneByNumcgm(array_shift($result)['numcgm']);
        $object->setFkSwCgm($swCgm);

        if ($elementoTipoLicencaDiversa = $this->getForm()->get('fkEconomicoElementoTipoLicencaDiversa')->getData()) {
            $elementoLicencaDiversa = new ElementoLicencaDiversa();
            $elementoLicencaDiversa->setFkEconomicoElementoTipoLicencaDiversa($elementoTipoLicencaDiversa);
            $elementoLicencaDiversa->setOcorrencia(1);

            $object->addFkEconomicoElementoLicencaDiversas($elementoLicencaDiversa);
        }

        foreach ((array) $this->getRequest()->get('atributoDinamico') as $codAtributo => $atributo) {
            $value = array_shift($atributo);
            $atributo = $em->getRepository(AtributoTipoLicencaDiversa::class)->findOneBy(
                [
                    'codAtributo' => $codAtributo,
                    'codTipo' => $this->getForm()->get('fkEconomicoTipoLicencaDiversa')->getData()->getCodTipo(),
                ]
            );

            $atributoLicencaDiversa = new AtributoLicencaDiversaValor();
            $atributoLicencaDiversa->setValor($value);
            $atributoLicencaDiversa->setFkEconomicoAtributoTipoLicencaDiversa($atributo);

            $object->addFkEconomicoAtributoLicencaDiversaValores($atributoLicencaDiversa);
        }
        return (new RedirectResponse(sprintf('/tributario/cadastro-economico/licenca/licenca-diversa/%d~%s/show', $codLicenca, $this->getExercicio())))->send();
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $licencaDiversaModel = new LicencaDiversaModel($em);
        $licencaDiversaModel->emissaoDocumento($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $licenca = $object->getFkEconomicoLicenca();
        $licenca->setDtInicio($this->getForm()->get('fkEconomicoLicenca__dtInicio')->getData());
        $licenca->setDtTermino($this->getForm()->get('fkEconomicoLicenca__dtTermino')->getData());

        if ($this->getForm()->get('fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao')->getData()) {
            $licencaObservacao = $licenca->getFkEconomicoLicencaObservacao() ?: new LicencaObservacao();
            $licencaObservacao->setObservacao($this->getForm()->get('fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao')->getData());
            $licenca->setFkEconomicoLicencaObservacao($licencaObservacao);
        }

        $arquivoDocumento = $this->getForm()->get('modeloDocumento')->getData();
        $licenca->getFkEconomicoLicencaDocumentos()->last()->getFkAdministracaoModeloDocumento()->getFkAdministracaoModeloArquivosDocumentos()->last()->setFkAdministracaoArquivosDocumento($arquivoDocumento);
    }

    /**
     * @param mixed $object
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object->getCodLicenca()
            ? 'success'
            : $this->getTranslator()->trans('label.economico.outrasLicencas.modulo');
    }
}
