<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaAnulado;
use Urbem\CoreBundle\Entity\Folhapagamento\DescontoExternoPrevidenciaValor;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Folhapagamento\DescontoExternoPrevidenciaModel;

class DescontoExternoPrevidenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_desconto_externo_previdencia';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/desconto-externo-previdencia';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $descontoExternoModel = new DescontoExternoPrevidenciaModel($em);

        $query = parent::createQuery($context);
        $query = $descontoExternoModel->getDescontoExternoNotInAnulado($query);

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $datagridMapper
            ->add(
                'fkPessoalContrato',
                'doctrine_orm_callback',
                [
                    'label' => 'label.matricula',
                    'callback' => [$this, 'getSearchFilter']
                ],
                'autocomplete',
                [
                    'class' => Contrato::class,
                    'route' => [
                        'name' => 'carrega_contrato'
                    ],
                    'json_choice_label' => function ($contrato) use ($em) {
                        if (!is_null($contrato->getFkPessoalContratoServidor())) {
                            $nomcgm = $contrato->getFkPessoalContratoServidor()
                                ->getFkPessoalServidorContratoServidores()->last()
                                ->getFkPessoalServidor()
                                ->getFkSwCgmPessoaFisica()
                                ->getFkSwCgm()
                                ->getNomcgm();
                        } else {
                            $nomcgm = "Não localizado";
                        }
                        return $nomcgm;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'vigencia',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.vigencia'
                ]
            );
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        $codContrato = $filter['fkPessoalContrato']['value'];

        $queryBuilder->andWhere("o.codContrato = $codContrato");

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $contratoServidor = $this->modelManager->getEntityManager('CoreBundle:Pessoal\ContratoServidor');

        $listMapper
            ->add(
                'fkPessoalContrato',
                'entity',
                [
                    'label' => 'Servidor',
                    'associated_property' => function ($codigoGravado) use ($contratoServidor) {

                        $contratoServidorModel = new ContratoServidorModel($contratoServidor);
                        $cgm = $contratoServidorModel->findOneByCodContrato($codigoGravado);

                        return empty($cgm) ? "Servidor não informado" : $cgm->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm();
                    }
                ]
            )
            ->add(
                'vlBasePrevidencia',
                'decimal',
                [
                    'label' => 'label.vrBasePrevidencia',
                    'attributes' => ['fraction_digits' => 2],
                    'textAttributes' => ['negative_prefix' => 'MINUS']
                ]
            )
            ->add(
                'vigencia',
                null,
                [
                    'label' => 'label.vigencia'
                ]
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $valorDescontoPrevidencia = 0;

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions['vlDescontoPrev'] = [
            'attr' => ['class' => 'money '],
            'label' => 'label.vrDescontoPrevidencia',
            'mapped' => false,
            'required' => false,
            'grouping' => false,
            'currency' => 'BRL',
        ];


        if (!is_null($id)) {
            /** @var DescontoExternoPrevidencia $descontoExterno */
            $descontoExterno = $this->getSubject();

            /** @var DescontoExternoPrevidenciaValor $descontoExternoPrevidenciaValor */
            $descontoExternoPrevidenciaValor = $em->getRepository('CoreBundle:Folhapagamento\DescontoExternoPrevidenciaValor')->findOneBy([
                'timestamp' => $descontoExterno->getTimestamp(),
                'codContrato' => $descontoExterno->getFkPessoalContrato()->getCodContrato(),
            ]);

            $valorExterno = is_null($descontoExternoPrevidenciaValor) ? null : $descontoExternoPrevidenciaValor->getValorPrevidencia();

            if (!is_null($valorExterno)) {
                $fieldOptions['vlDescontoPrev']['data'] = $valorExterno;
            }
        }

        $fieldOptions['codContrato'] = array(
            'label' => 'label.gerarAssentamento.inContrato',
            'route' => array(
                'name' => 'carrega_contrato'
            ),
            'class' => 'CoreBundle:Pessoal\Contrato',
            'json_choice_label' => function ($contrato) {
                return $contrato->getRegistro()
                    . " - "
                    . $contrato->getCodContrato()
                    . " - "
                    . $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
        );

        $formMapper
            ->with('DescontoExternoPrevidencia')
            ->add('fkPessoalContrato', 'autocomplete', $fieldOptions['codContrato'])
            ->add(
                'vlBasePrevidencia',
                'money',
                [
                    'attr' => [
                        'class' => 'money '
                    ],
                    'currency' => 'BRL',
                    'label' => 'label.vrBasePrevidencia'
                ]
            )
            ->add('vlDescontoPrev', 'money', $fieldOptions['vlDescontoPrev'])
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.vigencia'
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $codContrato = $this->getSubject()->getFkPessoalContrato()->getCodContrato();

        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = $em->getRepository('CoreBundle:Pessoal\ContratoServidor')
            ->findOneByCodContrato($codContrato);

        $codContratoServidorName = $contratoServidor->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm();

        $showMapper
            ->add('matricula', null, [
                'data' => $codContratoServidorName,
                'label' => 'label.matricula',
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
            ])
            ->add('vlBasePrevidencia', 'decimal', [

                'label' => 'label.vrBasePrevidencia',
            ]);

        /** @var DescontoExternoPrevidencia $descontoExternoPrevidencia */
        $descontoExternoPrevidencia = $this->getSubject();
        /** @var DescontoExternoPrevidenciaValor $descontoExternoValor */
        $descontoExternoValor = $em->getRepository('CoreBundle:Folhapagamento\DescontoExternoPrevidenciaValor')
            ->findOneBy([
                'timestamp' => $descontoExternoPrevidencia->getTimestamp(),
                'codContrato' => $descontoExternoPrevidencia->getCodContrato(),
            ]);

        $valorPrevidencia = is_null($descontoExternoValor) ? null : $descontoExternoValor->getValorPrevidencia();
        if (!is_null($valorPrevidencia)) {
            $showMapper->add('valorIrrf', 'currency', [
                'data' => $valorPrevidencia,
                'label' => 'label.descontoExternoValor',
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                'currency' => 'BRL'
            ]);
        }
        $showMapper->add('vigencia');
    }

    /**
     * @param DescontoExternoPrevidencia $descontoExternoPrevidencia
     */
    public function preUpdate($descontoExternoPrevidencia)
    {
        $this->codContratoHandling($descontoExternoPrevidencia);
    }

    /**
     * @param DescontoExternoPrevidencia $descontoExternoPrevidencia
     */
    public function postPersist($descontoExternoPrevidencia)
    {
        $this->codContratoHandling($descontoExternoPrevidencia);
    }

    /**
     * @param DescontoExternoPrevidencia $descontoExternoPrevidencia
     */
    public function codContratoHandling($descontoExternoPrevidencia)
    {

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $valordesconto = $formData['vlDescontoPrev'];

        /** @var DescontoExternoPrevidenciaValor $descontoExternoPrevidenciaValor */
        $descontoExternoPrevidenciaValor = $entityManager->getRepository('CoreBundle:Folhapagamento\DescontoExternoPrevidenciaValor')
            ->findOneBy([
                'timestamp' => $descontoExternoPrevidencia->getTimestamp(),
                'codContrato' => $descontoExternoPrevidencia->getCodContrato(),
            ]);
        if ($descontoExternoPrevidenciaValor) {
            $descontoExternoPrevidenciaValor->setValorPrevidencia($valordesconto);
            $entityManager->persist($descontoExternoPrevidenciaValor);
            $entityManager->flush();
        } else {
            $descModel = new DescontoExternoPrevidenciaModel($entityManager);
            /** @var DescontoExternoPrevidenciaValor $vlrDesconto */
            $vlrDesconto = new DescontoExternoPrevidenciaValor();
            $vlrDesconto->setFkFolhapagamentoDescontoExternoPrevidencia($descontoExternoPrevidencia);
            $vlrDesconto->setValorPrevidencia($valordesconto);
            $vlrDesconto->setTimestampValor($descontoExternoPrevidencia->getTimestamp());
            $descModel->saveDescExtPrevValor($vlrDesconto);
        }
    }

    /**
     * @param DescontoExternoPrevidencia $descontoExternoPrevidencia
     */
    public function preRemove($descontoExternoPrevidencia)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $descModel = new DescontoExternoPrevidenciaModel($em);
        /** @var DescontoExternoPrevidenciaAnulado $descontoExternoPrevidenciaAnulado */
        $descontoExternoPrevidenciaAnulado = new DescontoExternoPrevidenciaAnulado();
        $descontoExternoPrevidenciaAnulado->setFkFolhapagamentoDescontoExternoPrevidencia($descontoExternoPrevidencia);
        $descModel->save($descontoExternoPrevidenciaAnulado);

        $message = $this->trans('rh.descontoExternoPrevidencia.delete', [], 'flashes');
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('success', $message);
        (new RedirectResponse("/recursos-humanos/folha-pagamento/desconto-externo-previdencia/list"))->send();
    }
}
