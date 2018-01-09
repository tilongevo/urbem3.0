<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AgenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_agencia';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/agencia';

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($object->getFkMonetarioContaCorrentes()->isEmpty()) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioAgencia.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'codBanco' => $this->getRequest()->get('codBanco'),
        ];
    }

    /**
     * @return null|string
     */
    public function getNomBanco()
    {
        if (!$this->getPersistentParameter('codBanco')) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $banco = $em->getRepository(Banco::class)
            ->findOneBy(
                array(
                    'codBanco' => $this->getRequest()->get('codBanco')
                )
            );

        return (string) $banco;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getPersistentParameter('codBanco')) {
            $query->where('1 = 0');
        } else {
            $query->where('o.codBanco = :codBanco');
            $query->setParameter('codBanco', $this->getPersistentParameter('codBanco'));
        }

        return $query;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $lastAgencia = $em->getRepository(Agencia::class)
            ->findOneBy(
                [],
                [
                    'codAgencia' => 'DESC'
                ]
            );

        $object->setCodAgencia($lastAgencia ? $lastAgencia->getCodAgencia() + 1 : 1);

        $banco = $em->getRepository(Banco::class)
            ->findOneBy(
                array(
                    'codBanco' => $this->getPersistentParameter('codBanco')
                )
            );

        $swCgmPessoaJuridica = $em->getRepository(SwCgmPessoaJuridica::class)
            ->findOneBy(
                array(
                    'numcgm' => $this->getForm()->get('fkSwCgmPessoaJuridica')->getData()
                )
            );

        $object->setFkMonetarioBanco($banco);
        $object->setFkSwCgmPessoaJuridica($swCgmPessoaJuridica);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numAgencia', null, array('label' => 'label.monetarioAgencia.numAgencia'))
            ->add('nomAgencia', null, array('label' => 'label.monetarioAgencia.nomAgencia'))
            ->add('fkSwCgmPessoaJuridica', 'doctrine_orm_model_autocomplete', [
                'label' => 'label.monetarioAgencia.numcgmAgencia',
            ], 'sonata_type_model_autocomplete', [
                'attr' => ['class' => 'select2-parameters '],
                'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();

                    /** @var QueryBuilder|ProxyQueryInterface $query */
                    $query = $datagrid->getQuery();

                    $rootAlias = $query->getRootAlias();
                    $query->join("{$rootAlias}.fkMonetarioAgencias", "fkMonetarioAgencias");

                    $datagrid->setValue($property, 'LIKE', $value);
                },
                'placeholder' => $this->trans('label.selecione'),
                'property' => 'fkSwCgm.nomCgm'
            ], [
                'admin_code' => 'administrativo.admin.sw_cgm_admin_pj'
            ])
            ->add('nomPessoaContato', null, array('label' => 'label.monetarioAgencia.nomPessoaContato'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codBanco', null, ['label' => 'label.monetarioAgencia.codBanco'])
            ->add('numAgencia', null, array('label' => 'label.monetarioAgencia.numAgencia'))
            ->add('nomAgencia', null, array('label' => 'label.monetarioAgencia.nomAgencia'))
            ->add('fkSwCgmPessoaJuridica.nomFantasia', null, ['label' => 'label.monetarioAgencia.numcgmAgencia'])
            ->add('nomPessoaContato', null, array('label' => 'label.monetarioAgencia.nomPessoaContato'));

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['fkSwCgmPessoaJuridica'] = [
            'label' => 'label.monetarioAgencia.numcgmAgencia',
            'class' => SwCgmPessoaJuridica::class,
            'multiple' => false,
            'required' => true,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'placeholder' => 'Selecione'
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['fkSwCgmPessoaJuridica']['disabled'] = true;
        }

        $formMapper
            ->with($this->getNomBanco())
            ->add('numAgencia', null, array('label' => 'label.monetarioAgencia.numAgencia'))
            ->add('nomAgencia', null, array('label' => 'label.monetarioAgencia.nomAgencia'))
            ->add(
                'fkSwCgmPessoaJuridica',
                'autocomplete',
                $fieldOptions['fkSwCgmPessoaJuridica']
            )
            ->add('nomPessoaContato', null, array('label' => 'label.monetarioAgencia.nomPessoaContato'));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codBanco', null, ['label' => 'label.monetarioAgencia.codBanco'])
            ->add('fkMonetarioBanco.nomBanco', null, ['label' => 'label.monetarioBanco.nomeBanco'])
            ->add('fkSwCgmPessoaJuridica.nomFantasia', null, ['label' => 'label.monetarioAgencia.numcgmAgencia'])
            ->add('numAgencia', null, array('label' => 'label.monetarioAgencia.numAgencia'))
            ->add('nomAgencia', null, array('label' => 'label.monetarioAgencia.nomAgencia'))
            ->add('nomPessoaContato', null, array('label' => 'label.monetarioAgencia.nomPessoaContato'));
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getCodAgencia()) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $agencia = $em->getRepository(Agencia::class)
            ->findOneBy(
                [
                    'codBanco' => $this->getRequest()->get('codBanco'),
                    'numAgencia' => $object->getNumAgencia(),
                ]
            );

        if ($agencia) {
            $error = $this->getTranslator()->trans('label.monetarioAgencia.erroAgencia');
            $errorElement->with('numAgencia')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNomAgencia())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioAgencia.modulo');
    }
}
