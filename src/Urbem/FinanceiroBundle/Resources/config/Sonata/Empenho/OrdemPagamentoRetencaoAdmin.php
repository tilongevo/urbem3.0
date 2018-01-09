<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Empenho\OrdemPagamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrdemPagamentoRetencaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_ordem_pagamento_retencao';
    protected $baseRoutePattern = 'financeiro/empenho/ordem-pagamento/retencao';
    protected $includeJs = array('/financeiro/javascripts/empenho/ordem-pagamento-retencao.js');

    const RETENCAO_ORCAMENTARIA = 1;
    const RETENCAO_EXTRA_ORCAMENTARIA = 2;

    public function getLinkPerfil($object)
    {
        return sprintf(
            '/financeiro/empenho/ordem-pagamento/%s/perfil',
            implode('~', $this->getDoctrine()->getClassMetadata('CoreBundle:Empenho\OrdemPagamento')->getIdentifierValues($object))
        );
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'delete':
                return 'FinanceiroBundle:Empenho\OrdemPagamento:delete.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codOrdem' => $this->getRequest()->get('codOrdem'),
            'exercicio' => $this->getRequest()->get('exercicio'),
            'codEntidade' => $this->getRequest()->get('codEntidade')
        );
    }

    public function toString($object)
    {
        $valor = 'R$' . number_format($object->getVlRetencao(), 2, ',', '.');
        return $valor;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codPlano')
            ->add('vlRetencao')
            ->add('codReceita')
            ->add('sequencial')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codPlano')
            ->add('vlRetencao')
            ->add('codReceita')
            ->add('sequencial')
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

        $exercicio = $this->getExercicio();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $ordemPagamentoModel = new OrdemPagamentoModel($em);
        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy($this->getPersistentParameters());

        $fieldOptions = array();

        $fieldOptions['codOrdem'] = array(
            'data' => $this->getPersistentParameter('codOrdem'),
            'mapped' => false
        );

        $fieldOptions['exercicio'] = array(
            'data' => $this->getPersistentParameter('exercicio'),
            'mapped' => false
        );

        $fieldOptions['codEntidade'] = array(
            'data' => $this->getPersistentParameter('codEntidade'),
            'mapped' => false
        );

        $fieldOptions['tipoRetencao'] = [
            'label' => 'label.ordemPagamento.tipoRetencao',
            'choices' => [
                'label.ordemPagamento.orcamentarias' => self::RETENCAO_ORCAMENTARIA,
                'label.ordemPagamento.extraOrcamentarias' => self::RETENCAO_EXTRA_ORCAMENTARIA
            ],
            'expanded' => true,
            'data' => self::RETENCAO_ORCAMENTARIA,
            'mapped' => false,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        ];

        $fieldOptions['fkOrcamentoReceita'] = [
            'choice_label' => 'codReceita',
            'choice_value' => 'codReceita',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'mapped' => false,
            'label' => 'label.ordemPagamento.codReceita',
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['fkContabilidadePlanoAnalitica'] = [
            'label' => 'label.ordemPagamento.codPlano',
            'choice_label' => function ($planoAnalitica) {
                $conta = $planoAnalitica->getFkContabilidadePlanoConta();
                return $planoAnalitica->getCodPlano() . ' - ' . $conta->getNomConta();
            },
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false,
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->like('pc.codEstrutural', "'1.1.2.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.1.3.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'1.2.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.2.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.9.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.1.8.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.2.1.%'"),
                    $qb->expr()->like('pc.codEstrutural', "'2.2.2.%'")
                ));
                $qb->setParameter('exercicio', $exercicio);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['vlRetencao'] = [
            'label' => 'label.ordemPagamento.vlRetencao',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $total = $ordemPagamentoModel->recuperaTotal($ordemPagamento);
        $fieldOptions['total'] = [
            'label' => 'label.ordemPagamento.total',
            'currency' => 'BRL',
            'required' => true,
            'disabled' => true,
            'mapped' => false,
            'data' => $total,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $totalRetencoes = $ordemPagamentoModel->recuperaTotalRetencoes($ordemPagamento);
        $fieldOptions['totalRetencoes'] = [
            'label' => 'label.ordemPagamento.totalRetencoes',
            'currency' => 'BRL',
            'required' => true,
            'disabled' => true,
            'mapped' => false,
            'data' => $totalRetencoes,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['totalRetencoesOrdemPagamento'] = [
            'mapped' => false,
            'data' => $totalRetencoes,
        ];

        $formMapper
            ->with('label.ordemPagamento.retencoes')
            ->add('codOrdem', 'hidden', $fieldOptions['codOrdem'])
            ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
            ->add('codEntidade', 'hidden', $fieldOptions['codEntidade'])

            ->add('tipoRetencao', 'choice', $fieldOptions['tipoRetencao'])
            ->add('fkOrcamentoReceita', null, $fieldOptions['fkOrcamentoReceita'])
            ->add('fkContabilidadePlanoAnalitica', null, $fieldOptions['fkContabilidadePlanoAnalitica'], ['admin_code' => 'core.admin.plano_analitica'])
            ->add('vlRetencao', 'money', $fieldOptions['vlRetencao'])

            ->add('total', 'money', $fieldOptions['total'])
            ->add('totalRetencoesOrdemPagamento', 'hidden', $fieldOptions['totalRetencoesOrdemPagamento'])
            ->add('totalRetencoes', 'money', $fieldOptions['totalRetencoes'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codPlano')
            ->add('vlRetencao')
            ->add('codReceita')
            ->add('sequencial')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy([
                'codOrdem' => $this->getForm()->get('codOrdem')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData(),
                'codEntidade' => $this->getForm()->get('codEntidade')->getData()
            ]);

        $receitas = array();
        $planoAnaliticas = array();
        $valorRetencao = 0.00;
        $valorLiquidacao = 0.00;

        $pagamentoLiquidacoes = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes();
        foreach ($pagamentoLiquidacoes as $pagamentoLiquidacao) {
            $valorLiquidacao += $pagamentoLiquidacao->getVlPagamento();
        }

        $retencoes = $ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes();
        foreach ($retencoes as $retencao) {
            if ($retencao->getFkOrcamentoReceita()) {
                $receitas[] = $retencao->getFkOrcamentoReceita();
            }
            if ($retencao->getFkContabilidadePlanoAnalitica()) {
                $planoAnaliticas[] = $retencao->getFkContabilidadePlanoAnalitica();
            }
            $valorRetencao += $retencao->getVlRetencao();
        }

        if (in_array($this->getForm()->get('fkOrcamentoReceita')->getData(), $receitas)) {
            $mensagem = $this->getTranslation()->trans('erroReceitaEmUso');
            $errorElement->with('fkOrcamentoReceita')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        if (in_array($this->getForm()->get('fkContabilidadePlanoAnalitica')->getData(), $planoAnaliticas)) {
            $mensagem = $this->getTranslation()->trans('erroContaEmUso');
            $errorElement->with('fkContabilidadePlanoAnalitica')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        $valorRetencao += $object->getVlRetencao();
        if ($valorRetencao > $valorLiquidacao) {
            $mensagem = $this->getTranslation()->trans('erroValorRetencao');
            $errorElement->with('vlRetencao')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $parameters = array(
            'codOrdem' => $this->getForm()->get('codOrdem')->getData(),
            'exercicio' => $this->getForm()->get('exercicio')->getData(),
            'codEntidade' => $this->getForm()->get('codEntidade')->getData()
        );

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy($parameters);

        $sequencial = $ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes()->count() + 1;

        $object->setFkEmpenhoOrdemPagamento($ordemPagamento);
        $object->setSequencial($sequencial);

        if ($this->getForm()->get('fkOrcamentoReceita')->getData()) {
            $object->setFkOrcamentoReceita($this->getForm()->get('fkOrcamentoReceita')->getData());
            $codPlano = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
                ->getOrdemPagamentoReceitaCodPlano(
                    $object->getExercicio(),
                    $object->getCodEntidade(),
                    $object->getCodReceita()
                );
            $planoAnalitica = $em->getRepository('CoreBundle:Contabilidade\PlanoAnalitica')
                ->findOneBy([
                    'codPlano' => $codPlano,
                    'exercicio' => $object->getExercicio()
                ]);
            $object->setFkContabilidadePlanoAnalitica($planoAnalitica);
        } else {
            $object->setFkContabilidadePlanoAnalitica($this->getForm()->get('fkContabilidadePlanoAnalitica')->getData());
        }
    }

    public function postPersist($object)
    {
        $id = implode('~', $this->getPersistentParameters());
        $url = sprintf('/financeiro/empenho/ordem-pagamento/%s/perfil', $id);
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }

    public function postRemove($object)
    {
        $url = sprintf(
            '/financeiro/empenho/ordem-pagamento/%s~%s~%s/perfil',
            $object->getCodOrdem(),
            $object->getExercicio(),
            $object->getCodEntidade()
        );
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }
}
