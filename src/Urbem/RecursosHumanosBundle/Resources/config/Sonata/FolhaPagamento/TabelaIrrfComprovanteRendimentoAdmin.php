<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class TabelaIrrfComprovanteRendimentoAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class TabelaIrrfComprovanteRendimentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_comprovante_rendimento';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/irrf/tabela-irrf-comprovante-rendimento';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTabela')
            ->add('timestamp')
            ->add('codEvento')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codTabela')
            ->add('timestamp')
            ->add('codEvento')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['evento'] = [
            'class' => Evento::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $natureza = ['P','D'];
                $qb = $repo->createQueryBuilder('e');
                $qb->innerJoin('e.fkFolhapagamentoEventoEventos', 'ee');
                $qb->leftJoin('e.fkFolhapagamentoSequenciaCalculoEventos', 'sce');
                $qb->where($qb->expr()->in("e.natureza", $natureza));
                $qb->andWhere('e.eventoSistema = true');

                if (!is_numeric($term)) {
                    $qb->where(
                        $qb->expr()->like(
                            $qb->expr()->lower('e.descricao'),
                            $qb->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $qb->where('e.codEvento = :term')
                        ->setParameter('term', $term);
                }

                return $qb;
            },
            'json_choice_label' => function (Evento $evento) {
                $name = $evento->getCodEvento() . ' - ' . $evento->getDescricao();
                return (string) $name;
            },
            'label' => 'label.irrf.comprovanteRendimento.evento',
            'required' => true,
        ];

        $fieldOptions['idTabelaIrrf'] = [
            'mapped' => false,
            'required' => false,
            'data' => $id
        ];

        $formMapper
            ->add('fkFolhapagamentoEvento', 'autocomplete', $fieldOptions['evento'])
            ->add('idTabelaIrrf', 'hidden', $fieldOptions['idTabelaIrrf'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codTabela')
            ->add('timestamp')
            ->add('codEvento')
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     */
    public function validate(ErrorElement $errorElement, $tabelaIrrfComprovanteRendimento)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $oldObject = $entityManager->getUnitOfWork()->getOriginalEntityData($tabelaIrrfComprovanteRendimento);

        $oldCodEvento = 0;
        if (!empty($oldObject)) {
            $oldCodEvento = $oldObject['codEvento'];
        }

        $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();

        if (is_null($tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf())) {
            list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        } else {
            $codTabela = $tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf()->getCodTabela();
            $timestamp = $tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf()->getTimestamp();
        }

        $codEvento = $tabelaIrrfComprovanteRendimento->getCodEvento();

        $findEvento = $entityManager->getRepository(TabelaIrrfComprovanteRendimento::class)->findOneBy(['codEvento' => $codEvento,'codTabela' => $codTabela, 'timestamp' => $timestamp]);

        if (!is_null($findEvento) && $oldCodEvento != $codEvento) {
            $error = $this->getTranslator()->trans('tabelaIrrf.errors.eventoRepetido', [], 'validators');
            $errorElement->with('fkFolhapagamentoEvento')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
        }
    }

    /**
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     */
    public function prePersist($tabelaIrrfComprovanteRendimento)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();

        list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        $tabelaIrrf = $entityManager->getRepository(TabelaIrrf::class)->findOneBy(['codTabela' => $codTabela, 'timestamp' => $timestamp]);

        $tabelaIrrfComprovanteRendimento->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);
    }

    /**
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     */
    public function postPersist($tabelaIrrfComprovanteRendimento)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     */
    public function postUpdate($tabelaIrrfComprovanteRendimento)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     */
    public function postRemove($tabelaIrrfComprovanteRendimento)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfComprovanteRendimento->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }
}
