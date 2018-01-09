<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ConsultarEmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_consultar_empenho';
    protected $baseRoutePattern = 'financeiro/empenho/consultar-empenho';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/consultar-empenho.js'
    );
    protected $exibirMensagemFiltro = true;
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'show'));
        $collection->add('get_unidade_num_orgao', 'get-unidade-num-orgao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('relatorio', 'relatorio');
    }
    
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ))
        ;
    }

    public function createQuery($context = 'list')
    {
        $request = $this->getRequest();
        $query = parent::createQuery($context);
        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $dotacaoChoices = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getDotacaoOrcamentaria($this->getExercicio(), true);
        
        $elementoDespesaChoices = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getElementoDespesa($this->getExercicio(), true);
        
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
                    'label' => 'label.consultarEmpenho.exercicio',
                ),
                'text',
                array(
                    'disabled' => true,
                    'data' => $this->getExercicio()
                )
            )
            ->add(
                'numOrgao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.consultarEmpenho.numOrgao',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Orcamento\Orgao',
                    'choice_label' => 'nomOrgao',
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'numUnidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.consultarEmpenho.numUnidade',
                ),
                'choice',
                array(
                    'choices' => array(),
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'placeholder' => 'label.selecione',
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
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'elementoDespesa',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.consultarEmpenho.elementoDespesa',
                ),
                'choice',
                array(
                    'choices' => $elementoDespesaChoices,
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'placeholder' => 'label.selecione',
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
                'codAutorizacao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.consultarEmpenho.codAutorizacao',
                )
            )
            ->add(
                'fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
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
                'recurso',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.consultarEmpenho.recurso',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Orcamento\Recurso',
                    'choice_label' => 'nomRecurso',
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("r")
                            ->where("r.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codHistorico',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codHistorico',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Empenho\Historico',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("h")
                        ->where("h.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
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
        
        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();
        
        foreach ($atributos as $atributo) {
            $type = "";
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            
            switch ($atributo->cod_tipo) {
                case 1:
                    $datagridMapper->add(
                        $field_name,
                        'doctrine_orm_callback',
                        array(
                            'callback' => array($this, 'getSearchFilter'),
                            'label' => $atributo->nom_atributo,
                        ),
                        'number'
                    );
                    break;
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                    $choices = array();

                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$desc] = $valor_padrao[$key];
                    }
                    
                    $datagridMapper->add(
                        $field_name,
                        'doctrine_orm_callback',
                        array(
                            'callback' => array($this, 'getSearchFilter'),
                            'label' => $atributo->nom_atributo,
                        ),
                        'choice',
                        array(
                            'choices' => $choices,
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            'placeholder' => 'label.selecione'
                        )
                    );
                    break;
                default:
                    $datagridMapper->add(
                        $field_name,
                        'doctrine_orm_callback',
                        array(
                            'callback' => array($this, 'getSearchFilter'),
                            'label' => $atributo->nom_atributo,
                        )
                    );
                    break;
            }
        }
    }
    
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
        ->filterConsultarEmpenho($filter, $this->getExercicio());

        $ids = array();
        $entidades = array();
        foreach ($codEmpenhoList as $codEmpenho) {
            $ids[] = $codEmpenho->cod_empenho;
            $entidades[] = $codEmpenho->cod_entidade;
        }

        if (count($codEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEntidade", $entidades));
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEmpenho", $ids));
            $queryBuilder->andWhere("{$alias}.exercicio = :exercicio");
            $queryBuilder->setParameter("exercicio", $this->getExercicio());
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
                    'label' => 'label.preEmpenho.codEntidade'
                )
            )
            ->add(
                'empenho',
                null,
                array(
                    'label' => 'label.preEmpenho.numEmpenho'
                )
            )
            ->add(
                'dtEmpenho',
                'date',
                array(
                    'label' => 'label.consultarEmpenho.dtEmpenho',
                    'date_format' => 'dd/mm/yyyy'
                )
            )
            ->add(
                'valor',
                null,
                array(
                    'label' => 'label.consultarEmpenho.valor',
                    'template' => 'FinanceiroBundle:Sonata\Empenho\Empenho\CRUD:valor.html.twig',
                )
            )
        ;
        
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $showMapper
            ->add('codEmpenho')
            ->add('dtEmpenho')
            ->add('dtVencimento')
            ->add('vlSaldoAnterior')
            ->add('hora')
            ->add('restosPagar')
            ->add('codEntidade')
            ->add('exercicio')
            ->add('codPreEmpenho')
        ;
    }
    
    public function getDespesa()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDespesa($this->getSubject()->getFkEmpenhoPreEmpenho());
    }
    
    public function getAtributos()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        $atributosArr = array();
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            $data = $entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
            ->findOneBy(
                array(
                    'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codModulo' => 10,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo,
                ),
                array(
                    'timestamp' => 'DESC'
                )
            );
            
            $valorAtributo = null;
            if ($data) {
                $valorAtributo = $data->getValor();
            }

            $valor = "&nbsp;";
            switch ($atributo->cod_tipo) {
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
            
                    $choices = array();
                    
                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$valor_padrao[$key]] = $desc;
                    }
                    
                    if (! is_null($valorAtributo)) {
                        $valor = $choices[$valorAtributo];
                    } else {
                        $valor = "";
                    }
                    break;
                default:
                    if (! is_null($data)) {
                        $valor = $valorAtributo;
                    } else {
                        $valor = "";
                    }
                    break;
            }
            
            $atributosArr[$field_name] = array(
                'label' => $atributo->nom_atributo,
                'data' => $valor
            );
        }
        
        return $atributosArr;
    }

    public function getItemPreEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $itemPreEmpenhoList = $entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                'fkEmpenhoPreEmpenho' => $this->getSubject()->getFkEmpenhoPreEmpenho()
            )
        );

        return $itemPreEmpenhoList;
    }
    
    public function getEmpenhoAssinatura()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $empenhoAssinaturaList = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->findBy(
            array(
                'codEmpenho' => $this->getSubject()->getCodEmpenho(),
                'codEntidade' => $this->getSubject()->getCodEntidade(),
                'exercicio' => $this->getSubject()->getExercicio(),
            )
        );

        return $empenhoAssinaturaList;
    }
    
    public function getSaldosEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();
        
        $despesa = $this->getDespesa();
        
        $saldosEmpenho = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getSaldosEmpenho(
            $currentUser->getFkSwCgm()->getNumcgm(),
            $this->getSubject()->getExercicio(),
            $this->getSubject()->getCodEntidade(),
            $despesa['orgao'],
            $despesa['unidade'],
            $this->getSubject()->getDtVencimento()->format("d/m/Y"),
            $this->getSubject()->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNumcgm(),
            $despesa['recurso'],
            $this->getSubject()->getCodPreEmpenho(),
            $this->getSubject()->getCodEmpenho()
        );
        
        if (! $saldosEmpenho) {
            $saldosEmpenho = new \stdClass();
            $saldosEmpenho->vl_saldo_anterior = 0;
            $saldosEmpenho->vl_empenhado = 0;
            $saldosEmpenho->vl_empenhado_anulado = 0;
            $saldosEmpenho->vl_liquidado = 0;
            $saldosEmpenho->vl_pago = 0;
        }
        
        return $saldosEmpenho;
    }
    
    public function getDespesaLista($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getDespesa($object->getFkEmpenhoPreEmpenho());
    }
    
    public function getSaldosEmpenhoLista($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();
        
        $despesa = $this->getDespesaLista($object);
        
        $saldosEmpenho = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getSaldosEmpenho(
            $currentUser->getFkSwCgm()->getNumcgm(),
            $object->getExercicio(),
            $object->getCodEntidade(),
            $despesa['orgao'],
            $despesa['unidade'],
            $object->getDtVencimento()->format("d/m/Y"),
            $object->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNumcgm(),
            $despesa['recurso'],
            $object->getCodPreEmpenho(),
            $object->getCodEmpenho()
        );
        
        return $saldosEmpenho;
    }
}
