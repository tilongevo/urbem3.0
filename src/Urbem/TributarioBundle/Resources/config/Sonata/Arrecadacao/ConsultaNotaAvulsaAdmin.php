<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaNotaAvulsaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_consultas_nota_avulsa';
    protected $baseRoutePattern = 'tributario/arrecadacao/consultas/nota-avulsa';
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

        $routes->clearExcept(['list', 'consultar']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qs = $this->getRequest()->query->get('filter');

        if (!$qs || empty($qs['exercicio']['value'])) {
            $qb->andWhere(sprintf('%s.exercicio = :exercicio', $qb->getRootAlias()));
            $qb->setParameter('exercicio', $this->getExercicio());
        }

        $qb->join(sprintf('%s.fkArrecadacaoNota', $qb->getRootAlias()), 'nota');
        $qb->join('nota.fkArrecadacaoNotaServicos', 'nota_servico');
        $qb->join('nota_servico.fkArrecadacaoFaturamentoServico', 'faturamento_servico');
        $qb->join('faturamento_servico.fkArrecadacaoServicoSemRetencao', 'servico_sem_retencao');
        $qb->join('faturamento_servico.fkArrecadacaoCadastroEconomicoFaturamento', 'cadastro_economico_faturamento');
        $qb->join('cadastro_economico_faturamento.fkArrecadacaoCadastroEconomicoCalculos', 'cadastro_economico_calculo');
        $qb->join('cadastro_economico_calculo.fkArrecadacaoCalculo', 'calculo');
        $qb->join('calculo.fkArrecadacaoLancamentoCalculos', 'lancamento_calculo');
        $qb->join('lancamento_calculo.fkArrecadacaoLancamento', 'lancamento');
        $qb->join('lancamento.fkArrecadacaoParcelas', 'parcela');
        $qb->join('parcela.fkArrecadacaoCarnes', 'carne');

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

        $qb->join('cadastro_economico_faturamento.fkEconomicoCadastroEconomico', 'cadastro_economico');
        $qb->leftJoin('cadastro_economico.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
        $qb->leftJoin('cadastro_economico.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
        $qb->leftJoin('cadastro_economico.fkEconomicoCadastroEconomicoAutonomo', 'cea');
        $qb->join(SwCgm::class, 'cgm', 'WITH', 'cgm.numcgm = COALESCE(ceef.numcgm, ceed.numcgm, cea.numcgm)');

        $qb->andWhere('cgm.numcgm = :numcgm');
        $qb->setParameter('numcgm', $value['value']);

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $qs = $this->getRequest()->get('filter');

        if (empty($qs['exercicio']['value'])) {
            $this->getDatagrid()->setValue('exercicio', 'LIKE', $this->getExercicio());
        }

        $datagridMapper
            ->add(
                'contribuinte',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getContribuinteSearchFilter'],
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.contribuinte',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'route' => [
                        'name' => 'api-search-swcgm-by-nomcgm'
                    ],
                ]
            )
            ->add(
                'inscricaoEconomica',
                'doctrine_orm_callback',
                [
                    'callback' => function ($qb, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $qb->andWhere('faturamento_servico.inscricaoEconomica = :inscricaoEconomica');
                        $qb->setParameter('inscricaoEconomica', $value['value']);

                        return true;
                    },
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.inscricaoEconomica',
                ],
                'number'
            )
            ->add('exercicio', null, ['label' => 'label.arrecadacaoConsultaNotaAvulsa.exercicio']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'inscricaoEconomica',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_inscricao_economica.html.twig',
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.inscricaoEconomica'
                ]
            )
            ->add(
                'contribuinte',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_contribuinte.html.twig',
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.contribuinte'
                ]
            )
            ->add(
                'modalidade',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_modalidade.html.twig',
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.modalidade'
                ]
            )
            ->add(
                'competencia',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_competencia.html.twig',
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.competencia'
                ]
            )
            ->add(
                'serieNota',
                null,
                [
                    'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_serie_nota.html.twig',
                    'label' => 'label.arrecadacaoConsultaNotaAvulsa.serieNota'
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'consultar' => ['template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/list_action_consultar.html.twig'],
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

        $this->info = $em->getRepository(NotaAvulsa::class)->getInfo($this->getSubject());

        $fieldOptions = [];
        $fieldOptions['notaAvulsa'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/show_nota_avulsa.html.twig',
        ];

        $fieldOptions['listaServicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/show_lista_servicos.html.twig',
        ];

        $fieldOptions['detalhamentoValores'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Arrecadacao/ConsultaNotaAvulsa/show_detalhamento_valores.html.twig',
        ];

        $showMapper
            ->tab('label.arrecadacaoConsultaNotaAvulsa.tabDadosNotaAvulsa')
                ->with('label.arrecadacaoConsultaNotaAvulsa.cabecalhoNotaAvulsa')
                    ->add('notaAvulsa', null, $fieldOptions['notaAvulsa'])
                ->end()
                ->with('label.arrecadacaoConsultaNotaAvulsa.cabecalhoListaServicos')
                    ->add('listaServicos', null, $fieldOptions['listaServicos'])
                ->end()
            ->end()
            ->tab('label.arrecadacaoConsultaNotaAvulsa.tabDetalhamentoValores')
                ->with('label.arrecadacaoConsultaNotaAvulsa.cabecalhoDetalhamentoValores')
                    ->add('detalhamentoValores', null, $fieldOptions['detalhamentoValores'])
                ->end()
            ->end();
    }
}
