<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Frota\Escola;
use Urbem\CoreBundle\Entity\Frota\TransporteEscolar;
use Urbem\CoreBundle\Entity\Frota\Turno;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Model\Patrimonial\Frota\TransporteEscolarModel;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\VeiculoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class TransporteEscolarAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class TransporteEscolarAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_transporte_escolar';
    protected $baseRoutePattern = 'patrimonial/frota/transporte-escolar';

    protected $exibirBotaoVoltarNoList = true;

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $proxyQuery */
        $proxyQuery = parent::createQuery($context);

        $rootAlias = $proxyQuery->getRootAlias();
        $proxyQuery->join("{$rootAlias}.fkFrotaTransporteEscolares", "transportesEscolares");

        return $proxyQuery;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio', 'doctrine_orm_callback', [
                'callback' => [$this, 'configureSearchFilter'],
                'label' => 'label.exercicio'
            ])
            ->add('escola', 'doctrine_orm_callback', [
                'callback' => [$this, 'configureSearchFilter'],
                'label' => 'label.cgmEscola',
            ], 'entity', [
                'attr' => ['class' => 'select2-parameters '],
                'class' => Escola::class,
                'query_builder' => function (EntityRepository $repository) {
                    $queryBuilder = $repository->createQueryBuilder('escola');
                    $queryBuilder->join('escola.fkFrotaTransporteEscolares', 'transportesEscolares');

                    return $queryBuilder;
                }
            ])
            ->add('veiculo', 'doctrine_orm_callback', [
                'callback' => [$this, 'configureSearchFilter'],
                'label' => 'label.infracao.codVeiculo',
            ], 'entity', [
                'attr' => ['class' => 'select2-parameters '],
                'class' => Veiculo::class,
                'query_builder' => function (VeiculoRepository $repository) {
                    $queryBuilder = $repository->createQueryBuilder('veiculo');
                    $queryBuilder->join('veiculo.fkFrotaTransporteEscolares', 'transportesEscolares');

                    return $queryBuilder;
                }
            ])
        ;
    }

    /**
     * @param ProxyQuery|QueryBuilder   $queryBuilder
     * @param string                    $alias
     * @param string                    $field
     * @param array                     $data
     * @return boolean|void
     */
    public function configureSearchFilter($queryBuilder, $alias, $field, $data)
    {
        if (!$data['value']) {
            return;
        } else {
            $fkAlias = $queryBuilder->getAllAliases()[1];
        }

        $filter = $this->getDatagrid()->getValues();

        if (true == isset($filter['exercicio'])
            && false == empty($filter['exercicio']['value'])) {
            $queryBuilder
                ->andWhere("{$fkAlias}.exercicio = :exercicio")
                ->setParameter("exercicio", $filter['exercicio']['value'])
            ;
        }

        if (true == isset($filter['escola'])
            && false == empty($filter['escola']['value'])) {
            /** @var Escola $escola */
            $escola = $this->modelManager->find(Escola::class, $filter['escola']['value']);

            $queryBuilder
                ->andWhere("{$fkAlias}.fkFrotaEscola = :escola")
                ->setParameter("escola", $escola)
            ;
        }

        if (true == isset($filter['veiculo'])
            && false == empty($filter['veiculo']['value'])) {
            /** @var Veiculo $veiculo */
            $veiculo = $this->modelManager->find(Veiculo::class, $filter['veiculo']['value']);

            $queryBuilder
                ->andWhere("{$fkAlias}.fkFrotaVeiculo = :veiculo")
                ->setParameter("veiculo", $veiculo)
            ;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $baseTemplatePath = 'PatrimonialBundle:Sonata/Frota/TransporteEscolar/CRUD:list__##file_suffix##.html.twig';

        $listMapper
            ->add('exercicio', null, [
                'label' => 'label.exercicio',
                'template' => str_replace('##file_suffix##', 'exercicio', $baseTemplatePath)
            ])
            ->add('fkSwCgm', 'text', ['label' => 'label.cgmEscola'])
            ->add('veiculo', null, [
                'label' => 'label.infracao.codVeiculo',
                'template' => str_replace('##file_suffix##', 'veiculo', $baseTemplatePath)
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * Cria um grupo de campos baseado no mes cadastrado em administracao.mes
     *
     * @param FormMapper $formMapper
     * @param Escola $escola
     */
    protected function configureFormFieldsBasedOnMes(FormMapper $formMapper, Escola $escola = null)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $meses = $em->getRepository(Mes::class)->findAll();

        /** @var Turno $defaultTurno */
        $defaultTurno = $this->modelManager->find(Turno::class, Turno::NAO_INFORMADO);

        $fieldOptions = [];
        $fieldOptions['passageiros'] = [
            'label' => 'label.patrimonial.frota.transporteEscolar.passageiros',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['distancia'] = [
            'label' => 'label.patrimonial.frota.transporteEscolar.distancia',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['rodados'] = [
            'label' => 'label.patrimonial.frota.transporteEscolar.diasRodados',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['turno'] = [
            'attr' => ['class' => 'select2-parameters  '],
            'class' => Turno::class,
            'choice_label' => 'descricao',
            'label' => 'label.patrimonial.frota.transporteEscolar.turno',
            'mapped' => false,
            'required' => false
        ];

        /** @var Mes $mes */
        foreach ($meses as $mes) {
            if (false == is_null($escola)) {
                /** @var ArrayCollection $transporteEscolarCollection */
                $transporteEscolarCollection = $escola->getFkFrotaTransporteEscolares();

                $criteria = Criteria::create();
                $criteria = $criteria
                    ->where(
                        $criteria->expr()->eq('mes', $mes->getCodMes())
                    )
                ;

                /** @var TransporteEscolar $transporteEscolar */
                $transporteEscolar = $transporteEscolarCollection->matching($criteria)->first();
            }

            $fieldOptions['passageiros']['data'] =
                true == isset($transporteEscolar) ? $transporteEscolar->getPassageiros() : 0;

            $fieldOptions['distancia']['data'] =
                true == isset($transporteEscolar) ? $transporteEscolar->getDistancia() : 0;

            $fieldOptions['rodados']['data'] =
                true == isset($transporteEscolar) ? $transporteEscolar->getDiasRodados() : 0;

            $fieldOptions['turno']['data'] =
                true == isset($transporteEscolar) ? $transporteEscolar->getFkFrotaTurno() : $defaultTurno;

            $formMapper
                ->with($mes->getDescricao())
                    ->add(sprintf("passageiros_%s", $mes->getCodMes()), 'integer', $fieldOptions['passageiros'])
                    ->add(sprintf("distancia_%s", $mes->getCodMes()), 'integer', $fieldOptions['distancia'])
                    ->add(sprintf("diasRodados_%s", $mes->getCodMes()), 'integer', $fieldOptions['rodados'])
                    ->add(sprintf("turno_%s", $mes->getCodMes()), 'entity', $fieldOptions['turno'])
                ->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $objectKey = $this->getAdminRequestId();
        $exercicio = $this->getExercicio();

        if (true == is_null($objectKey)) {
            $this->setBreadCrumb([]);
            $disabled = false;
        } else {
            $this->setBreadCrumb(['id' => $objectKey]);

            /** @var Escola $escola */
            $escola = $this->modelManager->find(Escola::class, $objectKey);
            $disabled = true;
        }

        $fieldOptions = [];
        $fieldOptions['veiculo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Veiculo::class,
            'disabled' => $disabled,
            'label' => 'label.infracao.codVeiculo',
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['escola'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Escola::class,
            'disabled' => $disabled,
            'label' => 'label.cgmEscola',
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        if (true == isset($escola)) {
            /** @var TransporteEscolar $transporteEscolar */
            $transporteEscolar = $escola->getFkFrotaTransporteEscolares()->last();

            $fieldOptions['veiculo']['data'] = $transporteEscolar->getFkFrotaVeiculo();

            $fieldOptions['escola']['data'] = $escola;
        } else {
            $fieldOptions['escola']['query_builder'] = function (EntityRepository $repository) use ($exercicio) {
                $queryBuilder = $repository->createQueryBuilder('escola');
                $queryBuilder
                    ->setParameter('exercicio', $exercicio)
                    ->where(
                        $queryBuilder->expr()->notIn(
                            'escola',
                            $repository->createQueryBuilder('notTheseEscolas')
                                ->join('notTheseEscolas.fkFrotaTransporteEscolares', 'transportesEscolares')
                                ->where('transportesEscolares.exercicio = :exercicio')
                                ->getDQL()
                        )
                    )
                    ->andWhere('escola.ativo = true')
                ;

                return $queryBuilder;
            };
        }

        $formMapper
            ->with('label.patrimonial.frota.transporteEscolar.dadosVeiculo')
                ->add('veiculo', 'entity', $fieldOptions['veiculo'])
                ->add('escola', 'entity', $fieldOptions['escola'])
            ->end();

        if (true == isset($escola)) {
            $this->configureFormFieldsBasedOnMes($formMapper, $escola);
        } else {
            $this->configureFormFieldsBasedOnMes($formMapper);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectKey = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectKey]);

        /** @var Escola $escola */
        $escola = $this->getSubject();

        /** @var \ArrayIterator $iterator */
        $iterator = $escola->getFkFrotaTransporteEscolares()->getIterator();

        $iterator->uasort(function (TransporteEscolar $firstEntity, TransporteEscolar $secondEntity) {
            return $firstEntity->getMes() > $secondEntity->getMes() ? 1 : -1 ;
        });

        $escola->setFkFrotaTransporteEscolares(new ArrayCollection($iterator->getArrayCopy()));
    }

    /**
     * @param mixed $dumbObject
     * @return Response
     */
    public function prePersist($dumbObject)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        $meses = $em->getRepository(Mes::class)->findAll();

        /** @var Veiculo $veiculo */
        $veiculo = $form->get('veiculo')->getData();

        /** @var Escola $escola */
        $escola = $form->get('escola')->getData();

        $customFormData['exercicio'] = $this->getExercicio();

        /** @var Mes $mes */
        foreach ($meses as $mes) {
            /** @var Turno $turno */
            $turno = $form->get(sprintf('turno_%s', $mes->getCodMes()))->getData();

            $customFormData['passageiros'] = $form->get(sprintf('passageiros_%s', $mes->getCodMes()))->getData();
            $customFormData['distancia'] = $form->get(sprintf('distancia_%s', $mes->getCodMes()))->getData();
            $customFormData['diasRodados'] =$form->get(sprintf('diasRodados_%s', $mes->getCodMes()))->getData();

            if (true == is_null($turno)) {
                /** @var Turno $defaultTurno */
                $turno = $this->modelManager->find(Turno::class, Turno::NAO_INFORMADO);
            }

            $transporteEscolar = (new TransporteEscolarModel($em))
                ->createTransporteEscolar($mes, $veiculo, $escola, $turno, $customFormData);
        }

        $routeName = $this->baseRouteName . '_show';
        return $this->redirectByRoute($routeName, ['id' => $this->getObjectKey($escola)]);
    }

    /**
     * @param Escola $escola
     * @return Response
     */
    public function preUpdate($escola)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        /** @var TransporteEscolar $transporteEscolar */
        foreach ($escola->getFkFrotaTransporteEscolares() as $transporteEscolar) {
            /** @var Turno $turno */
            $turno = $form->get(sprintf('turno_%s', $transporteEscolar->getMes()))->getData();

            $customFormData['passageiros'] = $form
                ->get(sprintf('passageiros_%s', $transporteEscolar->getMes()))
                ->getData();

            $customFormData['distancia'] = $form
                ->get(sprintf('distancia_%s', $transporteEscolar->getMes()))
                ->getData();

            $customFormData['diasRodados'] =$form
                ->get(sprintf('diasRodados_%s', $transporteEscolar->getMes()))
                ->getData();

            if (true == is_null($turno)) {
                /** @var Turno $defaultTurno */
                $turno = $this->modelManager->find(Turno::class, Turno::NAO_INFORMADO);
            }

            $transporteEscolar = (new TransporteEscolarModel($em))
                ->updateTransporteEscolar($transporteEscolar, $turno, $customFormData);
        }

        $routeName = $this->baseRouteName . '_show';
        return $this->redirectByRoute($routeName, ['id' => $this->getObjectKey($escola)]);
    }

    /**
     * @param Escola $escola
     * @return Response
     */
    public function preRemove($escola)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new TransporteEscolarModel($em))->removeAllTransporteEscolaInEscola($escola);

        $routeName = $this->baseRouteName . '_list';
        return $this->redirectByRoute($routeName);
    }
}
