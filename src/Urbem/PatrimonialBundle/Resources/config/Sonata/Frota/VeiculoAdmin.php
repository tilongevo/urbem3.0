<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Frota\Utilizacao;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;

/**
 * Class VeiculoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class VeiculoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo';
    protected $baseRoutePattern = 'patrimonial/frota/veiculo';
    protected $model = VeiculoModel::class;
    protected $includeJs = [
        '/patrimonial/javascripts/frota/veiculo.js',
    ];

    /**
     * @param Frota\Veiculo $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        // Set FkFrotaModelo
        $modeloModel = new Model\Patrimonial\Frota\ModeloModel($em);
        $modelo = $modeloModel->findOneBy([
            'codModelo' => $formData['fkFrotaModelo'],
            'codMarca' => $formData['fkFrotaMarca']
        ]);

        $object->setFkFrotaModelo($modelo);
    }

    /**
     * @param Frota\Veiculo $object
     */
    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $this->saveRelationships($object, $this->getForm());
            $this->redirect($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo/create");
        }
    }

    /**
     * @param Frota\Veiculo $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ($form->get('fkFrotaVeiculoCombustiveis')->getData() as $combustivel) {
            $veiculoCombustivel = new Frota\VeiculoCombustivel();
            $veiculoCombustivel->setFkFrotaCombustivel($combustivel);
            $veiculoCombustivel->setFkFrotaVeiculo($object);

            $em->persist($veiculoCombustivel);
        }

        // Setar ControleInterno
        if ($form->get('verificado')->getData()) {
            $controleInterno = new Frota\ControleInterno();
            $controleInterno->setExercicio($exercicio);
            $controleInterno->setVerificado($form->get('verificado')->getData());
            $controleInterno->setFkFrotaVeiculo($object);

            $em->persist($controleInterno);
        }
        $em->flush();
    }

    /**
     * @param Frota\Veiculo $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object)}/show");
    }

    /**
     * @param Frota\Veiculo $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        // Set FkFrotaModelo
        $modeloModel = new Model\Patrimonial\Frota\ModeloModel($em);
        $modelo = $modeloModel->findOneBy([
            'codModelo' => $formData['fkFrotaModelo'],
            'codMarca' => $formData['fkFrotaMarca']
        ]);

        if ($modelo) {
            $object->setFkFrotaModelo($modelo);
        }
    }

    /**
     * @param Frota\Veiculo $object
     */
    public function postUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            // Remove ControleInterno
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\ControleInterno');
            $controleInterno = $em->getRepository('CoreBundle:Frota\ControleInterno')->findOneByCodVeiculo($object);

            if ($controleInterno) {
                $em->remove($controleInterno);
            }

            // Remove VeiculoCombustivel
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager(Frota\VeiculoCombustivel::class);
            $veiculoCombustiveisModel = new Model\Patrimonial\Frota\VeiculoCombustivelModel($em);

            foreach ($object->getFkFrotaVeiculoCombustiveis() as $veiculoCombustivel) {
                /** @var Frota\VeiculoCombustivel $veiculoCombustivel */
                $objVeiculoCombustivel = $veiculoCombustiveisModel->findOneBy([
                    'codVeiculo' => $object->getCodVeiculo(),
                    'codCombustivel' => $veiculoCombustivel->getCodCombustivel()
                ]);

                $em->remove($objVeiculoCombustivel);
            }

            $em->flush();
            $this->saveRelationships($object, $this->getForm());
            $this->redirect($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo/{$object->getCodVeiculo()}/edit");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var Frota\Veiculo $veiculo */
        $veiculo = $this->getSubject();

        $tipoVeiculo = ($veiculo->getFkFrotaVeiculoPropriedades() && $veiculo->getFkFrotaVeiculoPropriedades()->last() ? (
        $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaProprio() ? 'proprio' :
            ($veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ? 'terceiros' : 'default')
        ) : 'default');

        $documentosMes = [];

        foreach ($veiculo->getFkFrotaVeiculoDocumentos() as $documento) {
            $documentosMes[$documento->getCodDocumento()] = $entityManager->getRepository(Mes::class)->findOneBy([
                'codMes' => $documento->getMes()
            ]);
        }
        $veiculo->veiculo = $veiculo;
        $veiculo->veiculoCombustivel = $veiculo->getFkFrotaVeiculoCombustiveis();
        $veiculo->controleInterno = $veiculo->getFkFrotaControleInternos();
        $veiculo->cessoes = $veiculo->getFkFrotaVeiculoCessoes();
        $veiculo->documentos = $veiculo->getFkFrotaVeiculoDocumentos();
        $veiculo->documentosMes = $documentosMes;
        $veiculo->proprio = ($veiculo->getFkFrotaVeiculoPropriedades()->last() ?
            $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaProprio() : null);
        $veiculo->terceiros = ($veiculo->getFkFrotaVeiculoPropriedades()->last() ?
            $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() : null);
        $veiculo->utilizacao = $veiculo->getFkFrotaUtilizacoes()->last();
        $veiculo->terceirosHistorico = (
        $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
            $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros()->getFkFrotaTerceirosHistorico() : null
        );
        $veiculo->terceirosResponsavel = (
        $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
            $veiculo->getFkFrotaVeiculoTerceirosResponsaveis() : null
        );
        $veiculo->terceirosLocacao = (
        $veiculo->getFkFrotaVeiculoPropriedades()->last() && $veiculo->getFkFrotaVeiculoPropriedades()->last()->getFkFrotaTerceiros() ?
            $veiculo->getFkFrotaVeiculoLocacoes() : null
        );
        $veiculo->tipoVeiculo = $tipoVeiculo;

        $veiculo->isDisponivelParaBaixa = false;
        $veiculo->isDisponivelParaRetirada = false;
        $veiculo->isDisponivelParaRetorno = false;
        $veiculo->isDisponivelParaAdicao = false;
        $veiculo->isBaixado = false;

        if (true == is_null($veiculo->getFkFrotaVeiculoBaixado())) {
            $veiculo->isDisponivelParaBaixa = true;

            if (false == ($tipoVeiculo == 'proprio' || $tipoVeiculo == 'terceiros')) {
                $veiculo->isDisponivelParaAdicao = true;
            }

            if (true == $veiculo->getFkFrotaUtilizacoes()->isEmpty()) {
                $veiculo->isDisponivelParaRetirada = true;
            } else {
                /** @var Utilizacao $utilizacao */
                $utilizacao = $veiculo->getFkFrotaUtilizacoes()->last();

                if (false == is_null($utilizacao->getFkFrotaUtilizacaoRetorno())) {
                    $veiculo->isDisponivelParaRetirada = true;
                } else {
                    $veiculo->isDisponivelParaRetorno = true;
                }
            }
        } else {
            $veiculo->isBaixado = true;

            if (true == $veiculo->getFkFrotaUtilizacoes()->isEmpty()) {
                $veiculo->isDisponivelParaRetirada = true;
            }
            /** @var Utilizacao $utilizacao */
            $utilizacao = $veiculo->getFkFrotaUtilizacoes()->last();
            if ($utilizacao) {
                if (true == is_null($utilizacao->getFkFrotaUtilizacaoRetorno())) {
                    $veiculo->isDisponivelParaRetorno = true;
                }
            }
        }
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'consultar_restricoes_tipo_veiculo',
            'consultar-restricoes-tipo-veiculo/' . $this->getRouterIdParameter()
        );

        $collection->add(
            'consultar_marca_modelos',
            'consultar-marca-modelos/' . $this->getRouterIdParameter()
        );

        $collection->add(
            'consultar_veiculo_combustiveis',
            'consultar-veiculo-combustiveis/' . $this->getRouterIdParameter()
        );

        $collection->add(
            'get_km',
            'get-km/' . $this->getRouterIdParameter()
        );

        $collection->add(
            'consultar-dados-veiculo',
            'consultar-dados-veiculo/' . $this->getRouterIdParameter()
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('placa')
            ->add(
                'fkFrotaMarca',
                null,
                [
                    'label' => 'label.veiculo.codMarca',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Frota\Marca',
                    'choice_label' => 'nomMarca',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add(
                'fkFrotaModelo',
                'composite_filter',
                [
                    'label' => 'label.veiculo.codModelo',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Frota\Modelo',
                    'choice_label' => 'nomModelo',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'placa',
                'string',
                [
                    'label' => 'label.veiculo.placa'
                ]
            )
            ->add(
                'fkFrotaMarca',
                'text',
                [
                    'label' => 'label.veiculo.codMarca',
                ]
            )
            ->add(
                'fkFrotaModelo',
                'text',
                [
                    'label' => 'label.veiculo.codModelo'
                ]
            )
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'PatrimonialBundle:Sonata/Veiculo/CRUD:list__action_profile.html.twig'],
//                    'edit' => ['template' => 'PatrimonialBundle:Sonata/Veiculo/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig']
                ]
            ]);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $anoFabricacao1 = $this->getForm()->get('anoFabricacao')->getData();
        $anoFabricacao2 = (int) $anoFabricacao1 + 1;
        $anoModelo = $this->getForm()->get('anoModelo')->getData();
        $anoAquisicao = $this->getForm()->get('dtAquisicao')->getData()->format('Y');
        $placa = $this->getForm()->get('placa')->getData();
        $placaHidden = $this->getForm()->get('placaHidden')->getData();
        $prefixo = $this->getForm()->get('prefixo')->getData();
        $prefixoHidden = $this->getForm()->get('prefixoHidden')->getData();

        if ($anoModelo < $anoFabricacao1 || $anoModelo > $anoFabricacao2) {
            $error = $this->getTranslator()->trans('label.veiculo.msgErroAnoFabricacao', array('ano1' => $anoFabricacao1, 'ano2' => $anoFabricacao2));
            $errorElement->with('anoModelo')->addViolation($error)->end();
        }

        if ($anoFabricacao1 > $anoAquisicao) {
            $error = $this->getTranslator()->trans('label.veiculo.msgErroAnoModelo');
            $errorElement->with('dtAquisicao')->addViolation($error)->end();
        }

        $veiculoPlaca = $em->getRepository(Frota\Veiculo::class)->findOneBy(['placa' => strtoupper($placa)]);
        $veiculoPrefixo = $em->getRepository(Frota\Veiculo::class)->findOneBy(['prefixo' => $prefixo]);

        if (!$this->getSubject()) {
            if (!is_null($veiculoPlaca)) {
                $error = $this->getTranslator()->trans('label.veiculo.msgErroPlaca');
                $errorElement->with('placa')->addViolation($error)->end();
            }

            if (!is_null($veiculoPrefixo)) {
                $error = $this->getTranslator()->trans('label.veiculo.msgErroPrefixo');
                $errorElement->with('prefixo')->addViolation($error)->end();
            }
        } else {
            if ($placaHidden != $placa) {
                if (!is_null($veiculoPlaca)) {
                    $error = $this->getTranslator()->trans('label.veiculo.msgErroPlaca');
                    $errorElement->with('placa')->addViolation($error)->end();
                }
            }

            if ($prefixoHidden != $prefixo) {
                if (!is_null($veiculoPrefixo)) {
                    $error = $this->getTranslator()->trans('label.veiculo.msgErroPrefixo');
                    $errorElement->with('prefixo')->addViolation($error)->end();
                }
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['codMarca'] = [
            'class' => 'CoreBundle:Frota\Marca',
            'label' => 'label.veiculo.codMarca',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codModelo'] = [
            'class' => 'CoreBundle:Frota\Modelo',
            'label' => 'label.veiculo.codModelo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['verificado'] = [
            'label' => 'label.veiculo.verificado',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['fkFrotaVeiculoCombustiveis'] = [
            'class' => Frota\Combustivel::class,
            'label' => 'label.veiculo.codCombustivel',
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false
        ];

        $fieldOptions['placaHidden'] = [
            'mapped' => false
        ];

        $fieldOptions['prefixoHidden'] = [
            'mapped' => false
        ];

        if ($this->id($this->getSubject())) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa ControleInterno
            $controleInterno = $em->getRepository('CoreBundle:Frota\ControleInterno')->findOneByCodVeiculo($id);

            if (count($controleInterno) > 0) {
                $fieldOptions['verificado']['data'] = true;
            }

            $fieldOptions['placaHidden']['data'] = $this->getSubject()->getPlaca();
            $fieldOptions['prefixoHidden']['data'] = $this->getSubject()->getPrefixo();

            // Processa VeiculoCombustiveis
            $veiculoCombustiveisModel = new Model\Patrimonial\Frota\VeiculoCombustivelModel($em);
            $veiculoCombustiveis = $veiculoCombustiveisModel->findBy([
                'codVeiculo' => $id
            ]);

            $combustiveis = [];
            $combustiveisModel = new Model\Patrimonial\Frota\CombustivelModel($em);

            foreach ($veiculoCombustiveis as $combustivel) {
                /** @var Frota\VeiculoCombustivel $combustivel */
                $combustiveis[] = $combustiveisModel
                    ->findOneBy([
                        'codCombustivel' => $combustivel->getCodCombustivel()
                    ]);
            }

            if (count($combustiveis) > 0) {
                $fieldOptions['fkFrotaVeiculoCombustiveis']['data'] = $combustiveis;
            }

            $fieldOptions['codModelo']['data'] = $this->getSubject()->getFkFrotaModelo();
        }

        $formMapper
            ->add(
                'placaHidden',
                'hidden',
                $fieldOptions['placaHidden']
            )
            ->add(
                'prefixoHidden',
                'hidden',
                $fieldOptions['prefixoHidden']
            )
            ->add(
                'fkFrotaMarca',
                'entity',
                $fieldOptions['codMarca']
            )
            ->add(
                'fkFrotaModelo',
                'entity',
                $fieldOptions['codModelo']
            )
            ->add(
                'fkFrotaTipoVeiculo',
                'entity',
                array(
                    'class' => 'CoreBundle:Frota\TipoVeiculo',
                    'label' => 'label.veiculo.codTipoVeiculo',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                )
            )
            ->add(
                'fkFrotaVeiculoCombustiveis',
                'entity',
                $fieldOptions['fkFrotaVeiculoCombustiveis']
            )
            ->add(
                'placa',
                'text',
                [
                    'label' => 'label.veiculo.placa',
                    'required' => true,
                    'attr' => [
                        'maxlength' => 7,
                        'data-mask' => 'SSS0000'
                    ]
                ]
            )
            ->add(
                'prefixo',
                'text',
                [
                    'label' => 'label.veiculo.prefixo',
                    'required' => false
                ]
            )
            ->add(
                'chassi',
                'text',
                [
                    'label' => 'label.veiculo.chassi',
                    'required' => false
                ]
            )
            ->add(
                'kmInicial',
                'text',
                [
                    'label' => 'label.veiculo.kmInicial',
                    'required' => false,
                    'attr' => [
                        'class' => 'km '
                    ]
                ]
            )
            ->add(
                'numCertificado',
                'text',
                [
                    'label' => 'label.veiculo.numCertificado',
                    'required' => false,
                    'attr' => [
                        'maxlength' => 14,
                        'class' => 'numero '
                    ]
                ]
            )
            ->add(
                'anoFabricacao',
                'text',
                [
                    'label' => 'label.veiculo.anoFabricacao',
                    'attr' => [
                        'class' => 'ano '
                    ]

                ]
            )
            ->add(
                'anoModelo',
                'text',
                [
                    'label' => 'label.veiculo.anoModelo',
                    'attr' => [
                        'class' => 'ano '
                    ]
                ]
            )
            ->add(
                'categoria',
                'text',
                [
                    'label' => 'label.veiculo.categoria',
                    'required' => false
                ]
            )
            ->add(
                'capacidade',
                'text',
                [
                    'label' => 'label.veiculo.capacidade',
                    'required' => false
                ]
            )
            ->add(
                'potencia',
                'text',
                [
                    'label' => 'label.veiculo.potencia',
                    'required' => false
                ]
            )
            ->add(
                'cilindrada',
                'text',
                [
                    'label' => 'label.veiculo.cilindrada',
                    'required' => false
                ]
            )
            ->add(
                'numPassageiro',
                'number',
                [
                    'label' => 'label.veiculo.numPassageiro',
                    'required' => false,
                    'attr' => [
                        'class' => 'numero '
                    ]
                ]
            )
            ->add(
                'capacidadeTanque',
                'number',
                [
                    'label' => 'label.veiculo.capacidadeTanque',
                    'attr' => [
                        'class' => 'numero '
                    ]
                ]
            )
            ->add(
                'cor',
                'text',
                [
                    'label' => 'label.veiculo.cor',
                    'required' => false
                ]
            )
            ->add(
                'dtAquisicao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.veiculo.dtAquisicao'
                ]
            )
            ->add(
                'fkSwCategoriaHabilitacao',
                'entity',
                array(
                    'class' => 'CoreBundle:SwCategoriaHabilitacao',
                    'label' => 'label.veiculo.codCategoria',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                )
            )
            ->add(
                'verificado',
                'checkbox',
                $fieldOptions['verificado']
            );
    }
}
