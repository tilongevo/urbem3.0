<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Repository\Orcamento\EntidadeRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Administracao;

class AssinaturaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_assinatura';
    protected $baseRoutePattern = 'administrativo/administracao/assinatura';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('search_by_entidade_modulo', 'api/search/{entidade}/{modulo}');
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        /** @var QueryBuilder $qb */
        $qb = parent::createQuery($context);
        $qb->select('o', 'fkAdministracaoAssinaturaCrc');
        $qb->leftJoin('o.fkAdministracaoAssinaturaCrc', 'fkAdministracaoAssinaturaCrc');

        /* http://redmine.longevo.com.br/issues/342#note-12 */
        /** @var QueryBuilder $sub */
        $sub = $this->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Administracao\Assinatura::class)
            ->createQueryBuilder('subquery');

        $sub->select('DISTINCT(CONCAT(subquery.exercicio, subquery.codEntidade, subquery.numcgm, MAX(subquery.timestamp)))');
        $sub->groupBy('subquery.exercicio, subquery.codEntidade, subquery.numcgm');
        $sub->andWhere('subquery.exercicio = :exercicio');
        $sub->setParameter('exercicio', $exercicio);

        $qb->andWhere($qb->expr()->in('CONCAT(o.exercicio, o.codEntidade, o.numcgm, o.timestamp)', $sub->getDQL()));
        $qb->andWhere('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->getQuery()->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);

        return $qb;
    }

    public function preUpdate($assinatura)
    {
        /** @var Administracao\Assinatura $assinatura */

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(Administracao\Assinatura::class);

        $inscricaoCrcData = $this->getForm()->get('assinaturaCrc')->getData();

        if (false === empty($inscricaoCrcData)) {
            $assinaturaCrc = $assinatura->getFkAdministracaoAssinaturaCrc();
            $assinaturaCrc = null === $assinaturaCrc ? new Administracao\AssinaturaCrc() : $assinaturaCrc;
            $assinaturaCrc->setInscCrc($inscricaoCrcData);
            $assinatura->setFkAdministracaoAssinaturaCrc($assinaturaCrc);
        } elseif (false === empty($assinatura->getFkAdministracaoAssinaturaCrc())) {
            $em->remove($assinatura->getFkAdministracaoAssinaturaCrc());
        }

        $moduloData = new ArrayCollection($this->getForm()->get('assinaturaModulo')->getData());

        /** @var Administracao\AssinaturaModulo $assinaturaModulo */
        foreach ($assinatura->getFkAdministracaoAssinaturaModulos() as $assinaturaModulo) {
            $isSet = 1 <= $moduloData->filter(function (Administracao\Modulo $modulo) use ($assinaturaModulo) {
                return $assinaturaModulo->getFkAdministracaoModulo() === $modulo;
            })->count();

            if (true === $isSet) {
                continue;
            }

            $assinatura->removeFkAdministracaoAssinaturaModulos($assinaturaModulo);
        }

        foreach ($moduloData as $modulo) {
            $isSet = 1 <= $assinatura->getFkAdministracaoAssinaturaModulos()->filter(function (Administracao\AssinaturaModulo $assinaturaModulo) use ($modulo) {
                return $modulo === $assinaturaModulo->getFkAdministracaoModulo();
            })->count();

            if (true === $isSet) {
                continue;
            }

            $assinaturaModulo = new Administracao\AssinaturaModulo();
            $assinaturaModulo->setFkAdministracaoModulo($modulo);

            $assinatura->addFkAdministracaoAssinaturaModulos($assinaturaModulo);
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var Administracao\Assinatura $object */
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $found = $em->getRepository(Administracao\Assinatura::class)->findOneBy([
            'exercicio' => $object->getExercicio(),
            'fkOrcamentoEntidade' => $object->getFkOrcamentoEntidade(),
            'fkSwCgmPessoaFisica' => $object->getFkSwCgmPessoaFisica(),
        ]);

        $error = sprintf(
            'Registro duplicados',
            $this->getContainer()->get('translator')->trans('label.assinatura.exercicio'),
            $this->getContainer()->get('translator')->trans('label.assinatura.codEntidade'),
            $this->getContainer()->get('translator')->trans('label.assinatura.numcgm')
        );

        if (/* insert */
            (UnitOfWork::STATE_NEW === $em->getUnitOfWork()->getEntityState($object) && $found instanceof Administracao\Assinatura)

            ||

            /* update */
            ($found instanceof Administracao\Assinatura && $found !== $object)
        ) {
            $errorElement->addViolation($error);
        }
    }

    public function prePersist($assinatura)
    {
        /** @var Administracao\Assinatura $assinatura */
        $em = $this->getDoctrine();
        $assinatura->setExercicio($this->getExercicio());

        foreach ($this->getForm()->get('assinaturaModulo')->getData() as $modulo) {
            $assinaturaModulo = new Administracao\AssinaturaModulo();
            $assinaturaModulo->setFkAdministracaoModulo($modulo);

            $assinatura->addFkAdministracaoAssinaturaModulos($assinaturaModulo);
        }

        if ($this->getForm()->get('assinaturaCrc')->getData()) {
            $assinaturaCrc = new Administracao\AssinaturaCrc();
            $assinaturaCrc->setFkAdministracaoAssinatura($assinatura);
            $assinaturaCrc->setInscCrc($this->getForm()->get('assinaturaCrc')->getData());
            $assinaturaCrc->setExercicio($assinatura->getExercicio());

            $em->persist($assinaturaCrc);

            $assinatura->setFkAdministracaoAssinaturaCrc($assinaturaCrc);
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add(
            'fkOrcamentoEntidade',
            'composite_filter',
            ['label' => 'label.assinatura.codEntidade'],
            null,
            [
                'class' => Entidade::class,
                'query_builder' => function (EntidadeRepository $entidadeRepository) {
                    return $entidadeRepository->withExercicioQueryBuilder($this->getExercicio());
                }
            ],
            ['admin_code' => 'financeiro.admin.entidade']
        );

        $datagridMapper->add(
            'fkSwCgmPessoaFisica.fkSwCgm',
            'doctrine_orm_model_autocomplete',
            ['label' => 'label.assinatura.numcgm',],
            'sonata_type_model_autocomplete',
            [
                'class' => SwCgm::class,
                'property' => 'nomCgm',
                'attr' => ['class' => 'select2-parameters'],
            ],
            ['admin_code' => 'core.admin.filter.sw_cgm']
        );

        $datagridMapper->add('cargo');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.assinatura.codEntidade'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.nomCgm', null, ['label' => 'label.assinatura.assinante'])
            ->add('cargo')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $fieldOptions = [];

        $fieldOptions['exercicio'] = [
            'label' => 'label.assinatura.exercicio',
            'attr' => [
                'disabled' => true
            ],
            'mapped' => false
        ];

        $fieldOptions['fkOrcamentoEntidade'] = [
            'choice_label' => function ($codEntidade) {
                $rtn = $codEntidade->getCodEntidade();
                $rtn .= ' - '.$codEntidade->getFkSwCgm()->getNomCgm();
                return $rtn;
            },
            'label' => 'label.assinatura.codEntidade',
            'placeholder' => 'label.selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function (EntidadeRepository $er) use ($exercicio) {
                return $er->withExercicioQueryBuilder($exercicio);
            },
            'required' => true,
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label' => 'label.assinatura.numcgm',
            'callback' => function ($admin, $property, $value) {
                $datagrid = $admin->getDatagrid();
                $query = $datagrid->getQuery();

                $fkSwCgm = sprintf('%s.fkSwCgm', $query->getRootAlias());
                $query->join($fkSwCgm, 'cgm');
                $query->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm');
                $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                $datagrid->setValue($property, null, $value);
            },
            'property' => 'fkSwCgm.nomCgm',
            'to_string_callback' => function (SwCgmPessoaFisica $pessoaFisica, $property) {
                return strtoupper($pessoaFisica->getFkSwCgm()->getNumcgm() . ' - ' . $pessoaFisica->getFkSwCgm()->getNomCgm());
            },
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
        ];

        $fieldOptions['assinaturaCrc'] = [
            'label' => 'label.assinatura.assinaturaCrc',
            'attr' => [
                'maxlength' => 10
            ],
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['assinaturaModulo'] = [
            'class' => 'CoreBundle:Administracao\Modulo',
            'choice_label' => 'nomModulo',
            'label' => 'label.assinatura.assinaturaModulo',
            'placeholder' => 'label.selecione',
            'multiple' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ']
        ];

        if ($this->id($this->getSubject())) {
            $assinatura = $this->getSubject();

            $fieldOptions['exercicio']['data'] = $assinatura->getExercicio();
            $fieldOptions['fkOrcamentoEntidade']['data'] = $assinatura->getFkOrcamentoEntidade();

            $selectedModulos = [];
            $modulos = $assinatura->getFkAdministracaoAssinaturaModulos();
            foreach ($modulos as $modulo) {
                $selectedModulos[] = $modulo->getFkAdministracaoModulo();
            }
            $fieldOptions['assinaturaModulo']['data'] = $selectedModulos;

            $assinaturaCrc = $assinatura->getFkAdministracaoAssinaturaCrc();

            if ($assinaturaCrc) {
                $fieldOptions['assinaturaCrc']['data'] = $assinaturaCrc->getInscCrc();
            }
        } else {
            $fieldOptions['exercicio']['data'] = $exercicio;
        }

        $formMapper
            ->with('label.assinatura.dadosConfiguracao')
            ->add('exercicio', null, $fieldOptions['exercicio'])
            ->add(
                'fkOrcamentoEntidade',
                null,
                $fieldOptions['fkOrcamentoEntidade'],
                ['admin_code' => 'financeiro.admin.entidade']
            )
            ->add(
                'fkSwCgmPessoaFisica',
                'sonata_type_model_autocomplete',
                $fieldOptions['fkSwCgmPessoaFisica'],
                ['admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica']
            )
            ->add('cargo', null, ['label' => 'label.assinatura.cargo'])
            ->add('assinaturaCrc', 'text', $fieldOptions['assinaturaCrc'])
            ->add('assinaturaModulo', 'entity', $fieldOptions['assinaturaModulo'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('exercicio', null, ['label' => 'label.assinatura.exercicio'])
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.assinatura.codEntidade'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.nomCgm', null, ['label' => 'label.assinatura.numcgm'])
            ->add('cargo', null, ['label' => 'label.assinatura.cargo'])
            ->add('fkAdministracaoAssinaturaCrc', null, ['label' => 'label.assinatura.assinaturaCrc'])
            ->add('fkAdministracaoAssinaturaModulos', null, ['label' => 'label.assinatura.assinaturaModulo'])
        ;
    }
}
