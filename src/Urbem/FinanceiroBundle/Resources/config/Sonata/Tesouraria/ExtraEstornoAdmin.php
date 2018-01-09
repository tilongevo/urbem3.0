<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\VwTransferenciaView;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;
use Urbem\CoreBundle\Model\Tesouraria\VwTransferenciaViewModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper\ArrayHelper;

/**
 * Class ExtraEstornoAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria
 */
class ExtraEstornoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_extra_estorno';
    protected $baseRoutePattern = 'financeiro/tesouraria/extra-estorno';
    protected $includeJs = ['/financeiro/javascripts/tesouraria/pagamentos/extraEstorno.js'];
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        $query->andWhere('o.valorEstornado > 0');
        $query->orderBy('o.codLote', 'DESC');
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codLote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ]
            )
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
                'codlote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codBoletim',
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.nomEntidade',
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.extraArrecadacao.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                'valorEstornado',
                'currency',
                [
                    'label' => 'label.tesouraria.extraArrecadacao.valorEstornado',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig']
                    ]
                ]
            )
        ;
    }

    /**
     * @param $codHistorico
     * @return mixed
     */
    public function getDescHistorico($codHistorico)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return $em->getRepository(HistoricoContabil::class)->findOneBy(['codHistorico' => $codHistorico]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $historico = $this->getSubject();
        $historicoVal = $this->getDescHistorico($historico->getCodHistorico());

        $showMapper
            ->with("Extra Estorno")
            ->add(
                'codRecibo',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codRecibo',
                ]
            )
            ->add(
                'codLote',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codLote',
                ]
            )
            ->add(
                'codBoletim',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.codBoletim',
                ]
            )
            ->add(
                'dtBoletim',
                'date',
                [
                    'label' => 'label.tesouraria.extraPagamento.dtBoletim',
                ]
            )
            ->add(
                'nomEntidade',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.nomEntidade',
                ]
            )
            ->add(
                'planoDebito',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.contaDespesa',
                ]
            )
            ->add(
                'planoCredito',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.contaCredito',
                ]
            )
            ->add(
                'historico',
                'text',
                [
                    'label' => 'label.tesouraria.extraPagamento.codHistorico',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => $historicoVal
                ]
            )
            ->add(
                'valor',
                'currency',
                [
                    'label' => 'label.tesouraria.extraPagamento.valor',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                'valorEstornado',
                'currency',
                [
                    'label' => 'label.tesouraria.extraPagamento.valorEstornado',
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money'
                    ]
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => 'label.tesouraria.extraPagamento.observacao',
                ]
            )
            ->end()
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
        $entidadeModel = new EntidadeModel($em);
        $entidades = ArrayHelper::parseArrayToChoice($entidadeModel->getEntidades($this->getExercicio()), 'nom_cgm', 'cod_entidade');

        $formMapper
            ->with('Filtro de recibo')
            ->add(
                'entidade',
                'choice',
                [
                    'label' => 'label.reciboExtra.codEntidade',
                    'placeholder' => 'label.selecione',
                    'choices' => $entidades,
                    'mapped' => false,
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                ]
            )
            ->add(
                'boletim',
                'choice',
                [
                    'label' => 'label.reciboExtra.codBoletim',
                    'placeholder' => 'Selecione',
                    'mapped' => false,
                    'required' => true,
                    'choices' => $this->preSetPostToChoice("boletim", []),
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                ]
            )
            ->add(
                'codRecibo',
                'number',
                [
                    'label' => 'label.reciboExtra.codRecibo',
                    'mapped' => false,
                    'required' => true,
                ]
            )
            ->end()
            ->with('Dados para Estorno ', ['class' => 'dados-estorno'])
            ->add(
                'credor',
                'choice',
                [
                    'label' => 'label.reciboExtra.credor',
                    'placeholder' => 'Selecione',
                    'mapped' => false,
                    'required' => true,
                    'disabled' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'recurso',
                'choice',
                [
                    'label' => 'label.reciboExtra.codRecurso',
                    'placeholder' => 'Selecione',
                    'mapped' => true,
                    'required' => true,
                    'disabled' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'planoDebito',
                'choice',
                [
                    'label' => 'label.tesouraria.extraPagamento.contaDespesa',
                    'placeholder' => 'Selecione',
                    'mapped' => true,
                    'required' => true,
                    'disabled' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'planoCredito',
                'choice',
                [
                    'label' => 'label.tesouraria.extraPagamento.contaCredito',
                    'placeholder' => 'Selecione',
                    'mapped' => true,
                    'required' => true,
                    'disabled' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'codHistorico',
                'autocomplete',
                [
                    'label' => 'label.reciboExtra.codHistorico',
                    'multiple' => false,
                    'mapped' => true,
                    'required' => true,
                    'route' => ['name' => 'tesouraria_arrecadacao_extra_busca_historico_padrao']
                ]
            )
            ->add(
                'valor',
                'money',
                [
                    'label' => 'label.reciboExtra.valor',
                    'required' => true,
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money ',
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'valorEstorno',
                'money',
                [
                    'label' => 'label.arrecadacao.valorEstornar',
                    'required' => true,
                    'mapped' => false,
                    'currency' => 'BRL',
                    'attr' => [
                        'class' => 'money '
                    ],
                ]
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => 'label.reciboExtra.observacao',
                    'required' => false,
                    'mapped' => false,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formContent = (object) $this->getFormPost();
        $exercicio = $this->getExercicio();

        $paramsBoletim = [
            sprintf('cod_boletim = %s', $formContent->boletim),
            sprintf('cod_entidade = %s', $formContent->entidade),
        ];

        $boletim = new BoletimModel($em);
        $boletim = current($boletim->getBoletins($paramsBoletim));
        $object->setDtBoletim($boletim->dt_boletim);
        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        $arrecadacaoModel = new ArrecadacaoModel($em);

        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.encerramentoMesContabil');
            $errorElement->with('fkEntidade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
        if ($formContent->valor <= 0) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.campoMaiorZero');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
        if ($formContent->valorEstorno > $formContent->valor) {
            $mensagem = $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.campoValorEstorno');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    /**
     * @param $dtBoletim
     * @return string
     */
    public function formatDtBoletim($dtBoletim)
    {
        $dtBoletim = explode('/', $dtBoletim);
        $formatted = $dtBoletim[2].'-'.$dtBoletim[1].'-'.$dtBoletim[0];
        return $formatted;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $transferenciaModel = new VwTransferenciaViewModel($em);
            $form = (object) $this->getFormPost();
            $dtBoletim = $this->formatDtBoletim($object->getDtBoletim());
            $infTransferenciaModel = $transferenciaModel
                ->getInformacoesTransferencia($this->getExercicio(), $form->boletim, $dtBoletim, $form->codRecibo);
            $transferenciaModel->setTransferenciaEstorno($infTransferenciaModel, $form, $this->getExercicio());
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.tesouraria.extraPagamento.validacoes.success'));
            $this->forceRedirect(
                "/financeiro/tesouraria/extra-estorno/list"
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/tesouraria/extra-estorno/create"
            );
        }
    }
}
