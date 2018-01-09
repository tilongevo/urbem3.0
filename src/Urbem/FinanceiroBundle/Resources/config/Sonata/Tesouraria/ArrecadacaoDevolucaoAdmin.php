<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita;
use Urbem\CoreBundle\Entity\Tesouraria\Autenticacao;
use Sonata\AdminBundle\Route\RouteCollection;

class ArrecadacaoDevolucaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_arrecadacao_orcamentaria_devolucao_receita';
    protected $baseRoutePattern = 'financeiro/tesouraria/arrecadacao/orcamentaria-devolucao-receita';
    protected $includeJs = array('/financeiro/javascripts/tesouraria/arrecadacao/arrecadacaoDevolucao.js');
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Confirmar'];
    protected $exibirBotaoExcluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('create');
    }

    public function toString($object)
    {
        if ($object->getCodArrecadacao()) {
            return $object->getCodArrecadacao() . '/' . $object->getExercicio();
        } else {
            return 'Devolução de Receita';
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codArrecadacao')
            ->add('exercicio')
            ->add('timestampArrecadacao')
            ->add('codAutenticacao')
            ->add('dtAutenticacao')
            ->add('codBoletim')
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('cgmUsuario')
            ->add('timestampUsuario')
            ->add('codPlano')
            ->add('codEntidade')
            ->add('observacao')
            ->add('devolucao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codArrecadacao')
            ->add('exercicio')
            ->add('timestampArrecadacao')
            ->add('codAutenticacao')
            ->add('dtAutenticacao')
            ->add('codBoletim')
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('cgmUsuario')
            ->add('timestampUsuario')
            ->add('codPlano')
            ->add('codEntidade')
            ->add('observacao')
            ->add('devolucao')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
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
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm());

        if (!$usuarioTerminal) {
            $this->forceRedirect('/financeiro/tesouraria/arrecadacao/permissao');
        }

        $exercicio = $this->getExercicio();

        $fieldOptions = array();

        $fieldOptions['exercicio'] = [
            'mapped' => false,
            'data' => $exercicio
        ];

        $fieldOptions['codBoletim'] = [
            'mapped' => false
        ];

        $fieldOptions['codEntidade'] = [
            'mapped' => false
        ];

        $fieldOptions['codReceita'] = [
            'mapped' => false
        ];

        $fieldOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.arrecadacao.entidade',
            'choice_label' => function ($entidade) {
                $label = $entidade->getCodEntidade();
                $label .= ' - ' . $entidade->getFkSwCgm()->getNomCgm();
                return  $label;
            },
            'choice_value' => 'codEntidade',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkTesourariaBoletim'] = [
            'label' => 'label.arrecadacao.boletim',
            'choice_label' => function ($boletim) {
                $label = $boletim->getCodBoletim();
                $label .= ' - ' . $boletim->getDtBoletim()->format('d/m/Y');
                return  $label;
            },
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['receita'] = [
            'label' => 'label.arrecadacao.receita',
            'class' => 'CoreBundle:Orcamento\Receita',
            'choice_label' => function ($receita) use ($em) {
                $contaReceita = $em->getRepository('CoreBundle:Orcamento\ContaReceita')
                    ->findOneBy([
                        'codConta' => $receita->getCodConta(),
                        'exercicio' => $receita->getExercicio()
                    ]);
                $label = $receita->getCodReceita();
                if ($contaReceita) {
                    $label .= ' - ' . $contaReceita->getDescricao();
                }
                return $label;
            },
            'choice_value' => 'codReceita',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkContabilidadePlanoAnalitica'] = [
            'label' => 'label.arrecadacao.conta',
            'choice_label' => function ($planoAnalitica) {
                $conta = $planoAnalitica->getFkContabilidadePlanoConta();
                return $planoAnalitica->getCodPlano() . ' - ' . $conta->getNomConta();
            },
            'choice_value' => 'codPlano',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('pc.codEstrutural', "'1.1.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.1.4.%'")
                ));
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.arrecadacao.valor',
            'currency' => 'BRL',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['observacao'] = ['label' => 'label.arrecadacao.observacao'];

        $formMapper->with('label.arrecadacao.dadosDevolucao');
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('codBoletim', 'hidden', $fieldOptions['codBoletim']);
        $formMapper->add('codEntidade', 'hidden', $fieldOptions['codEntidade']);
        $formMapper->add('codReceita', 'hidden', $fieldOptions['codReceita']);
        $formMapper->add('fkOrcamentoEntidade', null, $fieldOptions['fkOrcamentoEntidade'], ['admin_code' => 'financeiro.admin.entidade']);
        $formMapper->add('fkTesourariaBoletim', null, $fieldOptions['fkTesourariaBoletim']);
        $formMapper->add('receita', 'entity', $fieldOptions['receita']);
        $formMapper->add('fkContabilidadePlanoAnalitica', null, $fieldOptions['fkContabilidadePlanoAnalitica'], ['admin_code' => 'core.admin.plano_analitica']);
        $formMapper->add('valor', 'money', $fieldOptions['valor']);
        $formMapper->add('observacao', null, $fieldOptions['observacao']);
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codArrecadacao')
            ->add('exercicio')
            ->add('timestampArrecadacao')
            ->add('codAutenticacao')
            ->add('dtAutenticacao')
            ->add('codBoletim')
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('cgmUsuario')
            ->add('timestampUsuario')
            ->add('codPlano')
            ->add('codEntidade')
            ->add('observacao')
            ->add('devolucao')
        ;
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codEntidade = $this->getForm()->get('codEntidade')->getData();

        $codBoletim = $this->getForm()->get('codBoletim')->getData();
        $boletim = $em->getRepository('CoreBundle:Tesouraria\Boletim')
            ->findOneBy([
                'codBoletim' => $codBoletim,
                'codEntidade' => $codEntidade,
                'exercicio' => $exercicio
            ]);
        $object->setFkTesourariaBoletim($boletim);

        $entidade = $object->getFkTesourariaBoletim()->getFkOrcamentoEntidade();
        $object->setFkOrcamentoEntidade($entidade);

        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $codArrecadacao = $repository->getCodArrecadacao();
        $object->setCodArrecadacao($codArrecadacao);

        $dtBoletim = $object->getFkTesourariaBoletim()->getDtBoletim();
        $codAutenticadao = $repository->getCodAutenticacao($dtBoletim->format('d/m/Y'));
        $tipo = $em->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')->find('A ');

        $dtAutenticacao = new DatePK($dtBoletim->format('Y-m-d'));
        $autenticacao = new Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticadao);
        $autenticacao->setDtAutenticacao($dtAutenticacao);
        $autenticacao->setFkTesourariaTipoAutenticacao($tipo);
        $object->setFkTesourariaAutenticacao($autenticacao);

        $container = $this->getConfigurationPool()->getContainer();

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        /**
         * @todo: Usuário Terminal
         */
        $repository = $em->getRepository('CoreBundle:Tesouraria\UsuarioTerminal');
        $usuarioTerminal = $repository->findOneByCgmUsuario($usuario->getNumcgm(), array('codTerminal' => 'DESC'));
        $object->setFkTesourariaUsuarioTerminal($usuarioTerminal);

        $receita = $this->getForm()->get('receita')->getData();
        $vlArrecadacao = $this->getForm()->get('valor')->getData();

        $arrecadacaoReceita = new ArrecadacaoReceita();
        $arrecadacaoReceita->setFkTesourariaArrecadacao($object);
        $arrecadacaoReceita->setFkOrcamentoReceita($receita);
        $arrecadacaoReceita->setVlArrecadacao($vlArrecadacao);

        $object->addFkTesourariaArrecadacaoReceitas($arrecadacaoReceita);

        if (!$object->getObservacao()) {
            $object->setObservacao('');
        }

        $object->setDevolucao(true);
    }

    public function postPersist($object)
    {
        $this->forceRedirect('/financeiro/tesouraria/arrecadacao/orcamentaria-devolucao-receita/create');
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();

        $utilizarEncerramentoMes = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => 9,
                'parametro' => 'utilizar_encerramento_mes',
                'exercicio' => $exercicio,
            ]);
        if ($utilizarEncerramentoMes) {
            $utilizarEncerramentoMes = $utilizarEncerramentoMes->getValor();
        }

        if ($utilizarEncerramentoMes == "true") {
            $encerramentoMes = $em->getRepository('CoreBundle:Contabilidade\EncerramentoMes')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'situacao' => 'F'
                ], ['timestamp' => 'DESC']);
            if ($encerramentoMes) {
                $encerramentoMes = $encerramentoMes->getMes();
            }
        }

        if (!$this->getSubject()->getCodArrecadacao()) {
            if ($utilizarEncerramentoMes == "true") {
                if ($encerramentoMes >= date('m')) {
                    $mensagem = "Não é possível utilizar esta rotina pois o mês atual está encerrado!";
                    $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }
            }

            $valor = $this->getForm()->get('valor')->getData();
            if ($valor <= 0) {
                $mensagem = "Campo Valor deve ser maior que zero!";
                $errorElement->with('valor')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        }
    }
}
