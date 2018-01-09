<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoContrato;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmpenhoContratoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_empenho_contrato';
    protected $baseRoutePattern = 'financeiro/empenho/vincular-contrato';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array('/financeiro/javascripts/empenho/vincular-empenho-contrato.js');

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit'));
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
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('numContrato'));

        $datagridMapper
            ->add(
                'fkOrcamentoEntidade',
                'composite_filter',
                [
                    'label' => 'label.reciboExtra.codEntidade'
                ],
                null,
                [
                    'class' => Entidade::class,
                    'choice_value' => 'codEntidade',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $this->getExercicio());
                        return $qb;
                    }
                ],
                [
                    'admin_code' => 'financeiro.admin.entidade'
                ]
            )
            ->add(
                'numContrato',
                null,
                array(
                    'label' => 'label.vinculoEmpenhoContrato.contrato'
                )
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
                'fkOrcamentoEntidade.fkSwCgm',
                null,
                array(
                    'label' => 'entidade'
                )
            )
            ->add(
                'numContrato',
                null,
                array(
                    'label' => 'label.vinculoEmpenhoContrato.contrato'
                )
            )
            ->add(
                'fkSwCgm.nomCgm',
                null,
                array(
                    'label' => 'credor'
                )
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'FinanceiroBundle:Empenho/Empenho/Contrato:list__action_edit.html.twig'),
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

        $em = $this->modelManager->getEntityManager(EmpenhoContrato::class);
        $vinculos = $em->getRepository(EmpenhoContrato::class)
            ->findBy([
                'exercicio' => $this->getSubject()->getExercicio(),
                'codEntidade' => $this->getSubject()->getCodEntidade(),
                'numContrato' => $this->getSubject()->getNumContrato()
            ]);

        $formMapper->with('label.vinculoEmpenhoContrato.dadosEmpenhoContrato');
            $formMapper->add(
                'dadosContrato',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(
                        'contrato' => $this->getSubject()
                    ),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Contrato:detalhe_dados_contrato.html.twig',
                ]
            );
        $formMapper->end();

        $formMapper->with('label.vinculoEmpenhoContrato.empenho');
            $formMapper->add(
                'entidade',
                'hidden',
                array(
                    'mapped' => false,
                    'data' => $this->getSubject()->getFkOrcamentoEntidade()->getCodEntidade()
                )
            );
            $formMapper->add(
                'entidadeText',
                'hidden',
                array(
                    'mapped' => false,
                    'data' => $this->getSubject()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm()
                )
            );
            $formMapper->add(
                'empenho',
                'autocomplete',
                array(
                    'label' => 'label.ordemPagamento.codEmpenho',
                    'mapped' => false,
                    'route' => array('name' => 'carrega_empenho_exercicio'),
                    'req_params' => array(
                        'exercicio' => $this->getExercicio()
                    )
                )
            );
            $formMapper->add(
                'btnAdd',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Convenio:botao.html.twig',
                ]
            );
        $formMapper->end();

        $formMapper->with('label.vinculoEmpenhoContrato.empenhosContrato');
            $formMapper->add(
                'empenhosVinculados',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'data' => array(
                        'empenhoContratos' => $vinculos
                    ),
                    'template' => 'FinanceiroBundle:Empenho\Empenho\Contrato:empenhos_vinculados.html.twig',
                ]
            );
        $formMapper->end();
    }

    /**
     * @param $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $empenhos = $this->getRequest()->request->get('empenhos');
            $em = $this->modelManager->getEntityManager(EmpenhoContrato::class);
            $vinculos = $em->getRepository(EmpenhoContrato::class)
                ->findBy([
                    'exercicio' => $this->getSubject()->getExercicio(),
                    'codEntidade' => $this->getSubject()->getCodEntidade(),
                    'numContrato' => $this->getSubject()->getNumContrato()
                ]);

            foreach ($vinculos as $vinculo) {
                $em->remove($vinculo);
            }
            $em->flush();


            foreach ($empenhos as $empenho) {
                list($codEntidade, $codEmpenho) = explode('__', $empenho);
                list($empenho, $exercicio) = explode('/', $codEmpenho);

                $empenho = $em->getRepository(Empenho::class)
                    ->findOneBy([
                        'exercicio' => $exercicio,
                        'codEmpenho' => $empenho,
                        'codEntidade' => $codEntidade
                    ]);

                $empenhoContrato = new EmpenhoContrato();
                $empenhoContrato->setFkEmpenhoEmpenho($empenho);
                $empenhoContrato->setFkLicitacaoContrato($object);

                $object->addFkEmpenhoEmpenhoContratos($empenhoContrato);
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect($this->baseRouteName . '_create');
        }
    }
}
