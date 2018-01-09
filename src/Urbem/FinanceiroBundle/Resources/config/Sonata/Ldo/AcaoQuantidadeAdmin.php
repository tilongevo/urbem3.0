<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ldo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AcaoQuantidadeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_ldo_validacao_acoes';
    protected $baseRoutePattern = 'financeiro/ldo/validacao-acoes';
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $includeJs = array(
        '/financeiro/javascripts/ldo/validacao-acoes.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("show");
        $collection->add('get_exercicio_ldo', 'get-exercicio-ldo', array(), array(), array(), '', array(), array('POST'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'inCodPPATxt',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.validacaoAcoes.inCodPPATxt'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'placeholder' => 'label.selecione'
                )
            )
            ->add(
                'slExercicioLDO',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.validacaoAcoes.slExercicioLDO'
                ),
                'choice',
                array(
                    'choices' => array(
                        'label.selecione' => ''
                    )
                )
            )
            ->add(
                'inCodPrograma',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.validacaoAcoes.inCodPrograma'
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Ppa\ProgramaDados',
                    'choice_label' => function ($programaDados) {
                        if (!empty($programaDados)) {
                            return $programaDados->getIdentificacao();
                        }
                    },
                    'choice_value' => function ($programaDados) {
                        if (!empty($programaDados)) {
                            return $programaDados->getCodPrograma();
                        }
                    }

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

        $queryBuilder->innerJoin("CoreBundle:Ppa\AcaoDados", "ad", "WITH", "ad.codAcao = {$alias}.codAcao");
        $queryBuilder->innerJoin("CoreBundle:Ppa\Acao", "a", "WITH", "a.codAcao = ad.codAcao");
        $queryBuilder->innerJoin("CoreBundle:Ppa\Programa", "p", "WITH", "p.codPrograma = a.codPrograma");

        if ($filter['inCodPPATxt']['value'] != '') {
            $queryBuilder->innerJoin("CoreBundle:Ppa\ProgramaSetorial", "ps", "WITH", "ps.codSetorial = p.codSetorial");
            $queryBuilder->innerJoin("CoreBundle:Ppa\MacroObjetivo", "m", "WITH", "m.codMacro = ps.codMacro");
            $queryBuilder->innerJoin("CoreBundle:Ppa\Ppa", "ppa", "WITH", "ppa.codPpa = m.codPpa");
            $queryBuilder->andWhere("ppa.codPpa = :codPpa");
            $queryBuilder->setParameter("codPpa", $filter['inCodPPATxt']['value']);
        }

        if ($filter['slExercicioLDO']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.ano = :ano");
            $queryBuilder->setParameter("ano", $filter['slExercicioLDO']['value']);
        }
        if ($filter['inCodPrograma']['value'] != '') {
            $queryBuilder->andWhere("p.codPrograma = :codPrograma");
            $queryBuilder->setParameter("codPrograma", $filter['inCodPrograma']['value']);
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
                'codAcao.codAcao',
                null,
                array(
                    'label' => 'label.validacaoAcoes.codAcao'
                )
            )
            ->add(
                'exercicioRecurso',
                null,
                array(
                    'label' => 'label.exercicio'
                )
            )
            ->add(
                'fkPpaAcaoRecurso.fkOrcamentoRecurso.nomRecurso',
                null,
                array(
                    'label' => 'label.nome'
                )
            )
            ->add(
                'quantidade',
                'decimal',
                array(
                    'label' => 'label.validacaoAcoes.quantidade'
                )
            )
            ->add(
                'valor',
                'currency',
                array(
                    'label' => 'label.validacaoAcoes.valor',
                    'currency' => 'BRL',
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

        $formOptions['codRecurso'] = array(
            'label' => 'label.validacaoAcoes.codRecurso',
            'data' => $this->getSubject()
            ->getFkPpaAcaoRecurso()
            ->getFkOrcamentoRecurso()
            ->getNomRecurso(),
            'disabled' => true,
        );

        $formOptions['quantidade'] = array(
            'label' => 'label.validacaoAcoes.quantidade',
            'attr' => array(
                'class' => 'money '
            )
        );

        $formOptions['valor'] = array(
            'label' => 'label.validacaoAcoes.valor',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            )
        );

        $formOptions['metaDisponivel'] = array(
            'label' => 'label.validacaoAcoes.metaDisponivel',
            'data' => $this->getSubject()->getValor(),
            'disabled' => true,
            'mapped' => false,
            'attr' => array(
                'class' => 'money '
            )
        );

        $params = array(
            "%codAcao%" => $this->getSubject()->getFkPpaAcaoRecurso()->getCodAcao(),
            "%titulo%" => $this->getSubject()->getFkPpaAcaoRecurso()->getFkPpaAcaoDados()->getTitulo()
        );

        $formMapper
            ->with($this->getTranslator()->trans('label.validacaoAcoes.dadosAcao', $params))
                ->add(
                    'codRecurso',
                    'text',
                    $formOptions['codRecurso']
                )
                ->add(
                    'quantidade',
                    'number',
                    $formOptions['quantidade']
                )
                ->add(
                    'valor',
                    'money',
                    $formOptions['valor']
                )
                ->add(
                    'metaDisponivel',
                    'number',
                    $formOptions['metaDisponivel']
                )
            ->end();
        ;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $acaoValidada = $entityManager->getRepository('CoreBundle:Ldo\AcaoValidada')
        ->findOneBy(
            array(
                'codAcao' => $object->getFkPpaAcaoRecurso()->getCodAcao(),
                'ano' => $object->getAno(),
                'timestampAcaoDados' => $object->getFkPpaAcaoRecurso()->getTimestampAcaoDados(),
                'codRecurso' => $object->getFkPpaAcaoRecurso()->getCodRecurso(),
                'exercicioRecurso' => $object->getExercicioRecurso()
            )
        );

        if (! $acaoValidada) {
            $acaoValidada = new \Urbem\CoreBundle\Entity\Ldo\AcaoValidada();
        }

        $acaoValidada->setFkPpaAcaoQuantidade($object);
        $acaoValidada->setValor($this->getForm()->get('valor')->getData());
        $acaoValidada->setQuantidade($this->getForm()->get('quantidade')->getData());
        $entityManager->persist($acaoValidada);
        $entityManager->flush();

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add("success", $this->getContainer()->get('translator')->transChoice('label.ldo.acaoQuantidade.validacoes.acao', 0, ['varAcao' => $object->getFkPpaAcaoRecurso()->getCodAcao()], 'messages'));
        $this->forceRedirect('/financeiro/ldo/validacao-acoes/list');
    }

    public function preRemove($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $acaoValidada = $entityManager->getRepository('CoreBundle:Ldo\AcaoValidada')
        ->findOneBy(
            array(
                'codAcao' => $object->getCodAcao()->getCodAcao()->getCodAcao(),
                'ano' => $object->getAno(),
                'timestampAcaoDados' => $object->getCodAcao()->getTimestampAcaoDados()->format("Y-m-d H:i:s"),
                'codRecurso' => $object->getCodRecurso()->getCodRecurso(),
                'exercicioRecurso' => $object->getExercicioRecurso()
            )
        );

        $container = $this->getConfigurationPool()->getContainer();

        if ($acaoValidada) {
            $entityManager->remove($acaoValidada);
            $entityManager->flush();

            $codAcao = str_pad($object->getCodAcao()->getCodAcao()->getCodAcao(), 4, "0", STR_PAD_LEFT);
            $codRecurso = str_pad($object->getCodRecurso()->getCodRecurso(), 4, "0", STR_PAD_LEFT);
            $container->get('session')->getFlashBag()->add("success", $this->getContainer()->get('translator')->transChoice('label.ldo.acaoQuantidade.validacoes.sucessoExcluirValidacaoAcao', 0, ['codAcao' => $codAcao, 'codRecurso' => $codRecurso], 'messages'));
            $this->forceRedirect('/financeiro/ldo/validacao-acoes/list');
        } else {
            $container->get('session')->getFlashBag()->add("error", $this->getContainer()->get('translator')->transChoice('label.ldo.acaoQuantidade.validacoes.erroRemoverAcaoInvalida', 0, [], 'messages'));
            $this->forceRedirect('/financeiro/ldo/validacao-acoes/' . $object->getCodAcao()->getCodAcao()->getCodAcao() . '/edit');
        }
    }
}
