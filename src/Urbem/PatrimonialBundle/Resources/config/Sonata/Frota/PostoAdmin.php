<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Frota\Posto;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Patrimonial\Frota\PostoModel;

class PostoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_posto';
    protected $baseRoutePattern = 'patrimonial/frota/posto';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkSwCgmPessoaJuridica', 'doctrine_orm_model_autocomplete', [
                'label' => 'label.posto.posto',
            ], 'sonata_type_model_autocomplete', [
                'attr' => ['class' => 'select2-parameters '],
                'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();

                    /** @var QueryBuilder|ProxyQueryInterface $query */
                    $query = $datagrid->getQuery();

                    $rootAlias = $query->getRootAlias();
                    $query->join("{$rootAlias}.fkFrotaPosto", "fkFrotaPosto");

                    $datagrid->setValue($property, 'LIKE', $value);
                },
                'placeholder' => $this->trans('label.selecione'),
                'property' => 'fkSwCgm.nomCgm'
            ], [
                'admin_code' => 'administrativo.admin.sw_cgm_admin_pj'
            ])
            ->add('interno', null, [
                'label' => 'label.posto.interno'
            ])
            ->add('ativo');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgmPessoaJuridica', null, [
                'label' => 'Posto'
            ])
            ->add('interno', 'boolean', [
                'label' => 'label.posto.interno',
                'sortable' => false
            ])
            ->add('ativo', 'boolean', [
                'label' => 'label.posto.ativo',
                'sortable' => false
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager(SwCgmPessoaJuridica::class);

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $swCgmPessoaJuridicaModel = new SwCgmPessoaJuridicaModel($em);
        $swCgmPessoaJuridicaEntity = $swCgmPessoaJuridicaModel->getDisponiveis($id);

        $fieldOptions['fkSwCgmPessoaJuridica'] = [
            'label' => 'label.posto.posto',
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
            'placeholder' => 'Selecione'
        ];

        if ($id) {
            $posto = $em->getRepository('CoreBundle:Frota\Posto')->find($id);
            $fieldOptions['fkSwCgmPessoaJuridica']['data'] = $posto->getFkSwCgmPessoaJuridica();
            $fieldOptions['fkSwCgmPessoaJuridica']['mapped'] = false;
            $fieldOptions['fkSwCgmPessoaJuridica']['disabled'] = true;
            $fieldOptions['fkSwCgmPessoaJuridica']['attr'] = [
                'class' => 'select2-parameters '
            ];
        } else {
            $fieldOptions['cgmPosto']['query_builder'] = $swCgmPessoaJuridicaEntity;
        }

        $formMapper
            ->add(
                'fkSwCgmPessoaJuridica',
                'autocomplete',
                $fieldOptions['fkSwCgmPessoaJuridica']
            )
            ->add('interno')
            ->add('ativo');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkSwCgmPessoaJuridica.nomFantasia', null, [
                'label' => 'label.posto.posto'
            ])
            ->add('interno', null, [
                'label' => 'label.posto.interno'
            ])
            ->add('ativo')
        ;
    }

    /**
     * @param Posto $posto
     */
    public function prePersist($posto)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getRequest()->request->get($this->getUniqid());

        (new PostoModel($entityManager))
            ->savePostoResponsavel($posto, $form);
    }
}
