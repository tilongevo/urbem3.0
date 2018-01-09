<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GuzzleHttp\Psr7\Request;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid;
use Urbem\CoreBundle\Entity\Pessoal\Cid;
use Urbem\CoreBundle\Entity\Pessoal\TipoDeficiencia;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class TabelaIrrfCidAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class TabelaIrrfCidAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_tabela_irrf_cid';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/irrf/tabela-irrf-cid';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCid')
            ->add('codTabela')
            ->add('timestamp')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codCid')
            ->add('codTabela')
            ->add('timestamp');

        $this->addActionsGrid($listMapper);
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

        $fieldOptions['cid'] = [
            'class' => Cid::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, \Symfony\Component\HttpFoundation\Request $request) {

                $qb = $repo->createQueryBuilder('o');
                $qb->join(TipoDeficiencia::class, 'td')
                    ->andWhere('LOWER(o.descricao) LIKE LOWER(:nomDescricao)')
                    ->orWhere('LOWER(o.sigla) LIKE LOWER(:nomDescricao)')
                    ->setParameter('nomDescricao', "%{$term}%");
                return $qb;
            },
            'json_choice_label' => function (Cid $cid) {
                $name = $cid->getSigla() . ' - ' . $cid->getDescricao();
                return (string) $name;
            },
            'label' => 'label.irrf.cid.cidSelect',
            'required' => true,
        ];

        $fieldOptions['idTabelaIrrf'] = [
            'mapped' => false,
            'required' => false,
            'data' => $id
        ];

        $formMapper
            ->add('fkPessoalCid', 'autocomplete', $fieldOptions['cid'])
            ->add('idTabelaIrrf', 'hidden', $fieldOptions['idTabelaIrrf'])
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param TabelaIrrfCid $tabelaIrrfCid
     */
    public function validate(ErrorElement $errorElement, $tabelaIrrfCid)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $oldObject = $entityManager->getUnitOfWork()->getOriginalEntityData($tabelaIrrfCid);

        $oldCodCid = 0;
        if (!empty($oldObject)) {
            $oldCodCid = $oldObject['codCid'];
        }

        $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();

        if (is_null($tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf())) {
            list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        } else {
            $codTabela = $tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf()->getCodTabela();
            $timestamp = $tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf()->getTimestamp();
        }

        $codCid = $tabelaIrrfCid->getCodCid();

        $findCid = $entityManager->getRepository(TabelaIrrfCid::class)->findOneBy(['codCid' => $codCid,'codTabela' => $codTabela, 'timestamp' => $timestamp]);

        if (!is_null($findCid) && $oldCodCid != $codCid) {
            $error = $this->getTranslator()->trans('tabelaIrrf.errors.cidRepetido', [], 'validators');
            $errorElement->with('fkPessoalCid')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
        }
    }

    /**
     * @param TabelaIrrfCid $tabelaIrrfCid
     */
    public function prePersist($tabelaIrrfCid)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();

        list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        $tabelaIrrf = $entityManager->getRepository(TabelaIrrf::class)->findOneBy(['codTabela' => $codTabela, 'timestamp' => $timestamp]);

        $tabelaIrrfCid->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);
    }

    /**
     * @param mixed $tabelaIrrfCid
     */
    public function postPersist($tabelaIrrfCid)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param TabelaIrrfCid $tabelaIrrfCid
     */
    public function postUpdate($tabelaIrrfCid)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param TabelaIrrfCid $tabelaIrrfCid
     */
    public function postRemove($tabelaIrrfCid)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($tabelaIrrfCid->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('codCid')
            ->add('codTabela')
            ->add('timestamp')
        ;
    }
}
