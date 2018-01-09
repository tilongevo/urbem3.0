<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use function foo\func;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\VeiculosPublicidadeModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class VeiculosPublicidadeAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class VeiculosPublicidadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_publicidade';
    protected $baseRoutePattern = 'patrimonial/licitacao/publicidade';

    protected $model = VeiculosPublicidadeModel::class;

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkLicitacaoTipoVeiculosPublicidade', null, [
                'label' => 'label.licitacaoPublicidade.tipoVeiculosPublicidade'
            ], null, [
                'attr' => ['class' => 'select2-parameters ']
            ])
            ->add('fkSwCgm', 'doctrine_orm_model_autocomplete', [
                'label' => 'label.licitacaoPublicidade.cgm'
            ], 'sonata_type_model_autocomplete', [
                'attr' => ['class' => 'select2-parameters '],
                'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                    $datagrid = $admin->getDatagrid();

                    /** @var QueryBuilder|ProxyQueryInterface $query */
                    $query = $datagrid->getQuery();

                    $rootAlias = $query->getRootAlias();
                    $query->join(
                        "{$rootAlias}.fkLicitacaoVeiculosPublicidade",
                        "fkLicitacaoVeiculosPublicidade"
                    );

                    $datagrid->setValue($property, 'LIKE', $value);
                },
                'to_string_callback' => function (SwCgm $swCgm, $property) {
                    return strtoupper($swCgm->getNomCgm());
                },
                'class' => SwCgm::class,
                'label' => 'nomcgm',
                'property' => 'nomCgm',
                'placeholder' => 'Selecione'
            ], [
                'admin_code' => 'core.admin.filter.sw_cgm'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkLicitacaoTipoVeiculosPublicidade', null, [
                'label' => 'label.licitacaoPublicidade.tipoVeiculosPublicidade'
            ])
            ->add('fkSwCgm', null, [
                'label' => 'label.licitacaoPublicidade.cgm'
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['fkLicitacaoTipoVeiculosPublicidade'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.licitacaoPublicidade.tipoVeiculosPublicidade',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        if (!$this->id($this->getSubject())) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $veiculoPublicidadeModel = new VeiculosPublicidadeModel($entityManager);
            $veiculosPublicidade = $veiculoPublicidadeModel->findAll();
            /** @var VeiculosPublicidade $veiculo */
            foreach ($veiculosPublicidade as $veiculo) {
                $cgms[] = $veiculo->getNumcgm();
            }

            $cgms = empty($cgms) ? 0 : $cgms;

            $type = 'sonata_type_model_autocomplete';
            $fieldOptions['fkSwCgm'] = [
                'container_css_class' => 'select2-v4-parameters ',
                'callback' => function (AbstractSonataAdmin $admin, $property, $value) use ($cgms) {
                    $datagrid = $admin->getDatagrid();

                    /** @var QueryBuilder|ProxyQueryInterface $query */
                    $query = $datagrid->getQuery();

                    $rootAlias = $query->getRootAlias();
                    $query
                        ->join("{$rootAlias}.fkSwCgmPessoaJuridica", "fkSwCgmPessoaJuridica")
                        ->andWhere("LOWER({$rootAlias}.nomCgm) LIKE :nomCgm")
                        ->andWhere($query->expr()->notIn("{$rootAlias}.numcgm", $cgms))
                        ->setParameter("nomCgm", "%{$value}%");

                    $datagrid->setValue($property, null, $value);
                },
                'property' => 'nomCgm',
                'label' => 'label.licitacaoPublicidade.cgm',
            ];
            $admincode = ['admin_code' => 'core.admin.filter.sw_cgm'];
        } else {
            $type = 'entity';
            $cgm = $this->getSubject()->getFkSwCgm()->getNumCgm();
            $fieldOptions['fkSwCgm'] = [
                'class' => SwCgm::class,
                'attr' => ['class' => 'select2-parameters '],
                'query_builder' => function (EntityRepository $entityRepository) use ($cgm) {
                    $queryBuilder = $entityRepository->createQueryBuilder('cgm')
                        ->where('cgm.numcgm = :cgm')
                        ->setParameter('cgm', $cgm);

                    return $queryBuilder;
                },
                'label' => 'label.licitacaoPublicidade.cgm',
            ];
            $admincode = [];
        }

        $formMapper
            ->add('fkLicitacaoTipoVeiculosPublicidade', null, $fieldOptions['fkLicitacaoTipoVeiculosPublicidade'])
            ->add('fkSwCgm', $type, $fieldOptions['fkSwCgm'], $admincode);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkLicitacaoTipoVeiculosPublicidade', null, [
                'label' => 'label.licitacaoPublicidade.tipoVeiculosPublicidade'
            ])
            ->add('fkSwCgm', null, [
                'label' => 'label.licitacaoPublicidade.cgm'
            ]);
    }

    /**
     * @param ErrorElement $errorElement
     * @param VeiculosPublicidade $veiculosPublicidade
     */
    public function validate(ErrorElement $errorElement, $veiculosPublicidade)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var SwCgm $fkSwCgm */
        $fkSwCgm = $this->getForm()->get('fkSwCgm')->getData();

        /** @var VeiculosPublicidade $veiculosPublicidadeClone */
        $veiculosPublicidadeClone = $entityManager
            ->getRepository(VeiculosPublicidade::class)
            ->findOneBy(['fkSwCgm' => $fkSwCgm]);
        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" != $route) {
            if (!is_null($veiculosPublicidadeClone)
                && $veiculosPublicidadeClone->getFkSwCgm()->getNumcgm() == $veiculosPublicidade->getFkSwCgm()->getNumcgm()
            ) {
                $message = $this->trans('licitacao.publicacao.errors.cgmPublicacaoEmUso', [
                    '%cgm%' => (string) $fkSwCgm
                ], 'validators');

                $errorElement->with('fkSwCgm')->addViolation($message)->end();
            }
        }
    }
}
