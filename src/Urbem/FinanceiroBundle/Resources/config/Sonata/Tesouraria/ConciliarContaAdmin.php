<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\Assinatura;
use Urbem\CoreBundle\Entity\Tesouraria\Conciliacao;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil;
use Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual;
use Urbem\CoreBundle\Model\Tesouraria\ConciliacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConciliarContaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_conciliacao';
    protected $baseRoutePattern = 'financeiro/tesouraria/conciliacao';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/conciliarConta/conciliar-conta.js');
    protected $exibirMensagemFiltro = false;
    protected $exibirBotaoIncluir = false;
    protected $filter = array();

    const TIPO_VALOR_ENTRADA = 'C';
    const TIPO_VALOR_SAIDA = 'D';
    const TIPO_ARRECADACAO = 'A';
    const TIPO_ASSINATURA = 'CO';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create','relatorio', 'autocomplete_sw_cgm_pessoa_fisica'));
        $collection->add('relatorio', 'relatorio');
        $collection->add('autocomplete_sw_cgm_pessoa_fisica', 'autocomplete-sw-cgm-pessoa--fisica');
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'params' => $this->getRequest()->get('params'),
        );
    }

    /**
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return Conciliacao|null
     */
    public function getConciliacao($codPlano, $exercicio, $mes)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $conciliacao = $em->getRepository(Conciliacao::class)->findOneBy(
            array(
                'codPlano' => $codPlano,
                'exercicio' => $exercicio,
                'mes' => $mes
            )
        );

        return $conciliacao;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->innerJoin("o.fkContabilidadePlanoBanco", "pb");
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        if ((!$this->getRequest()->query->get('filter')) && (!$this->getPersistentParameter('params'))) {
            $query->andWhere('1 = 0');
            $this->exibirMensagemFiltro = true;
        } else {
            $this->exibirMensagemFiltro = false;
        }
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
                'fkOrcamentoEntidade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.conciliarConta.filterEntidade',
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
                    'attr' => [
                        'required' => true
                    ]
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'mes',
                'doctrine_orm_callback',
                [
                    'label' => 'label.conciliarConta.filterMes',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => array(
                        'Janeiro' => 1,
                        'Fevereiro' => 2,
                        'Março' => 3,
                        'Abril' => 4,
                        'Maio' => 5,
                        'Junho' => 6,
                        'Julho' => 7,
                        'Agosto' => 8,
                        'Setembro' => 9,
                        'Outubro' => 10,
                        'Novembro' => 11,
                        'Dezembro' => 12,
                    ),
                    'attr' => array(
                        'required' => true
                    )
                ]
            )
            ->add(
                'codPlanoDe',
                'doctrine_orm_callback',
                [
                    'label' => 'label.conciliarConta.filterCodPlanoDe',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text',
                [
                    'attr' => array(
                        'required' => true
                    )
                ]
            )
            ->add(
                'codPlanoAte',
                'doctrine_orm_callback',
                [
                    'label' => 'label.conciliarConta.filterCodPlanoAte',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text',
                [
                    'attr' => array(
                        'required' => true
                    )
                ]
            )
            ->add(
                'dtExtrato',
                'doctrine_orm_callback',
                [
                'label' => 'label.conciliarConta.filterDataExtrato',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'agrupar',
                'doctrine_orm_choice',
                [
                    'label' => 'label.conciliarConta.agrupar'
                ],
                'choice',
                [
                    'choices' => array(
                        'sim' => 1
                    ),
                    'mapped' => false,
                    'expanded' => true,
                    'placeholder' => 'nao',
                ]
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if ((!$filter['fkOrcamentoEntidade']['value']) && ($this->getPersistentParameter('params'))) {
            list($codPlano, $exercicio, $mes, $dtExtrato, $codEntidade) = explode('~', $this->getPersistentParameter('params'));
            $queryBuilder->andWhere("pb.codEntidade = :codEntidade");
            $queryBuilder->andWhere("{$alias}.codPlano >= :codPlanoDe");
            $queryBuilder->andWhere("{$alias}.codPlano <= :codPlanoAte");
            $queryBuilder->setParameter("codEntidade", $codEntidade);
            $queryBuilder->setParameter("codPlanoDe", $codPlano);
            $queryBuilder->setParameter("codPlanoAte", $codPlano);

            $this->filter = array(
                'exercicio' => $exercicio,
                'mes' => $mes,
                'dtExtrato' => $dtExtrato,
                'codEntidade' => $codEntidade
            );
        }

        if (!count($value['value'])) {
            return;
        }

        $this->filter = array(
            'exercicio' => $this->getExercicio(),
            'mes' => $filter['mes']['value'],
            'dtExtrato' => $filter['dtExtrato']['value'],
            'codEntidade' => $filter['fkOrcamentoEntidade']['value']
        );

        if ($filter['codPlanoDe']['value'] != "" && $filter['codPlanoAte']['value']) {
            $queryBuilder->andWhere("{$alias}.codPlano >= :codPlanoDe");
            $queryBuilder->andWhere("{$alias}.codPlano <= :codPlanoAte");
            $queryBuilder->setParameter("codPlanoDe", $filter['codPlanoDe']['value']);
            $queryBuilder->setParameter("codPlanoAte", $filter['codPlanoAte']['value']);
        }

        if ($filter['fkOrcamentoEntidade']['value'] != "") {
            $queryBuilder->andWhere("pb.codEntidade = :codEntidade");
            $queryBuilder->setParameter("codEntidade", $filter['fkOrcamentoEntidade']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkContabilidadePlanoBanco.codEntidade', 'text', ['label' => 'label.conciliarConta.entidade'])
            ->add('codPlano', 'text', ['label' => 'label.conciliarConta.codPlano'])
            ->add('fkContabilidadePlanoConta.nomConta', 'text', ['label' => 'label.conciliarConta.nomConta'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'perfil' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/ConciliarConta/CRUD:list__action_conciliar.html.twig'),
                    'print' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/ConciliarConta/CRUD:list__action_print.html.twig')
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

        $em = $this->modelManager->getEntityManager($this->getClass());

        list($codPlano, $exercicio, $mes, $dtExtrato) = explode('~', $this->getPersistentParameter('params'));
        $dtExtrato = $this->stringToDate($dtExtrato);

        $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy(
            array(
                'codPlano' => $codPlano,
                'exercicio' => $exercicio
            )
        );

        $codEntidade = $planoAnalitica->getFkContabilidadePlanoBanco()->getCodEntidade();
        $entidade = $em->getRepository(Entidade::class)->findOneBy(
            array(
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            )
        );

        $conciliacao = $this->getConciliacao($codPlano, $exercicio, $mes);

        $fieldOptions = array();

        $fieldOptions['entidade'] = array(
            'label' => 'label.conciliarConta.entidade',
            'data' => (string) $entidade,
            'mapped' => false,
            'required' => false,
            'disabled' => true
        );

        $fieldOptions['conta'] = array(
            'label' => 'label.conciliarConta.conta',
            'data' => (string) $planoAnalitica,
            'mapped' => false,
            'required' => false,
            'disabled' => true
        );

        $fieldOptions['dtExtrato'] = array(
            'label' => 'label.conciliarConta.dataExtrato',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'data' => $dtExtrato
        );

        $vlExtrato = 0.00;
        if ($conciliacao) {
            $vlExtrato = (float) $conciliacao->getVlExtrato();
        }
        $fieldOptions['vlExtrato'] = array(
            'label' => 'label.conciliarConta.saldoExtrato',
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
            'data' => $vlExtrato
        );

        $meses = array(1 => '1 - Janeiro', '2 - Fevereiro', '3 - Março', '4 - Abril', '5 - Maio', '6 - Junho', '7 - Julho', '8 - Agosto', '9 - Setembro', '10 - Outubro', '11 - Novembro', '12 - Dezembro');
        $fieldOptions['mes'] = array(
            'label' => 'label.conciliarConta.mes',
            'required' => false,
            'mapped' => false,
            'data' => $meses[$mes],
            'disabled' => true
        );

        $arMovimentacoesPendentes = array(
            'entradaTesouraria' => array(),
            'saidaTesouraria' => array(),
            'entradaBanco' => array(),
            'saidaBanco' => array()
        );

        $conciliacaoModel = new ConciliacaoModel($em);
        $params = $conciliacaoModel->montaParamsMovimentacao($exercicio, $codEntidade, $dtExtrato->format('d/m/Y'), (integer) $codPlano, $mes);
        $movimentacoes = $conciliacaoModel->recuperaMovimentacao($params);
        sort($movimentacoes);
        $arMovimentacoes = array();

        $saldoConciliado = 0.00;
        foreach ($movimentacoes as $movimentacao) {
            if ($movimentacao['conciliar'] != "true") {
                $saldoConciliado += (float) $movimentacao['vl_lancamento'];
            } else {
                if (substr($movimentacao['dt_conciliacao'], 3, 2) != $mes) {
                    $saldoConciliado += (float) $movimentacao['vl_lancamento'];
                }
            }
            $arMovimentacoes[] = $movimentacao;
        }

        $params = $conciliacaoModel->montaParamsMovimentacaoPendente($codPlano, $exercicio, $mes, $dtExtrato->format('d/m/Y'), $codEntidade);
        $movimentacoesPendentes = $conciliacaoModel->recuperaMovimentacaoPendente($params);
        sort($movimentacoesPendentes);
        foreach ($movimentacoesPendentes as $movimentacoesPendente) {
            if (trim($movimentacoesPendente['ordem']) == "") {
                if ($movimentacoesPendente['tipo_valor'] == self::TIPO_VALOR_ENTRADA) {
                    $stChave = 'entradaTesouraria';
                } else {
                    $stChave = 'saidaTesouraria';
                }
            } else {
                if ($movimentacoesPendente['vl_lancamento'] < 0) {
                    $stChave = 'entradaBanco';
                } else {
                    $stChave = 'saidaBanco';
                }
            }

            if ($movimentacoesPendente['conciliar']  != "true") {
                $saldoConciliado += (float) $movimentacoesPendente['vl_lancamento'] * -1;
            } else {
                if (substr($movimentacoesPendente['dt_conciliacao'], 3, 2) != $mes) {
                    $saldoConciliado += (float) $movimentacoesPendente['vl_lancamento'] * -1;
                }
            }

            $arMovimentacoesPendentes[$stChave][] = $movimentacoesPendente;
        }

        $fieldOptions['movimentacoesPendentes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/ConciliarConta/movimentacoesPendentes.html.twig',
            'data' => $arMovimentacoesPendentes
        );

        $fieldOptions['movimentacoes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/ConciliarConta/movimentacoes.html.twig',
            'data' => $arMovimentacoes
        );

        $saldoTesouraria = $conciliacaoModel->recuperaSaldoContaTesouraria($codPlano, $exercicio, false, $dtExtrato->format('d/m/Y'));
        $fieldOptions['saldoTesouraria'] = array(
            'label' => 'label.conciliarConta.saldoTesouraria',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'currency' => 'BRL',
            'data' => $saldoTesouraria,
            'attr' => array(
                'data-custom' => (float) $saldoTesouraria
            )
        );

        $saldoConciliado = (float) $saldoTesouraria - $saldoConciliado;
        $fieldOptions['saldoConciliado'] = array(
            'label' => 'label.conciliarConta.saldoConciliado',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'currency' => 'BRL',
            'data' => $saldoConciliado,
            'attr' => array(
                'data-custom' => $saldoConciliado
            )
        );

        $arLancamentoManuais = array();
        if ($conciliacao) {
            $lancamentoManuais = $conciliacao->getFkTesourariaConciliacaoLancamentoManuais();
            foreach ($lancamentoManuais as $lancamentoManual) {
                $arLancamentoManuais[] = $lancamentoManual;
            }
        }

        $fieldOptions['lancamentoManuais'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Tesouraria/ConciliarConta/lancamentoManuais.html.twig',
            'data' => array(
                'lancamentos' => $arLancamentoManuais,
                'dtExtrato' => $dtExtrato->format('d/m/Y')
            )
        );

        $formMapper->tab('label.conciliarConta.principal');
        $formMapper->with('label.conciliarConta.dadosConciliacao');
        $formMapper->add('entidade', 'text', $fieldOptions['entidade']);
        $formMapper->add('conta', 'text', $fieldOptions['conta']);
        $formMapper->add('mes', 'text', $fieldOptions['mes']);
        $formMapper->add('dtExtrato', 'sonata_type_date_picker', $fieldOptions['dtExtrato']);
        $formMapper->add('vlExtrato', 'money', $fieldOptions['vlExtrato']);
        $formMapper->add('saldoTesouraria', 'money', $fieldOptions['saldoTesouraria']);
        $formMapper->add('saldoConciliado', 'money', $fieldOptions['saldoConciliado']);
        $formMapper->end();
        $formMapper->with('label.conciliarConta.movimentacaoPendente');
        $formMapper->add('movimentacoesPendentes', 'customField', $fieldOptions['movimentacoesPendentes']);
        $formMapper->end();
        $formMapper->with('Assinaturas');
        $this->montaAssinaturasForm($formMapper, $em, $exercicio, $codEntidade);
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.conciliarConta.movimentacaoCorrentes');
        $formMapper->with('label.conciliarConta.dadosConciliacao');
        $formMapper->add('movimentacoes', 'customField', $fieldOptions['movimentacoes']);
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.conciliarConta.novasMovimentacoes');
        $formMapper->with('label.conciliarConta.dadosMovimentacaoConciliacao');
        $formMapper->add('lancamentoManuais', 'customField', $fieldOptions['lancamentoManuais']);
        $formMapper->end();
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codPlano')
            ->add('exercicio')
            ->add('codConta')
            ->add('naturezaSaldo')
        ;
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $conciliacaoModel = new ConciliacaoModel($em);

        list($codPlano, $exercicio, $mes, $dtExtrato) = explode('~', $this->getPersistentParameter('params'));
        $dtExtrato = $this->stringToDate($dtExtrato);

        $conciliacao = $this->getConciliacao($codPlano, $exercicio, $mes);

        $contabilidadePlanoBanco = $em->getRepository(PlanoBanco::class)
            ->findOneBy(
                array(
                    'codPlano' => $codPlano,
                    'exercicio' => $exercicio
                )
            );

        $conciliacaoModel->removeConciliacaoLancamentoArrecadacao($codPlano, $exercicio, $mes);
        $conciliacaoModel->removeConciliacaoLancamentoArrecadacaoEstornada($codPlano, $exercicio, $mes);
        $conciliacaoModel->removeConciliacaoLancamentoContabil($codPlano, $exercicio, $this->getExercicio(), $mes);
        $conciliacaoModel->removeConciliacaoLancamentoManual($codPlano, $exercicio, $mes);

        $conciliacaoModel->removeAssinatura($contabilidadePlanoBanco->getCodEntidade(), $exercicio, self::TIPO_ASSINATURA);
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        for ($i = 1; $i <= 3; $i++) {
            if (($formData['cargo_' . $i] != "") && ($formData['numcgm_' . $i] != "")) {
                $matricula = $formData['matricula_' . $i];
                $cargo = $formData['cargo_' . $i];
                $cgm = $em->getRepository(SwCgm::class)->findOneByNumcgm($formData['numcgm_' . $i]);
                $entidade = $em->getRepository(Entidade::class)->findOneBy(
                    array(
                        'codEntidade' => $contabilidadePlanoBanco->getCodEntidade(),
                        'exercicio' => $exercicio
                    )
                );
                $assinatura = new Assinatura();
                $assinatura->setFkOrcamentoEntidade($entidade);
                $assinatura->setFkSwCgm($cgm);
                $assinatura->setCargo($cargo);
                $assinatura->setTipo(self::TIPO_ASSINATURA);
                $assinatura->setNumMatricula($matricula);
                $em->persist($assinatura);
            }
        }

        if ($conciliacao) {
            $conciliacao->setFkContabilidadePlanoBanco($contabilidadePlanoBanco);
            $conciliacao->setMes($mes);
            $conciliacao->setDtExtrato($this->getForm()->get('dtExtrato')->getData());
            $conciliacao->setVlExtrato($this->getForm()->get('vlExtrato')->getData());
        } else {
            $conciliacao = new Conciliacao();
            $conciliacao->setFkContabilidadePlanoBanco($contabilidadePlanoBanco);
            $conciliacao->setMes($mes);
            $conciliacao->setDtExtrato($this->getForm()->get('dtExtrato')->getData());
            $conciliacao->setVlExtrato($this->getForm()->get('vlExtrato')->getData());
        }

        $movimentacoesPendentes = ($this->request->get('movimentacoes_pendentes')) ? $this->request->get('movimentacoes_pendentes') : array();
        $movimentacoesPendentesConciliado = ($this->request->get('movimentacoes_pendentesConciliado')) ? $this->request->get('movimentacoes_pendentesConciliado') : array();
        foreach ($movimentacoesPendentes as $movimentacaoPendente) {
            list($codLote, $tipo, $sequencia, $codEntidade, $tipoValor, $codArrecadacao, $timestampArrecadacao, $timestampEstornada, $mes, $exercicioConciliacao) = explode('~', $movimentacaoPendente);
            if ($codLote == 0 && $codArrecadacao == 0 && $mes != '') {
                $conciliacaoLancamentoManual = $em->getRepository(ConciliacaoLancamentoManual::class)
                    ->findOneBy(
                        array(
                            'codPlano' => $codPlano,
                            'exercicio' => $exercicio,
                            'mes' => $mes,
                            'sequencia' => $sequencia
                        )
                    );
                if ($conciliacaoLancamentoManual) {
                    if (in_array($movimentacaoPendente, $movimentacoesPendentesConciliado)) {
                        $conciliacaoLancamentoManual->setConciliado(true);
                        $conciliacaoLancamentoManual->setDtConciliacao($conciliacao->getDtExtrato());
                    } else {
                        $conciliacaoLancamentoManual->setConciliado(false);
                        $conciliacaoLancamentoManual->setDtConciliacao(null);
                    }
                    $em->persist($conciliacaoLancamentoManual);
                }
            }

            if (in_array($movimentacaoPendente, $movimentacoesPendentesConciliado)) {
                if ($tipo == self::TIPO_ARRECADACAO) {
                    if ($tipoValor == self::TIPO_VALOR_SAIDA) {
                        $arrecadacao = $em->getRepository(Arrecadacao::class)
                            ->findOneBy(
                                array(
                                    'codArrecadacao' => $codArrecadacao,
                                    'exercicio' => $exercicio,
                                    'timestampArrecadacao' => $timestampArrecadacao
                                )
                            );

                        $conciliacaoLancamentoArrecadacao = new ConciliacaoLancamentoArrecadacao();
                        $conciliacaoLancamentoArrecadacao->setFkTesourariaArrecadacao($arrecadacao);
                        $conciliacaoLancamentoArrecadacao->setTipo($tipo);
                        $conciliacao->addFkTesourariaConciliacaoLancamentoArrecadacoes($conciliacaoLancamentoArrecadacao);
                    } else {
                        $arrecadacaoEstornada = $em->getRepository(ArrecadacaoEstornada::class)
                            ->findOneBy(
                                array(
                                    'codArrecadacao' => $codArrecadacao,
                                    'exercicio' => $exercicio,
                                    'timestampArrecadacao' => $timestampArrecadacao,
                                    'timestampEstornada' => $timestampEstornada
                                )
                            );

                        $conciliacaoLancamentoArrecadacaoEstornada = new ConciliacaoLancamentoArrecadacaoEstornada();
                        $conciliacaoLancamentoArrecadacaoEstornada->setFkTesourariaArrecadacaoEstornada($arrecadacaoEstornada);
                        $conciliacaoLancamentoArrecadacaoEstornada->setTipo($tipo);
                        $conciliacao->addFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas($conciliacaoLancamentoArrecadacaoEstornada);
                    }
                } else {
                    $valorLancamento = $em->getRepository(ValorLancamento::class)
                        ->findOneBy(
                            array(
                                'codLote' => $codLote,
                                'tipo' => $tipo,
                                'sequencia' => $sequencia,
                                'exercicio' => $exercicio,
                                'tipoValor' => $tipoValor,
                                'codEntidade' => $codEntidade
                            )
                        );

                    if ($valorLancamento) {
                        $conciliacaoLancamentoContabil = new ConciliacaoLancamentoContabil();
                        $conciliacaoLancamentoContabil->setFkContabilidadeValorLancamento($valorLancamento);
                        $conciliacao->addFkTesourariaConciliacaoLancamentoContabiis($conciliacaoLancamentoContabil);
                    }
                }
            }
        }

        $lancamentosManuais = ($this->request->get('manuais_lancamentos')) ? $this->request->get('manuais_lancamentos') : array();
        $lancamentosManuaisConciliado = ($this->request->get('manuais_lancamentosConciliado')) ? $this->request->get('manuais_lancamentosConciliado') : array();
        if ($lancamentosManuais) {
            foreach ($lancamentosManuais as $sequencia => $lancamentoManual) {
                list($dtLancamento, $tipoValor, $vlLancamento, $descricao, $conciliado) = explode('~', $lancamentoManual);
                $conciliacaoLancamentoManual = new ConciliacaoLancamentoManual();
                $conciliacaoLancamentoManual->setDtLancamento($this->stringToDate($dtLancamento));
                $conciliacaoLancamentoManual->setSequencia(($sequencia + 1));
                $conciliacaoLancamentoManual->setTipoValor($tipoValor);
                $conciliacaoLancamentoManual->setVlLancamento((float) $vlLancamento);
                $conciliacaoLancamentoManual->setDescricao($descricao);
                if ((in_array($lancamentoManual, $lancamentosManuaisConciliado)) || ($conciliado)) {
                    $conciliacaoLancamentoManual->setConciliado(true);
                    $conciliacaoLancamentoManual->setDtConciliacao($conciliacao->getDtExtrato());
                } else {
                    $conciliacaoLancamentoManual->setConciliado(false);
                }
                $conciliacao->addFkTesourariaConciliacaoLancamentoManuais($conciliacaoLancamentoManual);
            }
        }

        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em->persist($conciliacao);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.conciliarConta.msgSucesso'));
            $this->forceRedirect($this->generateUrl('list'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param $string
     * @return \DateTime
     */
    public function stringToDate($string)
    {
        list($dia, $mes, $ano) = explode('/', $string);
        return new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));
    }

    /**
     * @param $mes
     * @return string
     */
    public function retornaMes($mes)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $mesCorrente = strftime($mes . ' - %B', strtotime($this->getExercicio() . '-' . $mes . '-01'));
        return $mesCorrente;
    }

    /**
     * @param FormMapper $formMapper
     * @param $em
     * @param $exercicio
     * @param $entidade
     */
    public function montaAssinaturasForm(FormMapper $formMapper, $em, $exercicio, $entidade)
    {
        $assinaturas = $em->getRepository(Assinatura::class)->findBy(
            [
                'exercicio' => $exercicio,
                'codEntidade' => $entidade,
                'tipo' => self::TIPO_ASSINATURA
            ]
        );

        $fieldOptions['numcgm'] = [
            'label' => 'label.conciliarConta.cgm',
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'urbem_financeiro_tesouraria_conciliacao_autocomplete_sw_cgm_pessoa_fisica'],
            'attr' => [
                'class' => 'clear-left '
            ]
        ];

        $fieldOptions['cargo'] = [
            'label' => 'label.conciliarConta.cargo',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['matricula'] = [
            'label' => 'label.conciliarConta.matricula',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['num'] = [
            'label' => 'label.assinatura.numcgm',
            'mapped' => false,
            'required' => false
        ];

        for ($i = 1; $i <= 3; $i++) {
            $fieldOptions['cargo_' . $i] = $fieldOptions['cargo'];
            $fieldOptions['matricula_' . $i] = $fieldOptions['matricula'];
            $fieldOptions['numcgm_' . $i] = $fieldOptions['numcgm'];
            if (isset($assinaturas[$i - 1])) {
                $fieldOptions['cargo_' . $i]['data'] = $assinaturas[$i - 1]->getCargo();
                $fieldOptions['matricula_' . $i]['data'] = $assinaturas[$i - 1]->getNumMatricula();
                $fieldOptions['numcgm_' . $i]['data'] = $assinaturas[$i - 1]->getNumCgm();
            }
        }
        for ($i = 1; $i <= 3; $i++) {
            $formMapper
                ->add('num_' . $i, 'hidden', [
                    'mapped' => false,
                    'data' => $i
                ])
                ->add('numcgm_' . $i, 'autocomplete', $fieldOptions['numcgm_'.$i])
                ->add('matricula_' . $i, 'text', $fieldOptions['matricula_'.$i])
                ->add('cargo_' . $i, 'text', $fieldOptions['cargo_'.$i]);
        }
    }
}
