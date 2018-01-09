<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Helper\TimeMicrosecondPK;
use Urbem\CoreBundle\Model\Empenho\AutorizacaoEmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DuplicarAutorizacaoEmpenhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_duplicar_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/duplicar-autorizacao';
    protected $exibirBotaoIncluir = false;
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'codAutorizacao'
    );
    protected $exibirMensagemFiltro = true;

    /**
     * @param RouteCollection $routeCollection
     */
    public function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['list', 'edit']);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEntidade',
                ),
                'entity',
                array(
                    'class' => Entidade::class,
                    'choice_value' => 'codEntidade',
                    'choice_label' => 'fkSwCgm.nomCgm',
                    'attr' => array(
                        'class' => 'select2-parameters',
                        'required' => 'required'
                    ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'exercicio',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.exercicio',
                ),
                'text',
                array(
                    'attr' => array(
                        'required' => 'required'
                    )
                )
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoInicial',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoFinal',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'codEmpenhoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoInicial',
                )
            )
            ->add(
                'codEmpenhoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoFinal',
                )
            )
            ->add(
                'codAutorizacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoInicial',
                )
            )
            ->add(
                'codAutorizacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoFinal',
                )
            )
            ->add(
                'fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
                    'label' => 'label.ordemPagamento.credor',
                ),
                'sonata_type_model_autocomplete',
                array(
                    'class' => SwCgm::class,
                    'property' => 'nomCgm',
                    'to_string_callback' => function ($swCgm, $property) {
                        return $swCgm->getNomCgm();
                    },
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                ),
                array(
                    'admin_code' => 'core.admin.filter.sw_cgm'
                )
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $autorizacaoEmpenhoModel = new AutorizacaoEmpenhoModel($entityManager);
        $autorizacaoEmpenhoList = $autorizacaoEmpenhoModel->filterDuplicarAutorizacaoEmpenho($this->getCurrentUser()->getNumcgm(), $filter);

        $ids = array();
        foreach ($autorizacaoEmpenhoList as $codAutorizacao) {
            $ids[] = $codAutorizacao->cod_autorizacao;
        }

        if (count($autorizacaoEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codAutorizacao", $ids));
            $queryBuilder->andWhere("{$alias}.exercicio = :exercicio");
            $queryBuilder->andWhere("{$alias}.codEntidade = :codEntidade");

            $queryBuilder->setParameter("exercicio", $filter['exercicio']['value']);
            $queryBuilder->setParameter("codEntidade", $filter['codEntidade']['value']);
        } else {
            $queryBuilder->andWhere('1 = 0');
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
            ->add(
                'fkOrcamentoEntidade.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'entidade'
                ]
            )
            ->add(
                'codAutorizacaoAndExercicio',
                null,
                [
                    'label' => 'label.preEmpenho.autorizacao'
                ]
            )
            ->add(
                'dtAutorizacao',
                'date',
                [
                    'label' => 'label.preEmpenho.dtAutorizacao'
                ]
            )
            ->add(
                'fkEmpenhoPreEmpenho.fkSwCgm',
                null,
                [
                    'label' => 'label.ordemPagamento.credor'
                ]
            )
            ->add('saldoDotacao', 'customField', ['label' => 'label.preEmpenho.valor', 'template' => 'FinanceiroBundle:Sonata/Empenho/Autorizacao/CRUD:custom_field_valor.html.twig'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'duplicar' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Autorizacao/CRUD:list__action_duplicar.html.twig'),
                ),
                'header_style' => 'width: 5%'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var AutorizacaoEmpenho  $autorizacaoEmpenhoAnulado */
            $autorizacaoEmpenhoAnulado = $this->getSubject();

            if (is_null($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa())) {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.duplicarEmpenho.errorDespesa'));
                $this->forceRedirect("/financeiro/empenho/duplicar-autorizacao/list");
            }

            $codDespesa = $autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getCodDespesa();
            $dtAtual = sprintf('%s-12-31', $this->getExercicio());

            $valorTotalReserva = 0;
            if (!is_null($autorizacaoEmpenhoAnulado->getFkEmpenhoAutorizacaoReserva())) {
                $valorTotalReserva = $autorizacaoEmpenhoAnulado->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->getVlReserva();
            }

            // Valida o saldo da dotação
            $params = array(
                'exercicio' => $autorizacaoEmpenhoAnulado->getExercicio(),
                'codDespesa' => $codDespesa,
                'dtAtual' => $dtAtual,
                'dtEmpenho' => '',
                'codEntidade' => $autorizacaoEmpenhoAnulado->getCodEntidade(),
                'tipoEmissao' => EmpenhoModel::TIPO_EMISSAO_EMPENHO
            );

            $saldoAnterior = (new EmpenhoModel($em))->getFnSaldoDotacaoDataAtualEmpenho($params);

            if ($valorTotalReserva > $saldoAnterior->saldo_anterior) {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.duplicarEmpenho.saldoIndisponivelDotacao'));
                $this->forceRedirect("/financeiro/empenho/duplicar-autorizacao/list");
            }

            /** @var Historico $historico */
            $historico = $em->getRepository(Historico::class)->findOneBy([
                'codHistorico' => $autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getCodHistorico(),
                'exercicio' => $this->getExercicio()
            ]);

            $preEmpenhoModel = new PreEmpenhoModel($em);

            $codPreEmpenho = $preEmpenhoModel->getUltimoPreEmpenho($this->getExercicio());
            $preEmpenho = new PreEmpenho();
            $preEmpenho->setCodPreEmpenho($codPreEmpenho);
            $preEmpenho->setFkAdministracaoUsuario($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkAdministracaoUsuario());
            $preEmpenho->setFkEmpenhoTipoEmpenho($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoTipoEmpenho());
            $preEmpenho->setFkEmpenhoHistorico($historico);
            $preEmpenho->setFkSwCgm($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkSwCgm());
            $preEmpenho->setDescricao($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getDescricao());

            /** @var Unidade $unidade */
            $unidade = $em->getRepository(Unidade::class)
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'numUnidade' => $autorizacaoEmpenhoAnulado->getNumUnidade(),
                    'numOrgao' => $autorizacaoEmpenhoAnulado->getNumOrgao()
                ]);

            /** @var Entidade $entidade */
            $entidade = $em->getRepository(Entidade::class)
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'codEntidade' => $autorizacaoEmpenhoAnulado->getCodEntidade()
                ]);

            list($dia, $mes, $ano) = explode('/', $preEmpenhoModel->getDtAutorizacao($autorizacaoEmpenhoAnulado->getCodEntidade(), $this->getExercicio()));
            $dtAutorizacao = new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));

            $codAutorizacao = (new AutorizacaoEmpenhoModel($em))->getProximoCodAutorizacao($this->getExercicio(), $autorizacaoEmpenhoAnulado->getCodEntidade());
            $autorizacaoEmpenho = new AutorizacaoEmpenho();
            $autorizacaoEmpenho->setCodAutorizacao($codAutorizacao);
            $autorizacaoEmpenho->setExercicio($this->getExercicio());
            $autorizacaoEmpenho->setFkOrcamentoEntidade($entidade);
            $autorizacaoEmpenho->setFkOrcamentoUnidade($unidade);
            $autorizacaoEmpenho->setDtAutorizacao(new DateTimeMicrosecondPK($dtAutorizacao->format('Y-m-d H:i:s.u')));
            $autorizacaoEmpenho->setHora(new TimeMicrosecondPK());
            $autorizacaoEmpenho->setFkEmpenhoCategoriaEmpenho($autorizacaoEmpenhoAnulado->getFkEmpenhoCategoriaEmpenho());

            $preEmpenho->addFkEmpenhoAutorizacaoEmpenhos($autorizacaoEmpenho);

            /** @var ContaDespesa $contaDespesa */
            $contaDespesa = $em->getRepository(ContaDespesa::class)->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codConta' => $autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoContaDespesa()->getCodConta()
            ]);

            /** @var Despesa $despesa */
            $despesa = $em->getRepository(Despesa::class)->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codDespesa' => $autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa()->getCodDespesa()
            ]);

            $preEmpenhoDespesa = new PreEmpenhoDespesa();
            $preEmpenhoDespesa->setFkOrcamentoContaDespesa($contaDespesa);
            $preEmpenhoDespesa->setFkOrcamentoDespesa($despesa);

            $preEmpenho->setFkEmpenhoPreEmpenhoDespesa($preEmpenhoDespesa);
            /** @var ItemPreEmpenho $itemPreEmpenhoAnulado */
            foreach ($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoItemPreEmpenhos() as $itemPreEmpenhoAnulado) {
                $itemPreEmpenho = new ItemPreEmpenho();
                $itemPreEmpenho->setNumItem($itemPreEmpenhoAnulado->getNumItem());
                $itemPreEmpenho->setNomUnidade($itemPreEmpenhoAnulado->getNomUnidade());
                $itemPreEmpenho->setSiglaUnidade($itemPreEmpenhoAnulado->getSiglaUnidade());
                $itemPreEmpenho->setNomItem($itemPreEmpenhoAnulado->getNomItem());
                $itemPreEmpenho->setQuantidade($itemPreEmpenhoAnulado->getQuantidade());
                $itemPreEmpenho->setVlTotal($itemPreEmpenhoAnulado->getVlTotal());
                $itemPreEmpenho->setComplemento($itemPreEmpenhoAnulado->getComplemento());
                $itemPreEmpenho->setFkAdministracaoUnidadeMedida($itemPreEmpenhoAnulado->getFkAdministracaoUnidadeMedida());
                if ($itemPreEmpenhoAnulado->getFkAlmoxarifadoCentroCusto()) {
                    $itemPreEmpenho->setFkAlmoxarifadoCentroCusto($itemPreEmpenhoAnulado->getFkAlmoxarifadoCentroCusto());
                }
                if ($itemPreEmpenhoAnulado->getFkAlmoxarifadoMarca()) {
                    $itemPreEmpenho->setFkAlmoxarifadoMarca($itemPreEmpenhoAnulado->getFkAlmoxarifadoMarca());
                }
                if ($itemPreEmpenhoAnulado->getFkAlmoxarifadoCatalogoItem()) {
                    $itemPreEmpenho->setFkAlmoxarifadoCatalogoItem($itemPreEmpenhoAnulado->getFkAlmoxarifadoCatalogoItem());
                }
                $preEmpenho->addFkEmpenhoItemPreEmpenhos($itemPreEmpenho);
            }

            $timestamp = new DateTimeMicrosecondPK();
            /** @var AtributoEmpenhoValor $atributoEmpenhoValorAnulado */
            foreach ($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho()->getFkEmpenhoAtributoEmpenhoValores() as $atributoEmpenhoValorAnulado) {
                $atributoEmpenhoValor = new AtributoEmpenhoValor();
                $atributoEmpenhoValor->setTimestamp($timestamp);
                $atributoEmpenhoValor->setValor($atributoEmpenhoValorAnulado->getValor());
                $atributoEmpenhoValor->setFkAdministracaoAtributoDinamico($atributoEmpenhoValorAnulado->getFkAdministracaoAtributoDinamico());
                $preEmpenho->addFkEmpenhoAtributoEmpenhoValores($atributoEmpenhoValor);
            }

            $codReserva = (new ReservaSaldosModel($em))->getProximoCodReserva($this->getExercicio());
            $reservaSaldos = new ReservaSaldos();
            $reservaSaldos->setCodReserva($codReserva);
            $reservaSaldos->setFkOrcamentoDespesa($despesa);
            $reservaSaldos->setDtValidadeInicial($dtAutorizacao);
            $reservaSaldos->setDtValidadeFinal(new \DateTime("{$this->getExercicio()}-12-31"));
            $reservaSaldos->setDtInclusao(new \DateTime());
            $reservaSaldos->setMotivo(sprintf("Autorização de Empenho %s/%s", $autorizacaoEmpenho->getCodAutorizacao(), $this->getExercicio()));
            $reservaSaldos->setVlReserva($autorizacaoEmpenhoAnulado->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->getVlReserva());

            $autorizacaoReserva = new AutorizacaoReserva();
            $autorizacaoReserva->setFkOrcamentoReservaSaldos($reservaSaldos);

            $autorizacaoEmpenho->setFkEmpenhoAutorizacaoReserva($autorizacaoReserva);

            $em->persist($preEmpenho);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.duplicarEmpenho.sucesso', ['%codAutorizacao%' => $autorizacaoEmpenho->getCodAutorizacao(), '%exercicio%' => $autorizacaoEmpenho->getExercicio()]));
            $this->forceRedirect(sprintf("/financeiro/empenho/autorizacao/%s/show?codPreEmpenhoAnulada=%s", $this->getObjectKey($autorizacaoEmpenho->getFkEmpenhoPreEmpenho()), $this->getObjectKey($autorizacaoEmpenhoAnulado->getFkEmpenhoPreEmpenho())));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/financeiro/empenho/duplicar-autorizacao/list");
        }
    }

    /**
     * @param AutorizacaoEmpenho $autorizacaoEmpenho
     * @return int
     */
    public function getSaldoDotacao($autorizacaoEmpenho)
    {
        $valorTotalReserva = 0;
        if (!is_null($autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva())) {
            $valorTotalReserva = $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->getVlReserva();
        };
        return $valorTotalReserva;
    }
}
