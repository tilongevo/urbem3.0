<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Orcamento;

use Urbem\CoreBundle\Model\Patrimonial\Compras\ManutencaoPropostaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CompraDiretaModel;

/**
 * Class ManutencaoPropostaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class ManutencaoPropostaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_manutencao_proposta';

    protected $baseRoutePattern = 'patrimonial/compras/manutencao-proposta';

    protected $customHeader = 'PatrimonialBundle:Sonata\Compras\ManutencaoProposta\CRUD:header.html.twig';

    protected $exibirBotaoIncluir = false;

    protected $getExibirBotaoExcluir = false;

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('delete');
    }

    /**
     * Lista Customizada
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager(Compras\CompraDireta::class);

        $exercicio = $this->getExercicio();

        $manutencaoPropostaModel = new ManutencaoPropostaModel($entityManager);

        $query = parent::createQuery($context);
        $query = $manutencaoPropostaModel->getManutencaoPropostaList($query, $exercicio);

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add(
                'codEntidade',
                null,
                [
                    'label' => 'label.ordem.entidade'
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_label' => function (Entity\Orcamento\Entidade $codEntidade) {
                        return $codEntidade->getCodEntidade().' - '.$codEntidade->getFkSwCgm()->getNomCgm();
                    },
                    'query_builder' => function ($entityManager) use ($exercicio) {
                        return $entityManager
                            ->createQueryBuilder('entidade')
                            ->where('entidade.exercicio = :exercicio')
                            ->setParameter(':exercicio', $exercicio);
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codModalidade',
                null,
                [
                    'label' => 'label.manutencaoProposta.codModalidade',
                ],
                'entity',
                [
                    'class' => Compras\Modalidade::class,
                    'choice_label' => function (Compras\Modalidade $modalidade) {
                        return "{$modalidade->getCodModalidade()} - {$modalidade->getDescricao()}";
                    },
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add('codMapa', null, [
                'label' => 'label.manutencaoProposta.codMapa'
            ], 'entity', [
                'class' => Compras\Mapa::class,
                'choice_label' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'placeholder' => 'label.selecione',
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkOrcamentoEntidade.fkSwCgm.nomCgm', null, ['label' => 'label.comprasDireta.codEntidade'])
            ->add('fkComprasModalidade.descricao', null, ['label' => 'label.comprasDireta.codModalidade'])
            ->add('codCompraDireta', null, ['label' => 'label.comprasDireta.codCompraDireta'])
            ->add('timestamp', 'date', [
                'label' => 'label.comprasDireta.timestamp',
                'format' => 'd/m/Y',
            ])
            ->add('fkComprasMapa', null, [
                'associated_property' => function (Compras\Mapa $mapa) {
                    $exercicio = $mapa->getExercicio();

                    return "{$exercicio} | {$mapa->getCodMapa()}";
                },
                'label' => 'label.comprasDireta.codMapa'
            ])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig')
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

        $this->compraDireta = $this->getSubject();

        $fieldOptions['dtManutencao'] = [
            'label' => 'label.manutencaoProposta.dtManutencao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

//        dump($this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last());
//        die();
        if ($this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()) {
            $fieldOptions['dtManutencao']['data'] =
                $this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getFkComprasCotacao()->getTimestamp();
        }

        $formMapper
            ->with('')
            ->add(
                'dtManutencao',
                'sonata_type_date_picker',
                $fieldOptions['dtManutencao']
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('exercicio')
            ->add('codCotacao')
            ->add('timestamp')
        ;
    }

    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();

//         Persist Cotacao
        $em = $this->modelManager->getEntityManager('CoreBundle:Compras\Cotacao');
        $CotacaoModel = new CotacaoModel($em);
        $Cotacao = new Compras\Cotacao();
        $dataPk = new DateTimeMicrosecondPK($form->get('dtManutencao')->getData()->format("d/m/Y"));

        $Cotacao->setExercicio($exercicio);
        $Cotacao->setTimestamp($dataPk);
        $Cotacao->setCodCotacao($CotacaoModel->getProximoCodCotacao($exercicio));
        $CotacaoModel->save($Cotacao);

//         Persist MapaCotacao
        $em = $this->modelManager->getEntityManager('CoreBundle:Compras\MapaCotacao');
        $MapaCotacaoModel = new CompraDiretaModel($em);
        $MapaCotacao = new Compras\MapaCotacao();

        $MapaCotacao->setFkComprasMapa($this->getSubject()->getFkComprasMapa());
        $MapaCotacao->setFkComprasCotacao($Cotacao);

        $MapaCotacaoModel->save($MapaCotacao);
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $id = $this->getAdminRequestId();
            $em = $this->modelManager->getEntityManager($this->getClass());

            if ($this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()) {
                $em = $this->modelManager->getEntityManager('CoreBundle:Compras\Cotacao');
                $cotacao = $em->getRepository('CoreBundle:Compras\Cotacao')->findOneBy(
                    [
                        'codCotacao' => $this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getCodCotacao(),
                        'exercicio' => $this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getExercicioCotacao()
                    ]
                );

//                 Remove MapaCotacao
                $em = $this->modelManager->getEntityManager('CoreBundle:Compras\MapaCotacao');
                $mapaCotacao = $em->getRepository('CoreBundle:Compras\MapaCotacao')->findOneBy([
                    'codCotacao' => $this->getSubject()->getFkComprasMapa()->getFkComprasMapaCotacoes()->last()->getCodCotacao(),
                    'codMapa' => $this->getSubject()->getFkComprasMapa()->getCodMapa()
                ]);
                if ($mapaCotacao) {
                    $em->remove($mapaCotacao);
                }

//                 Remove Cotacao
                if ($cotacao) {
                    $em->remove($cotacao);
                }
            }

            $this->saveRelationships($object, $this->getForm());
        } catch (Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    public function redirect($object, $message)
    {
        $compraDireta = implode('~', $this->getDoctrine()->getClassMetadata('CoreBundle:Compras\CompraDireta')
            ->getIdentifierValues($object));

        $container = $this->getConfigurationPool()->getContainer();

        $this->forceRedirect("/patrimonial/compras/manutencao-proposta/".$compraDireta."/show");
    }

    public function postUpdate($object)
    {
        $this->redirect($object, $this->trans('patrimonial.manutencaoProposta.update', [], 'flashes'));
    }
}
