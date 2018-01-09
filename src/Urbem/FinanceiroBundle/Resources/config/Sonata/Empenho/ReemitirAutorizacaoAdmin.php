<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ReemitirAutorizacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_reemitir_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/reemitir-autorizacao';
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('list');
        $collection->add('reemitir_autorizacao', 'reemitir-autorizacao', array(), array(), array(), '', array(), array('GET'));
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
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codPreEmpenho'));

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $dotacaoChoices = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
            ->getDotacaoOrcamentaria($this->getExercicio(), true);


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
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_value' => 'codEntidade',
                    'choice_label' => 'fkSwCgm.nomCgm',
                    'attr' => array(
                        'class' => 'select2-parameters',
                        'required' => 'required'
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'exercicio',
                null,
                array(
                    'label' => 'label.exercicio',
                ),
                'text',
                array(
                    'disabled' => true,
                    'data' => $this->getExercicio()
                )
            )
            ->add(
                'centroCusto',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.autorizacao.centroCusto',
                ),
                'text',
                array(
                    'mapped' => false
                )
            )
            ->add(
                'codDespesa',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codDespesa',
                ),
                'choice',
                array(
                    'choices' => $dotacaoChoices,
                    'placeholder' => 'label.selecione',
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'codAutorizacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoInicial',
                ),
                'text',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
            ->add(
                'codAutorizacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoFinal',
                ),
                'text',
                [
                    'attr' => [
                        'required' => true
                    ]
                ]
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
                'fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.cgmBeneficiario',
                ),
                'sonata_type_model_autocomplete',
                array(
                    'class' => 'CoreBundle:SwCgm',
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
            ->add(
                'codModalidadeCompra',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codModalidadeCompra',
                ),
                'choice',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'choices' => array(
                        '8 - Dispensa de Licitação' => 8,
                        '9 - Inexibilidade' => 9
                    ),
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codCompraDiretaInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCompraDiretaInicial',
                )
            )
            ->add(
                'codCompraDiretaFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCompraDiretaFinal',
                )
            )
            ->add(
                'codModalidadeLicitacao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codModalidadeLicitacao',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Compras\Modalidade',
                    'choice_label' => 'descricao',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder("m");
                        $qb->where($qb->expr()->notIn("m.codModalidade", array(4,5,10,11)));
                        return $qb;
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codLicitacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codLicitacaoInicial',
                )
            )
            ->add(
                'codLicitacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codLicitacaoFinal',
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

        $filter['exercicio']['value'] = $this->getExercicio();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $codEmpenhoList = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
            ->filterListaReemitirAutorizacao($filter, $currentUser->getFkSwCgm()->getNumcgm());

        $ids = array();
        foreach ($codEmpenhoList as $codEmpenho) {
            $ids[] = $codEmpenho->cod_autorizacao;
        }

        if (count($codEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codAutorizacao", $ids));
            $queryBuilder->andWhere($queryBuilder->expr()->eq("{$alias}.exercicio", "'" . $this->getExercicio() . "'"));
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
                'getNomEntidade',
                null,
                array(
                    'label' => 'label.preEmpenho.codEntidade',
                )
            )
            ->add(
                'getCodAutorizacaoAndExercicio',
                null,
                array(
                    'label' => 'label.autorizacao.autorizacao',
                )
            )
            ->add(
                'dtAutorizacao',
                'date',
                array(
                    'label' => 'label.autorizacao.dtAutorizacao',
                )
            )
            ->add(
                'getDescricao',
                null,
                array(
                    'label' => 'label.autorizacao.autorizacao',
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'print' => array('template' => 'FinanceiroBundle::Sonata/Empenho/ReemitirAutorizacao/list__action_print.html.twig'),
                )
            ))
        ;
    }
}
