<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Folhapagamento\TabelaIrrfEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\TabelaIrrfModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class TabelaIrrfAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_tabela_irrf';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/irrf/tabela-irrf';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'vigencia',
                'doctrine_orm_date',
                [
                    'field_type' => 'sonata_type_date_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.vigencia'
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
            ->add('vigencia')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'RecursosHumanosBundle:Sonata/Folhapagamento/Tabelairrf/CRUD:list__action_profile.html.twig'],
//                    'edit' => ['template' => 'PatrimonialBundle:Sonata/Veiculo/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig']
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $informativo = 'I';
        $desconto = 'D';
        $base = 'B';

        $eventos = [
            ['natureza' => $desconto, 'label' => 'label.irrf.evento3', 'data' => null],
            ['natureza' => $base, 'label' => 'label.irrf.evento4', 'data' => null],
            ['natureza' => $base, 'label' => 'label.irrf.evento5', 'data' => null],
            ['natureza' => $desconto, 'label' => 'label.irrf.evento6', 'data' => null],
            ['natureza' => $base, 'label' => 'label.irrf.evento7', 'data' => null]
        ];

        $dataEvento1 = null;
        $dataEvento2 = null;
        if (!is_null($id)) {
            /** @var TabelaIrrf $tabelaIrrf */
            $tabelaIrrf = $this->getSubject();
            $numeroEvento = 0;
            foreach ($tabelaIrrf->getFkFolhapagamentoTabelaIrrfEventos() as $fkEvento) {
                $tipoEvento = $fkEvento->getCodTipo();
                if ($tipoEvento > 2) {
                    $eventos[$numeroEvento]['data'] = $fkEvento;
                    $numeroEvento++;
                }
                if ($tipoEvento == 1) {
                    $dataEvento1 = $fkEvento;
                }
                if ($tipoEvento == 2) {
                    $dataEvento2 = $fkEvento;
                }
            }
        } else {
            $container = $this->getConfigurationPool()->getContainer();
            /** @var TabelaIrrfModel $tabelaIrrfModel */
            $tabelaIrrfModel = new TabelaIrrfModel($entityManager);
            $getTabelaIrrfYear = $tabelaIrrfModel->getTabelaIrrfYear();
            if (count($getTabelaIrrfYear) > 0) {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.irrf.errorCreated'));
                $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/list');
                return false;
            }
        }

        $fieldOptions['vlDependente'] = [
            'label' => 'label.irrf.vlDependente',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money ',
                'maxlength' => 18
            )
        ];

        $fieldOptions['vlLimiteIsencao'] = [
            'label' => 'label.irrf.vlLimiteIsencao',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money ',
                'maxlength' => 18
            )
        ];

        $formMapper
            ->with('label.irrf.dadosTabela')
            ->add('vlDependente', 'money', $fieldOptions['vlDependente'])
            ->add('evento1', 'entity', $this->addFieldNatureza('label.irrf.eventoDependente', $informativo, $dataEvento1))
            ->add('vlLimiteIsencao', 'money', $fieldOptions['vlLimiteIsencao'])
            ->add('evento2', 'entity', $this->addFieldNatureza('label.irrf.eventoIsencao', $informativo, $dataEvento2))
            ->add(
                'vigencia',
                'sonata_type_date_picker',
                [
                    'mapped' => true,
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.vigencia',
                    'required' => true
                ]
            );

        $numeroEvento = 2;
        foreach ($eventos as $key => $evento) {
            $numeroEvento++;
            $formMapper
                ->add(
                    'evento' . $numeroEvento,
                    'entity',
                    $this->addFieldNatureza($evento['label'], $evento['natureza'], $evento['data'])
                );
        }
        $formMapper->end();
    }

    /**
     * @param $label
     * @param $natureza
     * @param null $value
     * @return array
     */
    public function addFieldNatureza($label, $natureza, $value = null)
    {
        $field = [
            'class' => Evento::class,
            'label' => $label,
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'choice_value' => 'codEvento',
            'query_builder' => function (EntityRepository $entityManager) use ($natureza) {
                $qb = $entityManager->createQueryBuilder('e');
                $qb->innerJoin('e.fkFolhapagamentoEventoEventos', 'ee');
                $qb->leftJoin('e.fkFolhapagamentoSequenciaCalculoEventos', 'sce');
                $qb->where('e.natureza = :natureza');
                $qb->andWhere('e.eventoSistema = true')
                    ->setParameter(':natureza', $natureza);

                return $qb;
            },
            'placeholder' => 'label.selecione',
            'data' => !empty($eventoArray) ? $eventoArray[1] : null,
            'mapped' => false
        ];

        if (!is_null($value)) {
            $field['data'] = $value;
        }

        return $field;
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     */
    public function prePersist($tabelaIrrf)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $tabelaIrrfModel = new TabelaIrrfModel($entityManager);
        $codTabela = $tabelaIrrfModel->getProximoCodTabela($tabelaIrrf->getTimestamp());

        $tabelaIrrf->setCodTabela($codTabela);
    }

    /**
     * @param mixed $tabelaIrrf
     */
    public function postPersist($tabelaIrrf)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var TabelaIrrfEventoModel $tabelaIrrfEventoModel */
        $tabelaIrrfEventoModel = new TabelaIrrfEventoModel($entityManager);

        $formData = $this->getForm();

        $totalEvent = 7;
        for ($i = 1; $i <= $totalEvent; $i++) {
            $tipoEvento = $entityManager->getRepository(TipoEventoIrrf::class)->findOneBy(['codTipo' => $i]);
            $evento = $formData->get('evento' . $i)->getData();
            $tabelaIrrfEventoModel->buildOneBasedTabelaIrrf($tipoEvento, $tabelaIrrf, $evento);
        }
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     */
    public function preUpdate($tabelaIrrf)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $oldObject = $entityManager->getUnitOfWork()->getOriginalEntityData($tabelaIrrf);

        $tabelaIrrfModel = new TabelaIrrfModel($entityManager);
        if ($oldObject['vigencia'] != $tabelaIrrf->getVigencia()) {
            $newObject = $tabelaIrrfModel->cloneTabelaIrrf($tabelaIrrf);
            $tabelaIrrf->setVigencia($oldObject['vigencia']);
            $tabelaIrrf->setVlLimiteIsencao($oldObject['vlLimiteIsencao']);
            $tabelaIrrf->setVlDependente($oldObject['vlDependente']);
            $entityManager->persist($tabelaIrrf);
            $entityManager->persist($newObject);
            $entityManager->flush($newObject);

            $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/list');
        }
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     */
    public function postUpdate($tabelaIrrf)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        /** @var TabelaIrrfEventoModel $tabelaIrrfEventoModel */
        $tabelaIrrfEventoModel = new TabelaIrrfEventoModel($entityManager);

        $formData = $this->getForm();

        $totalEvent = 7;
        for ($i = 1; $i <= $totalEvent; $i++) {
            $tipoEvento = $entityManager->getRepository(TipoEventoIrrf::class)->findOneBy(['codTipo' => $i]);
            $evento = $formData->get('evento' . $i)->getData();
            $timestamp = $tabelaIrrf->getTimestamp();
            $tabelaIrrfEventoModel->buildOneBasedTabelaIrrf($tipoEvento, $tabelaIrrf, $evento, $timestamp);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var TabelaIrrf $object */
        $object = $this->getSubject();
        $codTabela = $object->getCodTabela();
        $timestamp = $object->getTimestamp();

        $eventoDependente = $entityManager->getRepository(TabelaIrrfEvento::class)->findOneBy(['codTabela' => $codTabela, 'codTipo' => 1, 'timestamp' => $timestamp]);
        $eventoIsencao = $entityManager->getRepository(TabelaIrrfEvento::class)->findOneBy(['codTabela' => $codTabela, 'codTipo' => 2, 'timestamp' => $timestamp]);
        $eventos = $entityManager->getRepository(TabelaIrrfEvento::class)->findby(['codTabela' => $codTabela, 'timestamp' => $timestamp]);

        $object->tabelaIrrf = $object;
        $object->eventoDependente = $eventoDependente;
        $object->eventoIsencao = $eventoIsencao;
        $object->eventos = $eventos;
        $object->tabelaIrrfCids = $object->getFkFolhapagamentoTabelaIrrfCids();
        $object->tabelaIrrfComprovanteRendimentos = $object->getFkFolhapagamentoTabelaIrrfComprovanteRendimentos();
        $object->faixaDescontoIrrfs = $object->getFkFolhapagamentoFaixaDescontoIrrfs();
    }
}
