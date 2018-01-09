<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AnularEmpenhoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_anular_empenho';
    protected $baseRoutePattern = 'financeiro/empenho/anular-empenho';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $customHeader = 'FinanceiroBundle:Sonata\Empenho\AnularEmpenho\CRUD:header.html.twig';
    protected $exibirMensagemFiltro = true;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('edit', 'list'));
        $collection->add('reemitir_anulacao_empenho', 'reemitir-anulacao-empenho');
    }
    
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Empenho/CRUD:list_action_anularEmpenho.html.twig'),
                )
            ))
        ;
    }
    
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
        $this->getDataGrid()->getPager();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $dotacaoChoices = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getDotacaoOrcamentariaKeyCodDespesa($this->getExercicio(), true);

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
                        'class' => 'select2-parameters',
                    ),
                )
            )
            ->add(
                'codEmpenhoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoInicial',
                ),
                null,
                array(
                    'attr' => array(
                        'required' => 'required'
                    ),
                )
            )
            ->add(
                'codEmpenhoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoFinal'
                ),
                null,
                array(
                    'attr' => array(
                        'required' => 'required'
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
                null,
                array(
                    'attr' => array(
                        'required' => true
                    )
                )
            )
            ->add(
                'codAutorizacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codAutorizacaoFinal',
                ),
                null,
                array(
                    'attr' => array(
                        'required' => true
                    )
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
                    'label' => 'label.preEmpenho.periodoInicial'
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false
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
                    'mapped' => false
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
    
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        
        $queryBuilder->resetDQLPart('join');
        
        $filter['exercicio']['value'] = $this->getExercicio();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $currentUser = $container->get('security.token_storage')->getToken()->getUser()->getNumcgm();
        $codEmpenhoList = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->findListaAnularEmpenho($filter, $this->getExercicio(), $currentUser);

        $ids = array();
        foreach ($codEmpenhoList as $codEmpenho) {
            $ids[] = $codEmpenho->cod_empenho;
        }

        if (count($codEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEmpenho", $ids));
            $queryBuilder->andWhere("{$alias}.exercicio = :exercicio");
            $queryBuilder->andWhere("{$alias}.codEntidade = :codEntidade");
            $queryBuilder->setParameter("exercicio", $this->getExercicio());
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
                    'date_format' => 'dd-mm-yyyy',
                    'label' => 'label.consultarEmpenho.dtEmpenho'
                )
            )
            ->add(
                'fkEmpenhoPreEmpenho.fkSwCgm.nomCgm',
                null,
                array(
                    'label' => 'label.preEmpenho.cgmBeneficiario',
                )
            )
        ;
        
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $formOptions = array();
        
        $formOptions['timestamp'] = array(
            'label' => 'label.anularEmpenho.timestamp',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );
        
        $formOptions['motivo'] = array(
            'label' => 'label.anularEmpenho.motivo',
            'mapped' => false,
        );
        
        $formMapper
            ->with('label.anularEmpenho.anulacao')
                ->add(
                    'timestamp',
                    'sonata_type_date_picker',
                    $formOptions['timestamp']
                )
                ->add(
                    'motivo',
                    'textarea',
                    $formOptions['motivo']
                )
            ->end()
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
            $currentUser->getNumcgm()->getNumcgm(),
            $object->getExercicio(),
            $object->getCodEntidade(),
            $despesa['orgao'],
            $despesa['unidade'],
            $object->getDtVencimento()->format("d/m/Y"),
            $object->getFkEmpenhoPreEmpenho()->getCgmBeneficiario()->getNumcgm(),
            $despesa['recurso'],
            $object->getCodPreEmpenho(),
            $object->getCodEmpenho()
        );
        
        return $saldosEmpenho;
    }
    
    public function verificaEmpenhoAnulado($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $empenhoAnulado = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAnulado")
        ->findOneBy(
            array(
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $object->getCodEntidade(),
                'codEmpenho' => $object->getCodEmpenho()
            )
        );
        
        if ($empenhoAnulado) {
            return false;
        }
        return true;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if (empty($this->getSaldosEmpenho())) {
            $errorElement->addViolation($this->getContainer()->get('translator')->transChoice('label.anularEmpenho.saldoNulo', 0, [], 'messages'))->end();
            $this->getRequest()->getSession()->getFlashBag()->add("error", $this->getContainer()->get('translator')->transChoice('label.anularEmpenho.saldoNulo', 0, [], 'messages'));
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        $anularEmpenho = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->anularEmpenho($object, $this->getForm(), $this->getSaldosEmpenho());
        $empenho = $object->getCodEmpenho() . "/" . $object->getExercicio();
        if (!$anularEmpenho) {
            $compositeKey = $object->getCodEmpenho()
                . "~" . $object->getExercicio()
                . "~" . $object->getCodEntidade();

            $container->get('session')->getFlashBag()->add('error', "Falha ao anular o empenho! ({$empenho})");
            $this->redirectToUrl("/financeiro/empenho/anular-empenho/" . $compositeKey . "/edit");
        } else {
            $this->redirectToUrl("/financeiro/empenho/anular-empenho/list");
        }
    }
}
