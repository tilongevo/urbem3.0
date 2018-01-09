<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\PrevisaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoTributario;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Model\Orcamento\ReceitaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ReceitaAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento
 */
class ReceitaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_elaboracao_orcamento_receita';
    protected $baseRoutePattern = 'financeiro/orcamento/elaboracao-orcamento/receita';
    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/elaboracaoorcamento/receita.js'
    );
    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere('o.exercicio = :exercicio');
        $query->setParameter(':exercicio', $this->getExercicio());
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codReceita'));

        $datagridMapper
            ->add('codEntidade', null, ['label' => 'label.planoconta.entidade'], 'entity', [
                'class' => Entidade::class,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'query_builder' => function ($entityManager) {
                    return $entityManager
                        ->createQueryBuilder('e')
                        ->where('e.exercicio = :exercicio')
                        ->setParameter(':exercicio', $this->getExercicio())
                        ->orderBy('e.codEntidade', 'ASC');
                }
            ])
            ->add('codReceita', null, ['label' => 'label.receita'], 'entity', [
                'class' => Receita::class,
                'placeholder' => 'label.selecione',
                'query_builder' => function ($entityManager) {
                    return $entityManager
                        ->createQueryBuilder('re')
                        ->where('re.exercicio = :exercicio')
                        ->setParameter(':exercicio', $this->getExercicio())
                        ->orderBy('re.codReceita', 'ASC');
                },
                'attr' => [
                    'class' => 'selecione2-parameters '
                ]
            ])
            ->add('codRecurso', null, ['label' => 'label.suplementacao.recurso'], 'entity', [
                'class' => Recurso::class,
                'placeholder' => 'label.selecione',
                'query_builder' => function ($entityManager) {
                    return $entityManager
                        ->createQueryBuilder('rec')
                        ->where('rec.exercicio = :exercicio')
                        ->setParameter(':exercicio', $this->getExercicio())
                        ->orderBy('rec.codRecurso', 'ASC');
                },
                'attr' => [
                    'class' => 'selecione2-parameters '
                ]
            ])
            ->add('vlOriginal', null, ['label' => 'label.suplementacao.valor'])
            ->add('creditoTributario', null, ['label' => 'label.elaboracaoReceita.receita.contaCreditoTributario', 'placeholder' => 'label.selecione'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codReceita', null, ['label' => 'label.receita'])
            ->add('fkOrcamentoContaReceita.codEstrutural', null, ['label' => 'label.planoconta.codEstrutural'])
            ->add('fkOrcamentoContaReceita.descricao', null, ['label' => 'label.planoconta.nomConta'])
            ->add('fkOrcamentoRecurso.nomRecurso', null, ['label' => 'label.suplementacao.recurso'])
            ->add('dtCriacao', null, ['label' => 'label.dtCriacao'])
            ->add('vlOriginal', 'currency', ['label' => 'label.suplementacao.valor', 'currency' => 'BRL', 'attr' => 'money '])
            ->add('creditoTributario', null, ['label' => 'label.elaboracaoReceita.receita.contaCreditoTributario',])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
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

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formOptions['fkOrcamentoEntidade'] = [
            'label' => 'label.planoconta.entidade',
            'placeholder' => 'label.selecione',
            'query_builder' => function ($entityManager) {
                return $entityManager
                    ->createQueryBuilder('o')
                    ->where('o.exercicio = :exercicio')
                    ->setParameter(':exercicio', $this->getExercicio())
                    ->orderBy('o.codEntidade', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $formOptions['codConta'] = [
            'label' => 'label.elaboracaoReceita.receita.classificacao',
            'route' => ['name' => 'busca_receita'],
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $formOptions['fkOrcamentoRecurso'] = [
            'label' => 'label.suplementacao.recurso',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\Recurso',
            'query_builder' => function ($entityManager) {
                return $entityManager
                    ->createQueryBuilder('rec')
                    ->where('rec.exercicio = :exercicio')
                    ->setParameter(':exercicio', $this->getExercicio())
                    ->orderBy('rec.codRecurso', 'ASC');
            },
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $formOptions['receita'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'FinanceiroBundle::Orcamento/ElaboracaoOrcamento/Receita/edit.html.twig',
            'data' => [
                'itens' => null,
                'lancamentos' => null,
                'errors' => null,
                'tipo' => null
            ],
            'attr' => [
                'class' => ''
            ]
        ];

        $formOptions['fkOrcamentoReceitaCreditoTributario'] = [
            'label' => 'label.elaboracaoReceita.receita.contaCreditoTributario',
            'placeholder' => 'label.selecione',
            'class' => 'CoreBundle:Orcamento\ReceitaCreditoTributario',
            'mapped' => true,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $formOptions['vlOriginal'] = [
            'label' => 'label.elaboracaoReceita.receita.valorPrevisao',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money '
            ),
        ];

        if ($this->id($this->getSubject())) {
            $this->exibirBotaoExcluir = false;
            /** @var Receita $receita */
            $receita = $this->getSubject();

            $formOptions['fkOrcamentoEntidade']['disabled'] = true;

            $formOptions['codConta']['disabled'] = true;
            $formOptions['codConta']['data'] = $receita->getFkOrcamentoContaReceita();

            $formOptions['fkOrcamentoReceitaCreditoTributario']['mapped'] = false;
            $formOptions['fkOrcamentoReceitaCreditoTributario']['data'] = $receita->getFkOrcamentoReceitaCreditoTributario();

            $formOptions['vlOriginal']['disabled'] = true;

            $periodos = $receita->getFkOrcamentoPrevisaoReceitas();
            $lancamentos = (new ReceitaModel($entityManager))->getLancamentosReceita($receita);
            $formOptions['receita']['data'] = [
                'itens' => $periodos,
                'lancamentos' => $lancamentos
            ];
        }

        $formMapper
            ->with('label.elaboracaoReceita.receita.dadosReceita')
            ->add(
                'fkOrcamentoEntidade',
                null,
                $formOptions['fkOrcamentoEntidade'],
                ['admin_code' => 'financeiro.admin.entidade']
            )
            ->add(
                'codConta',
                'autocomplete',
                $formOptions['codConta']
            )
            ->add(
                'fkOrcamentoRecurso',
                'entity',
                $formOptions['fkOrcamentoRecurso']
            )
            ->add(
                'vlOriginal',
                'money',
                $formOptions['vlOriginal']
            )
            ->add(
                'creditoTributario',
                null,
                [
                    'label' => 'label.elaboracaoReceita.receita.contaCreditoTributario'
                ]
            )
            ->add(
                'fkOrcamentoReceitaCreditoTributario',
                'entity',
                $formOptions['fkOrcamentoReceitaCreditoTributario']
            )
            ->end();

        $formMapper
            ->with('label.elaboracaoReceita.receita.registrosMetas')
            ->add(
                'receita',
                'customField',
                $formOptions['receita']
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
            ->add('codReceita')
            ->add('codConta')
            ->add('codEntidade')
            ->add('codRecurso')
            ->add('dtCriacao')
            ->add('vlOriginal')
            ->add('creditoTributario')
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $isCreditoTributario = $this->getForm()->get('creditoTributario')->getData();

        if ($isCreditoTributario) {
            if ($this->getForm()->get('fkOrcamentoReceitaCreditoTributario')->getData() == null) {
                $mensagem = $this->getTranslator()->trans('label.elaboracaoReceita.receita.validate.campoContaCreditoTrib');
                $errorElement->with('fkOrcamentoReceitaCreditoTributario')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }

        if (!$this->id($this->getSubject())) {
            $codConta =  $this->getForm()->get('codConta')->getData();
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $result = (new ReceitaModel($entityManager))->getReceita($this->getExercicio(), $codConta);
            if (count($result)) {
                $mensagem = $this->getTranslator()->trans('label.elaboracaoReceita.receita.validate.receitaExistente');
                $errorElement->with('codConta')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }
    }

    /**
     * @param Receita $receita
     */
    public function prePersist($receita)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codReceita = $em->getRepository($this->getClass())
            ->getNewCodReceita($this->getExercicio());
        $receita->setCodReceita($codReceita);

        /** @var ContaReceita $contaReceita */
        $contaReceita = $em->getRepository(ContaReceita::class)
            ->findOneBy(['exercicio' => $this->getExercicio(), 'codConta' => $this->getForm()->get('codConta')->getData()]);
        $receita->setFkOrcamentoContaReceita($contaReceita);

        for ($i = 1; $i <= 6; $i++) {
            $prevPeriodo = new PrevisaoReceita();
            $prevPeriodo->setPeriodo($i);
            $prevPeriodo->setVlPeriodo($this->getRequest()->get('vl_'.$i));
            $receita->addFkOrcamentoPrevisaoReceitas($prevPeriodo);
        }
    }

    /**
     * @param Receita $receita
     */
    public function preUpdate($receita)
    {
        /** @var PrevisaoReceita $previsaoReceita */
        foreach ($receita->getFkOrcamentoPrevisaoReceitas() as $previsaoReceita) {
            $previsaoReceita->setVlPeriodo($this->getRequest()->get('vl_' . $previsaoReceita->getPeriodo()));
        }

        if ($receita->getCreditoTributario()) {
            $receita->setFkOrcamentoReceitaCreditoTributario($this->getForm()->get('fkOrcamentoReceitaCreditoTributario')->getData());
        }
    }

    /**
     * @param Receita $receita
     */
    public function postUpdate($receita)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        if (!$receita->getCreditoTributario()) {
            $receitaCreditoTributario = $em->getRepository(ReceitaCreditoTributario::class)->findOneBy([
                'codReceita' => $receita->getCodReceita(),
                'exercicio' => $receita->getExercicio()
            ]);
            if ($receitaCreditoTributario) {
                $em->remove($receitaCreditoTributario);
                $em->flush();
            }
        }
    }

    /**
     * @param Receita $receita
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($receita)
    {
        $container = $this->getConfigurationPool()->getContainer();
        if ($receita->getFkContabilidadeLancamentoReceitas()->count()) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.elaboracaoReceita.receita.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param Receita $receita
     * @return string
     */
    public function toString($receita)
    {
        return ($receita->getCodReceita())
            ? (string) $receita
            : $this->getTranslator()->trans('label.elaboracaoReceita.receita.modulo');
    }
}
