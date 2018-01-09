<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\ProcessoSuspensao;
use Urbem\CoreBundle\Entity\Arrecadacao\Suspensao;
use Urbem\CoreBundle\Entity\Arrecadacao\SuspensaoTermino;
use Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\SwCgm;

class SuspensaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_suspensao';
    protected $baseRoutePattern = 'tributario/arrecadacao/suspensao';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/suspensao.js'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codLancamento',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.arrecadacaoSuspensao.codLancamento',
                )
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.cgm',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'autocomplete',
                array(
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    )
                )
            )
            ->add(
                'grupoCredito',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.arrecadacaoSuspensao.grupoCredito',
                ),
                'entity',
                array(
                    'class' => GrupoCredito::class,
                    'choice_value' => function ($grupoCredito) {
                        if ($grupoCredito) {
                            return sprintf('%d/%s', $grupoCredito->getCodGrupo(), $grupoCredito->getAnoExercicio());
                        }
                    },
                    'choice_label' => function ($grupoCredito) {
                        return sprintf('%d/%s - %s', $grupoCredito->getCodGrupo(), $grupoCredito->getAnoExercicio(), $grupoCredito->getDescricao());
                    },
                )
            )
            ->add(
                'credito',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' =>'label.arrecadacaoSuspensao.credito',
                ),
                'entity',
                array(
                    'class' => Credito::class,
                    'choice_value' => function ($credito) {
                        if ($credito) {
                            return sprintf('%d.%d.%d.%d', $credito->getCodCredito(), $credito->getCodEspecie(), $credito->getCodGenero(), $credito->getCodNatureza());
                        }
                    },
                )
            );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codLancamentoList = (new \Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel($entityManager))
            ->filterLancamento($filter);

        $ids = array();

        foreach ($codLancamentoList as $codLancamento) {
            $ids[] = $codLancamento->cod_lancamento;
        }

        if (count($codLancamentoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codLancamento", $ids));
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    /**
     * @param $lancamento
     * @return string
     */
    public function getProprietario($lancamento)
    {
        if (is_null($lancamento)) {
            return '';
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $proprietario = (new \Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel($entityManager))
            ->getProprietario($lancamento);

        $proprietario = array_shift($proprietario);

        if (count($proprietario)) {
            return $proprietario->proprietario;
        }
        return '';
    }

    /**
     * @param $lancamento
     * @return string
     */
    public function getOrigemCobranca($lancamento)
    {
        if (is_null($lancamento)) {
            return '';
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $origemCobranca = (new \Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel($entityManager))
            ->getDadosLancamento($lancamento);

        $origemCobranca = array_shift($origemCobranca);

        if (count($origemCobranca)) {
            return $origemCobranca->origemcobranca;
        }
        return '';
    }

    /**
     * @param $lancamento
     * @return string
     */
    public function getDadosComplementares($lancamento)
    {
        if (is_null($lancamento)) {
            return '';
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $dadosComplementares = (new \Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel($entityManager))
            ->getDadosLancamento($lancamento);

        $dadosComplementares = array_shift($dadosComplementares);

        if (count($dadosComplementares)) {
            return $dadosComplementares->dados_complementares;
        }
        return '';
    }

    /**
     * @param $lancamento
     * @return string
     */
    public function getInscricao($lancamento)
    {
        if (is_null($lancamento)) {
            return '';
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $inscricao = (new \Urbem\CoreBundle\Model\Arrecadacao\SuspensaoModel($entityManager))
            ->getDadosLancamento($lancamento);

        $inscricao = array_shift($inscricao);

        if (count($inscricao)) {
            return $inscricao->inscricao;
        }
        return '';
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLancamento', null, array('label' => 'label.arrecadacaoSuspensao.codLancamento'))
            ->add(
                'nomCgm',
                'customField',
                array(
                    'label' => 'label.arrecadacaoSuspensao.proprietario',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Suspensao:proprietario.html.twig',
                )
            )
            ->add(
                'origemCobranca',
                'customField',
                array(
                    'label' => 'label.arrecadacaoSuspensao.origemCobranca',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Suspensao:origemCobranca.html.twig',
                )
            )
            ->add(
                'inscricao',
                'customField',
                array(
                    'label' => 'label.arrecadacaoSuspensao.inscricao',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Suspensao:inscricao.html.twig',
                )
            )
            ->add(
                'dadosComplementares',
                'customField',
                array(
                    'label' => 'label.arrecadacaoSuspensao.dadosComplementares',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Arrecadacao\Suspensao:dadosComplementares.html.twig',
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata\Arrecadacao\Suspensao\CRUD:list__action_baixar.html.twig'),
                ),
                'header_style' => 'width: 20%'
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['fkArrecadacaoTipoSuspensao'] = array(
            'class' => TipoSuspensao::class,
            'choice_label' => function (TipoSuspensao $tipoSuspensao) {
                return sprintf('%d - %s', $tipoSuspensao->getCodTipoSuspensao(), $tipoSuspensao->getDescricao());
            },
            'mapped' => false,
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-tipo-suspensao'
            ),
            'label' => 'label.arrecadacaoSuspensao.codTipoSuspensao',
        );

        $fieldOptions['inicio'] = array(
            'pk_class' => DatePK::class,
            'mapped' => false,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.arrecadacaoSuspensao.inicio',
        );

        $fieldOptions['termino'] = array(
            'pk_class' => DatePK::class,
            'mapped' => false,
            'required' => false,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.arrecadacaoSuspensao.termino',
        );

        $fieldOptions['observacoes'] = array(
            'required' => true,
            'mapped' => false,
            'label' => 'label.arrecadacaoSuspensao.observacoes',
        );


        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioLote.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwAssunto'] = array(
            'label' => 'label.imobiliarioLote.assunto',
            'class' => SwAssunto::class,
            'choice_value' => 'codAssunto',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwProcesso'] = array(
            'label' => 'label.imobiliarioLote.processo',
            'class' => SwProcesso::class,
            'req_params' => array(
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $proprietario = $this->getProprietario($this->getSubject());
        $grupoCrediro = $this->getOrigemCobranca($this->getSubject());
        $fieldOptions['dadosLancamento'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/Suspensao/dadosLancamento.html.twig',
            'data' => array(
                'dados' =>
                    array(
                        'proprietario' => $proprietario,
                        'grupoCredito' => $grupoCrediro
                    )
            )
        );

        $formMapper
            ->with('label.arrecadacaoSuspensao.dadosSuspensao')
            ->add('dadosLancamento', 'customField', $fieldOptions['dadosLancamento'])
            ->add('fkArrecadacaoTipoSuspensao', 'entity', $fieldOptions['fkArrecadacaoTipoSuspensao'])
            ->add('inicio', 'datepkpicker', $fieldOptions['inicio'])
            ->add('termino', 'datepkpicker', $fieldOptions['termino'])
            ->add('observacoes', 'textarea', $fieldOptions['observacoes'])
            ->end()
            ->with('label.imobiliarioLote.processo')
            ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
            ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
            ->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.arrecadacaoSuspensao.dados')
            ->add('codSuspensao', null, array('label' => 'label.arrecadacaoSuspensao.codSuspensao'))
            ->add('codLancamento', null, array('label' => 'label.arrecadacaoSuspensao.codLancamento'))
            ->add('fkArrecadacaoTipoSuspensao.descricao', null, array('label' => 'label.arrecadacaoSuspensao.codTipoSuspensao'))
            ->add('inicio', null, array('label' => 'label.arrecadacaoSuspensao.inicio'))
            ->add('observacoes', null, array('label' => 'label.arrecadacaoSuspensao.observacoes'));
    }

    /**
     * @param mixed $suspensao
     * @throws \Exception
     */
    public function preUpdate($lancamento)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em = $this->modelManager->getEntityManager(Suspensao::class);

            $suspensaoModel = new SuspensaoModel($em);
            $suspensao = new Suspensao;
            $codSuspensao = $suspensaoModel->getNextVal($lancamento->getCodLancamento());

            $suspensao->setCodSuspensao($codSuspensao);
            $suspensao->setCodLancamento($lancamento->getCodLancamento());
            $suspensao->setCodTipoSuspensao($this->getForm()->get('fkArrecadacaoTipoSuspensao')->getData()->getCodTipoSuspensao());
            $suspensao->setInicio($this->getForm()->get('inicio')->getData());
            $suspensao->setObservacoes($this->getForm()->get('observacoes')->getData());

            $suspensao->setFkArrecadacaoTipoSuspensao($this->getForm()->get('fkArrecadacaoTipoSuspensao')->getData());
            $suspensao->setFkArrecadacaoLancamento($lancamento);

            if ($this->getForm()->get('termino')->getData()) {
                $suspensaoTermino = new SuspensaoTermino();
                $suspensaoTermino->setTermino($this->getForm()->get('termino')->getData());
                $suspensaoTermino->setCodLancamento($this->getForm()->get('termino')->getData());
                $suspensaoTermino->setObservacoes($suspensao->getObservacoes());

                $suspensao->addFkArrecadacaoSuspensaoTerminos($suspensaoTermino);
            }

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $processoSuspensao = new ProcessoSuspensao();
                $processoSuspensao->setFkArrecadacaoSuspensao($suspensao);
                $processoSuspensao->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());

                $suspensao->addFkArrecadacaoProcessoSuspensoes($processoSuspensao);
            }
            $em->persist($suspensao);
            $em->flush();

            $this->forceRedirect("/tributario/arrecadacao/suspensao/list");
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoSuspensao.msgSuspensao'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Suspensao
            ? $object->getObservacoes()
            : $this->getTranslator()->trans('label.suspensao.modulo');
    }
}
