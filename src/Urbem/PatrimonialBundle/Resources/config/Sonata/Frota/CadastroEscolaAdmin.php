<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Frota\Escola;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository\SwCgmRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEscolaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_cadastro_escola';

    protected $baseRoutePattern = 'patrimonial/frota/cadastro-escola';

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkSwCgm',
                null,
                [
                    'label' => 'label.cgmEscola',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Frota\Escola',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add('ativo')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkSwCgm',
                'entity',
                [
                    'class' => 'CoreBundle:SwCgm',
                    'associated_property' => function (SwCgm $numcgm) {
                        return $numcgm;
                    },
                    'label' => 'label.cgmEscola'
                ]
            )
            ->add('ativo')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $admin = $this;

        $fieldOptions = [];

        $fieldOptions['fkSwCgm'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (SwCgmRepository $repository, $term, Request $request) use ($admin) {
                /** @var EntityManager $em */
                $entityManager = $admin->modelManager->getEntityManager(SwCgm::class);
                $queryBuilder = (new SwCgmModel($entityManager))->findLikeQuery(['nomCgm'], $request->get('q'));
                $rootAlias = $queryBuilder->getRootAlias();

                return $queryBuilder
                    ->join("{$rootAlias}.fkSwCgmPessoaJuridica", 'cgm_pessoa_juridica')
                    ->andWhere(
                        $queryBuilder->expr()->notIn(
                            $rootAlias,
                            $repository->createQueryBuilder('notThisCgm')
                                ->select('notThisCgm')
                                ->join('notThisCgm.fkFrotaEscola', 'escola')
                                ->getDQL()
                        )
                    )
                    ->orderBy("{$rootAlias}.nomCgm")
                ;
            },
            'label' => 'label.cgmEscola',
            'placeholder' => $this->trans('label.selecione')
        ];

        if ($id) {
            $fieldOptions['fkSwCgm']['disabled'] = true;
        }

        $formMapper
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'])
            ->add('ativo')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'fkSwCgm',
                'entity',
                [
                    'class' => 'CoreBundle:SwCgm',
                    'choice_label' => function (SwCgm $cgm) {
                        return $cgm->getNumcgm() . ' - ' .
                        $cgm->getNomCgm();
                    },
                    'label' => 'label.cgmEscola'
                ]
            )
            ->add('ativo')
        ;
    }
}
