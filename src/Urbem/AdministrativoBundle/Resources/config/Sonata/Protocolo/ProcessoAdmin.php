<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Doctrine\ORM\EntityManager;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Urbem\AdministrativoBundle\Controller\Protocolo\ProcessoAdminController;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\SwAndamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwAssuntoAtributo;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwCopiaDigital;
use Urbem\CoreBundle\Entity\SwDocumento;
use Urbem\CoreBundle\Entity\SwDocumentoProcesso;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoInteressado;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\SwAndamentoModel;
use Urbem\CoreBundle\Model\SwAssuntoAtributoValorModel;
use Urbem\CoreBundle\Model\SwCopiaDigitalModel;
use Urbem\CoreBundle\Model\SwDocumentoModel;
use Urbem\CoreBundle\Model\SwDocumentoProcessoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;

/**
 * Class ProcessoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo
 */
class ProcessoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo';
    protected $baseRoutePattern = 'administrativo/protocolo/processo';

    protected $exibirBotaoExcluir = false;

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'anoExercicio'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('perfil', '{id}/perfil', [], ['id' => $this->getRouterIdParameter()])
            ->add('assunto_classificacao', 'assunto-classificacao')
            ->add('documentos_assunto', 'assunto/{id}/documentos')
            ->add('atributo_dinamico', 'assunto/{id}/atributo-dinamico');
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwProcesso');

        $user = $this->getCurrentUser();
        $swProcessoModel = new SwProcessoModel($em);
        $query = $swProcessoModel->getListaProcessosNaoConfidenciais($query);

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codProcesso',
                null,
                [
                    'label' => 'label.processo.codigo'
                ]
            )
            ->add(
                'fkSwAssunto',
                'composite_filter',
                [
                    'label' => 'label.classificacao_assunto'
                ],
                null,
                [
                    'class'         => SwAssunto::class,
                    'choice_label'  => function (SwAssunto $assunto) {
                        return sprintf('%s - %s', $assunto->getFkSwClassificacao()->getNomClassificacao(), $assunto->getNomAssunto());
                    },
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                        $qb = $repository->createQueryBuilder('SwAssunto');
                        $qb->join('SwAssunto.fkSwClassificacao', 'fkSwClassificacao');
                        $qb->addOrderBy('fkSwClassificacao.nomClassificacao', 'ASC');
                        $qb->addOrderBy('SwAssunto.nomAssunto', 'ASC');

                        return $qb;
                    },
                    'multiple'      => false
                ],
                [
                    'admin_code' => 'core.filter.admin.sw_assunto'
                ]
            )
            ->add(
                'timestamp',
                'doctrine_orm_datetime_range',
                [
                    'label' => 'label.periodo',
                    'field_type' => 'sonata_type_date_range_picker',
                ],
                null,
                [
                    'field_options_start' => [
                        'format' => 'dd/MM/yyyy',
                        'label' => false,
                    ],
                    'field_options_end' => [
                        'format' => 'dd/MM/yyyy',
                        'label' => false,
                    ]
                ]
            )
            ->add(
                'fkSwSituacaoProcesso',
                'composite_filter',
                [
                    'label' => 'label.processo.codSituacao'
                ],
                null,
                [
                    'class'         => 'CoreBundle:SwSituacaoProcesso',
                    'choice_label'  => 'nomSituacao',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) {
                        return $repository->createQueryBuilder('u')->orderBy('u.nomSituacao', 'ASC');
                    },
                    'multiple'      => true
                ]
            );
    }

    /**
     * @param SwProcesso $swProcesso
     *
     * @return string
     */
    public function mascaraDoProcesso(SwProcesso $swProcesso)
    {
        return sprintf("%05d/%s", $swProcesso->getCodProcesso(), $swProcesso->getAnoExercicio());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codProcesso')
            ->add('anoExercicio')
            ->add('fkSwProcessoInteressados', null, [
                'associated_property' => function (SwProcessoInteressado $swProcessoInteressado) {
                    return strtoupper($swProcessoInteressado->getFkSwCgm()->getNomCgm());
                },
                'label'               => 'label.processo.interessados',
                'admin_code'          => 'administrativo.admin.sw_processo_interessado'
            ], [
            ])
            ->add('fkSwAssunto.fkSwClassificacao.nomClassificacao', 'text', [
                'label' => 'label.classificacao'
            ])
            ->add('fkSwAssunto.nomAssunto', 'text', [
                'admin_code' => 'core.filter.admin.sw_assunto',
                'label'      => 'label.assunto'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return $this
     */
    private function configureFormFieldsDadosDoProcesso(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/administrativo/javascripts/administracao/processo/classificacao-assunto.js');

        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->getSubject();

        $admin = $this;

        $fieldOptions['swClassificacao'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => SwClassificacao::class,
            'choice_label' => 'nomClassificacao',
            'choices'      => $entityManager->getRepository(SwClassificacao::class)->findBy([], ['nomClassificacao' => 'ASC']),
            'label'        => 'label.classificacao',
            'mapped'       => false,
            'required'     => true,
            'placeholder'  => 'label.selecione'
        ];

        $fieldDescriptionOptions['swClassificacao'] = ['admin_code' => 'administrativo.admin.classificacao'];

        $fieldOptions['fkSwAssunto'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'nomAssunto',
            'choice_value' => function ($swAssunto) use ($admin) {
                return $admin->id($swAssunto);
            },
            'choices'      => $entityManager->getRepository(SwAssunto::class)->findBy([], ['nomAssunto' => 'ASC']),
            'label'        => 'label.assunto',
            'required'     => true,
            'placeholder'  => 'label.selecione'
        ];

        $fieldDescriptionOptions['fkSwAssunto'] = ['admin_code' => 'core.filter.admin.sw_assunto'];

        $fieldOptions['observacoes'] = [
            'label' => 'label.observacoes'
        ];

        // TODO Remover nullable: false do banco. SwProcesso.orm.yml
        $fieldOptions['resumoAssunto'] = [
            'label'    => 'label.processo.assuntoReduzido',
            'required' => false
        ];

        $fieldOptions['confidencial'] = [
            'attr'       => ['class' => 'checkbox-sonata '],
            'choices'    => [
                'sim' => true,
                'nao' => false
            ],
            'expanded'   => true,
            'label'      => 'label.processo.confidencial',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'multiple'   => false,
        ];

        if (!is_null($this->id($swProcesso))) {
            $fieldOptions['swClassificacao']['data'] = $swProcesso->getFkSwAssunto()->getFkSwClassificacao();
        }

        $formMapper
            ->with('label.processo.dadosProcesso')
            ->add('swClassificacao', 'entity', $fieldOptions['swClassificacao'], $fieldDescriptionOptions['swClassificacao'])
            ->add('fkSwAssunto', null, $fieldOptions['fkSwAssunto'], $fieldDescriptionOptions['fkSwAssunto'])
            ->add('observacoes', null, $fieldOptions['observacoes'])
            ->add('resumoAssunto', null, $fieldOptions['resumoAssunto'])
            ->add('confidencial', 'choice', $fieldOptions['confidencial'])
            ->end();

        return $this;
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return $this
     */
    private function configureFormFieldsAtributosDoProcesso(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/administrativo/javascripts/administracao/processo/atributos.js');

        $formMapper->with('label.processo.atributosProcesso', [
            'box_class' => 'row atributosProcesso'
        ]);
        // A rendereização desse campo ocorre com javascript de acordo com o SwAssunto selecionado.
        $formMapper->end();

        return $this;
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return $this
     */
    private function configureFormFieldsDocumentosDoProcesso(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/administrativo/javascripts/administracao/processo/documentos.js');

        $formMapper->with('label.processo.documentosProcesso', [
            'box_class' => 'row documentosProcesso'
        ]);
        // A rendereização desse campo ocorre com javascript de acordo com o SwAssunto selecionado.
        $formMapper->end();

        return $this;
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return $this
     */
    private function configureFormFieldsEncaminhamentoDoProcesso(FormMapper $formMapper)
    {
        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->getSubject();

        $fieldOptions['codOrgao'] = [
            'mapped' => false
        ];

        if (!is_null($this->id($swProcesso))) {
            /** @var SwAndamento $swAndamento */
            $swAndamento = $swProcesso->getFkSwAndamentos()->last();
            $fieldOptions['codOrgao']['data'] = $swAndamento->getCodOrgao();

            // Monta JS com base no órgão cadastrado para este usuário
            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao($swAndamento->getCodOrgao())
            );
        }

        $formMapper->with('Encaminhamento de Processo');
        $formMapper->add('codOrgao', 'hidden', $fieldOptions['codOrgao']);

        $this->createFormOrganograma($formMapper, false);
        $formMapper->end();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->getSubject();
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->configureFormFieldsDadosDoProcesso($formMapper);

        if (is_null($this->id($swProcesso))) {
            $this->configureFormFieldsAtributosDoProcesso($formMapper);
        }

        $this->configureFormFieldsDocumentosDoProcesso($formMapper);

        $this->configureFormFieldsEncaminhamentoDoProcesso($formMapper);
    }

    /**
     * @param SwProcesso   $swProcesso
     * @param SwDocumento  $swDocumento
     * @param UploadedFile $uploadedFile
     */
    private function uploadAndPersistFile(SwProcesso $swProcesso, SwDocumento $swDocumento, UploadedFile $uploadedFile)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $swDocumentoProcessoModel = new SwDocumentoProcessoModel($entityManager);
        $swCopiaDigitalModel = new SwCopiaDigitalModel($entityManager);

        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        /** @var SwDocumentoProcesso $swDocumentoProcesso */
        $swDocumentoProcesso = $modelManager->findOneBy(SwDocumentoProcesso::class, [
            'fkSwProcesso' => $swProcesso,
            'fkSwDocumento' => $swDocumento
        ]);

        try {
            if (is_null($swDocumentoProcesso)) {
                $swDocumentoProcesso = $swDocumentoProcessoModel->builOne($swDocumento, $swProcesso);
                $entityManager->persist($swDocumentoProcesso);
            }

            $swCopiaDigital = $swCopiaDigitalModel->buildOne($swDocumentoProcesso, false, $uploadedFile->getClientOriginalName());

            $fileName = $swCopiaDigitalModel->generateFileName($swCopiaDigital);
            $swCopiaDigital->setAnexo($fileName);

            $entityManager->persist($swCopiaDigital);

            $uploadedFile->move($foldersAdminBundle['documentoProcesso'], $fileName);

            $swDocumentoProcesso->addFkSwCopiaDigitais($swCopiaDigital);
            $swProcesso->addFkSwDocumentoProcessos($swDocumentoProcesso);
        } catch (IOException $IOException) {
            $message = $this->trans('default.errors.failedUploadFile', [], 'validators');

            $container = $this->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * @param SwProcesso $swProcesso
     */
    private function preUploadFkSwDocumentoProcessos(SwProcesso $swProcesso)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $files = $this->getRequest()->files;

        $documentos = (new SwDocumentoModel($entityManager))->getDocumentosBySwAssunto($swProcesso->getFkSwAssunto());

        /** @var SwDocumento $swDocumento */
        foreach ($documentos as $swDocumento) {
            $fileRequestName = ProcessoAdminController::FILE_FIELD_PREFIX . $swDocumento->getCodDocumento();

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $files->get($fileRequestName);

            if (!is_null($uploadedFile)) {
                $this->uploadAndPersistFile($swProcesso, $swDocumento, $uploadedFile);
            }
        }
    }

    /**
     * @param SwProcesso $swProcesso
     */
    private function updateUploadFkSwDocumentoProcessos(SwProcesso $swProcesso)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $files = $this->getRequest()->files;

        $documentos = (new SwDocumentoModel($entityManager))->getDocumentosBySwAssunto($swProcesso->getFkSwAssunto());

        /** @var SwDocumento $swDocumento */
        foreach ($documentos as $swDocumento) {
            $fileRequestName = ProcessoAdminController::FILE_FIELD_PREFIX . $swDocumento->getCodDocumento();

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $files->get($fileRequestName);

            if (!is_null($uploadedFile)) {
                $this->uploadAndPersistFile($swProcesso, $swDocumento, $uploadedFile);
            }
        }
    }

    /**
     * @param SwProcesso $swProcesso
     */
    private function prePersistFkSwProcessoAtributoValores(SwProcesso $swProcesso)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $atributosDinamicos = $this->getRequest()->get('form');

        $swAssuntoAtributos = $modelManager->findBy(SwAssuntoAtributo::class, [
            'fkSwAssunto' => $swProcesso->getFkSwAssunto()
        ]);

        $swAssuntoAtributoValorModel = new SwAssuntoAtributoValorModel($entityManager);

        /** @var SwAssuntoAtributo $swAssuntoAtributo */
        foreach ($swAssuntoAtributos as $swAssuntoAtributo) {
            $requestAtributoKey = ProcessoAdminController::ATTR_FIELD_PREFIX . $swAssuntoAtributo->getCodAtributo();

            $valor = $atributosDinamicos[$requestAtributoKey];

            $swProcessoAtributoValor = $swAssuntoAtributoValorModel->buildOne($swAssuntoAtributo, $swProcesso, $valor);
            $swProcesso->addFkSwAssuntoAtributoValores($swProcessoAtributoValor);
        }
    }

    /**
     * @param SwProcesso $swProcesso
     */
    private function prePersistFkSwAndamentos(SwProcesso $swProcesso)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        /** @var OrgaoNivel $orgaoNivel */
        $orgaoNivel = $this->getOrgaoSelected();

        $swAndamentoModel = new SwAndamentoModel($entityManager);
        $swAndamento = $swAndamentoModel->buildOne(
            $swProcesso,
            $orgaoNivel->getFkOrganogramaOrgao(),
            $this->getCurrentUser(),
            $swProcesso->getFkSwSituacaoProcesso()
        );

        $swProcesso->addFkSwAndamentos($swAndamento);
    }

    /**
     * @param SwProcesso $swProcesso
     */
    public function prePersist($swProcesso)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $exercicio = $this->getExercicio();
        $codProcesso = (new SwProcessoModel($entityManager))->getNextCodProcesso($exercicio);

        $resumoAssunto = $form->get('resumoAssunto')->getData();

        /** @var SwSituacaoProcesso $swSituacaoProcesso */
        $swSituacaoProcesso = $modelManager->findOneBy(SwSituacaoProcesso::class, ['nomSituacao' => 'Em andamento, a receber']);

        $swProcesso->setCodProcesso($codProcesso);
        $swProcesso->setAnoExercicio($exercicio);
        $swProcesso->setResumoAssunto($resumoAssunto);
        $swProcesso->setFkSwSituacaoProcesso($swSituacaoProcesso);
        $swProcesso->setFkAdministracaoUsuario($this->getCurrentUser());

        $this->preUploadFkSwDocumentoProcessos($swProcesso);
        $this->prePersistFkSwProcessoAtributoValores($swProcesso);
        $this->prePersistFkSwAndamentos($swProcesso);

        // TODO cadastrar 'Inscrição cadastral'
    }

    /**
     * @param SwProcesso $swProcesso
     */
    private function updateFkSwUltimoAndamento(SwProcesso $swProcesso)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();
        $entityManager = $modelManager->getEntityManager($this->getClass());

        /** @var OrgaoNivel $orgaoNivel */
        $orgaoNivel = $this->getOrgaoSelected();

        $swUltimoAndamento = $swProcesso->getFkSwUltimoAndamento();

        if (!is_null($swUltimoAndamento)) {
            $swAndamento = $swUltimoAndamento->getFkSwAndamento()->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao());
            $entityManager->persist($swAndamento);
        }
    }

    /**
     * @param SwProcesso $swProcesso
     */
    public function preUpdate($swProcesso)
    {
        $form = $this->getForm();
        $resumoAssunto = $form->get('resumoAssunto')->getData();
        $swProcesso->setResumoAssunto($resumoAssunto);

        $this->updateUploadFkSwDocumentoProcessos($swProcesso);
        $this->updateFkSwUltimoAndamento($swProcesso);
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['receber'] = [
            'label'            => $this->trans('label.receberEmLote', [], 'CoreBundle'),
            'ask_confirmation' => true
        ];

        $actions['encaminhar'] = [
            'label'            => $this->trans('label.encaminharEmLote', [], 'CoreBundle'),
            'ask_confirmation' => true
        ];

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $swProcessoModel = new SwProcessoModel($entityManager);

        $usuario = $this->getCurrentUser();

        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->getSubject();
        $swProcesso->fkSwDespachado = $swProcessoModel->despachado($swProcesso);
        $swProcesso->encaminhado = $swProcessoModel->encaminhado($swProcesso, $usuario->getFkOrganogramaOrgao());
        $swProcesso->apensado = $swProcessoModel->apensado($swProcesso);
    }

    /**
     * @param SwCopiaDigital $swCopiaDigital
     *
     * @return string|null
     */
    public function getFileLink(SwCopiaDigital $swCopiaDigital)
    {
        $fileSystem = new Filesystem();
        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        if ($fileSystem->exists($foldersAdminBundle['documentoProcesso'] . DIRECTORY_SEPARATOR . $swCopiaDigital->getAnexo())) {
            return $foldersAdminBundle['documentoProcessoShow'] . $swCopiaDigital->getAnexo();
        }

        return null;
    }
}
