<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Folhapagamento;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento;
use Sonata\AdminBundle\Route\RouteCollection;

class ConfiguracaoBeneficioAdmin extends AbstractAdmin
{
    /** @var string */
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio';
    /** @var string */
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao-beneficio';
    /** @var integer */
    const BENEFICIO_EVENTO_CODTIPO = 1;
    /** @var boolean */
    protected $exibirBotaoIncluir = false;

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/configuracaobeneficio.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(['list', 'edit', 'create'])
            ->add('get_texto_complementar', 'get-texto-complementar', array(), array(), array(), '', array(), array('POST'))
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $query = parent::createQuery($context);

        $configuracaoBeneficio = $entityManager->createQueryBuilder();
        $configuracaoBeneficio->from('CoreBundle:Folhapagamento\ConfiguracaoBeneficio', 'cb');
        $configuracaoBeneficio->select('MAX(cb.timestamp) AS timestamp');

        $query->innerJoin('o.fkFolhapagamentoBeneficioEventos', 'be');
        $query->andWhere($query->expr()->in('be.timestamp', $configuracaoBeneficio->getDql()));
        $query->andWhere('be.codTipo = :codTipo');
        $query->setParameter('codTipo', self::BENEFICIO_EVENTO_CODTIPO);

        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkFolhapagamentoBeneficioEventos',
                null,
                [
                    'label' => 'label.configuracaoBeneficio.codEventoValeTransporte'
                ]
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

        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        $eventoModel = new Folhapagamento\EventoModel($entityManager);
        $eventoEntity = $eventoModel->getEventoPensaoFuncaoPadrao();

        $fieldOptions['codEventoValeTransporte'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.configuracaoBeneficio.codEventoValeTransporte',
            'query_builder' => $eventoEntity,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $fieldOptions['textoComplementarValeTransporte'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'label' => 'label.configuracaoBeneficio.textoComplementar',
        ];

        $fieldOptions['fkFolhapagamentoBeneficioEventos'] = [
            'label' => false,
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codEventoValeTransporte']['data'] = $this->getSubject()
            ->getFkFolhapagamentoBeneficioEventos()->last()->getFkFolhapagamentoEvento();

            $fieldOptions['textoComplementarValeTransporte']['data'] = $this->getSubject()
            ->getFkFolhapagamentoBeneficioEventos()->last()->getFkFolhapagamentoEvento()
            ->getFkFolhapagamentoEventoEventos()->last()->getObservacao();

            $fieldOptions['fkFolhapagamentoBeneficioEventos']['data'] =
            $entityManager->getRepository('CoreBundle:Folhapagamento\BeneficioEvento')
            ->getConfiguracaoBeneficioPlanoSaude([
                'timestamp' => $this->getSubject()->getTimestamp()->format("Y-m-d H:i:s.u")
            ]);
        }

        $formMapper
            ->with('label.configuracaoBeneficio.valeTransporte')
                ->add(
                    'codEventoValeTransporte',
                    'entity',
                    $fieldOptions['codEventoValeTransporte']
                )
                ->add(
                    'textoComplementarValeTransporte',
                    'text',
                    $fieldOptions['textoComplementarValeTransporte']
                )
            ->end()
            ->with('label.configuracaoBeneficio.planoSaude')
                ->add(
                    'fkFolhapagamentoBeneficioEventos',
                    'sonata_type_collection',
                    $fieldOptions['fkFolhapagamentoBeneficioEventos'],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'delete' => true,
                    ]
                )
            ->end()
        ;
    }
}
