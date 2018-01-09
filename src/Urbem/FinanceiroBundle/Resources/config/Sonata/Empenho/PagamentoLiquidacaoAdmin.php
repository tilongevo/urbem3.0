<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Empenho\OrdemPagamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PagamentoLiquidacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_ordem_pagamento_pagamento_liquidacao';
    protected $baseRoutePattern = 'financeiro/empenho/ordem-pagamento/pagamento-liquidacao';
    protected $includeJs = array('/financeiro/javascripts/empenho/pagamento-liquidacao.js');
    protected $linkPerfil = '';

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

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create', 'delete'));
    }

    public function toString($object)
    {
        return $object->getCodNota()
            ? $object
            : $this->getTranslator()->trans('label.ordemPagamento.pagamentoLiquidacao');
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
            ->add('exercicioLiquidacao')
            ->add('codNota')
            ->add('vlPagamento')
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
            ->add('exercicioLiquidacao')
            ->add('codNota')
            ->add('vlPagamento')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array()
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
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

        $fieldOptions['numItens'] = array(
            'data' => $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes()->count(),
            'mapped' => false
        );

        $fieldOptions['codEntidade'] = array(
            'data' => $this->getPersistentParameter('codEntidade'),
            'mapped' => false
        );

        $fieldOptions['observacao'] = array(
            'data' => $ordemPagamento->getObservacao(),
            'label' => false,
            'mapped' => false,
            'attr' => ['class' => 'observacao-textarea ']
        );

        $fieldOptions['exercicioEmpenho'] = [
            'label' => 'label.ordemPagamento.exercicioEmpenho',
            'mapped' => false,
            'data' => $exercicio
        ];

        $fieldOptions['codEmpenho'] = [
            'label' => 'label.ordemPagamento.codEmpenho',
            'multiple' => false,
            'mapped' => false,
            'route' => ['name' => 'urbem_financeiro_empenho_ordem_pagamento_busca_empenho'],
            'req_params' => [
                'codEntidade' => $this->getPersistentParameter('codEntidade'),
                'exercicio' => 'varJsExercicio'
            ]
        ];

        $fieldOptions['fkEmpenhoNotaLiquidacao'] = [
            'label' => 'label.ordemPagamento.liquidacao',
            'choices' => array(),
            'mapped' => false,
            'required' => true,
            'disabled' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['vlPagamento'] = [
            'label' => 'label.ordemPagamento.vlPagamento',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fornecedor = $ordemPagamentoModel->recuperaFornecedor($ordemPagamento);
        $fieldOptions['codFornecedor'] = [
            'label' => 'label.ordemPagamento.codFornecedor',
            'choices' => $fornecedor,
            'required' => true,
            'disabled' => true,
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
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

        $fieldOptions['totalOrdemPagamento'] = [
            'data' => $total,
            'mapped' => false
        ];

        $formMapper->with('label.ordemPagamento.itens');
        $formMapper->add('codOrdem', 'hidden', $fieldOptions['codOrdem']);
        $formMapper->add('exercicio', 'hidden', $fieldOptions['exercicio']);
        $formMapper->add('codEntidade', 'hidden', $fieldOptions['codEntidade']);
        $formMapper->add('numItens', 'hidden', $fieldOptions['numItens']);
        $formMapper->add('codNota', 'hidden', ['mapped' => false]);

        $formMapper->add('exercicioEmpenho', 'text', $fieldOptions['exercicioEmpenho']);
        $formMapper->add('codEmpenho', 'autocomplete', $fieldOptions['codEmpenho']);
        $formMapper->add('fkEmpenhoNotaLiquidacao', 'choice', $fieldOptions['fkEmpenhoNotaLiquidacao'], ['admin_code' => 'financeiro.admin.nota_liquidacao']);
        $formMapper->add('vlPagamento', 'money', $fieldOptions['vlPagamento']);
        $formMapper->add('codFornecedor', 'choice', $fieldOptions['codFornecedor']);
        $formMapper->add('total', 'money', $fieldOptions['total']);
        $formMapper->add('totalOrdemPagamento', 'hidden', $fieldOptions['totalOrdemPagamento']);
        $formMapper->end();

        $formMapper->with('label.ordemPagamento.descricao');
        $formMapper->add('observacao', 'textarea', $fieldOptions['observacao']);
        $formMapper->end();
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
            ->add('exercicioLiquidacao')
            ->add('codNota')
            ->add('vlPagamento')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codEntidade = $this->getForm()->get('codEntidade')->getData();

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy([
                'codOrdem' => $this->getForm()->get('codOrdem')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData(),
                'codEntidade' => $codEntidade
            ]);

        $notaLiquidacao = $em->getRepository('CoreBundle:Empenho\NotaLiquidacao')
            ->findOneBy(
                array(
                    'exercicio' => $this->getForm()->get('exercicio')->getData(),
                    'codNota' => $this->getForm()->get('codNota')->getData(),
                    'codEntidade' => $this->getForm()->get('codEntidade')->getData()
                )
            );

        $fornecedorAtual = '';
        $notaLiquidacoes = array();


        $pagamentoLiquidacoes = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes();
        if ($pagamentoLiquidacoes->count()) {
            foreach ($pagamentoLiquidacoes as $pagamentoLiquidacao) {
                $fornecedorAtual = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao()->getFkEmpenhoNotaLiquidacaoItens()->last()->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNumcgm();
                $notaLiquidacoes[] = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao();
            }

            if (in_array($notaLiquidacao, $notaLiquidacoes)) {
                $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroNotaEmUso');
                $errorElement->with('codEmpenho')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }

        $info = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->getOrdemPagamentoItem($notaLiquidacao->getExercicioEmpenho(), $codEntidade, $notaLiquidacao->getCodEmpenho());

        $valorFaltante = ((float) $info['vl_itens'] - (float) $info['vl_itens_anulados']) - ((float) $info['vl_ordem'] - (float) $info['vl_ordem_anulada']);
        if ($object->getVlPagamento() > $valorFaltante) {
            $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroValorNota');
            $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }

        if ($object->getVlPagamento() <= 0) {
            $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroValor');
            $errorElement->with('vlPagamento')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy(
                array(
                    'codOrdem' => $this->getForm()->get('codOrdem')->getData(),
                    'exercicio' => $this->getForm()->get('exercicio')->getData(),
                    'codEntidade' => $this->getForm()->get('codEntidade')->getData()
                )
            );

        $notaLiquidacao = $em->getRepository('CoreBundle:Empenho\NotaLiquidacao')
            ->findOneBy(
                array(
                    'exercicio' => $this->getForm()->get('exercicio')->getData(),
                    'codNota' => $this->getForm()->get('codNota')->getData(),
                    'codEntidade' => $this->getForm()->get('codEntidade')->getData()
                )
            );

        $object->setFkEmpenhoOrdemPagamento($ordemPagamento);
        $object->setFkEmpenhoNotaLiquidacao($notaLiquidacao);

        $observacao = $this->getForm()->get('observacao')->getData();
        $object->getFkEmpenhoOrdemPagamento()->setObservacao($observacao);
    }

    public function postPersist($object)
    {
        $id = implode('~', $this->getPersistentParameters());
        $url = sprintf('/financeiro/empenho/ordem-pagamento/%s/perfil', $id);
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
