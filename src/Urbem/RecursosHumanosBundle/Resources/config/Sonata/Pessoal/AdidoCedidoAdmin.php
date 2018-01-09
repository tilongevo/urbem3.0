<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedido;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\AdidoCedido as AdidoCedidoConstants;

class AdidoCedidoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_adidos_cedidos';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/adidos-cedidos';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('consultar_adido_cedido', 'consultar-adido-cedido', array(), array(), array(), '', array(), array('POST','GET'))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/adidocedido/filter--adidocedido.js',
        ]));

        $datagridMapper
            ->add(
                'matricula',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.adidoscedidos.inContrato'
                ),
                'autocomplete',
                array(
                    'class' => Contrato::class,
                    'route' => array(
                        'name' => 'carrega_contrato'
                    ),
                    'mapped' => false,
                )
            )
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->getEntityManager();
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');

        $params = [];

        if ($filter) {
            if (isset($filter['matricula']) && $filter['matricula']['value'] != '') {
                $legacyResult = $entityManager->getRepository(AdidoCedido::class)
                ->consultaAdidoCedidoLegado([
                    'exercicio' => $this->getExercicio(),
                    'cod_contrato' => $filter['matricula']['value']
                ]);

                if ($legacyResult) {
                    $query->andWhere('o.codContrato = :codContrato');
                    $query->andWhere('o.codNorma = :codNorma');
                    $query->andWhere('o.timestamp = :timestamp');
                    $params['codContrato'] = $legacyResult->cod_contrato;
                    $params['codNorma'] = $legacyResult->cod_norma;
                    $params['timestamp'] = $legacyResult->timestamp;
                } else {
                    $query->andWhere('1 = 0');
                }
            }
            $query->setParameters($params);
        } else {
            $query->andWhere('1 = 0');
        }

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
                'matricula',
                'text',
                [
                    'label' => 'label.adidoscedidos.inContrato',
                    'row_align' => 'right'
                ]
            )
            ->add(
                'servidor',
                'text',
                [
                    'label' => 'label.servidor.modulo'
                ]
            )
            ->add(
                'local',
                'text',
                [
                    'label' => 'label.adidoscedidos.inCodLocal'
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
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/adidocedido/form--adidocedido.js',
        ]));

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getDoctrine();

        $request = $this->getRequest();

        $fieldOptions = [];

        $fieldOptions['fkPessoalContratoServidor'] = [
            'class' => ContratoServidor::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->findByNomCgm($term);
            },
            'json_choice_label' => function (ContratoServidor $contratoServidor) use ($entityManager) {
                return (new ContratoServidorModel($entityManager))
                ->toStringContratoServidorAutocomplete($contratoServidor);
            },
            'label' => 'label.adidoscedidos.inContrato'
        ];

        $fieldOptions['codTipoNorma'] = [
            'label' => 'label.adidoscedidos.inCodTipoNormaTxt',
            'class' => TipoNorma::class,
            'choice_label' => function ($tipoNorma) {
                return $tipoNorma->getCodTipoNorma()
                . " - "
                . $tipoNorma->getNomTipoNorma();
            },
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'placeholder' => 'label.selecione',
            'required' => true,
        ];

        $fieldOptions['fkNormasNorma'] = [
            'label' => 'label.adidoscedidos.stNrNormaTxt',
            'class' => Norma::class,
            'req_params' => [
                'codTipoNorma' => 'varJsCodTipoNorma'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->andWhere('n.codTipoNorma = :codTipoNorma')
                    ->andWhere('n.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                    ->setParameter('codTipoNorma', $request->get('codTipoNorma'))
                    ->setParameter('exercicio', $this->getExercicio())
                ;

                return $qb;
            },
            'required' => true,
        ];

        $fieldOptions['dtInicial'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.adidoscedidos.dtDataInicialAto',
        ];

        $fieldOptions['dtFinal'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.adidoscedidos.dtDataFinalAto',
        ];

        $fieldOptions['tipoCedencia'] = [
            'label' => 'label.adidoscedidos.stTipoCedencia',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
            'choices' => AdidoCedidoConstants::TIPOCEDENCIA,
            'data' => 'a'
        ];

        $fieldOptions['fkSwCgm'] = [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->getSwCgmPessoaJuridicaQueryBuilder($term);
            },
            'label' => 'label.adidoscedidos.inCGM',
            'attr' => [
                'class' => 'select2-parameters'
            ],
        ];

        $fieldOptions['indicativoOnus'] = [
            'label' => 'label.adidoscedidos.stIndicativoOnus',
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
            'choices' => AdidoCedidoConstants::INDICATIVOONUS,
            'data' => 'c'
        ];

        $fieldOptions['numConvenio'] = [
            'label' => 'label.adidoscedidos.inCodConvenioTxt',
        ];

        $fieldOptions['codLocal'] = [
            'class' => Local::class,
            'label' => 'label.adidoscedidos.inCodLocal',
            'choice_label' => 'descricao',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codTipoNorma']['data'] = $this->getSubject()
            ->getFkNormasNorma()->getFkNormasTipoNorma();

            $codLocal = $this->getSubject()->getFkPessoalAdidoCedidoLocais();

            if (! $codLocal->isEmpty()) {
                $fieldOptions['codLocal']['data'] = $codLocal->last()->getFkOrganogramaLocal();
            }

            $fieldOptions['fkPessoalContratoServidor']['disabled'] = true;
            $fieldOptions['tipoCedencia']['disabled'] = true;
            $fieldOptions['fkSwCgm']['disabled'] = true;
            $fieldOptions['indicativoOnus']['disabled'] = true;
        }

        $formMapper
            ->with('label.adidoscedidos.dadosMovimentacao')
                ->add(
                    'fkPessoalContratoServidor',
                    'autocomplete',
                    $fieldOptions['fkPessoalContratoServidor']
                )
                ->add(
                    'codTipoNorma',
                    'entity',
                    $fieldOptions['codTipoNorma']
                )
                ->add(
                    'fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkNormasNorma']
                )
                ->add(
                    'dtInicial',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicial']
                )
                ->add(
                    'dtFinal',
                    'sonata_type_date_picker',
                    $fieldOptions['dtFinal']
                )
                ->add(
                    'tipoCedencia',
                    'choice',
                    $fieldOptions['tipoCedencia']
                )
                ->add(
                    'fkSwCgm',
                    'autocomplete',
                    $fieldOptions['fkSwCgm']
                )
                ->add(
                    'indicativoOnus',
                    'choice',
                    $fieldOptions['indicativoOnus']
                )
                ->add(
                    'numConvenio',
                    null,
                    $fieldOptions['numConvenio']
                )
                ->add(
                    'codLocal',
                    'entity',
                    $fieldOptions['codLocal']
                )
            ->end()
        ;

        if (preg_match('/(create)/', $request->getUri()) === 1) {
            $formMapper
                ->getFormBuilder()
                ->setAction('create');
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add(
                'servidor',
                'text',
                [
                    'label' => 'cgm'
                ]
            )
            ->add(
                'matricula',
                'text',
                [
                    'label' => 'label.adidoscedidos.inContrato'
                ]
            )
            ->add(
                'fkNormasNorma.fkNormasTipoNorma',
                'text',
                [
                    'label' => 'label.adidoscedidos.inCodTipoNormaTxt',
                ]
            )
            ->add(
                'fkNormasNorma',
                'text',
                [
                    'label' => 'label.adidoscedidos.stNrNormaTxt',
                ]
            )
            ->add(
                'fkNormasNorma.dtPublicacao',
                null,
                [
                    'label' => 'label.dtPublicacao',
                ]
            )
            ->add(
                'dtInicial',
                null,
                [
                    'label' => 'label.adidoscedidos.dtDataInicialAto',
                ]
            )
            ->add(
                'dtFinal',
                null,
                [
                    'label' => 'label.adidoscedidos.dtDataFinalAto',
                ]
            )
            ->add(
                'tipoCedenciaTranslate',
                'trans',
                [
                    'label' => 'label.adidoscedidos.stTipoCedencia',
                ]
            )
            ->add(
                'fkSwCgm',
                null,
                [
                    'label' => 'label.adidoscedidos.inCGM',
                ]
            )
            ->add(
                'indicativoOnusTranslate',
                'trans',
                [
                    'label' => 'label.adidoscedidos.stIndicativoOnus',
                ]
            )
            ->add(
                'numConvenio',
                null,
                [
                    'label' => 'label.adidoscedidos.inCodConvenioTxt',
                ]
            )
            ->add(
                'local',
                'text',
                [
                    'label' => 'label.adidoscedidos.inCodLocal',
                ]
            )
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $adidoCedido
     */
    public function validate(ErrorElement $errorElement, $adidoCedido)
    {
        $form = $this->getForm();

        if ($form->get('dtFinal')->getData() < $form->get('dtInicial')->getData()) {
            $message = $this->trans('adidoscedidos.errors.dataFinal');
            $errorElement->with('dtFinal')->addViolation($message)->end();
        }
    }

    /**
     * @param mixed $adidoCedido
     */
    public function prePersist($adidoCedido)
    {
        $fkOrganogramaLocal = $this->getForm()->get('codLocal')->getData();

        if ($fkOrganogramaLocal) {
            $adidoCedidoLocal = new AdidoCedidoLocal();
            $adidoCedidoLocal->setFkPessoalAdidoCedido($adidoCedido);
            $adidoCedidoLocal->setFkOrganogramaLocal($fkOrganogramaLocal);

            $adidoCedido->addFkPessoalAdidoCedidoLocais($adidoCedidoLocal);
        }
    }

    /**
     * @param mixed $adidoCedido
     */
    public function preUpdate($adidoCedido)
    {
        $entityManager = $this->getEntityManager();
        $newObject = clone $adidoCedido;
        $newObject->setTimestamp((new DateTimeMicrosecondPK()));

        $fkOrganogramaLocal = $this->getForm()->get('codLocal')->getData();

        if ($fkOrganogramaLocal) {
            $adidoCedidoLocal = new AdidoCedidoLocal();
            $adidoCedidoLocal->setFkPessoalAdidoCedido($adidoCedido);
            $adidoCedidoLocal->setFkOrganogramaLocal($fkOrganogramaLocal);

            $newObject->addFkPessoalAdidoCedidoLocais($adidoCedidoLocal);
        }

        $entityManager->persist($newObject);
        $entityManager->flush();
        $this->forceRedirect('/recursos-humanos/pessoal/adidos-cedidos/list');
    }

    /**
     * @param mixed $adidoCedido
     * @return string
     */
    public function toString($adidoCedido)
    {
        return $adidoCedido->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
        . " - "
        . $adidoCedido->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }
}
