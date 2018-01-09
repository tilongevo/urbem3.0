<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Contabilidade\Lote;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class LoteAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_lote';
    protected $baseRoutePattern = 'financeiro/contabilidade/lancamento-contabil';
    protected $includeJs = array(
        '/financeiro/javascripts/contabilidade/lancamentocontabil/lote.js',
        '/financeiro/javascripts/contabilidade/lancamentocontabil/lote-lista.js'
    );
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/contabilidade/report/design/notaLancamento.rptdesign';
    protected $exibirMensagemFiltro =  false;
    protected $legendButtonSave = array('icon' => 'save', 'text' => 'Salvar');

    const TYPE_CREDITO = 'C';
    const TYPE_DEBITO = 'D';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_assinaturas', 'consultar-assinaturas', array(), array(), array(), '', array(), array('POST'));
        $collection->add('verifica_mes_processamento', 'verifica-mes-processamento', array(), array(), array(), '', array(), array('POST'));
        $collection->add('verifica_mes_encerramento', 'verifica-mes-encerramento', array(), array(), array(), '', array(), array('POST'));
        $collection->add('verifica_ano_processamento', 'verifica-ano-processamento', array(), array(), array(), '', array(), array('POST'));

        $collection->add('consultar_cod_lote', 'consultar-cod-lote');
        $collection->add('autocomplete_plano_analitica', 'autocomplete-plano-analitica');
        $collection->add('autocomplete_historico_contabil', 'autocomplete-historico-contabil');

        $collection->add('gerar_nota', $this->getRouterIdParameter() . '/gerar-nota');
        $collection->add('perfil', $this->getRouterIdParameter() . '/perfil');

        $collection->remove('show');
        $collection->remove('delete');
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->andWhere('o.tipo = :tipo');
        $query->setParameters([
            'exercicio' => $this->getExercicio(),
            'tipo' => LoteModel::TYPE_LOTE_LANCAMENTO_CONTABIL
        ]);

        if (! $this->getRequest()->query->get('filter')) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere('1 = 0');
        }
        return $query;
    }

    /**
     * @param Lote $lote
     */
    public function prePersist($lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $entidade = $this->getForm()->get('fkOrcamentoEntidade')->getData();
        $tipo = $this->getForm()->get('tipo')->getData();
        $exercicio = $this->getForm()->get('exercicio')->getData();

        $loteModel = new LoteModel($em);

        $codLote = $loteModel
            ->getProximoCodLote(
                $entidade->getCodEntidade(),
                $tipo,
                $exercicio
            );

        $lote->setCodLote($codLote);
        $lote->setFkOrcamentoEntidade($entidade);
        $lote->setTipo($this->getForm()->get('tipo')->getData());
        $lote->setExercicio($this->getForm()->get('exercicio')->getData());

        $loteModel->salvarLancamentos($lote, $this->request->request);
    }

    /**
     * @param Lote $lote
     */
    public function preUpdate($lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        (new LoteModel($em))->alterarLancamentos($lote, $this->request->request);
    }

    /**
     * @param Lote $lote
     */
    public function postPersist($lote)
    {
        $mensagem = $this->getTranslator()->trans('label.lote.msgSucesso', ['%codLote%' => $lote->getCodLote(), '%exercicio%' => $lote->getExercicio()]);
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->clear();
        $container->get('session')->getFlashBag()->add('success', $mensagem);
        $this->forceRedirect($this->generateUrl('perfil', array('id' => $this->getObjectKey($lote))));
    }

    /**
     * @param Lote $lote
     */
    public function postUpdate($lote)
    {
        $mensagem = $this->getTranslator()->trans('label.lote.msgAlterarSucesso', ['%codLote%' => $lote->getCodLote(), '%exercicio%' => $lote->getExercicio()]);
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->clear();
        $container->get('session')->getFlashBag()->add('success', $mensagem);
        $this->forceRedirect($this->generateUrl('perfil', array('id' => $this->getObjectKey($lote))));
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
                'composite_filter',
                [
                    'label' => 'label.lote.codEntidade'
                ],
                null,
                [
                    'class' => Entidade::class,
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    }
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add('codLote', null, ['label' => 'label.lote.codLote'])
            ->add('nomLote', null, ['label' => 'label.lote.nomLote'])
            ->add(
                'dtLote',
                null,
                [
                    'label' => 'label.lote.dtLote'
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLote', null, ['label' => 'label.lote.codLote'])
            ->add('nomLote', null, ['label' => 'label.lote.nomLote'])
            ->add('dtLote', null, ['label' => 'label.lote.dtLote'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'perfil' => array('template' => 'FinanceiroBundle:Sonata/Contabilidade/Lote/CRUD:list__action_edit.html.twig'),
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

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();

        $dtAtual = new \DateTime();

        $mesEncerramento = (new LoteModel($em))->verificaMesEncerramento($dtAtual->format('d/m/Y'), $exercicio);
        if (!$mesEncerramento) {
            $mensagem = $this->getTranslator()->trans('label.lote.erroMesEncerrado');
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->clear();
            $container->get('session')->getFlashBag()->add('error', $mensagem);
            $this->forceRedirect($this->generateUrl('list'));
        }

        $fieldOptions['tipo'] = array(
            'mapped' => false,
            'data' => LoteModel::TYPE_LOTE_LANCAMENTO_CONTABIL
        );

        $fieldOptions['exercicio'] = array(
            'mapped' => false,
            'data' => $exercicio
        );

        $fieldOptions['fkOrcamentoEntidade'] = array(
            'label' => 'label.lote.codEntidade',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'choice_value' => 'codEntidade',
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            }
        );

        $fieldOptions['codLote'] = array(
            'label' => 'label.lote.codLote',
            'mapped' => false,
            'disabled' => true
        );

        $fieldOptions['nomLote'] = array(
            'label' => 'label.lote.nomLote'
        );

        $fieldOptions['dtLote'] = array(
            'label' => 'label.lote.dtLote',
            'format' => 'dd/MM/yyyy'
        );

        $fieldOptions['sequencia'] = [
            'mapped' => false
        ];

        $fieldOptions['fkContabilidadePlanoAnalitica'] = [
            'label' => 'label.lote.codConta',
            'route' => ['name' => 'urbem_financeiro_contabilidade_lote_autocomplete_plano_analitica'],
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'req_params' => ['exercicio' => $exercicio]
        ];

        $fieldOptions['vlLancamento'] = [
            'label' => 'label.lote.valor',
            'grouping' => false,
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money vl-lancamento '
            ]
        ];

        $fieldOptions['fkContabilidadeHistoricoContabil'] = [
            'label' => 'label.lote.codHistorico',
            'route' => ['name' => 'urbem_financeiro_contabilidade_lote_autocomplete_historico_contabil'],
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'req_params' => [
                'exercicio' => $exercicio
            ]
        ];

        $fieldOptions['complemento'] = [
            'label' => 'label.lote.complemento',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'maxlength' => 400
            ]
        ];

        $fieldOptions['dadosListaDebitos'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Contabilidade/Lote/lista.html.twig',
            'attr' => [
                'style' => 'display:none;'
            ],
            'data' => [
                'lancamentos' => array(),
                'tipo' => 'debito'
            ]
        ];

        $fieldOptions['dadosListaCreditos'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'FinanceiroBundle::Contabilidade/Lote/lista.html.twig',
            'attr' => [
                'style' => 'display:none;'
            ],
            'data' => [
                'lancamentos' => array(),
                'tipo' => 'credito'
            ]
        ];

        $fieldOptions['vlDebito'] = [
            'label' => 'label.lote.totalDebito',
            'grouping' => false,
            'mapped' => false,
            'currency' => 'BRL',
            'data' => 0.00,
            'disabled' => true,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['vlCredito'] = [
            'label' => 'label.lote.totalCredito',
            'grouping' => false,
            'mapped' => false,
            'currency' => 'BRL',
            'data' => 0.00,
            'disabled' => true,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['vlDiferenca'] = [
            'label' => 'label.lote.diferenca',
            'grouping' => false,
            'mapped' => false,
            'currency' => 'BRL',
            'data' => 0.00,
            'disabled' => true,
            'attr' => [
                'class' => 'money '
            ]
        ];

        if ($this->getSubject()->getExercicio() != null) {
            /** @var Lote $lote */
            $lote = $this->getSubject();

            $fieldOptions['fkOrcamentoEntidade']['disabled'] = true;
            $fieldOptions['fkOrcamentoEntidade']['data'] = $lote->getFkOrcamentoEntidade();

            $fieldOptions['codLote']['data'] = $lote->getCodLote();

            $fieldOptions['nomLote']['disabled'] = true;
            $fieldOptions['nomLote']['mapped'] = false;
            $fieldOptions['nomLote']['data'] = $lote->getNomLote();

            $fieldOptions['dtLote']['disabled'] = true;
            $fieldOptions['dtLote']['mapped'] = false;
            $fieldOptions['dtLote']['data'] = $lote->getDtLote();

            $fieldOptions['dadosListaDebitos']['data']['lancamentos'] = $lote->getFkContabilidadeLancamentos();
            $fieldOptions['dadosListaCreditos']['data']['lancamentos'] = $lote->getFkContabilidadeLancamentos();

            $vlDebito = $vlCredito = $vlDiferenca = 0;
            /** @var Lancamento $lancamento */
            foreach ($lote->getFkContabilidadeLancamentos() as $lancamento) {
                /** @var ValorLancamento $valorLancamento */
                foreach ($lancamento->getFkContabilidadeValorLancamentos() as $valorLancamento) {
                    if ($valorLancamento->getTipoValor() == self::TYPE_DEBITO) {
                        $vlDebito += $valorLancamento->getVlLancamento();
                    } else {
                        $vlCredito += ($valorLancamento->getVlLancamento() * -1);
                    }
                }
            }
            $vlDiferenca = $vlCredito - $vlDebito;

            $fieldOptions['vlDebito']['data'] = $vlDebito;
            $fieldOptions['vlCredito']['data'] = $vlCredito;
            $fieldOptions['vlDiferenca']['data'] = $vlDiferenca;
        }

        $formMapper->with('label.lote.dados');
        $formMapper->add('tipo', 'hidden', $fieldOptions['tipo']);
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade']);
        $formMapper->add('codLote', null, $fieldOptions['codLote']);
        $formMapper->add('nomLote', null, $fieldOptions['nomLote']);
        $formMapper->add('dtLote', 'sonata_type_date_picker', $fieldOptions['dtLote']);
        $formMapper->end();

        $formMapper->with('label.lote.dadosLancamentoDebito');
        $formMapper->add('debito.sequencia', 'hidden', $fieldOptions['sequencia']);
        $formMapper->add('debito.fkContabilidadePlanoAnalitica', 'autocomplete', $fieldOptions['fkContabilidadePlanoAnalitica']);
        $formMapper->add('debito.vlLancamento', 'money', $fieldOptions['vlLancamento']);
        $formMapper->add('debito.fkContabilidadeHistoricoContabil', 'autocomplete', $fieldOptions['fkContabilidadeHistoricoContabil']);
        $formMapper->add('debito.complemento', 'textarea', $fieldOptions['complemento']);
        $formMapper->add('debito.dadosLista', 'customField', $fieldOptions['dadosListaDebitos']);
        $formMapper->end();

        $formMapper->with('label.lote.dadosLancamentoCredito');
        $formMapper->add('credito.sequencia', 'hidden', $fieldOptions['sequencia']);
        $formMapper->add('credito.fkContabilidadePlanoAnalitica', 'autocomplete', $fieldOptions['fkContabilidadePlanoAnalitica']);
        $formMapper->add('credito.vlLancamento', 'money', $fieldOptions['vlLancamento']);
        $formMapper->add('credito.fkContabilidadeHistoricoContabil', 'autocomplete', $fieldOptions['fkContabilidadeHistoricoContabil']);
        $formMapper->add('credito.complemento', 'textarea', $fieldOptions['complemento']);
        $formMapper->add('credito.dadosLista', 'customField', $fieldOptions['dadosListaCreditos']);
        $formMapper->end();

        $formMapper->with('label.lote.totais');
        $formMapper->add('totais.vlDebito', 'money', $fieldOptions['vlDebito']);
        $formMapper->add('totais.vlCredito', 'money', $fieldOptions['vlCredito']);
        $formMapper->add('totais.vlDiferenca', 'money', $fieldOptions['vlDiferenca']);
        $formMapper->end();
    }

    /**
     * @param mixed $object
     * @return mixed|string
     */
    public function toString($object)
    {
        return $object->getCodLote()
            ? $object
            : $this->getTranslator()->trans('label.lote.modulo');
    }
}
