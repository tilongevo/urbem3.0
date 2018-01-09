<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Organograma;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Helper\ValidaDocumentoHelper;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel;

/**
 * Class SwCgmPessoaJuridicaAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class SwCgmPessoaJuridicaAdmin extends SwCgmAdmin
{
    protected $baseRouteName = 'urbem_administrativo_cgm_pessoa_juridica';
    protected $baseRoutePattern = 'administrativo/cgm/pessoa-juridica';
    public static $tipoPessoaJuridica = 2;

    protected $includeJs = [
        '/administrativo/javascripts/cgm/swcgmpessoajuridica.js'
    ];

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by'    => 'fkSwCgm.numcgm',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.razao_social'])
            ->add('cnpj', null, ['label' => 'label.servidor.cnpj']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numcgm', null, ['label' => 'label.cgm'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.razao_social'])
            ->add('cnpj', null, ['label' => 'label.servidor.cnpj']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var SwCgmPessoaJuridica $swCgmPessoaJuridica */
        $swCgmPessoaJuridica = $this->getSubject();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['nomCgm'] = [
            'attr'        => ['maxlength' => 200],
            'constraints' => [$this->addConstraintLength(200)],
            'label'       => 'label.razao_social',
            'mapped'      => false,
            'required'    => true,
        ];

        $fieldOptions['nomFantasia'] = [
            'label' => 'label.servidor.nomfantasia'
        ];

        $fieldOptions['cnpj'] = [
            'label' => 'label.servidor.cnpj'
        ];

        $fieldOptions['inscEstadual'] = [
            'attr'     => ['class' => 'numeric '],
            'label'    => 'label.servidor.inscestadual',
            'required' => false
        ];

        $fieldOptions['fkAdministracaoOrgaoRegistro'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'choice_label' => 'descricao',
            'label'        => 'label.servidor.orgaoregistro',
            'required'     => false,
        ];

        $fieldOptions['numRegistro'] = [
            'attr'     => ['class' => 'numeric '],
            'label'    => 'label.servidor.numregistro',
            'required' => false
        ];

        $fieldOptions['dtRegistro'] = [
            'label'    => 'label.servidor.dtregistro',
            'required' => false,
            'format'   => 'dd/MM/yyyy'
        ];

        $fieldOptions['numRegistroCvm'] = [
            'attr'     => ['class' => 'numeric '],
            'label'    => 'label.servidor.numregistrocvm',
            'required' => false
        ];

        $fieldOptions['dtRegistroCvm'] = [
            'label'    => 'label.servidor.dtregistro',
            'required' => false,
            'format'   => 'dd/MM/yyyy'
        ];

        $fieldOptions['objetoSocial'] = [
            'label'    => 'label.servidor.objetosocial',
            'required' => false
        ];

        $fieldOptions['createUser'] = [
            'label' => 'label.usuario.criarUsuarioAutomaticamente',
            'mapped' => false,
            'required' => false,
            'attr' => ['class' => 'checkbox-sonata'],
            'label_attr' => ['class' => 'checkbox-sonata']
        ];

        if (!is_null($this->id($swCgmPessoaJuridica))) {
            $this->swCgm = $swCgmPessoaJuridica->getFkSwCgm();

            $fieldOptions['nomCgm']['data'] = $this->swCgm->getNomCgm();
        }

        $formMapper->with('label.dados_cgm');
        $formMapper->add('nomCgm', 'text', $fieldOptions['nomCgm']);
        $formMapper->add('nomFantasia', 'text', $fieldOptions['nomFantasia']);
        $formMapper->add('cnpj', 'text', $fieldOptions['cnpj']);
        $formMapper->add('inscEstadual', 'text', $fieldOptions['inscEstadual']);
        $formMapper->add('fkAdministracaoOrgaoRegistro', null, $fieldOptions['fkAdministracaoOrgaoRegistro']);
        $formMapper->add('numRegistro', 'text', $fieldOptions['numRegistro']);
        $formMapper->add('dtRegistro', 'sonata_type_date_picker', $fieldOptions['dtRegistro']);
        $formMapper->add('numRegistroCvm', 'text', $fieldOptions['numRegistroCvm']);
        $formMapper->add('dtRegistroCvm', 'sonata_type_date_picker', $fieldOptions['dtRegistroCvm']);
        $formMapper->add('objetoSocial', 'textarea', $fieldOptions['objetoSocial']);

        // Criar Usuário Automaticamente
        if ($this->id($this->getSubject())) {
            /** @var SwCgm $cgm */
            $cgm = $this->getSubject();
            $usuario = $entityManager->getRepository(Usuario::class)->find($cgm->getNumcgm());
            if (!$usuario) {
                $formMapper->add('createUser', 'checkbox', $fieldOptions['createUser']);
            }
        } else {
            $formMapper->add('createUser', 'checkbox', $fieldOptions['createUser']);
        }

        $formMapper->end();

        parent::configureFormFields($formMapper);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $swPessoaJuridica)
    {
        $route = $this->request->get('_route');
        $form = $this->getForm();

        $cnpj = $form->get('cnpj')->getData();

        $cnpjValido = ValidaDocumentoHelper::CNPJ($cnpj);

        if (! $cnpjValido) {
            $message = $this->trans('swPessoaJuridica.error.cnpjInvalido', [], 'flashes');
            $errorElement->with('cnpj')->addViolation($message)->end();
        }

        $cnpj = StringHelper::clearString($cnpj);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $swPessoaJuridicaModel = new SwCgmPessoaJuridicaModel($entityManager);

        $cnpjAlreadyExists = false;

        if ($route == sprintf('%s_create', $this->baseRouteName)
            && $swPessoaJuridicaModel->checkIfCnpjAlreadyExists($cnpj)) {
            $cnpjAlreadyExists = true;
        } elseif ($route == sprintf('%s_edit', $this->baseRouteName)) {
            $originalEntityData = $entityManager->getUnitOfWork()->getOriginalEntityData($swPessoaJuridica);

            if ($swPessoaJuridicaModel->checkIfCnpjAlreadyExists($cnpj, $originalEntityData['cnpj'])) {
                $cnpjAlreadyExists = true;
            }
        }

        if ($cnpjAlreadyExists) {
            $message = $this->trans('swPessoaJuridica.error.cnpjAlreadyExists', [], 'flashes');
            $errorElement->with('cnpj')->addViolation($message)->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.dados_cgm')
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.razao_social'])
            ->add('nomFantasia', null, ['label' => 'label.servidor.nomfantasia'])
            ->add('cnpj', null, ['label' => 'label.servidor.cnpj'])
            ->add('inscEstadual', null, ['label' => 'label.servidor.inscestadual'])
            ->add('fkAdministracaoOrgaoRegistro.descricao', null, ['label' => 'label.servidor.orgaoregistro'])
            ->add('num_registro', null, ['label' => 'label.servidor.numregistro'])
            ->add('dt_registro', 'date', ['label' => 'label.servidor.dtregistro'])
            ->add('num_registro_cvm', null, ['label' => 'label.servidor.numregistrocvm'])
            ->add('dt_registro_cvm', 'date', ['label' => 'label.servidor.dtregistrocvm'])
            ->add('objeto_social', null, ['label' => 'label.servidor.objetosocial'])
            ->end();

        /** @var SwCgmPessoaJuridica $swCgmPessoaJuridica */
        $swCgmPessoaJuridica = $this->getSubject();

        $this->swCgm = $swCgmPessoaJuridica->getFkSwCgm();

        parent::configureShowFields($showMapper);
    }

    /**
     * @param SwCgmPessoaJuridica $swCgmPessoaJuridica
     *
     * @return $this
     */
    private function persistCnpj(SwCgmPessoaJuridica $swCgmPessoaJuridica)
    {
        $form = $this->getForm();

        $cnpj = $form->get('cnpj')->getData();
        $cnpj = StringHelper::clearString($cnpj);

        $swCgmPessoaJuridica->setCnpj($cnpj);

        return $this;
    }

    /**
     * @param SwCgm $swCgm
     */
    private function persistNomcgm(SwCgm $swCgm)
    {
        $form = $this->getForm();

        $nomCgm = $form->get('nomCgm')->getData();
        $nomCgm = StringHelper::clearString($nomCgm);

        $swCgm->setNomCgm($nomCgm);
    }

    /**
     * @param SwCgmPessoaJuridica $object
     */
    public function prePersist($object)
    {
        $swCgm = new SwCgm();

        $this->persistCnpj($object);

        $this->persistNomcgm($swCgm);
        $this->prePersistSwCgm($swCgm);

        $object->setFkSwCgm($swCgm);
        if ($this->getForm()->get('createUser')->getData()) {
            $this->prePersistUsuario($swCgm, $object->getCnpj());
        }
    }

    /**
     * @param SwCgmPessoaJuridica $object
     */
    public function preUpdate($object)
    {
        $swCgm = $object->getFkSwCgm();

        $this->persistCnpj($object);
        $this->persistNomcgm($swCgm);

        parent::preUpdateSwCgm($swCgm);
    }

    /**
     * @param SwCgmPessoaJuridica $swCgmPessoaJuridica
     */
    public function postRemove($swCgmPessoaJuridica)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        (new SwCgmModel($entityManager))->remove($swCgmPessoaJuridica->getFkSwCgm());
    }

    /**
     * @param SwCgmPessoaJuridica $swCgmPessoaJuridica
     */
    public function postPersist($swCgmPessoaJuridica)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $message = sprintf('%s - %s cadastrado com sucesso.', $swCgmPessoaJuridica->getNumcgm(), $swCgmPessoaJuridica->getFkSwCgm()->getNomCgm());
        $container->get('session')->getFlashBag()->add('success', $message);
    }
}
