<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\Tesouraria\Boletim;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal;
use Urbem\CoreBundle\Model\Tesouraria\OrcamentariaPagamentosModel;
use Urbem\CoreBundle\Model\Tesouraria\TransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArrecadacaoExtraEstornosAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_arrecadacao_extra_estornos';
    protected $baseRoutePattern = 'financeiro/tesouraria/arrecadacao/extra-estornos';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/arrecadacao/arrecadacaoExtraEstornos.js');
    protected $exibirMensagemFiltro = false;
    protected $exibirBotaoIncluir = false;

    const COD_TIPO_TRANSFERENCIA = 2;
    const TIPO_LOTE = 'T';
    const COD_HISTORICO = 1;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('ler_codigo_de_barras', 'ler-codigo-de-barras');
        $collection->clearExcept(array('list', 'create', 'ler_codigo_de_barras'));
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
            'entidade' => $this->getRequest()->get('entidade'),
        );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        if (!$this->getRequest()->query->get('filter')) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere('1 = 0');
        } else {
            $this->exibirMensagemFiltro = false;
            $filter = $this->getRequest()->query->get('filter');
            $em = $this->modelManager->getEntityManager($this->getClass());
            $repository = $em->getRepository(Transferencia::class);
            $aEstornar = $repository->getArrecadacaoExtraEstornos(
                $this->getExercicio(),
                (int) $filter['fkContabilidadeLote__fkOrcamentoEntidade']['value'],
                self::COD_TIPO_TRANSFERENCIA
            );
            $query->andWhere($query->expr()->in("o.codLote", $aEstornar));
            $query->andWhere('o.tipo = :tipo');
            $query->setParameter('tipo', self::TIPO_LOTE);
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
                'codBarras',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.codBarras',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'text'
            )
            ->add(
                'fkContabilidadeLote.fkOrcamentoEntidade',
                'composite_filter',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.filterEntidade',
                ),
                null,
                array(
                    'class' => Entidade::class,
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) {
                        return $em->createQueryBuilder('o')
                            ->where('o.exercicio = :exercicio')
                            ->setParameter('exercicio', $this->getExercicio())
                            ->orderBy('o.sequencia', 'ASC');
                    },
                    'attr' => array(
                        'required' => true
                    )
                ),
                array(
                    'admin_code' => 'financeiro.admin.entidade'
                )
            )
            ->add(
                'fkTesourariaReciboExtraTransferencias.codReciboExtra',
                null,
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.nrRecibo'
                )
            )
            ->add(
                'fkTesourariaBoletim.dtBoletim',
                null,
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.dtBoletim'
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy'
                )
            )
            ->add('codBoletim', null, array('label' => 'label.arrecadacaoExtraEstornos.nrBoletim'))
            ->add(
                'fkTesourariaTransferenciaCredor.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.credor'
                ),
                'sonata_type_model_autocomplete',
                array(
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $cgm, $property) {
                        return (string) $cgm;
                    }
                )
            )
            ->add(
                'fkTesourariaTransferenciaRecurso.fkOrcamentoRecurso',
                'composite_filter',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.recurso'
                ),
                null,
                array(
                    'class' => Recurso::class,
                    'query_builder' => function ($em) {
                        return $em->createQueryBuilder('o')
                            ->where('o.exercicio = :exercicio')
                            ->setParameter('exercicio', $this->getExercicio())
                            ->orderBy('o.codRecurso', 'ASC');
                    }
                )
            )
            ->add(
                'codPlanoCredito',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.contaReceita',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'urbem_financeiro_contabilidade_lote_autocomplete_plano_analitica'
                    ),
                    'req_params' => array(
                        'exercicio' => $this->getExercicio()
                    )
                )
            )
            ->add(
                'codPlanoDebito',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.contaCaixaBanco',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'urbem_financeiro_contabilidade_lote_autocomplete_plano_analitica'
                    ),
                    'req_params' => array(
                        'exercicio' => $this->getExercicio()
                    )
                )
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
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $usuarioTerminal = $em->getRepository(UsuarioTerminal::class)
            ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/arrecadacao/permissao');
        }

        $listMapper
            ->add(
                'recibo',
                'text',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.recibo',
                    'admin_code' => 'financeiro.admin.recibo_extra'
                )
            )
            ->add('boletim', 'text', array('label' => 'label.arrecadacaoExtraEstornos.boletim'))
            ->add('fkTesourariaBoletim.dtBoletim', null, array('label' => 'label.arrecadacaoExtraEstornos.data'))
            ->add(
                'fkContabilidadeLote',
                'text',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.lote',
                    'admin_code' => 'financeiro.admin.lote'
                )
            )
            ->add(
                'fkContabilidadePlanoAnalitica',
                'text',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.contaReceita',
                    'admin_code' => 'core.admin.plano_analitica'
                )
            )
            ->add(
                'fkContabilidadePlanoAnalitica1',
                'text',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.contaCaixaBanco',
                    'admin_code' => 'core.admin.plano_analitica'
                )
            )
            ->add(
                'recurso',
                'text',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.recurso'
                )
            )
            ->add(
                'valor',
                'currency',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.vlArrecadado',
                    'currency' => 'BRL'
                )
            )
            ->add(
                'valorEstornado',
                'currency',
                array(
                    'label' => 'label.arrecadacaoExtraEstornos.vlEstornado',
                    'currency' => 'BRL'
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'estornar' => array('template' => 'FinanceiroBundle:Sonata/Tesouraria/Arrecadacao/ExtraEstorno/CRUD:list__action_estornar.html.twig')
                )
            ))
        ;
    }

    /**
     * @return Transferencia
     */
    public function getTransferencia()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        list($codLote, $exercicio, $codEntidade, $tipo) = explode('~', $this->getPersistentParameter('params'));
        $transferencia = $em->getRepository(Transferencia::class)
            ->findOneBy(
                array(
                    'codLote' => $codLote,
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'tipo' => $tipo
                )
            );
        return $transferencia;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $usuarioTerminal = $em->getRepository(UsuarioTerminal::class)
            ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/arrecadacao/permissao');
        }

        $transferencia = $this->getTransferencia();

        $fieldOptions = array();

        $fieldOptions['recibo'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.recibo',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => $transferencia->getRecibo()
        );

        $fieldOptions['codBoletim'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.nrBoletim',
            'mapped' => false,
            'disabled' => true,
            'data' => $transferencia->getCodBoletim()
        );

        $fieldOptions['dtBoletim'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.dtBoletim',
            'mapped' => false,
            'disabled' => true,
            'format' => 'dd/MM/yyyy',
            'data' => $transferencia->getFkTesourariaBoletim()->getDtBoletim()
        );

        $boletins = (new OrcamentariaPagamentosModel($em))->listaBoletins($transferencia->getExercicio(), $transferencia->getCodEntidade());

        $fieldOptions['boletimEstorno'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.boletimEstorno',
            'class' => Boletim::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($transferencia, $boletins) {
                $qb = $em->createQueryBuilder('o');
                if (count($boletins)) {
                    $qb->where('o.exercicio = :exercicio');
                    $qb->andWhere('o.codEntidade = :codEntidade');
                    $qb->andWhere('o.codBoletim IN (:codBoletim)');
                    $qb->setParameter('exercicio', $transferencia->getExercicio());
                    $qb->setParameter('codEntidade', $transferencia->getCodEntidade());
                    $qb->setParameter('codBoletim', $boletins);
                } else {
                    $qb->where('1 = 0');
                }
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters',
            )
        );

        $fieldOptions['entidade'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.entidade',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => $transferencia->getFkContabilidadeLote()->getFkOrcamentoEntidade()
        );

        $fieldOptions['credor'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.credor',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => ($transferencia->getFkTesourariaTransferenciaCredor()) ? $transferencia->getFkTesourariaTransferenciaCredor()->getFkSwCgm() : null
        );

        $fieldOptions['recurso'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.recurso',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => $transferencia->getRecurso()
        );

        $fieldOptions['contaReceita'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.contaReceita',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => $transferencia->getFkContabilidadePlanoAnalitica()
        );

        $fieldOptions['contaCaixaBanco'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.contaCaixaBanco',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'data' => $transferencia->getFkContabilidadePlanoAnalitica1()
        );

        $fieldOptions['historicoPadrao'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.historicoPadrao',
            'class' => HistoricoContabil::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($transferencia) {
                return $em->createQueryBuilder('o')
                    ->where('o.exercicio = :exercicio')
                    ->andWhere('o.codHistorico != :codHistorico')
                    ->setParameters(
                        array(
                            'exercicio' => $transferencia->getExercicio(),
                            'codHistorico' => self::COD_HISTORICO
                        )
                    )
                    ->orderBy('o.codHistorico', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters',
            )
        );

        $fieldOptions['valorArrecadado'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.vlArrecadado',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
            'data' => $transferencia->getValor()
        );

        $fieldOptions['valorEstornado'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.vlEstornado',
            'mapped' => false,
            'required' => false,
            'disabled' => true,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
            'data' => $transferencia->getValorEstornado()
        );

        $fieldOptions['valor'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.valor',
            'mapped' => false,
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
            'data' => $transferencia->getValor() - $transferencia->getValorEstornado()
        );

        $fieldOptions['observacao'] = array(
            'label' => 'label.arrecadacaoExtraEstornos.observacao',
            'mapped' => false,
            'required' => false
        );

        $formMapper->with('label.arrecadacaoExtraEstornos.dados');
        $formMapper->add('recibo', 'text', $fieldOptions['recibo']);
        $formMapper->add('codBoletim', 'text', $fieldOptions['codBoletim']);
        $formMapper->add('dtBoletim', 'sonata_type_date_picker', $fieldOptions['dtBoletim']);
        $formMapper->add('boletimEstorno', 'entity', $fieldOptions['boletimEstorno']);
        $formMapper->add('entidade', 'text', $fieldOptions['entidade']);
        $formMapper->add('credor', 'text', $fieldOptions['credor']);
        $formMapper->add('recurso', 'text', $fieldOptions['recurso']);
        $formMapper->add('contaReceita', 'text', $fieldOptions['contaReceita']);
        $formMapper->add('contaCaixaBanco', 'text', $fieldOptions['contaCaixaBanco']);
        $formMapper->add('historicoPadrao', 'entity', $fieldOptions['historicoPadrao']);
        $formMapper->add('valorArrecadado', 'money', $fieldOptions['valorArrecadado']);
        $formMapper->add('valorEstornado', 'money', $fieldOptions['valorEstornado']);
        $formMapper->add('valor', 'money', $fieldOptions['valor']);
        $formMapper->add('observacao', 'textarea', $fieldOptions['observacao']);
        $formMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $transferencia = $this->getTransferencia();
        $valorAEstornar = $transferencia->getValor() - $transferencia->getValorEstornado();

        if ($this->getForm()->get('valor')->getData() > $valorAEstornar) {
            $mensagem = $this->getTranslator()->trans('label.arrecadacaoExtraEstornos.erroValorAEstornar');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }

        if ($this->getForm()->get('valor')->getData() <= 0.00) {
            $mensagem = $this->getTranslator()->trans('label.arrecadacaoExtraEstornos.erroValorMenor');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $transferencia = $this->getTransferencia();

        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        $retorno = (new TransferenciaModel($em))
            ->realizarArrecadacaoExtraEstorno(
                $transferencia,
                $this->getForm(),
                $currentUser,
                $this->getTranslator()
            );

        if (is_object($retorno)) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoExtraEstornos.msgSucesso', array('%codLote%' => $retorno->getFkContabilidadeLote()->getCodLote(), '%exercicio%' => $retorno->getFkContabilidadeLote()->getExercicio())));
            $this->forceRedirect($this->generateUrl('list'));
        } else {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $retorno);
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodLote())
            ? (string) $object
            : $this->getTranslator()->trans('label.arrecadacaoExtraEstornos.modulo');
    }
}
