<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Diarias\TipoDiariaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmitirEmpenhoAutorizacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_emitir_empenho_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/emitir-empenho-autorizacao';
    protected $includeJs = array('/financeiro/javascripts/empenho/pre-empenho.js');
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $customHeader = 'FinanceiroBundle:Sonata\Empenho\EmitirEmpenhoAutorizacao\CRUD:header.html.twig';
    protected $exibirMensagemFiltro = true;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit'));
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        } else {
            $query->andWhere(
                $query->expr()->eq($query->getRootAliases()[0] . '.exercicio', ':exercicio')
            );
            $query->setParameter("exercicio", $this->getExercicio());
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
                'codCentroCusto',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codCentroCusto',
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
                    'choices' => array(),
                    'placeholder' => 'label.selecione',
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

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();
        $codAutorizacaoList = (new TipoDiariaModel($entityManager))
            ->filterAutorizacaoEmpenho($currentUser->getFkSwCgm()->getNumcgm(), $this->getExercicio(), $filter);

        $ids = array();
        foreach ($codAutorizacaoList as $codAutorizacao) {
            $ids[] = $codAutorizacao->cod_pre_empenho;
        }
        
        if (count($codAutorizacaoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codPreEmpenho", $ids));
        }

        return true;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'header_style' => 'width: 5%; text-align: center',
                'actions' => array(
                    'incluir' => array('template' => 'FinanceiroBundle:Sonata/Empenho/EmitirEmpenhoAutorizacao/CRUD:list__action_incluir.html.twig'),

                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codEntidade',
                null,
                array(
                    'label' => 'label.preEmpenho.codEntidade',
                )
            )
            ->add(
                'autorizacao',
                null,
                array(
                    'label' => 'label.preEmpenho.autorizacao',
                )
            )
            ->add(
                'dtAutorizacao',
                null,
                array(
                    'label' => 'label.preEmpenho.dtAutorizacao',
                )
            )
            ->add(
                'fkSwCgm',
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

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formOptions = array();

        $formOptions['descricao'] = array(
            'label' => 'label.emitirEmpenhoAutorizacao.descricao',
        );

        $formOptions['dtEmpenho'] = array(
            'label' => 'label.emitirEmpenhoAutorizacao.dtEmpenho',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        $formOptions['dtVencimento'] = array(
            'label' => 'label.emitirEmpenhoAutorizacao.dtVencimento',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        );

        $formOptions['fkEmpenhoTipoEmpenho'] = array(
            'label' => 'label.emitirEmpenhoAutorizacao.codTipo',
            'class' => 'CoreBundle:Empenho\TipoEmpenho',
            'choice_label' => 'nomTipo',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione'
        );

        if ($this->id($this->getSubject())) {
            if (!empty($this->getSubject()->getFkEmpenhoEmpenho())) {
                $formOptions['dtEmpenho']['data'] = $this->getSubject()->getFkEmpenhoEmpenho()->getDtEmpenho();
            }
            $formOptions['dtVencimento']['data'] = new DateTimeMicrosecondPK('Dec 31');
        }

        $formMapper
            ->with('label.emitirEmpenhoAutorizacao.dadosEmpenho')
                ->add(
                    'descricao',
                    null,
                    $formOptions['descricao']
                )
                ->add(
                    'dtEmpenho',
                    'sonata_type_date_picker',
                    $formOptions['dtEmpenho']
                )
                ->add(
                    'dtVencimento',
                    'sonata_type_date_picker',
                    $formOptions['dtVencimento']
                )
                ->add(
                    'fkEmpenhoTipoEmpenho',
                    'entity',
                    $formOptions['fkEmpenhoTipoEmpenho']
                )
            ->end()
        ;

        $formMapper->with('label.preEmpenho.atributos');

        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        if (!empty($atributos)) {
            foreach ($atributos as $atributo) {
                if (in_array($atributo->nom_atributo, array('Modalidade', 'Complementar'))) {
                    continue;
                }
                $type = "";
                $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
                switch ($atributo->cod_tipo) {
                    case 1:
                        $type = "number";
                        $formOptions[$field_name] = array(
                            'label' => $atributo->nom_atributo,
                            'required' => !$atributo->nao_nulo,
                            'mapped' => false,
                        );
                        break;
                    case 3:
                        $type = "choice";

                        $valor_padrao = explode(",", $atributo->valor_padrao);
                        $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                        $choices = array();

                        foreach ($valor_padrao_desc as $key => $desc) {
                            $choices[$desc] = $valor_padrao[$key];
                        }

                        $formOptions[$field_name] = array(
                            'label' => $atributo->nom_atributo,
                            'choices' => $choices,
                            'required' => !$atributo->nao_nulo,
                            'mapped' => false,
                            'attr' => array(
                                'class' => 'select2-parameters'
                            ),
                            'placeholder' => 'label.selecione'
                        );
                        break;
                    default:
                        $type = "text";
                        $formOptions[$field_name] = array(
                            'label' => $atributo->nom_atributo,
                            'required' => !$atributo->nao_nulo,
                            'mapped' => false,
                        );
                        break;
                }

                if ($this->id($this->getSubject())) {
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

                    if ($data) {
                        $formOptions[$field_name]['data'] = $data->getValor();
                    }
                }

                $formMapper->add(
                    $field_name,
                    $type,
                    $formOptions[$field_name]
                );
            }
        }
        $formMapper->end();
    }

    public function getPreEmpenhoDespesa()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoDespesa = $entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
            ->findOneBy(
                array(
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                )
            );

        return $preEmpenhoDespesa;
    }

    public function getRubricaDespesa()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoDespesa = $entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
            )
        );

        $rubricaDespesa = $entityManager->getRepository('CoreBundle:Orcamento\ContaDespesa')
        ->findOneBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codConta' => $preEmpenhoDespesa->getCodConta()
            )
        );

        return $rubricaDespesa;
    }

    public function getSaldoAnterior()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoDespesa = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->getSaldoAnterior($this->getSubject());

        return (float) $preEmpenhoDespesa->saldo_anterior;
    }

    public function getContaContrapartida()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        if (! $this->getSubject()->getFkEmpenhoAutorizacaoEmpenhos()->last()) {
            return null;
        }
        
        $contaContrapartida = $entityManager->getRepository('CoreBundle:Empenho\ContrapartidaAutorizacao')
        ->findOneBy(
            array(
                'exercicio' => $this->getSubject()->getFkEmpenhoAutorizacaoEmpenhos()->last()->getExercicio(),
                'codEntidade' => $this->getSubject()->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkOrcamentoEntidade()->getCodEntidade(),
                'codAutorizacao' => $this->getSubject()->getFkEmpenhoAutorizacaoEmpenhos()->last()->getCodAutorizacao(),
            )
        );
        
        if ($contaContrapartida) {
            $rubricaDespesa = $entityManager->getRepository('CoreBundle:Empenho\ResponsavelAdiantamento')
            ->findOneBy(
                array(
                    'contaContrapartida' => $contaContrapartida->getContaContrapartida()
                )
            );
                
            $planoAnalitica = $entityManager->getRepository('CoreBundle:Contabilidade\PlanoAnalitica')
            ->findOneBy(
                array(
                    'codPlano' => $contaContrapartida->getContaContrapartida()
                )
            );
                    
            return $contaContrapartida->getContaContrapartida() . " - " . $planoAnalitica->getFkPlanoConta()->getNomConta();
        }
        
        return null;
    }

    public function getAtributos()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            if (! in_array($atributo->nom_atributo, array('Complementar', 'Modalidade'))) {
                continue;
            }
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

            if (!empty($data)) {
                $data = $data->getValor();
            }

            switch ($atributo->cod_tipo) {
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                    $choices = array();
                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$valor_padrao[$key]] = $desc;
                    }
                    $valor = ($data) ? $choices[$data] : null;
                    break;
                default:
                    $valor = $data;
                    break;
            }

            $this->atributos[$field_name] = array(
                'label' => $atributo->nom_atributo,
                'data' => $valor
            );
        }
        return $this->atributos;
    }

    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $empenho = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoModel($entityManager))
        ->save($this->getForm(), $object);
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $configuracao = $entityManager->getRepository("CoreBundle:Administracao\Configuracao")
        ->pegaConfiguracao(
            "utilizar_encerramento_mes",
            9,
            $this->getExercicio()
        );

        if ($configuracao[0]['valor'] != "false") {
            $ultimoMesEncerrado = $entityManager->getRepository("CoreBundle:Contabilidade\EncerramentoMes")
            ->getUltimoMesEncerrado($this->getExercicio());

            $dtAutorizacao = date("m", mktime(0, 0, 0, date("m"), date("d"), $this->getExercicio()));

            if ($ultimoMesEncerrado->mes >= (int) $dtAutorizacao) {
                $error = "Mês do Empenho encerrado!";
                $errorElement->with('descricao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    public function getItemPreEmpenho()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $itemPreEmpenhoList = $entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'exercicio' => $this->getSubject()->getExercicio(),
                'codPreEmpenho' => $this->getSubject()->getCodPreEmpenho(),
                'fkEmpenhoPreEmpenho' => $this->getSubject()
            )
        );

        return $itemPreEmpenhoList;
    }

    public function getVlTotal()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $reservaSaldos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($entityManager))
        ->getReservaSaldoPerfil($this->getSubject());

        return ($reservaSaldos) ? $reservaSaldos->getVlReserva() : 0.00;
    }
}
