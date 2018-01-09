<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;
use Urbem\CoreBundle\Entity\Arrecadacao\Pagamento;
use Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLote;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaLoteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_consultas_lote';
    protected $baseRoutePattern = 'tributario/arrecadacao/consultas/lote';
    protected $includeJs = ['/tributario/javascripts/arrecadacao/consulta-lote.js'];
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'consultar',
            sprintf(
                'consultar/%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->add(
            'relatorio_baixa',
            sprintf(
                'relatorio-baixa-lote/%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->add(
            'relatorio_registro',
            sprintf(
                'relatorio-registro-lote/%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['list', 'consultar', 'relatorio_baixa', 'relatorio_registro']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $qb->where(sprintf('%s.codLote IS NULL', $qb->getRootAlias()));
        }

        $qb->join(sprintf('%s.fkArrecadacaoLote', $qb->getRootAlias()), 'lote');

        return $qb;
    }

    /**
     * @param $qb
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getContribuinteSearchFilter($qb, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $qb->join('lote.fkArrecadacaoPagamentoLotes', 'pagamento_lote');
        $qb->join('pagamento_lote.fkArrecadacaoPagamento', 'pagamento');
        $qb->join('pagamento.fkArrecadacaoCarne', 'carne');
        $qb->join('carne.fkArrecadacaoParcela', 'parcela');
        $qb->join('parcela.fkArrecadacaoLancamento', 'lancamento');
        $qb->join('lancamento.fkArrecadacaoLancamentoCalculos', 'lancamento_calculo');
        $qb->join('lancamento_calculo.fkArrecadacaoCalculo', 'calculo');
        $qb->join('calculo.fkArrecadacaoCalculoCgns', 'calculo_cgm');

        $qb->andWhere('calculo_cgm.numcgm = :numcgm');
        $qb->setParameter('numcgm', $value['value']);

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $qs = $this->getRequest()->get('filter');

        $datagridMapper
            ->add(
                'loteInicial',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere('lote.codLote >= :codLote');
                        $qb->setParameter('codLote', $value['value']);

                        return true;
                    },
                    'label' => 'label.arrecadacaoConsultaLote.loteInicial',
                ],
                'number'
            )
            ->add(
                'loteFinal',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere('lote.codLote <= :codLote');
                        $qb->setParameter('codLote', $value['value']);

                        return true;
                    },
                    'label' => 'label.arrecadacaoConsultaLote.loteFinal',
                ],
                'number'
            )
            ->add(
                'dataLoteInicial',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere('lote.dataLote >= :dataLote');
                        $qb->setParameter('dataLote', $value['value']);

                        return true;
                    },
                    'label' => 'label.arrecadacaoConsultaLote.dataLoteInicial',
                ],
                'datepkpicker',
                [
                    'pk_class' => DatePK::class,
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'class' => 'js-dt-primeiro-vencimento '
                    ],
                ]
            )
            ->add(
                'dataLoteFinal',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere('lote.dataLote <= :dataLote');
                        $qb->setParameter('dataLote', $value['value']);

                        return true;
                    },
                    'label' => 'label.arrecadacaoConsultaLote.dataLoteFinal',
                ],
                'datepkpicker',
                [
                    'pk_class' => DatePK::class,
                    'format' => 'dd/MM/yyyy',
                    'attr' => [
                        'class' => 'js-dt-primeiro-vencimento '
                    ],
                ]
            )
            ->add(
                'fkArrecadacaoLote.fkMonetarioAgencia.fkMonetarioBanco',
                null,
                [
                    'label' => 'label.arrecadacaoConsultaLote.banco'
                ],
                'entity',
                [
                    'class' => Banco::class,
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');

                        $qb->orderBy('o.numBanco', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function (Banco $banco) {
                        return sprintf('%d - %s', $banco->getNumBanco(), $banco->getNomBanco());
                    },
                    'placeholder' => 'Selecione',
                    'attr' => [
                        'class' => 'select2-parameters js-select-banco',
                    ],
                ]
            )
            ->add(
                'fkArrecadacaoLote.fkMonetarioAgencia',
                null,
                [
                    'label' => 'label.arrecadacaoConsultaLote.agencia',
                ],
                'entity',
                [
                    'class' => Agencia::class,
                    'mapped' => false,
                    'query_builder' => function ($em) use ($qs) {
                        $qb = $em->createQueryBuilder('o');
                        if (empty($qs['fkArrecadacaoLote__fkMonetarioAgencia__fkMonetarioBanco']['value'])) {
                            $qb->where('o.codAgencia IS NULL');
                        }

                        if (!empty($qs['fkArrecadacaoLote__fkMonetarioAgencia__fkMonetarioBanco']['value'])) {
                            $qb->andWhere('o.codBanco = :codBanco');
                            $qb->setParameter('codBanco', $qs['fkArrecadacaoLote__fkMonetarioAgencia__fkMonetarioBanco']['value']);
                        }

                        $qb->orderBy('o.numAgencia', 'ASC');

                        return $qb;
                    },
                    'choice_value' => 'codAgencia',
                    'choice_label' => function (Agencia $agencia) {
                        return (string) $agencia->getNumAgencia();
                    },
                    'attr' => [
                        'class' => 'select2-parameters js-select-agencia',
                    ],
                ]
            )
            ->add('fkArrecadacaoLote.exercicio', null, ['label' => 'label.arrecadacaoConsultaLote.exercicio'])
            ->add(
                'contribuinte',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getContribuinteSearchFilter'],
                    'label' => 'label.arrecadacaoConsultaLote.contribuinte',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'api-search-swcgm-by-nomcgm'
                    ],
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
            ->add('codLote', null, ['label' => 'label.arrecadacaoConsultaLote.codLote'])
            ->add('fkArrecadacaoLote.dataLote', null, ['label' => 'label.arrecadacaoConsultaLote.dataLote'])
            ->add(
                'fkArrecadacaoLote.fkMonetarioAgencia.fkMonetarioBanco',
                'entity',
                [
                    'associated_property' => function (Banco $banco) {
                        return sprintf('%d - %s', $banco->getNumBanco(), $banco->getNomBanco());
                    },
                    'label' => 'label.arrecadacaoConsultaLote.banco',
                ]
            )
            ->add(
                'fkArrecadacaoLote.fkMonetarioAgencia',
                'entity',
                [
                    'associated_property' => function (Agencia $agencia) {
                        return sprintf('%s - %s', $agencia->getNumAgencia(), $agencia->getNomAgencia());
                    },
                    'label' => 'label.arrecadacaoConsultaLote.agencia',
                ]
            )
            ->add(
                'fkArrecadacaoLote.fkAdministracaoUsuario',
                'entity',
                [
                    'admin_code' => 'administrativo.admin.usuario',
                    'label' => 'label.arrecadacaoConsultaLote.responsavel',
                ]
            )
            ->add(
                'automatico',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/list_tipo.html.twig',
                    'label' => 'label.arrecadacaoConsultaLote.tipo',
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'consultar' => ['template' => 'TributarioBundle::Arrecadacao/ConsultaLote/list_action_consultar.html.twig'],
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

        $em = $this->modelManager->getEntityManager($this->getClass());

        $loteArquivo = $this->getSubject();

        $this->pagamentos = $em->getRepository(Lote::class)->getPagamentos($loteArquivo->getFkArrecadacaoLote());

        $fieldOptions['incluirDia'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/incluir_dia.html.twig',
            'data' => [],
        ];

        $showMapper
            ->with('label.arrecadacaoConsultaLote.cabecalhoEmissao')
                ->add('codLote', null, ['label' => 'label.arrecadacaoConsultaLote.codLote'])
                ->add('fkArrecadacaoLote.dataLote', null, ['label' => 'label.arrecadacaoConsultaLote.dataLote'])
                ->add(
                    'dataBaixa',
                    null,
                    [
                        'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/show_data_baixa.html.twig',
                    ]
                )
                ->add(
                    'fkArrecadacaoLote.fkAdministracaoUsuario',
                    'text',
                    [
                        'admin_code' => 'administrativo.admin.usuario',
                        'label' => 'label.arrecadacaoConsultaLote.responsavel'
                    ]
                )
                ->add('nomArquivo', null, ['label' => 'label.arrecadacaoConsultaLote.nomArquivo'])
                ->add(
                    'fkArrecadacaoLote.fkMonetarioAgencia.fkMonetarioBanco',
                    'entity',
                    [
                        'associated_property' => function (Banco $banco) {
                            return sprintf('%d - %s', $banco->getNumBanco(), $banco->getNomBanco());
                        },
                        'label' => 'label.arrecadacaoConsultaLote.banco',
                    ]
                )
                ->add(
                    'fkArrecadacaoLote.fkMonetarioAgencia',
                    'entity',
                    [
                        'associated_property' => function (Agencia $agencia) {
                            return sprintf('%s - %s', $agencia->getNumAgencia(), $agencia->getNomAgencia());
                        },
                        'label' => 'label.arrecadacaoConsultaLote.agencia',
                    ]
                )
                ->add(
                    'automatico',
                    null,
                    [
                        'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/show_tipo.html.twig',
                    ]
                )
                ->add(
                    'valorLote',
                    null,
                    [
                        'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/show_valor_lote.html.twig',
                    ]
                )
            ->end()
            ->with('label.arrecadacaoConsultaLote.cabecalhoListaPagamentos')
                ->add(
                    'listaPagamentos',
                    null,
                    [
                        'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/show_lista_pagamentos.html.twig',
                    ]
                )
                ->add(
                    'relatorios',
                    null,
                    [
                        'template' => 'TributarioBundle::Arrecadacao/ConsultaLote/show_btn_relatorios.html.twig',
                    ]
                )
            ->end();
    }
}
