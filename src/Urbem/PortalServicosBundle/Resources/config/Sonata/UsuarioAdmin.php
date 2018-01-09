<?php

namespace Urbem\PortalServicosBundle\Resources\config\Sonata;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm\SwCgmAdmin;
use Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm\SwCgmPessoaFisicaAdmin;
use Urbem\CoreBundle\Entity\Administracao\Usuario;

use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwCategoriaHabilitacao;
use Urbem\CoreBundle\Entity\SwCep;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmLogradouro;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwEscolaridade;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwTipoLogradouro;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Helper\StringHelper;

/**
 * Class UsuarioAdmin
 *
 * @package Urbem\PortalServicosBundle\Resources\config\Sonata\Administracao
 */
class UsuarioAdmin extends SwCgmAdmin
{
    protected $baseRouteName = 'urbem_portalservicos_usuario';
    protected $baseRoutePattern = 'portal-cidadao/usuario';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['show', 'edit']);

        $collection->add('change_password', $this->getRouterIdParameter() . '/change-password', [
            '_controller' => CRUDController::class . '::editAction',
        ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFieldsDadosSwCgm(FormMapper $formMapper)
    {
        $swCgmPessoaFisica = null;
        if (!is_null($this->swCgm)) {
            /** @var Usuario $usuario */
            $usuario = $this->getSubject();
            $swCgmPessoaFisica = $this->swCgm->getFkSwCgmPessoaFisica();

            $this->swCgm->setEMail($usuario->getEmail());
            $this->swCgm->setEMailAdcional($usuario->getEmail());
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['nomCgm'] = [
            'attr'        => ['maxlength' => 200],
            'constraints' => [$this->addConstraintLength(200)],
            'label'       => 'label.nome',
            'mapped'      => false,
            'required'    => true,
        ];

        $fieldOptions['cpf'] = [
            'label'    => 'label.servidor.cpf',
            'required' => true,
        ];

        $fieldOptions['rg'] = [
            'label' => 'label.servidor.rg',
        ];

        $fieldOptions['orgaoEmissor'] = [
            'label' => 'label.servidor.orgaoemissor',
        ];

        // UF do Órgao Emissor
        // TODO Adicionar default da Prefeitura
        $fieldOptions['fkSwUf'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'class'    => SwUf::class,
            'choices'  => $entityManager->getRepository(SwUf::class)
                ->findBy([], ['nomUf' => 'ASC']),
            'label'    => 'label.servidor.uforgaoemissor',
            'required' => true,
        ];

        $fieldOptions['dtEmissaoRg'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.dtEmissao',
            'required' => false,
        ];

        // TODO Adicionar máscara 999.99999.99-9
        $fieldOptions['servidorPisPasep'] = [
            'label'    => 'label.servidor.pis',
            'required' => false,
        ];

        // Nacionalidade
        // TODO adiciona default como brasileira (ou o default da aplicação)
        $fieldOptions['fkSwPais'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => SwPais::class,
            'choice_label' => 'nacionalidade',
            'choices'      => $entityManager->getRepository(SwPais::class)
                ->findBy([], ['nacionalidade' => 'ASC']),
            'label'        => 'label.servidor.nacionalidade',
            'required'     => true,
        ];

        $fieldOptions['fkSwEscolaridade'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => SwEscolaridade::class,
            'choice_label' => 'descricao',
            'choices'      => $entityManager->getRepository(SwEscolaridade::class)
                ->findBy([], ['codEscolaridade' => 'ASC']),
            'data'         => $entityManager->getRepository(SwEscolaridade::class)->find(0),
            'label'        => 'label.servidor.escolaridade',
            'required'     => true,
        ];

        $fieldOptions['dtNascimento'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.datanascimento',
            'required' => false,
        ];

        $fieldOptions['sexo'] = [
            'attr'       => ['class' => 'checkbox-sonata '],
            'choices'    => [
                'label.servidor.masculino' => 'm',
                'label.servidor.feminino'  => 'f',
            ],
            'data'       => 'm',
            'expanded'   => true,
            'label'      => 'label.servidor.sexo',
            'label_attr' => ['class' => 'checkbox-sonata'],
        ];

        // TODO Não permitir a inclusão de letras
        $fieldOptions['numCnh'] = [
            'label'    => 'label.servidor.numerocnh',
            'required' => false,
        ];

        $fieldOptions['fkSwCategoriaHabilitacao'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'nomCategoria',
            'class'        => SwCategoriaHabilitacao::class,
            'data'         => $entityManager->getRepository(SwCategoriaHabilitacao::class)->find(0),
            'label'        => 'label.servidor.categoriacnh',
            'required'     => false,
        ];

        $fieldOptions['dtValidadeCnh'] = [
            'format'   => 'dd/MM/yyyy',
            'label'    => 'label.servidor.datavalidadecnh',
            'required' => false,
        ];

        if (!is_null($this->id($swCgmPessoaFisica))) {
            $fieldOptions['nomCgm']['data'] = $swCgmPessoaFisica->getFkSwCgm()->getNomCgm();
            $fieldOptions['fkSwEscolaridade']['data'] = $swCgmPessoaFisica->getFkSwEscolaridade();
            $fieldOptions['fkSwCategoriaHabilitacao']['data'] = $swCgmPessoaFisica->getFkSwCategoriaHabilitacao();

            $this->swCgm = $swCgmPessoaFisica->getFkSwCgm();
        }

        $formMapper
            ->with('label.usuario.seus_dados')
            ->add('fkSwCgm.nomCgm', 'text', $fieldOptions['nomCgm'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.cpf', 'text', $fieldOptions['cpf'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.rg', 'text', $fieldOptions['rg'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.orgaoEmissor', 'text', $fieldOptions['orgaoEmissor'])
            // fkSwUf: UF do Órgao Emissor
            ->add('fkSwCgm.fkSwCgmPessoaFisica.fkSwUf', 'entity', $fieldOptions['fkSwUf'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.dtEmissaoRg', 'sonata_type_date_picker', $fieldOptions['dtEmissaoRg'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.numCnh', 'text', $fieldOptions['numCnh'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.fkSwCategoriaHabilitacao', 'entity', $fieldOptions['fkSwCategoriaHabilitacao'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.dtValidadeCnh', 'sonata_type_date_picker', $fieldOptions['dtValidadeCnh'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.servidorPisPasep', 'text', $fieldOptions['servidorPisPasep'])
            // fkSwPais: Nacionalidade
            ->add('fkSwCgm.fkSwCgmPessoaFisica.fkSwPais', 'entity', $fieldOptions['fkSwPais'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.fkSwEscolaridade', 'entity', $fieldOptions['fkSwEscolaridade'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.dtNascimento', 'sonata_type_date_picker', $fieldOptions['dtNascimento'])
            ->add('fkSwCgm.fkSwCgmPessoaFisica.sexo', 'choice', $fieldOptions['sexo'])
            ->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFieldsDadosAcesso(FormMapper $formMapper)
    {
        $this->label = (string) $this->getSubject();

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

        $fieldOptions['username'] = [
            'disabled' => true,
            'label'    => 'label.usuario.username',
        ];

        $formMapper
            ->with('label.informacoes_acesso')
            ->add('foto', 'file', $fieldOptions['foto'])
            ->add('username', 'text', $fieldOptions['username'])
            ->end();
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
        $this->label = $this->trans('label.usuario.mudar_sua_senha');

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
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Usuario $usuario */
        $usuario = $this->getSubject();

        $request = $this->getRequest();

        switch ($request->get('_route')) {
            case ($this->baseRouteName . '_change_password'):
                $this->configureFormFieldsChangePassword($formMapper);

                break;
            default:
                $this->addToIncludeJs('/portalservicos/javascripts/usuario/init.js');

                if (!is_null($usuario)) {
                    $this->swCgm = $usuario->getFkSwCgm();
                }

                $this->configureFormFieldsDadosSwCgm($formMapper);
                $this->configureFormFieldsDadosEndereco($formMapper);
                $this->configureFormFieldsDadosContato($formMapper);
                $this->configureFormFieldsDadosAcesso($formMapper);

                break;
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
     * {@inheritdoc}
     */
    public function getTemplate($name)
    {
        if ($name == 'show') {
            return 'PortalServicosBundle:Usuario:show.html.twig';
        }

        return parent::getTemplate($name);
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
    }

    /**
     * @param string  $action
     * @param Usuario $usuario
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkAccess($action, $usuario = null)
    {
        $currentUser = $this->getCurrentUser();

        if ($this->getAdminRequestId() != $this->getObjectKey($currentUser)) {
            return (new RedirectResponse('/acesso-negado'))->send();
        }

        return true;
    }

    /**
     * @param SwCgm $swCgm
     */
    private function persistNomcgm(SwCgm $swCgm)
    {
        $form = $this->getForm();

        $nomCgm = $form->get('fkSwCgm__nomCgm')->getData();
        $nomCgm = StringHelper::clearString($nomCgm);

        $swCgm->setNomCgm($nomCgm);
    }

    /**
     * @param SwCgmPessoaFisica $swCgmPessoaFisica
     *
     * @return $this
     */
    private function persistCpf(SwCgmPessoaFisica $swCgmPessoaFisica)
    {
        $form = $this->getForm();

        $cpf = $form->get('fkSwCgm__fkSwCgmPessoaFisica__cpf')->getData();
        $cpf = StringHelper::clearString($cpf);

        $swCgmPessoaFisica->setCpf($cpf);

        return $this;
    }

    /**
     * @param Usuario $usuario
     */
    public function preUpdate($usuario)
    {
        if ($this->getForm()->has('plainPassword')) {
            $usuario->setPasswordRequestedAt(null);
            $userManager = $this->getContainer()->get('fos_user.user_manager');
            $userManager
                ->updateUser($usuario, false);
        } else {
            $swCgm = $usuario->getFkSwCgm();

            $this->persistCpf($swCgm->getFkSwCgmPessoaFisica());
            $this->persistNomcgm($swCgm);

            $this->preUpdateSwCgm($swCgm);

            $usuario->setEmail($swCgm->getEMail());
        }
    }

    /**
     * @param Usuario $usuario
     */
    public function postUpdate($usuario)
    {
        $this->redirectByRoute($this->baseRouteName . '_show', ['id' => $this->id($usuario)]);
    }
}
