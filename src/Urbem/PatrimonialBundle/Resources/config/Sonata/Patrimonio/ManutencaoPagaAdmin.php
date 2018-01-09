<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\Manutencao;
use Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Repository\Patrimonio\BemRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ManutencaoPagaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_manutencao_paga';

    protected $baseRoutePattern = 'patrimonial/patrimonio/manutencao-paga';

    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/manutencao-paga.js'
    ];

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = $this->getModelManager()->createQuery(Bem::class);
        $query
            ->join('o.fkPatrimonioManutencoes', 'm')
            ->join('m.fkPatrimonioManutencaoPaga', 'mp')
        ;
        return $query;
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codBem', null, ['label' => 'label.manutencaoPaga.codBem'])
            ->add(
                'dtAgendamento',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.manutencaoPaga.dtAgendamento',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            );
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['dtAgendamento']['value'] != '') {
            $queryBuilder->join("{$alias}.fkPatrimonioManutencoes", "manutencao");
            $queryBuilder->andWhere("manutencao.dtAgendamento = :dtAgendamento");
            $queryBuilder->setParameter("dtAgendamento", $filter['dtAgendamento']['value']);
        }

        return true;
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $saidaAutorizacaoAbastecimentoTemplatePath =
            "PatrimonialBundle:Sonata/Patrimonio/ManutencaoPaga/CRUD:";
        $classificacaoTemplate = $saidaAutorizacaoAbastecimentoTemplatePath . "list__classificacao.html.twig";
        $dtAgendamentoTemplate = $saidaAutorizacaoAbastecimentoTemplatePath . "list__dtAgendamento.html.twig";

        $listMapper
            ->add(
                'classificacao',
                null,
                [
                    'template' => $classificacaoTemplate,
                    'label' => 'label.manutencaoPaga.classificacao'
                ]
            )
            ->add('codBem', null, ['label' => 'label.manutencaoPaga.codBem'])
            ->add('numPlaca', null, ['label' => 'label.manutencaoPaga.numPlaca'])
            ->add(
                'dtAgendamento',
                null,
                [
                    'label' => 'label.manutencaoPaga.dtAgendamento',
                    'template' => $dtAgendamentoTemplate
                ]
            )
            ->add('manutencao', null, ['label' => 'label.manutencaoPaga.manutencao'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'PatrimonialBundle:Sonata/Patrimonio/ManutencaoPaga/CRUD:list__action_delete.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codBem = $formData['codBem'];
            $dtAgendamentoOriginal = $formData['dtAgendamento'];
            $dataAgendamento = explode('/', $dtAgendamentoOriginal);
            $dtAgendamento = $dataAgendamento[2] . '-' . $dataAgendamento[1] . '-' . $dataAgendamento[0];
        }

        $exercicio = $this->getExercicio();

        $now = new \DateTime();

        $formMapperOptions['dtAgendamento'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.dtAgendamento'
        ];
        $formMapperOptions['observacao'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.observacao'
        ];
        $formMapperOptions['codNatureza'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codNatureza'
        ];
        $formMapperOptions['codGrupo'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codGrupo'
        ];
        $formMapperOptions['codEspecie'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codEspecie'
        ];
        $formMapperOptions['codBem'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codigoBem'
        ];
        $formMapperOptions['numPlaca'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.numPlaca'
        ];
        $formMapperOptions['descricao'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.descricao'
        ];
        $formMapperOptions['cgm'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.cgm'
        ];

        $formMapperOptions['dtRealizacao'] = [
            'widget' => 'single_text',
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'mapped' => false,
            'label' => 'label.manutencaoPaga.dtRealizacao'
        ];

        $formMapperOptions['dtGarantia'] = [
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'mapped' => false,
            'label' => 'label.manutencaoPaga.dtGarantia'
        ];

        $formMapperOptions['codEntidade'] = [
            'class' => Entidade::class,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codEntidade',
            'placeholder' => 'label.selecione',
            'choice_value' => 'codEntidade',
            'required' => true,
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio)->orderBy('entidade.codEntidade');

                return $result;
            }
        ];

        $formMapperOptions['valor'] = [
            'attr' => [
                'class' => 'money '
            ]
        ];

        $formMapper
            ->with('label.dadosAgendamento')
            ->add(
                'agenda',
                'entity',
                [
                    'class' => Manutencao::class,
                    'label' => 'label.manutencaoPaga.agenda',
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'choice_value' => function ($mp) {
                        if (!$mp) {
                            return null;
                        }
                        return $this->getObjectKey($mp);
                    },
                    'query_builder' => function (EntityRepository $repository) use ($exercicio) {
                        $em = $this->modelManager->getEntityManager($repository->getClassName());
                        $bemModel = new BemModel($em);
                        $bensIds = $bemModel->getBensParaManutencaoBemIdLista();
                        $qb = $repository->createQueryBuilder('o');
                        $qb->where($qb->expr()->in('o.codBem', $bensIds ? $bensIds : 0));

                        return $qb;
                    },
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add('codNatureza', 'text', $formMapperOptions['codNatureza'])
            ->add('codGrupo', 'text', $formMapperOptions['codGrupo'])
            ->add('codEspecie', 'text', $formMapperOptions['codEspecie'])
            ->add('codBem', 'text', $formMapperOptions['codBem'])
            ->add('numPlaca', 'text', $formMapperOptions['numPlaca'])
            ->add('descricao', 'text', $formMapperOptions['descricao'])
            ->add('dtAgendamento', 'text', $formMapperOptions['dtAgendamento'])
            ->add('cgm', 'text', $formMapperOptions['cgm'])
            ->add('observacao', 'text', $formMapperOptions['observacao'])
            ->add('dtRealizacao', 'sonata_type_date_picker', $formMapperOptions['dtRealizacao'])
            ->add('dtGarantia', 'sonata_type_date_picker', $formMapperOptions['dtGarantia'])
            ->add('codEntidade', 'entity', $formMapperOptions['codEntidade'])
            ->add('exercicio', 'text', ['label' => 'label.manutencaoPaga.exercicio', 'attr' => ['class' => 'ano ']])
            ->add('codEmpenho', 'text', ['label' => 'label.manutencaoPaga.empenho'])
            ->add('valor', null, $formMapperOptions['valor'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codBem')
            ->add('dtAgendamento')
            ->add('codEmpenho')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('valor');
    }

    /**
     * @param ManutencaoPaga $manutencaoPaga
     */
    public function prePersist($manutencaoPaga)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codBem = $formData['codBem'];
        $dtManutencaoOriginal = explode("/", $formData['dtAgendamento']);
        $dtManutencao = $dtManutencaoOriginal[2] . "-" . $dtManutencaoOriginal[1] . "-" . $dtManutencaoOriginal[0];

        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var Manutencao $manutencao */
        $manutencao = $em->getRepository('CoreBundle:Patrimonio\Manutencao')->findOneBy(
            [
                'codBem' => $codBem,
                'dtAgendamento' => $dtManutencao
            ]
        );

        $manutencaoPaga->setFkPatrimonioManutencao($manutencao);
        $manutencaoPaga->setCodEntidade($manutencaoPaga->getCodEntidade()->getCodEntidade());
        $manutencao->setDtGarantia($this->getForm()->get('dtGarantia')->getData());
        $manutencao->setDtRealizacao($this->getForm()->get('dtRealizacao')->getData());
        $manutencao->setFkPatrimonioManutencaoPaga($manutencaoPaga);
    }
}
