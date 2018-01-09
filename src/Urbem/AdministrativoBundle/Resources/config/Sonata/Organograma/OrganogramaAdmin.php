<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Organograma;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class OrganogramaAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma
 */
class OrganogramaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_organograma';
    protected $baseRoutePattern = 'administrativo/organograma/organograma';

    protected $model = OrganogramaModel::class;

    protected $defaultObjectId = 'codOrganograma';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_norma', 'consultar-norma/' . $this->getRouterIdParameter());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('implantacao', null, [
                'label' => 'label.organograma.implantacao'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy'
            ])
            ->add('ativo', null, [
                'label' => 'label.ativo'
            ])
            ->add('permissaoHierarquica', null, [
                'label' => 'label.organograma.permissaoHierarquica'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codOrganograma', null, ['label' => 'label.codigo'])
            ->add('implantacao', null, ['label' => 'label.organograma.implantacao'])
            ->add('ativo', null, ['label' => 'label.ativo'])
            ->add('permissaoHierarquica', null, ['label' => 'label.organograma.permissaoHierarquica'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        array_push($this->includeJs, '/administrativo/javascripts/organograma/organograma/form.js');

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var Organograma $organograma */
        $organograma = $this->getSubject();

        $dtImplantacao = new \DateTime();

        if ($id) {
            $dtImplantacao = $organograma->getImplantacao();
        }

        $fieldOptions = [];
        $fieldOptions['implantacao'] = [
            'format' => 'dd/MM/yyyy',
            'data'   => $dtImplantacao,
            'label'  => 'label.organograma.implantacao',
        ];

        $fieldOptions['permissaoHierarquica'] = [
            'choices'    => ['sim' => true, 'nao' => false],
            'data'       => false,
            'label'      => 'label.organograma.permissaoHierarquica',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr'       => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['fkNormasNorma.fkNormasTipoNorma'] = [
            'attr'          => ['class' => 'select2-parameters'],
            'class'         => TipoNorma::class,
            'label'         => 'label.organograma.codTipoNorma',
            'mapped'        => false,
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('n')
                    ->orderBy('n.nomTipoNorma');
            }
        ];

        $fieldOptions['fkNormasNorma'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => Norma::class,
            'choice_label' => 'nomNorma',
            'label'        => 'label.organograma.codNorma',
            'placeholder'  => 'label.selecione',
            'required'     => true,
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('n')
                    ->orderBy('n.numNorma, n.exercicio', 'ASC');
            }
        ];

        $niveis = [];
        if ($this->id($organograma)) {
            /** @var ModelManager $modelManager */
            $modelManager = $this->getModelManager();

            $niveis = $modelManager->findBy(OrgaoNivel::class, [
                'codOrganograma' => $organograma->getCodOrganograma()
            ]);

            $norma = $organograma->getFkNormasNorma();
            $fieldOptions['fkNormasNorma.fkNormasTipoNorma']['data'] = $norma->getFkNormasTipoNorma();
            $fieldOptions['fkNormasNorma']['data'] = $norma;
        }

        $formMapper
            ->with('label.organograma.dadosOrganograma')
                ->add('implantacao', 'sonata_type_date_picker', $fieldOptions['implantacao'])
                ->add('fkNormasNorma.fkNormasTipoNorma', 'entity', $fieldOptions['fkNormasNorma.fkNormasTipoNorma'])
                ->add('fkNormasNorma', 'entity', $fieldOptions['fkNormasNorma'])
                ->add('permissaoHierarquica', 'choice', $fieldOptions['permissaoHierarquica'])
            ->end();

        $formMapper->with('label.organograma.dadosNivel');

        if (empty($niveis)) {
            $formMapper->add('fkOrganogramaNiveis', 'sonata_type_collection', [
                'label'        => false
            ], [
                'edit'     => 'inline',
                'inline'   => 'table',
                'sortable' => 'position'
            ]);
        } else {
            $formMapper->add('fkOrganogramaNiveis', 'customField', [
                'attr'     => ['class' => 'row '],
                'data'     => [
                    'value'  => $this->trans('organograma.niveisNaoExibidos', [], 'flashes')
                ],
                'label'    => false,
                'mapped'   => false,
                'template' => 'CoreBundle:Sonata\CRUD:edit_generic.html.twig'
            ]);
        }

        $formMapper->end();

        $formMapper
            ->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $fieldOptions) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    if (isset($data['fkNormasNorma__fkNormasTipoNorma'])
                        && !empty(isset($data['fkNormasNorma__fkNormasTipoNorma']))
                    ) {
                        $fieldOptions['fkNormasNorma']['auto_initialize'] = false;
                        $fieldOptions['fkNormasNorma']['query_builder'] =
                            function (EntityRepository $repository) use ($data) {
                                return $repository
                                    ->createQueryBuilder('n')
                                    ->where('n.codTipoNorma = :cod_tipo_norma')
                                    ->setParameter('cod_tipo_norma', $data['fkNormasNorma__fkNormasTipoNorma'])
                                    ->orderBy('n.numNorma, n.exercicio', 'ASC');
                            };

                        $fieldFkNormasNorma = $formMapper
                            ->getFormBuilder()
                            ->getFormFactory()
                            ->createNamed('fkNormasNorma', 'entity', null, $fieldOptions['fkNormasNorma']);

                        $form->add($fieldFkNormasNorma);
                    }
                }
            );
    }

    /**
     * @param ErrorElement $errorElement
     * @param Organograma  $organograma
     */
    public function validate(ErrorElement $errorElement, $organograma)
    {
        if (preg_match('/(create)/', $this->getRequest()->getUri())) {
            if ($organograma->getFkOrganogramaNiveis()->isEmpty()) {
                $message = $this->trans('organograma.errors.semNiveis', [], 'validators');
                $errorElement->with('fkOrganogramaNiveis')->addViolation($message)->end();
            }

            /** @var ModelManager $modelManager */
            $modelManager = $this->modelManager;
            $entityManager = $modelManager->getEntityManager($this->getClass());

            $today = new \DateTime();

            if ($organograma->getImplantacao() < $today) {
                $organogramasAtivos = (new OrganogramaModel($entityManager))->getOrganogramaAtivo($today);

                /** @var Organograma $organogramaAtivo */
                $organogramaAtivo = end($organogramasAtivos);

                if ($organogramaAtivo->getImplantacao() > $organograma->getImplantacao()) {
                    $message = $this->trans('organograma.errors.dataAnteriorVigente', [], 'validators');
                    $errorElement->with('implantacao')->addViolation($message)->end();
                }
            }

            $organogramas = $modelManager->findOneBy(Organograma::class, [
                'implantacao' => $organograma->getImplantacao()
            ]);

            if (count($organogramas) > 0) {
                $message = $this->trans('organograma.errors.implantacaoExistente', [], 'validators');
                $errorElement->with('implantacao')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param Organograma $organograma
     */
    public function persistFkOrganogramaNiveis(Organograma $organograma)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $nivelRepository = $entityManager->getRepository(Nivel::class);

        $codNivel = $nivelRepository->nextCodNivel($organograma->getCodOrganograma());

        /** @var Nivel $nivel */
        foreach ($organograma->getFkOrganogramaNiveis() as $nivel) {
            if (is_null($nivel->getFkOrganogramaOrganograma())) {
                $nivel->setCodNivel($codNivel);
                $nivel->setFkOrganogramaOrganograma($organograma);
                $codNivel++;
            }
        }
    }

    /**
     * @param Organograma $organograma
     */
    public function prePersist($organograma)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;
        $entityManager = $modelManager->getEntityManager($this->getClass());

        $codOrganograma = (new OrganogramaModel($entityManager))->getProximoCodOrganograma();
        $organograma->setCodOrganograma($codOrganograma);

        /** @var Organograma $organogramaAtivo */
        $organogramaAtivo = $modelManager->findOneBy(Organograma::class, ['ativo' => true]);

        if (is_null($organogramaAtivo)) {
            $organograma->setAtivo(true);
        }

        $this->persistFkOrganogramaNiveis($organograma);
    }

    /**
     * @param Organograma $organograma
     */
    public function preUpdate($organograma)
    {
        $this->persistFkOrganogramaNiveis($organograma);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $organogramaModel = new OrganogramaModel($entityManager);

        $organograma = $this->getSubject();
        $orgaosNivel = $organogramaModel->getOrganogramaByCodOrganograma($organograma->getCodOrganograma());

        $showMapper
            ->with('label.organograma.visualizacao')
            ->add('fkNormasNorma.fkNormasTipoNorma', null, ['label' => 'label.organograma.codTipoNorma'])
            ->add('fkNormasNorma', null, ['label' => 'label.organograma.codNorma'])
            ->add('permissaoHierarquica', null, ['label' => 'label.organograma.permissaoHierarquica'])
            ->add('organograma', null, [
                'label' => $organograma,
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                'data' => $orgaosNivel
            ])
            ->end()
        ;
    }
}
