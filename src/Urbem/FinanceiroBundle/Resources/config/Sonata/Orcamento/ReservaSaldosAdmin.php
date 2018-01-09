<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\ChoiceList;

class ReservaSaldosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_reserva_saldos';
    protected $baseRoutePattern = 'financeiro/orcamento/reserva-saldos';
    protected $includeJs = array('/financeiro/javascripts/orcamento/reserva_saldos.js');
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'codReserva'
    );

    const RESERVA_SALDOS_AUTOMATICAS = 'A';
    const RESERVA_SALDOS_MANUAIS = 'M';
    const RESERVA_SALDOS_INATIVAS = 0;
    const RESERVA_SALDOS_ATIVAS = 1;
    const RESERVA_SALDOS_ANULADAS = 2;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_despesas', 'consultar-despesas', array(), array(), array(), '', array(), array('POST'));
        $collection->add('consultar_saldo', 'consultar-saldo', array(), array(), array(), '', array(), array('POST'));
        $collection->add('relatorio', 'relatorio', array(), array(), array(), '', array(), array('GET'));
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'fkOrcamentoDespesa.fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.reservaSaldos.codEntidade'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                    'multiple' => true,
                    'attr' => ['class' => 'select2-parameters select2-multiple-options-custom ']
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'fkOrcamentoDespesa',
                'composite_filter',
                [
                    'label' => 'label.reservaSaldos.dotacao'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Despesa',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    }
                ]
            )
            ->add('codReserva', null, ['label' => 'label.reservaSaldos.codReserva'])
            ->add('dtInicio', 'doctrine_orm_callback', ['label' => 'label.reservaSaldos.dtInicio', 'callback' => array($this, 'getSearchFilter')], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add('dtFim', 'doctrine_orm_callback', ['label' => 'label.reservaSaldos.dtFim', 'callback' => array($this, 'getSearchFilter')], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add(
                'fkOrcamentoDespesa.fkOrcamentoRecurso',
                'composite_filter',
                [
                    'label' => 'label.reservaSaldos.codRecurso'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Recurso',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.codRecurso', 'ASC');
                        return $qb;
                    }
                ]
            )
            ->add(
                'situacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reservaSaldos.situacao',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => [
                        'label.reservaSaldos.ativas' => $this::RESERVA_SALDOS_ATIVAS,
                        'label.reservaSaldos.inativas' => $this::RESERVA_SALDOS_INATIVAS,
                        'label.reservaSaldos.anuladas' => $this::RESERVA_SALDOS_ANULADAS,
                    ]
                ]
            )
            ->add('tipo', null, ['label' => 'label.reservaSaldos.tipo'], 'choice', [
                'choices' => [
                    'label.reservaSaldos.automaticas' => $this::RESERVA_SALDOS_AUTOMATICAS,
                    'label.reservaSaldos.manuais' => $this::RESERVA_SALDOS_MANUAIS
                ]
            ])
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!count($value['value'])) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $dtAtual = new \DateTime();

        if ($filter['situacao']['value'] != "") {
            $queryBuilder->leftJoin("{$alias}.fkOrcamentoReservaSaldosAnulada", "rsa");
            if ($filter['situacao']['value'] == 2) {
                $queryBuilder->andWhere("rsa.codReserva is not null");
            } elseif ($filter['situacao']['value'] == 1) {
                $queryBuilder->andWhere("rsa.codReserva is null");
                $queryBuilder->andWhere("{$alias}.dtValidadeFinal > :dtAtual");
                $queryBuilder->setParameter('dtAtual', $dtAtual->format('d/m/Y'));
            } elseif ($filter['situacao']['value'] == 0) {
                $queryBuilder->andWhere("rsa.codReserva is null");
                $queryBuilder->andWhere("{$alias}.dtValidadeFinal <= :dtAtual");
                $queryBuilder->setParameter('dtAtual', $dtAtual->format('d/m/Y'));
            }
        }

        if ($filter['dtInicio']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.dtValidadeInicial >= :dtInicio");
            $queryBuilder->setParameter('dtInicio', $filter['dtInicio']['value']);
        }

        if ($filter['dtFim']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.dtValidadeInicial <= :dtFim");
            $queryBuilder->setParameter('dtFim', $filter['dtFim']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkOrcamentoDespesa.codEntidade', 'text', ['label' => 'label.reservaSaldos.codEntidade'])
            ->add('codReserva', 'text', ['label' => 'label.reservaSaldos.codReserva'])
            ->add('codDespesa', 'text', ['label' => 'label.reservaSaldos.dotacao'])
            ->add('fkOrcamentoDespesa.fkOrcamentoRecurso.codFonte', 'text', ['label' => 'label.reservaSaldos.codRecurso'])
            ->add('dtValidadeInicial', 'date', ['label' => 'label.reservaSaldos.dtValidadeInicial'])
            ->add('dtValidadeFinal', 'date', ['label' => 'label.reservaSaldos.dtValidadeFinal'])
            ->add('getSituacao', 'trans', ['label' => 'label.reservaSaldos.situacao'])
            ->add('vlReserva', 'currency', ['label' => 'label.reservaSaldos.vlReserva', 'currency' => 'BRL', 'sortable' => false])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'block' => array('template' => 'FinanceiroBundle:Sonata/Orcamento/ReservaSaldos/CRUD:list__action_edit.html.twig'),
                    'print' => array('template' => 'FinanceiroBundle:Sonata/Orcamento/ReservaSaldos/CRUD:list__action_print.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $now = new \DateTime();
        $lastDate = new \DateTime();
        $lastDate->modify('last day of december');

        $fieldOptions = [];

        $fieldOptions['codEntidade'] = [
            'label' => 'label.reservaSaldos.codEntidade',
            'class' => 'CoreBundle:Orcamento\Entidade',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choice_value' => 'codEntidade',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'attr' => ['class' => 'select2-parameters']
        ];

        $fieldOptions['dtValidadeInicial'] = [
            'label' => 'label.reservaSaldos.dtValidadeInicial',
            'format' => 'dd/MM/yyyy',
            'data' => $now
        ];

        $fieldOptions['codDespesa'] = [
            'class' => 'CoreBundle:Orcamento\Despesa',
            'label' => 'label.reservaSaldos.dotacaoOrcamentaria',
            'required' => true,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'choice_value' => 'codDespesa',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('o.codDespesa', 'ASC');
                return $qb;
            },
            'attr' => ['class' => 'select2-parameters']
        ];

        $fieldOptions['saldoDotacao'] = [
            'label' => 'label.reservaSaldos.saldoDotacao',
            'currency' => 'BRL',
            'mapped' => false,
            'required' => false,
            'data' => 0,
            'attr' => [
                'class' => 'money ',
                'readonly' => true
            ]
        ];

        $fieldOptions['dtValidadeFinal'] = [
            'label' => 'label.reservaSaldos.dtValidadeFinal',
            'format' => 'dd/MM/yyyy',
            'data' => $lastDate
        ];

        $fieldOptions['vlReserva'] = [
            'label' => 'label.reservaSaldos.vlReserva',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['motivo'] = [
            'label' => 'label.reservaSaldos.motivo',
            'required' => false,
            'attr' => [
                'class' => 'mensagem-inicial '
            ]
        ];

        $formMapper->with('label.reservaSaldos.dados');

        if ($this->id($this->getSubject())) {
            $reservaSaldos = $this->getSubject();

            $this->legendButtonSave = ['icon' => 'block', 'text' => 'Anular'];

            $formMapper->add('codReserva', null, [
                'label' => 'label.reservaSaldos.codReserva',
                'mapped' => false,
                'disabled' => true,
                'data' => $reservaSaldos->getCodReserva()
            ]);

            $fieldOptions['codEntidade']['disabled'] = true;
            $fieldOptions['codEntidade']['data'] = $reservaSaldos->getFkOrcamentoDespesa()->getFkOrcamentoEntidade();

            $fieldOptions['dtValidadeInicial']['mapped'] = false;
            $fieldOptions['dtValidadeInicial']['disabled'] = true;
            $fieldOptions['dtValidadeInicial']['data'] = $reservaSaldos->getDtValidadeInicial();

            $fieldOptions['codDespesa']['disabled'] = true;
            $fieldOptions['codDespesa']['data'] = $reservaSaldos->getFkOrcamentoDespesa();

            $fieldOptions['dtValidadeFinal']['mapped'] = false;
            $fieldOptions['dtValidadeFinal']['disabled'] = true;
            $fieldOptions['dtValidadeFinal']['data'] = $reservaSaldos->getDtValidadeFinal();

            $fieldOptions['vlReserva']['mapped'] = false;
            $fieldOptions['vlReserva']['disabled'] = true;
            $fieldOptions['vlReserva']['data'] = $reservaSaldos->getVlReserva();

            $recurso = $reservaSaldos->getFkOrcamentoDespesa()->getFkOrcamentoRecurso();
        }

        $formMapper->add('codEntidade', 'entity', $fieldOptions['codEntidade']);
        $formMapper->add('dtValidadeInicial', 'sonata_type_date_picker', $fieldOptions['dtValidadeInicial']);
        $formMapper->add('fkOrcamentoDespesa', 'entity', $fieldOptions['codDespesa']);

        if (!$this->id($this->getSubject())) {
            $formMapper->add('saldoDotacao', 'money', $fieldOptions['saldoDotacao']);
        }

        $formMapper->add('dtValidadeFinal', 'sonata_type_date_picker', $fieldOptions['dtValidadeFinal']);

        if ($this->id($this->getSubject())) {
            $formMapper->add('codRecurso', 'choice', [
                'label' => 'label.reservaSaldos.codRecurso',
                'mapped' => false,
                'disabled' => true,
                'choices' => [
                    sprintf('%s-%s', $recurso->getCodRecurso(), $recurso->getNomRecurso()) => $recurso->getCodRecurso()
                ],
                'attr' => ['class' => 'select2-parameters']
            ]);
        }

        $formMapper->add('vlReserva', 'money', $fieldOptions['vlReserva']);

        if (!$this->id($this->getSubject())) {
            $formMapper->add('motivo', 'textarea', $fieldOptions['motivo']);
        }

        $formMapper->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false]);
        $formMapper->end();

        if ($this->id($this->getSubject())) {
            $formMapper->with('label.reservaSaldos.anularReserva');
            $formMapper->add('dtAnulacao', 'sonata_type_date_picker', [
                'label' => 'label.reservaSaldos.dtAnulacao',
                'format' => 'dd/MM/yyyy',
                'data' => $lastDate,
                'mapped' => false
            ]);
            $formMapper->add('motivoAnulacao', 'textarea', [
                'label' => 'label.reservaSaldos.motivoAnulacao',
                'required' => false,
                'mapped' => false
            ]);
            $formMapper->end();
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.reservaSaldos.dados')
            ->add('codReserva', null, ['label' => 'label.reservaSaldos.codReserva'])
            ->add('fkOrcamentoDespesa.fkOrcamentoEntidade', 'text', [
                'label' => 'label.reservaSaldos.codEntidade',
                'admin_code' => 'financeiro.admin.entidade'
            ])
            ->add('codDespesa', null, ['label' => 'label.reservaSaldos.dotacaoOrcamentaria'])
            ->add('dtValidadeInicial', null, ['label' => 'label.reservaSaldos.dtValidadeInicial'])
            ->add('dtValidadeFinal', null, ['label' => 'label.reservaSaldos.dtValidadeFinal'])
            ->add('fkOrcamentoDespesa.fkOrcamentoRecurso', 'text', ['label' => 'label.reservaSaldos.codRecurso'])
            ->add('motivo', null, ['label' => 'label.reservaSaldos.motivo'])
            ->add('vlReserva', 'currency', [
                'label' => 'label.reservaSaldos.vlReserva',
                'currency' => 'BRL'
            ])
            ->add('fkOrcamentoReservaSaldosAnulada.dtAnulacao', null, ['label' => 'label.reservaSaldos.dtAnulacao'])
            ->add('fkOrcamentoReservaSaldosAnulada.motivoAnulacao', null, ['label' => 'label.reservaSaldos.motivoAnulacao'])
            ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        if (!$this->id($this->getSubject())) {
            $dtAtualInicial = new \DateTime();
            $dtAtualInicial->modify('first day of january');

            $dtAtualFinal = new \DateTime();
            $dtAtualFinal->modify('last day of december');

            $dtInicial = $object->getDtValidadeInicial();
            $dtFinal = $object->getDtValidadeFinal();

            if ($dtInicial < $dtAtualInicial) {
                $mensagem = "A data de reserva deve ser maior que o dia " . $dtAtualInicial->format('d/m/Y') . "!";
                $errorElement->with('dtValidadeInicial')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if ($dtInicial > $dtFinal) {
                $mensagem = "A data de reserva deve ser menor que a data da validade!";
                $errorElement->with('dtValidadeInicial')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if (!($dtFinal >= $dtInicial)) {
                $mensagem = "A data de validade final deve ser maior ou igual ao dia de hoje!";
                $errorElement->with('dtValidadeFinal')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if ($dtFinal > $dtAtualFinal) {
                $mensagem = "A data de validade final não pode ser maior que " . $dtAtualFinal->format('d/m/Y') . "!";
                $errorElement->with('dtValidadeFinal')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            $saldo = $this->getForm()->get('saldoDotacao')->getData();
            $valor = $this->getForm()->get('vlReserva')->getData();

            if ($valor > $saldo) {
                $mensagem = "Valor informado é maior que o saldo desta dotação!";
                $errorElement->with('vlReserva')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        } else {
            $dtAnulacao = $this->getForm()->get('dtAnulacao')->getData();

            $dtInicial = $object->getDtValidadeInicial();
            $dtFinal = $object->getDtValidadeFinal();

            if ($dtAnulacao < $dtInicial) {
                $mensagem = "A data de anulação não pode ser inferior a data da reserva!";
                $errorElement->with('dtAnulacao')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }

            if ($dtAnulacao > $dtFinal) {
                $mensagem = "A data de anulação não pode ser superior a data de validade!";
                $errorElement->with('dtAnulacao')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $reservaSaldosModel = new ReservaSaldosModel($em);

        $exercicio = $this->getExercicio();
        $codReserva = $reservaSaldosModel->getProximoCodReserva($exercicio);

        $object->setExercicio($exercicio);
        $object->setCodReserva($codReserva);
        $object->setTipo($this::RESERVA_SALDOS_MANUAIS);

        $object->setFkOrcamentoDespesa($this->getForm()->get('fkOrcamentoDespesa')->getData());

        if ($object->getMotivo() == null) {
            $object->setMotivo("");
        }
    }

    public function preUpdate($object)
    {
        $dtAnulacao = $this->getForm()->get('dtAnulacao')->getData();
        $motivoAnulacao = (string) $this->getForm()->get('motivoAnulacao')->getData();

        $reservaSaldosAnulada = new ReservaSaldosAnulada();
        $reservaSaldosAnulada->setDtAnulacao($dtAnulacao);
        $reservaSaldosAnulada->setMotivoAnulacao($motivoAnulacao);

        $object->setFkOrcamentoReservaSaldosAnulada($reservaSaldosAnulada);
    }
}
