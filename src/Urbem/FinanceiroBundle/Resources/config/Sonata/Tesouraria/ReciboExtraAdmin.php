<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor;
use Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;
use Urbem\CoreBundle\Model\Empenho\ReciboExtraModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ReciboExtraAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_recibo_extra';
    protected $baseRoutePattern = 'financeiro/tesouraria/recibo-receita-extra';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/reciboextra.js');
    protected $exibirBotaoEditar = true;
    protected $exibirBotaoExcluir = true;
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];

    const RECIBO_A_RECEBER = 0;
    const RECIBO_ARRECADADO = 1;
    const RECIBO_ANULADO = 2;
    const RECIBO_DESPESA = 'D';
    const RECIBO_RECEITA = 'R';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('data_emissao', 'data-emissao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('conta_banco', 'conta-banco', array(), array(), array(), '', array(), array('POST'));
        $collection->add('conta_receita', 'conta-receita', array(), array(), array(), '', array(), array('POST'));
        $collection->add('assinatura', 'assinatura', array(), array(), array(), '', array(), array('POST'));
        $collection->add('relatorio', 'relatorio', array(), array(), array(), '', array(), array('GET'));

        $collection->add('busca_sw_cgm', 'busca-sw-cgm');
        $collection->add('busca_assinatura', 'busca-assinatura');
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'delete':
                return 'FinanceiroBundle:Tesouraria\ReciboExtra:delete.html.twig';
                break;
            case 'show':
                return 'FinanceiroBundle:Tesouraria\ReciboExtra:show.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'tipoRecibo',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reciboExtra.tipoRecibo',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => [
                        'label.reciboExtra.receita' => self::RECIBO_RECEITA,
                        'label.reciboExtra.despesa' => self::RECIBO_DESPESA
                    ],
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'dtEmissao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reciboExtra.dtEmissao',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add('codReciboExtra', null, ['label' => 'label.reciboExtra.codReciboExtra'])
            ->add(
                'codPlano',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reciboExtra.contaReceita',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                    'choice_value' => 'codPlano',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('pa');
                        $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                        $qb->andWhere('pc.exercicio = :exercicio');
                        $qb->andWhere($qb->expr()->orX(
                            $qb->expr()->like('pc.codEstrutural', "'1.1.2.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'1.1.3.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'1.1.4.9%'"),
                            $qb->expr()->like('pc.codEstrutural', "'1.2.1.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.1.1.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.1.2.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.1.8.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.1.9.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.2.1.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'2.2.2.%'"),
                            $qb->expr()->like('pc.codEstrutural', "'3.5.%'")
                        ));
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('pc.codEstrutural', 'ASC');
                        return $qb;
                    }
                ],
                [
                    'admin_code' => 'core.admin.plano_analitica'
                ]
            )
            ->add(
                'status',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reciboExtra.status',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => [
                        'label.reciboExtra.aReceber' => self::RECIBO_A_RECEBER,
                        'label.reciboExtra.arrecadado' => self::RECIBO_ARRECADADO,
                        'label.reciboExtra.anulado' => self::RECIBO_ANULADO
                    ]
                ]
            )
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.reciboExtra.codEntidade',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                    'multiple' => true,
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if ($filter['tipoRecibo']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.tipoRecibo = :tipoRecibo");
            $queryBuilder->setParameter('tipoRecibo', $filter['tipoRecibo']['value']);
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        if (!count($value['value'])) {
            return;
        }

        $queryBuilder->resetDQLPart('join');

        if ($filter['status']['value'] == self::RECIBO_ANULADO) {
            $queryBuilder->join("{$alias}.fkTesourariaReciboExtraAnulacao", "anulado");
        } elseif ($filter['status']['value'] == self::RECIBO_ARRECADADO) {
            $queryBuilder->join("{$alias}.fkTesourariaReciboExtraTransferencias", "arrecadado");
        } elseif ($filter['status']['value'] === (string) self::RECIBO_A_RECEBER) {
            $queryBuilder->leftJoin("{$alias}.fkTesourariaReciboExtraAnulacao", "anulado");
            $queryBuilder->leftJoin("{$alias}.fkTesourariaReciboExtraTransferencias", "arrecadado");
            $queryBuilder->andWhere("anulado.codReciboExtra is null");
            $queryBuilder->andWhere("arrecadado.codReciboExtra is null");
        }

        if ($filter['dtEmissao']['value'] != "") {
            $exp = explode('/', $filter['dtEmissao']['value']);
            $dateMin = mktime(0, 0, 0, $exp[1], $exp[0], $exp[2]);
            $dateMax = mktime(23, 59, 59, $exp[1], $exp[0], $exp[2]);
            $queryBuilder->andWhere("{$alias}.timestamp >= :dtEmissaoMin");
            $queryBuilder->andWhere("{$alias}.timestamp <= :dtEmissaoMax");
            $queryBuilder->setParameter('dtEmissaoMin', date('Y-m-d H:i:s', $dateMin));
            $queryBuilder->setParameter('dtEmissaoMax', date('Y-m-d H:i:s', $dateMax));
        }

        if (isset($filter['codEntidade']['value'])) {
            $entidades = $filter['codEntidade']['value'];
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEntidade", $entidades));
        }

        if ($filter['codPlano']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.codPlano = :codPlano");
            $queryBuilder->setParameter('codPlano', $filter['codPlano']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEntidade', 'text', ['label' => 'label.reciboExtra.codEntidade'])
            ->add('getCodReciboExtraComposto', null, ['label' => 'label.reciboExtra.codReciboExtra'])
            ->add('timestamp', 'date', ['label' => 'label.reciboExtra.dtEmissao', 'pattern' => 'dd/MM/yyyy'])
            ->add('fkContabilidadePlanoAnalitica', 'text', ['label' => 'label.reciboExtra.contaReceita', 'admin_code' => 'core.admin.plano_analitica'])
            ->add('valor', 'currency', ['label' => 'label.reciboExtra.valor', 'currency' => 'BRL'])
            ->add('getValorPago', 'currency', ['label' => 'label.reciboExtra.valorPago', 'currency' => 'BRL'])
            ->add('getSaldo', 'currency', ['label' => 'label.reciboExtra.saldo', 'currency' => 'BRL'])
            ->add('getStatus', 'trans', ['label' => 'label.reciboExtra.status'])
        ;

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'print' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/ReciboExtra/CRUD:list__action_print.html.twig'),
                    'anular' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/ReciboExtra/CRUD:list__action_delete.html.twig')
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

        $this->legendButtonSave = ['icon' => 'print', 'text' => 'Emitir'];

        $em = $this->modelManager->getEntityManager($this->getClass());
        $assinaturaModel =new AssinaturaModel($em);
        $lastTimestamp = $assinaturaModel->getLastTimestamp();

        $exercicio = $this->getExercicio();

        $fieldOptions = [];

        $fieldOptions['tipoRecibo'] = [
            'label' => 'label.reciboExtra.tipoRecibo',
            'placeholder' => 'label.selecione',
            'choices' => [
                'label.reciboExtra.receita' => self::RECIBO_RECEITA,
                'label.reciboExtra.despesa' => self::RECIBO_DESPESA
            ],
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkOrcamentoEntidade'] = array(
            'label' => 'label.reciboExtra.codEntidade',
            'placeholder' => 'label.selecione',
            'choice_value' => 'codEntidade',
            'required' => true,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters '
            ]
        );

        $fieldOptions['dtEmissao'] = [
            'label' => 'label.reciboExtra.dtEmissao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['codCredor'] = [
            'label' => 'label.reciboExtra.credor',
            'multiple' => false,
            'required' => false,
            'mapped' => false,
            'route' => ['name' => 'urbem_financeiro_tesouraria_recibo_extra_busca_sw_cgm']
        ];

        $fieldOptions['codRecurso'] = [
            'class' => 'CoreBundle:Orcamento\Recurso',
            'label' => 'label.reciboExtra.codRecurso',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('o.codRecurso', 'ASC');
                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codContaBanco'] = [
            'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
            'choice_value' => 'codPlano',
            'label' => 'label.reciboExtra.contaBanco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('pc.codEstrutural', ':codEstrutural1'),
                    $qb->expr()->like('pc.codEstrutural', ':codEstrutural2')
                ));
                $qb->setParameters([
                    'exercicio' => $exercicio,
                    'codEstrutural1' => '1.1.1.%',
                    'codEstrutural2' => '1.1.4.%'
                ]);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['codContaReceita'] = [
            'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
            'label' => 'label.reciboExtra.contaReceita',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => true,
            'mapped' => false,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('pc.codEstrutural', "'1.1.2.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.1.3.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.1.4.9%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.2.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.2.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.8.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.9.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.2.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.2.2.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'3.5.%'")
                ));
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.reciboExtra.valor',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['incluirAssinaturas'] = [
            'label' => 'label.reciboExtra.incluirAssinaturas',
            'choices' => [
                'label_type_yes' => 1,
                'label_type_no' => 0
            ],
            'data' => 0,
            'expanded' => true,
            'required' => true,
            'mapped' => false,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata ppa-sub-tipo-acao']
        ];

        $fieldOptions['exercicio'] = [
            'data' => $exercicio,
            'mapped' => false
        ];

        $formMapper
            ->with('label.reciboExtra.dadosReciboExtra')
                ->add('tipoRecibo', 'choice', $fieldOptions['tipoRecibo'])
                ->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade'])
                ->add('dtEmissao', 'sonata_type_date_picker', $fieldOptions['dtEmissao'])
                ->add('codCredor', 'autocomplete', $fieldOptions['codCredor'])
                ->add('codRecurso', 'entity', $fieldOptions['codRecurso'])
                ->add('codContaBanco', 'entity', $fieldOptions['codContaBanco'], ['admin_code' => 'core.admin.plano_analitica'])
                ->add('codContaReceita', 'entity', $fieldOptions['codContaReceita'], ['admin_code' => 'core.admin.plano_analitica'])
                ->add('valor', 'money', $fieldOptions['valor'])
                ->add('historico', null, ['label' => 'label.reciboExtra.historico'])
                ->add('incluirAssinaturas', 'choice', $fieldOptions['incluirAssinaturas'])
                ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
            ->end()
            ->with('label.reciboExtra.assinaturas')
            ->add('assinaturas', 'entity', [
                'label' => 'label.reciboExtra.tesoureiro',
                'class' => 'CoreBundle:Administracao\Assinatura',
                'mapped' => false,
                'required' => true,
                'choice_value' => 'numcgm',
                'query_builder' => function ($em) use ($lastTimestamp) {
                    $qb = $em->createQueryBuilder('a');
                    $qb->where('a.timestamp = :lastTimestamp');
                    $qb->setParameter('lastTimestamp', (string) $lastTimestamp);
                    return $qb;
                },
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->exibirBotaoEditar = false;
        $this->exibirBotaoExcluir = false;

        $showMapper
            ->with('label.reciboExtra.modulo')
            ->add('getCodEntidadeComposto', null, ['label' => 'label.reciboExtra.codEntidade'])
            ->add('timestamp', 'date', ['label' => 'label.reciboExtra.dtEmissao'])
            ->add('fkTesourariaReciboExtraCredor', null, ['label' => 'label.reciboExtra.credor'])
            ->add('fkTesourariaReciboExtraRecurso', null, ['label' => 'label.reciboExtra.codRecurso'])
            ->add('fkTesourariaReciboExtraBanco', null, ['label' => 'label.reciboExtra.contaBanco'])
            ->add('fkContabilidadePlanoAnalitica', 'text', ['label' => 'label.reciboExtra.contaReceita'])
            ->add('valor', 'currency', ['label' => 'label.reciboExtra.valor', 'currency' => 'BRL'])
            ->add('historico', null, ['label' => 'label.reciboExtra.historico'])
            ->add('getStatus', 'trans', ['label' => 'label.reciboExtra.status'])
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $reciboExtraModel = new ReciboExtraModel($em);

        $dtEmissao = $this->getForm()->get('dtEmissao')->getData();
        $timestamp = new DateTimeMicrosecondPK($dtEmissao->format('Y-m-d ') . date('H:i:s.u'));
        $object->setTimestamp($timestamp);

        $planoAnalitica = $this->getForm()->get('codContaReceita')->getData();
        $object->setFkContabilidadePlanoAnalitica($planoAnalitica);

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $object->setExercicio($exercicio);
        $codEntidade = $object->getCodEntidade();
        $tipoRecibo = $object->getTipoRecibo();
        $codReciboExtra = $reciboExtraModel->getProximoCodReciboExtra($exercicio, $codEntidade, $tipoRecibo);
        $object->setCodReciboExtra($codReciboExtra);

        $codContaBanco = $this->getForm()->get('codContaBanco')->getData();
        if ($codContaBanco) {
            $reciboExtraBanco = new ReciboExtraBanco();
            $reciboExtraBanco->setFkContabilidadePlanoAnalitica($codContaBanco);
            $object->setFkTesourariaReciboExtraBanco($reciboExtraBanco);
        }

        $assinatura = $this->getForm()->get('assinaturas')->getData();
        if ($assinatura) {
            $reciboExtraAssinatura = new ReciboExtraAssinatura();
            $reciboExtraAssinatura->setFkSwCgm($assinatura->getFkSwCgmPessoaFisica()->getFkSwCgm());
            $reciboExtraAssinatura->setCargo($assinatura->getCargo());
            $reciboExtraAssinatura->setNumAssinatura(1);
            $object->addFkTesourariaReciboExtraAssinaturas($reciboExtraAssinatura);
        }

        $credor = $this->getForm()->get('codCredor')->getData();
        if ($credor) {
            $swCgm = $em->getRepository('CoreBundle:SwCgm')->find($credor);
            $reciboExtraCredor = new ReciboExtraCredor();
            $reciboExtraCredor->setFkSwCgm($swCgm);
            $object->setFkTesourariaReciboExtraCredor($reciboExtraCredor);
        }

        $recurso = $this->getForm()->get('codRecurso')->getData();
        if ($recurso) {
            $reciboExtraRecurso = new ReciboExtraRecurso();
            $reciboExtraRecurso->setFkOrcamentoRecurso($recurso);
            $object->setFkTesourariaReciboExtraRecurso($reciboExtraRecurso);
        }
    }

    public function preRemove($object)
    {
        $container = $this->configurationPool->getContainer();
        if ($object->getFkTesourariaReciboExtraTransferencias()->count()) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.reciboExtra.erroAnulacao'));
            $this->forceRedirect($this->generateUrl('list'));
        } else {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $dtAnulacao = new DateTimeMicrosecondPK();

            $reciboExtraAnulacao = new ReciboExtraAnulacao();
            $reciboExtraAnulacao->setTimestampAnulacao($dtAnulacao);
            $object->setFkTesourariaReciboExtraAnulacao($reciboExtraAnulacao);

            $em->persist($object);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.reciboExtra.mensagemAnulacao'));
            $this->forceRedirect($this->generateUrl('list'));
        }
    }
}
