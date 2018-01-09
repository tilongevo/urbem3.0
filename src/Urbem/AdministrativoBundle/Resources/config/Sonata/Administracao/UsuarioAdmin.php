<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use Urbem\AdministrativoBundle\Controller\Administracao\UsuarioAdminController;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\UsuarioModel;
use Urbem\CoreBundle\Model\Organograma\NivelModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository\SwCgmRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;

/**
 * Class UsuarioAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class UsuarioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_usuarios';
    protected $baseRoutePattern = 'administrativo/administracao/usuarios';

    protected $model = UsuarioModel::class;

    protected $tokenStorage;

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'id',
    ];

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/administrativo/javascripts/administracao/usuario.js',
        ]));
    }

    /**
     * Rotas para
     *   /administrativo/administracao/usuarios/{id}/change_password
     *   /administrativo/administracao/usuarios/get_orgao_info
     *   /administrativo/administracao/usuarios/search?q=
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['show', 'create', 'edit', 'list']);

        $collection->add('change_password', $this->getRouterIdParameter() . '/change-password', [
            '_controller' => UsuarioAdminController::class . '::editAction',
        ]);

        $collection->add('search', 'search');
        $collection->add('resend_password', $this->getRouterIdParameter() . '/resend-password');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkSwCgm', null, ['label' => 'label.usuario.numcgm'], 'entity', [
                'class'         => SwCgm::class,
                'query_builder' => function (EntityRepository $repository) {
                    $queryBuilder = $repository->createQueryBuilder('swCgm');

                    return $queryBuilder->join('swCgm.fkAdministracaoUsuario', 'fkAdministracaoUsuario');
                },
            ], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('username', null, [
                'label' => 'label.usuario.username',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numcgm', null, ['label' => 'label.usuario.numcgm'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.usuario.nomCgm'])
            ->add('username', null, ['label' => 'label.usuario.username']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show'            => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit'            => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                    'change-password' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_change_password.html.twig'],
                    'resend-password' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_resend_password.html.twig'],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $request = $this->getRequest();

        switch ($request->get('_route')) {
            case ($this->baseRouteName . '_change_password'):
                $this->configureFormFieldsChangePassword($formMapper);
                break;
            case ($this->baseRouteName . '_edit'):
                $this->configureFormFieldsEdit($formMapper);
                break;
            default:
                $this->configureFormFieldsCreate($formMapper);
                break;
        }
    }

    /**
     * Formulário de alteração de senha.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsChangePassword(FormMapper $formMapper)
    {
        /** @var Usuario $usuario */
        $usuario = $this->getSubject();

        if ($usuario->getPasswordRequestedAt()) {
            $this->getContainer()->get('session')->getFlashBag()->add('warning', $this->getTranslator()->trans('flash_suggest_change_password'));
            $usuario->setPasswordRequestedAt(null);
            $this->getEntityManager()->persist($usuario);
            $this->getEntityManager()->flush();
        }

        $this->exibirBotaoExcluir = false;
        $this->label = $this->trans('label.usuario.dados_usuario_password', [
            '%usuario%' => $usuario->getUsername(),
        ]);

        $passwordOptions = [
            'type'            => 'password',
            'invalid_message' => $this->trans('usuario.errors.passwordFieldsNotMatch', [], 'validators'),
            'first_options'   => ['label' => 'label.usuario.plainPassword'],
            'second_options'  => ['label' => 'label.usuario.password'],
        ];

        $formMapper
            ->add('plainPassword', 'repeated', $passwordOptions)
            ->getFormBuilder()
            ->setAction('change_password');

        if ($this->getCurrentUser()->getNumcgm() != $usuario->getNumcgm()) {
            $suggestChangePasswordOptions = [
                'label' => 'label.usuario.suggestChangePassword',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'checkbox-sonata'],
                'label_attr' => ['class' => 'checkbox-sonata'],
            ];
            $formMapper->add('suggestChangePassword', 'checkbox', $suggestChangePasswordOptions);
        }
    }

    /**
     * Formulário base de edição/criação de usuário.
     *
     * @param FormMapper $formMapper
     * @param bool       $isEditForm
     */
    private function configureFormFieldsBase(FormMapper $formMapper, $isEditForm = false)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['codOrgao']['mapped'] = false;

        $availableTypes = ['image/jpeg', 'image/pjpeg', 'image/png'];
        $imageRules = [
            'mimeTypes'        => $availableTypes,
            'maxSize'          => '500k',
            'maxWidth'         => '512',
            'maxHeight'        => '512',
            'minWidth'         => '256',
            'minHeight'        => '256',
            'mimeTypesMessage' => $this->trans('usuario.errors.invalidFileType', ['%file_types%' => implode(', ', $availableTypes)], 'validators'),
            'maxSizeMessage'   => $this->trans('usuario.errors.uploadedFileSizeNotAllowed', ['%size%' => '500Kb'], 'validators'),
            'maxWidthMessage'  => $this->trans('usuario.errors.maxPicSizeExceeded', ['%max_size%' => '500px'], 'validators'),
            'minWidthMessage'  => $this->trans('usuario.errors.minPicSizeExceeded', ['%max_size%' => '256px'], 'validators'),
        ];

        $fotoHelp = $this->getContainer()
            ->get('twig')
            ->render('@Administrativo/Sonata/Administracao/Usuario/CRUD/field__foto__help.html.twig', [
                'rules' => $imageRules,
            ]);

        $fieldOptions['foto'] = [
            'help'        => $fotoHelp,
            'mapped'      => false,
            'label'       => 'label.usuario.foto',
            'required'    => false,
            'constraints' => [new Assert\Image($imageRules)],
        ];

        $fieldOptions['fkSwCgm'] = [
            'attr'                 => ['class' => 'select2-parameters '],
            'class'                => SwCgm::class,
            'label'                => 'label.cgm',
            'json_from_admin_code' => $this->code,
            'json_query_builder'   => function (SwCgmRepository $repository, $term, Request $request) use ($entityManager) {
                $queryBuilder = $entityManager->createQueryBuilder();
                $queryBuilder
                    ->select('usuario.numcgm')
                    ->from(Usuario::class, 'usuario');

                if (is_numeric($term)) {
                    $swCgmQueryBuilder = $repository->createQueryBuilder('cgm');
                    $swCgmQueryBuilderAlias = $swCgmQueryBuilder->getRootAlias();
                    $swCgmQueryBuilder->andWhere(
                        $queryBuilder->expr()->eq("{$swCgmQueryBuilderAlias}.numcgm", $term)
                    );
                } else {
                    $swCgmQueryBuilder = (new SwCgmModel($entityManager))->findLikeQuery(['nomCgm'], $term);
                    $swCgmQueryBuilderAlias = $swCgmQueryBuilder->getRootAlias();

                    $swCgmQueryBuilder
                    ->join("$swCgmQueryBuilderAlias.fkSwCgmPessoaFisica", "fkSwCgmPessoaFisica")
                    ->andWhere(
                        $queryBuilder->expr()->notIn("{$swCgmQueryBuilderAlias}.numcgm", $queryBuilder->getDQL())
                    );
                }

                return $swCgmQueryBuilder;
            },
            'placeholder'          => $this->trans('label.selecione'),
            'required'             => true,
        ];

        $fieldOptions['username'] = [
            'label' => 'label.usuario.username',
        ];

        $fieldOptions['email'] = [
            'label' => 'label.usuario.email',
        ];

        $fieldOptions['status'] = [
            'attr'       => ['class' => 'checkbox-sonata'],
            'choices'    => [
                'label.ativo'   => 'A',
                'label.inativo' => 'I',
            ],
            'expanded'   => true,
            'label'      => 'label.usuario.status',
            'label_attr' => ['class' => 'checkbox-sonata'],
            'multiple'   => false,
        ];

        $fieldOptions['roles'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'label'    => 'label.usuario.tipoUsuario',
            'mapped'   => false,
            'required' => true,
            'multiple' => true,
            'choices'  => [
                'label.usuario.roles.ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                'label.usuario.roles.ROLE_ADMIN'       => 'ROLE_ADMIN',
                'label.usuario.roles.ROLE_MUNICIPE'    => 'ROLE_MUNICIPE',
            ],
        ];

        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            unset($fieldOptions['roles']['choices']['ROLE_SUPER_ADMIN']);
        }

        if ($isEditForm) {
            /** @var Usuario $usuario */
            $usuario = $this->getSubject();

            $fieldOptions['codOrgao']['data'] = $usuario->getCodOrgao();

            $fieldOptions['username']['disabled'] = true;
            $fieldOptions['username']['empty_data'] = $usuario->getUsername();

            $fieldOptions['fkSwCgm']['disabled'] = true;
            $fieldOptions['isAdmin']['data'] = in_array("ROLE_SUPER_ADMIN", $usuario->getRoles()) ?: false;

            // Monta JS com base no órgão cadastrado para este usuário
            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao($usuario->getCodOrgao())
            );

            $roles = $usuario->getRoles();
            $fieldOptions['roles']['data'] = $roles;

            // Usuário não pode remover seu poder de administrador
            if ($this->getCurrentUser()->getId() == $usuario->getId()) {
                $this->setScriptDynamicBlock($this->getScriptDynamicBlock() . '$(".admin-user").prop("readonly", true); $(".admin-user").iCheck("disable");');
            }
        }

        $formMapper
            ->add('codOrgao', 'hidden', $fieldOptions['codOrgao'])
            ->add('foto', 'file', $fieldOptions['foto'])
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('username', 'text', $fieldOptions['username'])
            ->add('email', 'text', $fieldOptions['email']);

        if (!$isEditForm) {
            $passwordOptions = [
                'type'            => 'password',
                'invalid_message' => $this->trans('usuario.errors.passwordFieldsNotMatch', [], 'validators'),
                'first_options'   => ['label' => 'label.usuario.plainPassword'],
                'second_options'  => ['label' => 'label.usuario.password'],
            ];

            $suggestChangePasswordOptions = [
                'label' => 'label.usuario.suggestChangePassword',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'checkbox-sonata'],
                'label_attr' => ['class' => 'checkbox-sonata'],
            ];

            $formMapper
                ->add('plainPassword', 'repeated', $passwordOptions)
                ->add('suggestChangePassword', 'checkbox', $suggestChangePasswordOptions)
                ->getFormBuilder()
                ->setAction('create');
        }

        // Renderiza campos de Organograma
        $formMapper
            ->add('status', 'choice', $fieldOptions['status'])
            ->add('roles', 'choice', $fieldOptions['roles'])
            ->end();

        $formMapper->with('label.usuario.codOrganograma');
        $this->createFormOrganograma($formMapper, true);
        $formMapper->end();
    }

    /**
     * Formulário de edição de usuário.
     * O mesmo não contém campos de senha.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsEdit(FormMapper $formMapper)
    {
        /** @var Usuario $usuario */
        $usuario = $this->getSubject();

        $this->exibirBotaoExcluir = false;
        $this->label = $this->trans('label.usuario.dados_usuario_edit', [
            '%usuario%' => $usuario->getUsername(),
        ]);

        $this->configureFormFieldsBase($formMapper, true);
    }

    /**
     * Formulário de criação de um novo usuário.
     * O mesmo contém tanto campos de edição e campos de senha.
     *
     * @param FormMapper $formMapper
     */
    private function configureFormFieldsCreate(FormMapper $formMapper)
    {
        $this->exibirBotaoExcluir = false;
        $this->label = $this->trans('label.usuario.dados_usuario');

        $this->configureFormFieldsBase($formMapper);
    }

    /**
     * Verifica se a action possui campos de password.
     *
     * @return bool
     */
    private function hasPasswordsFieldsInRequest()
    {
        return preg_match('/(change-password|create)/', $this->getRequest()->getUri()) === 1;
    }

    /**
     * Verifica se a action possui campo de foto.
     *
     * @return bool
     */
    private function hasProfilePictureFieldInRequest()
    {
        return preg_match('/(edit|create)/', $this->getRequest()->getUri()) === 1;
    }

    private function hasEmailFieldInRequest()
    {
        return $this->hasProfilePictureFieldInRequest();
    }

    /**
     * @param ErrorElement $errorElement
     */
    private function validateEmail(ErrorElement $errorElement)
    {
        /** @var Form $form */
        $form = $this->getForm();

        $email = $form->get('email')->getData();
        if (!is_null($email) && filter_var($email, FILTER_VALIDATE_EMAIL) == "") {
            $message = $this->trans('usuario.errors.invalidEmail', [], 'validators');
            $errorElement->with('email')->addViolation($message)->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->hasEmailFieldInRequest()) {
            $this->validateEmail($errorElement);
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        if (!$this->id($object)) {
            /** @var Usuario $userName */
            $userName = $entityManager->getRepository(Usuario::class)->findOneBy(
                [
                    'usernameCanonical' => $object->getUsernameCanonical()
                ]
            );

            if ($userName) {
                $message = $this->trans('usuario.errors.aleadyExistsUsername', [], 'validators');
                $errorElement->with('username')->addViolation($message)->end();
            }
        }
    }

    /**
     * Recupera o caminho completo da imagem de perfil do usuário, caso a mesma exista.
     *
     * @param Usuario $usuario
     *
     * @return string|null
     */
    private function getProfilePictureFile(Usuario $usuario)
    {
        $fileSystem = new Filesystem();
        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        $filePath = sprintf('%s/%s', $foldersAdminBundle['usuario'], $usuario->getProfilePicture());

        // Verifica se o arquivo existe na pasta.
        if ($fileSystem->exists($filePath)) {
            return $usuario->getProfilePicture();
        }

        return null;
    }

    /**
     * Faz o upload da imagem
     *
     * @param Usuario      $usuario
     * @param UploadedFile $uploadedFile
     */
    private function uploadProfilePicture(Usuario $usuario, UploadedFile $uploadedFile)
    {
        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        try {
            $uploadedFile->move($foldersAdminBundle['usuario'], $usuario->getProfilePicture());
        } catch (IOException $IOException) {
            $message = $this->trans('usuario.errors.failedMoveProfilePicture', [], 'validators');

            $container = $this->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $message);

            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    /**
     * Persiste a imagem no perfil do usuário
     *
     * @param Usuario $usuario
     */
    private function persistProfilePicture(Usuario $usuario)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('foto')->getData();

        if (!is_null($uploadedFile)) {
            $profilePictureFileName = md5(date('dmyhis'));
            $profilePictureFileName = sprintf('%s.%s', $profilePictureFileName, $uploadedFile->getClientOriginalExtension());

            $usuario->setProfilePicture($profilePictureFileName);

            $this->uploadProfilePicture($usuario, $uploadedFile);
        }
    }

    /**
     * Remove a foto do perfil.
     *
     * @param Usuario $usuario
     */
    private function removeProfilePicture(Usuario $usuario)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $originalUsuario = $entityManager->getUnitOfWork()->getOriginalEntityData($usuario);

        $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');

        $filePath = sprintf('%s/%s', $foldersAdminBundle['usuario'], $originalUsuario['profilePicture']);

        $fileSystem = new Filesystem();
        if ($fileSystem->exists($filePath)) {
            try {
                $fileSystem->remove($filePath);
            } catch (IOException $IOException) {
                $message = $this->trans('usuario.errors.failedRemoveProfilePicture', [], 'validators');

                $container = $this->getContainer();
                $container
                    ->get('session')
                    ->getFlashBag()
                    ->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * Atualiza a foto do perfil.
     *
     * @param Usuario $usuario
     */
    private function updateProfilePicture(Usuario $usuario)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('foto')->getData();

        if (!is_null($uploadedFile)) {
            $this->removeProfilePicture($usuario);
            $this->persistProfilePicture($usuario);
        }
    }

    /**
     * Persiste o Orgão no objeto Usuario
     *
     * @param Usuario $usuario
     */
    private function persistOrganogramaOrgao(Usuario $usuario)
    {
        /** @var OrgaoNivel $orgaoNivel */
        $orgaoNivel = $this->getOrgaoSelected();

        $usuario->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao());
    }

    /**
     * Validação e persistencia do usuario dependendo da ROLE que foi concedida a ele.
     *
     * @param Usuario $usuario
     */
    private function persistAdminUserRole(Usuario $usuario)
    {
        // Usuário não pode remover seu poder de administrador
        if ($this->getCurrentUser()->getId() == $usuario->getId()) {
            return;
        }

        $roles = $this->getForm()->get('roles')->getData();
        $usuario->setRoles($roles);
    }

    /**
     * Codificação de password de acordo com as diretivas do FOSUserBundle.
     *
     * @param Usuario $usuario
     */
    private function persistPassword(Usuario $usuario)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $userManager
            ->updateUser($usuario, false);
    }

    /**
     * @param Usuario $usuario
     */
    public function prePersist($usuario)
    {
        $form = $this->getForm();

        $this->persistOrganogramaOrgao($usuario);
        $this->persistAdminUserRole($usuario);

        $usuario->setEnabled($form->get('status')->getData() == "A");
        $usuario->setDtCadastro(new \DateTime());

        if ($form->get('suggestChangePassword')->getData()) {
            $usuario->setPasswordRequestedAt(new \DateTime());
        }

        $this->persistProfilePicture($usuario);
        $this->persistPassword($usuario);
    }

    /**
     * @param Usuario $usuario
     */
    public function preUpdate($usuario)
    {
        if (!$this->hasPasswordsFieldsInRequest()) {
            $usuario->setEnabled($this->getForm()->get('status')->getData() == "A");

            $this->persistOrganogramaOrgao($usuario);
            $this->persistAdminUserRole($usuario);

            $this->updateProfilePicture($usuario);
        } else {
            if (($this->getCurrentUser()->getNumcgm() != $usuario->getNumcgm()) && ($this->getForm()->get('suggestChangePassword')->getData())) {
                $usuario->setPasswordRequestedAt(new \DateTime());
            }
            $this->persistPassword($usuario);
        }
    }

    /**
     * @param Usuario $usuario
     */
    protected function redirectToUserProfile(Usuario $usuario)
    {
        $this->redirectByRoute($this->baseRouteName . '_show', ['id' => $usuario->getFkSwCgm()->getNumcgm()]);
    }

    /**
     * @param Usuario $usuario
     */
    public function postPersist($usuario)
    {
        $this->redirectToUserProfile($usuario);
    }

    /**
     * @param Usuario $usuario
     */
    public function postUpdate($usuario)
    {
        $this->redirectToUserProfile($usuario);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var Usuario $usuario */
        $usuario = $this->getSubject();

        $usuario->profilePic = $this->getProfilePictureFile($usuario);

        if (!is_null($usuario->profilePic)) {
            $foldersAdminBundle = $this->getContainer()->getParameter('administrativobundle');
            $usuario->profilePic = $foldersAdminBundle['usuarioShow'] . $usuario->profilePic;
        }

        if (!is_null($usuario->getFkOrganogramaOrgao())) {
            $this->configureShowFieldsOrgaos();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureShowFieldsOrgaos()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var EntityManager $entityManager */
        $entityManager = $modelManager->getEntityManager(Nivel::class);

        /** @var Usuario $usuario */
        $usuario = $this->getSubject();
        $orgao = $usuario->getFkOrganogramaOrgao();

        /** @var OrgaoNivel $orgaoNivel */
        $orgaoNivel = $orgao->getFkOrganogramaOrgaoNiveis()->first();

        $organograma = $orgaoNivel->getFkOrganogramaNivel()->getFkOrganogramaOrganograma();

        $niveis = (new NivelModel($entityManager))->findByOrganograma($organograma);

        /** @var VwOrgaoNivelView $vwOrgaoNivelView */
        $vwOrgaoNivelView = $modelManager->find(VwOrgaoNivelView::class, $orgao->getCodOrgao());

        $niveis = $niveis->filter(function (Nivel $nivel) use ($vwOrgaoNivelView) {
            return $nivel->getCodNivel() <= $vwOrgaoNivelView->getNivel();
        });

        $orgaosAtrelados = $entityManager->getRepository(Orgao::class)
            ->getOrgaosSuperiores(
                $orgao->getCodOrgao(),
                $organograma->getCodOrganograma(),
                $vwOrgaoNivelView->getNivel()
            );
        $orgaosAtrelados = new ArrayCollection($orgaosAtrelados);

        /** @var Nivel $nivel */
        foreach ($niveis as $index => $nivel) {
            $vwOrgaoNivelViewAtrelado = $orgaosAtrelados->filter(function ($nivelArray) use ($nivel) {
                return $nivel->getCodNivel() == $nivelArray->nivel;
            });
            $vwOrgaoNivelViewAtrelado = $vwOrgaoNivelViewAtrelado->toArray();
            $vwOrgaoNivelViewAtrelado = reset($vwOrgaoNivelViewAtrelado);

            $niveis[$index]->fkOrganogramaOrgao =
                $modelManager->find(Orgao::class, $vwOrgaoNivelViewAtrelado->cod_orgao);
        }

        $usuario->vwOrgaoNivelView = $vwOrgaoNivelView;
        $usuario->fkOrganogramaNiveis = $niveis;
    }

    /**
     * Garante que o usuário altere a própria senha se:
     * - O usuário tem que estar na action/rota de 'change_password'.
     * - O usuário que ser o mesmo usuário da url.
     * - O usuário que ser um usuário comum, caso seja administrador, ele não precisará de checagem de acesso.
     *
     * @param string       $action
     * @param null|Usuario $usuario
     *
     * @return void
     */
    public function checkAccess($action, $usuario = null)
    {
        $currentUser = $this->getCurrentUser();

        if (($this->isCurrentRoute('change_password') || $this->isCurrentRoute('show'))
            && $this->getAdminRequestId() == $this->getObjectKey($currentUser)
            && !in_array("ROLE_SUPER_ADMIN", $usuario->getRoles())
        ) {
            return;
        }

        parent::checkAccess($action, $usuario);
    }
}
