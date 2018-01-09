<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Model\Folhapagamento\DescontoExternoIrrfModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class DescontoExternoIrrfAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_irrf_desconto_externo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/irrf/desconto-externo';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $descontoExternoModel = new DescontoExternoIrrfModel($em);

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
                    'class' => Pessoal\Contrato::class,
                    'route' => [
                        'name' => 'carrega_contrato'
                    ],
                    'json_choice_label' => function ($contrato) use ($em) {
                        return $contrato->getFkPessoalContratoServidor()
                            ->getFkPessoalServidorContratoServidores()->last()
                            ->getFkPessoalServidor()
                            ->getFkSwCgmPessoaFisica()
                            ->getFkSwCgm()
                            ->getNomcgm();
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
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

        $listMapper
            ->add(
                'fkPessoalContrato',
                null,
                [
                    'label' => 'label.matricula',
                    'associated_property' => function ($fkPessoalContrato) {
                        return $fkPessoalContrato->getRegistro()
                            . " - " . $fkPessoalContrato->getFkPessoalContratoServidor()
                                ->getFkPessoalServidorContratoServidores()->last()
                                ->getFkPessoalServidor()
                                ->getFkSwCgmPessoaFisica()
                                ->getFkSwCgm()
                                ->getNomcgm();
                    }
                ]
            )
            ->add(
                'vlBaseIrrf',
                'decimal',
                [
                    'label' => 'label.irrf.vlBaseIrrf',
                    'attributes' => ['fraction_digits' => 2],
                    'textAttributes' => ['negative_prefix' => 'MINUS']
                ]
            )
            ->add('vigencia', null, ['label' => 'label.vigencia']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['valorIrrf'] = [
            'attr' => ['class' => 'money '],
            'label' => 'label.irrf.valorIrrf',
            'mapped' => false,
            'required' => false,
            'grouping' => false,
            'currency' => 'BRL',
        ];

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

        if (!is_null($id)) {
            $descontoExternoIrrf = $this->getSubject();
            $descontoExternoIrrfValor = $em->getRepository('CoreBundle:Folhapagamento\DescontoExternoIrrfValor')
                ->findOneBy([
                    'timestamp' => $descontoExternoIrrf->getTimestamp(),
                    'codContrato' => $descontoExternoIrrf->getCodContrato(),
                ]);

            $valorIrrf = is_null($descontoExternoIrrfValor) ? null : $descontoExternoIrrfValor->getValorIrrf();

            if (!is_null($valorIrrf)) {
                $fieldOptions['valorIrrf']['data'] = $valorIrrf;
            }
        }

        $formMapper
            ->with('label.irrf.descontoExternoIrrf')
            ->add('fkPessoalContrato', 'autocomplete', $fieldOptions['codContrato'])
            ->add('vlBaseIrrf', 'money', [
                'grouping' => false,
                'currency' => 'BRL',
                'attr' => ['class' => 'money '],
                'label' => 'label.irrf.vlBaseIrrf'
            ])
            ->add('valorIrrf', 'money', $fieldOptions['valorIrrf'])
            ->add('vigencia', 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
                'label' => 'label.vigencia'
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $codContrato = $this->getSubject()->getCodContrato();

        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = $em->getRepository('CoreBundle:Pessoal\ContratoServidor')
            ->findOneByCodContrato($codContrato);

        $codContratoServidorName = $contratoServidor->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm();

        $showMapper
            ->with('label.irrf.descontoExternoIrrf')
            ->add('matricula', null, [
                'data' => $codContratoServidorName,
                'label' => 'label.matricula',
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
            ])
            ->add(
                'vlBaseIrrf',
                'currency',
                [
                    'label' => 'label.irrf.vlBaseIrrf',
                    'currency' => 'BRL'
                ]
            )
            ->add('vigencia', 'date', ['label' => 'label.vigencia']);

        $descontoExternoIrrf = $this->getSubject();
        $descontoExternoIrrfValor = $em->getRepository('CoreBundle:Folhapagamento\DescontoExternoIrrfValor')
            ->findOneBy([
                'timestamp' => $descontoExternoIrrf->getTimestamp(),
                'codContrato' => $descontoExternoIrrf->getCodContrato(),
            ]);

        $valorIrrf = is_null($descontoExternoIrrfValor) ? null : $descontoExternoIrrfValor->getValorIrrf();

        if (!is_null($valorIrrf)) {
            $showMapper->add('valorIrrf', 'currency', [
                'data' => $valorIrrf,
                'label' => 'label.irrf.valorIrrf',
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                'currency' => 'BRL'
            ]);
        }

        $showMapper->add('timestamp', 'datetime', ['label' => 'label.timestamp'])->end();
    }

    /**
     * @param Folhapagamento\DescontoExternoIrrf $descontoExternoIrrf
     */
    public function postPersist($descontoExternoIrrf)
    {
        $valorIrrf = $this->getForm()->get('valorIrrf')->getData();

        if (!is_null($valorIrrf)) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $descontoExternoIrrfValor = new Folhapagamento\DescontoExternoIrrfValor();
            $descontoExternoIrrfValor->setFkFolhapagamentoDescontoExternoIrrf($descontoExternoIrrf);
            $descontoExternoIrrfValor->setValorIrrf($valorIrrf);
            $descontoExternoIrrf->addFkFolhapagamentoDescontoExternoIrrfValores($descontoExternoIrrfValor);

            $em->persist($descontoExternoIrrfValor);
            $em->flush();
        }
    }

    public function preUpdate($descontoExternoIrrf)
    {
        $valorIrrf = $this->getForm()->get('valorIrrf')->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $descontoExternoIrrfValor = $em->getRepository('CoreBundle:Folhapagamento\descontoExternoIrrfValor')
            ->findOneBy([
                'timestamp' => $descontoExternoIrrf->getTimestamp(),
                'codContrato' => $descontoExternoIrrf->getCodContrato(),
            ]);

        if (is_null($descontoExternoIrrfValor)) {
            $descontoExternoIrrfValor = new Folhapagamento\DescontoExternoIrrfValor();
        }

        $descontoExternoIrrfValor->setFkFolhapagamentoDescontoExternoIrrf($descontoExternoIrrf);
        $descontoExternoIrrfValor->setValorIrrf($valorIrrf);

        $em->persist($descontoExternoIrrfValor);
        $em->flush();
    }

    /**
     * @param Folhapagamento\DescontoExternoIrrf $descontoExternoIrrf
     */
    public function preRemove($descontoExternoIrrf)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $descModel = new DescontoExternoIrrfModel($em);
        /** @var Folhapagamento\DescontoExternoIrrfAnulado $descontoExternoIrrfAnulado */
        $descontoExternoIrrfAnulado = new Folhapagamento\DescontoExternoIrrfAnulado();
        $descontoExternoIrrfAnulado->setFkFolhapagamentoDescontoExternoIrrf($descontoExternoIrrf);
        $descModel->save($descontoExternoIrrfAnulado);

        $message = $this->trans('rh.descontoExternoPrevidencia.delete', [], 'flashes');
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('success', $message);
        (new RedirectResponse("/recursos-humanos/folha-pagamento/irrf/desconto-externo/list"))->send();
    }
}
