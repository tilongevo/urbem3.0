<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada;
use Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OrdemPagamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_ordem_pagamento';
    protected $baseRoutePattern = 'financeiro/empenho/ordem-pagamento';
    protected $includeJs = array('/financeiro/javascripts/empenho/ordempagamento.js');
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $customBodyTemplate = '';
    protected $customAnulacao;
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codOrder'
    );

    const STATUS_APAGAR = 0;
    const STATUS_PAGAS = 1;
    const STATUS_ANULADAS = 2;
    const MODULO = 9;
    const PARAMETRO = 'utilizar_encerramento_mes';
    const SITUACAO = 'F';
    const A_PAGAR = 'A Pagar';

    public function toString($object)
    {
        return $object->getCodOrdem()
            ? $object
            : $this->getTranslator()->trans('label.ordemPagamento.subModulo');
    }

    /**
     * @return mixed
     */
    public function getCustomAnulacao()
    {
        return $this->customAnulacao;
    }

    /**
     * @param mixed $customAnulacao
     */
    public function setCustomAnulacao($customAnulacao)
    {
        $this->customAnulacao = $customAnulacao;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('data_ordem', 'data-ordem', array(), array(), array(), '', array(), array('POST'));
        $collection->add('empenho', 'empenho', array(), array(), array(), '', array(), array('POST'));
        $collection->add('receita', 'receita', array(), array(), array(), '', array(), array('POST'));
        $collection->add('item', 'item', array(), array(), array(), '', array(), array('POST'));
        $collection->add('relatorio', 'relatorio', array(), array(), array(), '', array(), array('GET'));
        $collection->add('reemitir', 'reemitir', array(), array(), array(), '', array(), array('GET'));

        $collection->add('busca_empenho', 'busca-empenho');
        $collection->add('perfil', $this->getRouterIdParameter() . '/perfil');

        $collection->remove('show');
        $collection->remove('delete');
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        $query->orderBy('codOrdem', 'DESC');
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codOrdem'));

        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.reciboExtra.codEntidade'
                ],
                null,
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },
                    'attr' => [
                        'required' => true
                    ]
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'fkEmpenhoPagamentoLiquidacoes.fkEmpenhoNotaLiquidacao.exercicioEmpenho',
                null,
                [
                    'label' => 'label.ordemPagamento.exercicioEmpenho',
                ],
                'number',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'exercicio',
                null,
                [
                    'label' => 'label.ordemPagamento.exercicio'
                ]
            )
            ->add(
                'fkEmpenhoPagamentoLiquidacoes.fkEmpenhoNotaLiquidacao.codEmpenho',
                null,
                [
                    'label' => 'label.ordemPagamento.numeroEmpenho'
                ],
                'number'
            )
            ->add(
                'fkEmpenhoPagamentoLiquidacoes.fkEmpenhoNotaLiquidacao.codNota',
                null,
                [
                    'label' => 'label.ordemPagamento.numeroLiquidacao'
                ],
                'number'
            )
            ->add('codOrdem', null, ['label' => 'label.ordemPagamento.numeroOrdem'])
            ->add(
                'fkEmpenhoPagamentoLiquidacoes.fkEmpenhoNotaLiquidacao.fkEmpenhoNotaLiquidacaoItens.fkEmpenhoItemPreEmpenho.fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.ordemPagamento.credor',
                    'callback' => array($this, 'getSearchFilter'),
                ],
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $cgm, $property) {
                        return strtoupper($cgm->getNomCgm());
                    }
                ]
            )
            ->add('dtEmissao', null, ['label' =>'label.ordemPagamento.dtEmissao'], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add('dtVencimento', null, ['label' =>'label.ordemPagamento.dtVencimento'], 'sonata_type_date_picker', ['format' => 'dd/MM/yyyy'])
            ->add(
                'fkEmpenhoPagamentoLiquidacoes.fkEmpenhoNotaLiquidacao.fkEmpenhoNotaLiquidacaoItens.fkEmpenhoItemPreEmpenho.fkEmpenhoPreEmpenho.fkEmpenhoPreEmpenhoDespesa.fkOrcamentoDespesa.fkOrcamentoRecurso',
                'composite_filter',
                [
                    'label' => 'label.reciboExtra.codRecurso'
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
                'status',
                'doctrine_orm_callback',
                [
                    'label' => 'label.ordemPagamento.status',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => [
                        'label.ordemPagamento.aPagar' => self::STATUS_APAGAR,
                        'label.ordemPagamento.pagas' => self::STATUS_PAGAS,
                        'label.ordemPagamento.anuladas' => self::STATUS_ANULADAS
                    ]
                ]
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $filter = $this->getDataGrid()->getValues();

        if (!isset($filter['fkOrcamentoEntidade']['value'])) {
            $queryBuilder->andWhere('1 = 0');
        }

        if (!count($value['value'])) {
            return;
        }

        if ($filter['status']['value'] != "") {
            $codOrdemPagas = array();

            $entidades = $filter['fkOrcamentoEntidade']['value'];

            $codOrdemAnuladas = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
                ->getOrdemPagamentoAnulada($exercicio, $entidades);

            $repository = $em->getRepository('CoreBundle:Empenho\PagamentoLiquidacao');
            $qbp = $repository->createQueryBuilder('o');
            $qbp->innerJoin('CoreBundle:Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga', 'p', 'WITH', 'o.codOrdem = p.codOrdem and o.exercicio = p.exercicio and o.codEntidade = p.codEntidade and o.codNota = p.codNota and o.exercicioLiquidacao = p.exercicioLiquidacao');
            $qbp->where('o.exercicio = :exercicio');
            $qbp->andWhere($qbp->expr()->in("o.codEntidade", $entidades));
            $qbp->setParameter('exercicio', $exercicio);
            $rltp = $qbp->getQuery()->getResult();

            foreach ($rltp as $value) {
                $codOrdemPagas[] = $value->getCodOrdem();
            }

            if ($filter['status']['value'] == self::STATUS_ANULADAS) {
                if (count($codOrdemAnuladas)) {
                    $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codOrdem", $codOrdemAnuladas));
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            } elseif ($filter['status']['value'] == self::STATUS_PAGAS) {
                if (count($codOrdemPagas)) {
                    $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codOrdem", $codOrdemPagas));
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            } else {
                $codOrdem = array_merge($codOrdemAnuladas, $codOrdemPagas);
                if (count($codOrdem)) {
                    $queryBuilder->andWhere($queryBuilder->expr()->notIn("{$alias}.codOrdem", $codOrdem));
                }
            }
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkOrcamentoEntidade', 'text', ['label' => 'label.ordemPagamento.codEntidade', 'admin_code' => 'financeiro.admin.entidade'])
            ->add('getCodOrdemComposto', null, ['label' => 'label.ordemPagamento.nrop'])
            ->add('getCredor', null, ['label' => 'label.ordemPagamento.credor'])
            ->add('getValor', 'currency', ['label' => 'label.ordemPagamento.valor', 'currency' => 'BRL'])
            ->add('getValorAnulado', 'currency', ['label' => 'label.ordemPagamento.valorAnulado', 'currency' => 'BRL'])
            ->add('getStatus', null, ['label' => 'label.ordemPagamento.status'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'perfil' => array('template' => 'FinanceiroBundle:Sonata/Empenho/OrdemPagamento/CRUD:list__action_profile.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->legendButtonSave = ['icon' => 'save', 'text' => 'Continuar'];

        $exercicio = $this->getExercicio();

        $dtVencimento = new \DateTime();
        $dtVencimento->modify('last day of december');

        $fieldOptions = array();

        $fieldOptions['fkOrcamentoEntidade'] = array(
            'label' => 'label.ordemPagamento.codEntidade',
            'choice_value' => 'codEntidade',
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['dtEmissao'] = array(
            'label' => 'label.ordemPagamento.dtEmissao',
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['dtVencimento'] = array(
            'label' => 'label.ordemPagamento.dtVencimento',
            'format' => 'dd/MM/yyyy',
            'data' => $dtVencimento
        );

        $fieldOptions['observacao'] = array(
            'label' => false
        );

        if ($this->id($this->getSubject())) {
            $ordemPagamento = $this->getSubject();

            $retencoes = false;
            if ($ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes()->count() > 0) {
                $retencoes = true;
            }

            $codPagamentoLiquidacao = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes();
            $vlOriginal = 0.00;
            $vlAnulado = 0.00;
            $dados = array();
            foreach ($codPagamentoLiquidacao as $pagamentoLiquidacao) {
                $vlOriginal = $pagamentoLiquidacao->getVlPagamento();
                $codOrdemPagamentoLiquidacaoAnulada = $pagamentoLiquidacao->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas();
                foreach ($codOrdemPagamentoLiquidacaoAnulada as $ordemPagamentoLiquidacaoAnulada) {
                    $vlAnulado += $ordemPagamentoLiquidacaoAnulada->getVlAnulado();
                }

                $notaLiquidacao = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao();

                $vlOrdemPagamento = $vlOriginal - $vlAnulado;

                $parametro = $pagamentoLiquidacao->getCodOrdem();
                $parametro .= '-' . $pagamentoLiquidacao->getExercicio();
                $parametro .= '-' . $pagamentoLiquidacao->getCodEntidade();
                $parametro .= '-' . $pagamentoLiquidacao->getExercicioLiquidacao();
                $parametro .= '-' . $pagamentoLiquidacao->getCodNota();

                $dados[] = array(
                    'parametro' => $parametro,
                    'empenho' => $notaLiquidacao->getCodEmpenho() . '/' . $notaLiquidacao->getExercicioEmpenho(),
                    'dtEmpenho' => $ordemPagamento->getDtEmissao()->format('d/m/Y'),
                    'liquidacao' => $notaLiquidacao->getCodNota() . '/' . $notaLiquidacao->getExercicio(),
                    'dtLiquidacao' => $notaLiquidacao->getDtLiquidacao()->format('d/m/Y'),
                    'vlOrdemPagamento' => $vlOrdemPagamento,
                    'vlAnulacao' => $vlOrdemPagamento,
                    'retencoes' => $retencoes
                );
            }

            $this->setCustomAnulacao($dados);

            $fieldOptions['fkOrcamentoEntidade']['mapped'] = false;
            $fieldOptions['fkOrcamentoEntidade']['disabled'] = true;
            $fieldOptions['fkOrcamentoEntidade']['data'] = $ordemPagamento->getFkOrcamentoEntidade();

            $fieldOptions['dtEmissao']['mapped'] = false;
            $fieldOptions['dtEmissao']['disabled'] = true;
            $fieldOptions['dtEmissao']['data'] = $ordemPagamento->getDtEmissao();

            $fieldOptions['dtVencimento']['mapped'] = false;
            $fieldOptions['dtVencimento']['disabled'] = true;
            $fieldOptions['dtVencimento']['data'] = $ordemPagamento->getDtVencimento();

            $fieldOptions['observacao']['attr'] = ['readOnly' => 'readOnly'];

            $this->legendButtonSave = ['icon' => 'block', 'text' => 'Anular'];
        }

        $formMapper->with('label.ordemPagamento.dados');
        $formMapper->add('exercicio', 'hidden', ['mapped' => false, 'data' => $exercicio]);
        $formMapper->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade']);
        $formMapper->add('codEntidade', 'hidden', ['mapped' => false]);
        $formMapper->add('dtEmissao', 'sonata_type_date_picker', $fieldOptions['dtEmissao']);
        $formMapper->add('dtVencimento', 'sonata_type_date_picker', $fieldOptions['dtVencimento']);

        if ($this->id($this->getSubject())) {
            $formMapper->add('vlOriginal', 'money', [
                'label' => 'label.ordemPagamento.vlOriginal',
                'currency' => 'BRL',
                'required' => false,
                'mapped' => false,
                'disabled' => true,
                'data' => $vlOriginal,
                'attr' => [
                    'class' => 'money '
                ]
            ]);

            $formMapper->add('vlAnulado', 'money', [
                'label' => 'label.ordemPagamento.vlAnulado',
                'currency' => 'BRL',
                'required' => false,
                'mapped' => false,
                'disabled' => true,
                'data' => $vlAnulado,
                'attr' => [
                    'class' => 'money '
                ]
            ]);
        }

        $formMapper->end();

        if ($this->id($this->getSubject())) {
            $formMapper->with('label.ordemPagamento.descricao');
            $formMapper->add('observacao', 'textarea', $fieldOptions['observacao']);
            $formMapper->end();
            $formMapper->with('label.ordemPagamento.anulacao');
            $formMapper->add('motivo', 'textarea', [
                'label' => 'label.ordemPagamento.motivo',
                'mapped' => false,
            ]);
            $formMapper->end();

            $this->customBodyTemplate = 'FinanceiroBundle::Empenho/OrdemPagamento/anulacao.html.twig';
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();

        $utilizarEncerramentoMes = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => self::MODULO,
                'parametro' => self::PARAMETRO,
                'exercicio' => $exercicio,
            ]);
        if ($utilizarEncerramentoMes) {
            $utilizarEncerramentoMes = $utilizarEncerramentoMes->getValor();
        }

        if ($utilizarEncerramentoMes == "true") {
            $encerramentoMes = $em->getRepository('CoreBundle:Contabilidade\EncerramentoMes')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'situacao' => self::SITUACAO
                ], ['timestamp' => 'DESC']);
            if ($encerramentoMes) {
                $encerramentoMes = $encerramentoMes->getMes();
            }
        }

        if (!$this->getSubject()->getCodOrdem()) {
            if ($utilizarEncerramentoMes == "true") {
                if ($encerramentoMes >= $object->getDtEmissao()->format('m')) {
                    $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroMesEncerrado');
                    $errorElement->with('dtEmissao')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
                }
            }

            $dtInicio = mktime(0, 0, 0, 1, 1, $exercicio);
            $dtInicio = date('Y-m-d', $dtInicio);
            $dtInicio = new \DateTime($dtInicio);

            if ($object->getDtEmissao() <= $dtInicio) {
                $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroDataEmissao', array('%dtInicio%' => $dtInicio->format('d/m/Y')));
                $errorElement->with('dtEmissao')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }

            if ($object->getDtVencimento() < $object->getDtEmissao()) {
                $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroDtVencimento');
                $errorElement->with('dtVencimento')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        } else {
            if ($utilizarEncerramentoMes == "true") {
                if ($encerramentoMes >= date('m')) {
                    $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroMesAnulacaoEncerrado');
                    $errorElement->with('dtEmissao')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
                }
            }

            $anulacoes = $this->request->get('vlAnulacao');

            $erroValor = false;
            foreach ($anulacoes as $parametro => $anulacao) {
                $ids = explode('-', $parametro);
                list($codOrdem, $exercicio, $codEntidade, $exercicioLiquidacao, $codNota) = $ids;
                
                $pagamentoLiquidacao = $em->getRepository('CoreBundle:Empenho\PagamentoLiquidacao')
                    ->findOneBy([
                        'codOrdem' => $codOrdem,
                        'exercicio' => $exercicio,
                        'codEntidade' => $codEntidade,
                        'exercicioLiquidacao' => $exercicioLiquidacao,
                        'codNota' => $codNota,
                    ]);

                $vlOriginal = $pagamentoLiquidacao->getVlPagamento();
                $vlAnulado = 0.0;
                $codOrdemPagamentoLiquidacaoAnulada = $pagamentoLiquidacao->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas();
                foreach ($codOrdemPagamentoLiquidacaoAnulada as $ordemPagamentoLiquidacaoAnulada) {
                    $vlAnulado += $ordemPagamentoLiquidacaoAnulada->getVlAnulado();
                }

                $vlDisponivel = $vlOriginal - $vlAnulado;

                if (($anulacao > $vlDisponivel) || ($anulacao == 0.00)) {
                    $erroValor = true;
                }
            }

            if ($erroValor) {
                $mensagem = $this->getTranslator()->trans('llabel.ordemPagamento.erroValorAnulacao');
                $errorElement->with('vlAnulacao')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codEntidade = $this->getForm()->get('codEntidade')->getData();
        $exercicio = $this->getForm()->get('exercicio')->getData();

        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');
        $codOrdem = $repository->getProximoCodOrdem($exercicio, $codEntidade);

        $object->setCodOrdem($codOrdem);
        $object->setTipo('');
        $object->setObservacao('');
    }

    public function postPersist($object)
    {
        $url = sprintf(
            '/financeiro/empenho/ordem-pagamento/pagamento-liquidacao/create?codOrdem=%s&exercicio=%s&codEntidade=%s',
            $object->getCodOrdem(),
            $object->getExercicio(),
            $object->getCodEntidade()
        );
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $anulacoes = $this->request->get('vlAnulacao');
        $motivo = $this->getForm()->get('motivo')->getData();

        $dtAtual = new DateTimeMicrosecondPK();
        foreach ($anulacoes as $parametro => $anulacao) {
            $dtAtual->modify('+1 second');

            $ids = explode('-', $parametro);
            list($codOrdem, $exercicio, $codEntidade, $exercicioLiquidacao, $codNota) = $ids;

            $pagamentoLiquidacao = $em->getRepository('CoreBundle:Empenho\PagamentoLiquidacao')
                ->findOneBy([
                    'codOrdem' => $codOrdem,
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'exercicioLiquidacao' => $exercicioLiquidacao,
                    'codNota' => $codNota
                ]);

            $ordemPagamentoAnulada = new OrdemPagamentoAnulada();
            $ordemPagamentoAnulada->setTimestamp($dtAtual);
            $ordemPagamentoAnulada->setMotivo($motivo);
            $ordemPagamentoAnulada->setFkEmpenhoOrdemPagamento($object);

            $ordemPagamentoLiquidacaoAnulada = new OrdemPagamentoLiquidacaoAnulada();
            $ordemPagamentoLiquidacaoAnulada->setVlAnulado((float) $anulacao);
            $ordemPagamentoLiquidacaoAnulada->setTimestamp($dtAtual);

            $ordemPagamentoAnulada->addFkEmpenhoOrdemPagamentoLiquidacaoAnuladas($ordemPagamentoLiquidacaoAnulada);

            $pagamentoLiquidacao->addFkEmpenhoOrdemPagamentoLiquidacaoAnuladas($ordemPagamentoLiquidacaoAnulada);
        }
    }

    public function postUpdate($object)
    {
        $url = sprintf(
            '/financeiro/empenho/ordem-pagamento/%s~%s~%s/perfil',
            $object->getCodOrdem(),
            $object->getExercicio(),
            $object->getCodEntidade()
        );
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }
}
