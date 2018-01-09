<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse\Conselho;
use Urbem\CoreBundle\Entity\Cse\Profissao;
use Urbem\CoreBundle\Entity\Economico\Responsavel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ResponsavelTecnicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_configuracao_responsavel_tecnico';
    protected $baseRoutePattern = 'financeiro/orcamento/configuracao/responsavel-tecnico';
    protected $includeJs = ['/financeiro/javascripts/orcamento/configuracao/responsavel_tecnico.js'];

    const PROFISSAO_CONTADOR = 'Contador';
    const PROFISSAO_TECNICO_CONTABILIDADE = 'Técnico de Contabilidade';

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->id($this->getSubject())) {
            return true;
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $numRegistro = $entityManager->getRepository(ResponsavelTecnico::class)
            ->findOneBy([
                'numcgm' => $object->getNumcgm()
            ]);

        if (!empty($numRegistro)) {
            $error = "Responsável técnico " . $object->getNumcgm() . " já cadastrado!";
            $errorElement->with('fkSwCgm')->addViolation($error)->end();
        }
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');

        if ($filter['fkSwCgm']['value'] != '') {
            $query->andWhere('o.fkSwCgm = :fkSwCgm');
            $query->setParameters([
                'fkSwCgm' => $filter['fkSwCgm']['value']
            ]);
        }

        if ($filter['codProfissao']['value'] != '') {
            $query->andWhere('o.codProfissao = :codProfissao');
            $query->setParameters([
                'codProfissao' => $filter['codProfissao']['value']
            ]);
        }

        if ($filter['codUf']['value'] != '') {
            $query->andWhere('o.codUf = :codUf');
            $query->setParameters([
                'codUf' => $filter['codUf']['value']
            ]);
        }

        return $query;
    }
    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $maxSequence = $entityManager->getRepository(ResponsavelTecnico::class)
            ->getMaxSequenciaByCgm($object->getFkSwCgm());
        $maxSequence = array_shift($maxSequence);

        $sequence = $maxSequence['max_sequencia'];
        if (is_null($sequence)) {
            $sequence = 1;
        } else {
            $sequence++;
        }

        $object->setSequencia($sequence);

        $responsavel = new Responsavel();
        $responsavel->setNumcgm($object->getNumCgm());
        $responsavel->setSequencia($sequence);

        $entityManager->persist($responsavel);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('numcgm'));

        $datagridMapper
            ->add(
                'codProfissao',
                null,
                [
                    'label' => 'label.profissao',
                ],
                'entity',
                [
                    'class' => Profissao::class,
                    'choice_label' => function ($profissao) {
                        return $profissao->getCodProfissao().' - '.$profissao->getNomProfissao();
                    },
                    'query_builder' => function ($em) {
                        return $em->createQueryBuilder('p')
                            ->where('p.nomProfissao = :contador OR p.nomProfissao = :tecnicoContabilidade')
                            ->setParameter('contador', self::PROFISSAO_CONTADOR)
                            ->setParameter('tecnicoContabilidade', self::PROFISSAO_TECNICO_CONTABILIDADE);
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_choice',
                array(
                    'label' => 'cgm',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'numRegistro',
                null,
                [
                    'label' => 'label.numIdentificacao'
                ]
            )
            ->add(
                'codUf',
                null,
                [
                    'label' => 'label.uf',
                ],
                'entity',
                [
                    'class' => SwUf::class,
                    'choice_label' => 'nomUf',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkSwCgm',
                'entity',
                [
                    'class' => SwCgm::class,
                    'choice_label' => 'nomCgm',
                    'label' => 'cgm',
                    'attr' => [
                        'class' => 'select2-parameters',
                        'sortable' => false
                    ],
                    'associated_property' => function ($numcgm) {
                        return sprintf("%s - %s", $numcgm->getNumcgm(), $numcgm->getNomCgm());
                    }
                ]
            )
            ->add(
                'fkCseProfissao',
                'entity',
                [
                    'class' => Profissao::class,
                    'label' => 'label.profissao',
                    'choice_label' => 'nomProfissao',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters',
                        'sortable' => false
                    ],
                    'associated_property' => function ($profissao) {
                        return sprintf("%s - %s", $profissao->getCodProfissao(), $profissao->getNomProfissao());
                    }
                ]
            )
            ->add(
                'numRegistro',
                'text',
                [
                    'label' => 'label.numIdentificacao',
                    'attr' => [
                        'sortable' => false
                    ],
                ]
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codProfissao'] = [
            'class' => Profissao::class,
            'label' => 'label.profissao',
            'choice_label' => 'nomProfissao',
            'query_builder' => function ($profissao) {
                return $profissao->createQueryBuilder('p')
                    ->where('p.nomProfissao = :contador OR p.nomProfissao = :tecnicoContabilidade')
                    ->setParameter('contador', self::PROFISSAO_CONTADOR)
                    ->setParameter('tecnicoContabilidade', self::PROFISSAO_TECNICO_CONTABILIDADE);
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codProfissao']['attr'] = [
                'class' => 'select2-parameters',
                'disabled' => true,
            ];
        }

        $formMapper
            ->add(
                'codProfissao',
                'entity',
                $fieldOptions['codProfissao']
            )
            ->add(
                'fkSwCgm',
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        $qb = $repo->createQueryBuilder('o');
                        $qb->where($qb->expr()->orX(
                            $qb->expr()->like('LOWER(o.nomCgm)', ':nomCgm'),
                            $qb->expr()->eq('o.numcgm', ':numcgm')
                        ));
                        $qb->setParameters([
                            'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                            'numcgm' => ((int) $term) ? $term: null
                        ]);
                        return $qb;
                    },
                    'label' => 'label.cgm',
                    'required' => true
                ]
            )
            ->add(
                'classeConselho',
                'entity',
                [
                    'mapped' => false,
                    'class' => Conselho::class,
                    'choice_label' => 'nomConselho',
                    'label' => 'label.classeConselho',
                    'query_builder' => function ($profissao) {
                        return $profissao->createQueryBuilder('c')
                            ->where('c.codConselho = 0');
                    },
                    'attr' => [
                        'class' => 'select2-parameters',
                        'readonly' => true,

                    ],
                ]
            )
            ->add(
                'numRegistro',
                'text',
                [
                    'label' => 'label.numIdentificacao',
                    'attr' => [
                        'maxlength' => 10
                    ],
                ]
            )
            ->add(
                'fkSwUf',
                'entity',
                [
                    'class' => SwUf::class,
                    'label' => 'label.uf',
                    'choice_label' => 'nomUf',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'fkSwCgm',
                null,
                [
                    'class' => SwCgm::class,
                    'associated_property' => function ($numcgm) {
                        return sprintf("%s - %s", $numcgm->getNumcgm(), $numcgm->getNomCgm());
                    },
                    'label' => 'cgm'
                ]
            )
            ->add(
                'fkCseProfissao',
                null,
                [
                    'class' => Profissao::class,
                    'associated_property' => function ($profissao) {
                        return sprintf("%s - %s", $profissao->getCodProfissao(), $profissao->getNomProfissao());
                    },
                    'label' => 'label.profissao'
                ]
            )
            ->add(
                'numRegistro',
                null,
                [
                    'label' => 'label.numIdentificacao'
                ]
            )
            ->add(
                'fkSwUf',
                null,
                [
                    'class' => SwUf::class,
                    'label' => 'label.uf',
                    'associated_property' => function ($uf) {
                        return sprintf("%s - %s", $uf->getCodUf(), $uf->getNomUf());
                    },
                ]
            );
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof ResponsavelTecnico
            ? sprintf('Responsável Técnico: %s', $object->getFkSwCgm()->getNomCgm())
            : 'Responsável Técnico';
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $object->setCodProfissao($object->getFkCseProfissao()->getCodProfissao());
    }
}
