<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Model\Folhapagamento\FaixaDescontoIrrfModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class FaixaDescontoIrrfAdmin
 * @package Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento
 */
class FaixaDescontoIrrfAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_faixa_desconto_irrf';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/irrf/faixa-desconto-irrf';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codFaixa')
            ->add('codTabela')
            ->add('timestamp')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('aliquota')
            ->add('parcelaDeduzir')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codFaixa')
            ->add('codTabela')
            ->add('timestamp')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('aliquota')
            ->add('parcelaDeduzir')
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
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['vlInicial'] = [
            'label' => 'label.irrf.faixaDesconto.vlInicial',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['vlFinal'] = [
            'label' => 'label.irrf.faixaDesconto.vlFinal',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['aliquota'] = [
            'label' => 'label.irrf.faixaDesconto.aliquota',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['parcelaDeduzir'] = [
            'label' => 'label.irrf.faixaDesconto.deduzir',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['idTabelaIrrf'] = [
            'mapped' => false,
            'required' => false,
            'data' => $id
        ];

        $formMapper
            ->add('vlInicial', 'money', $fieldOptions['vlInicial'])
            ->add('vlFinal', 'money', $fieldOptions['vlFinal'])
            ->add('aliquota', 'money', $fieldOptions['aliquota'])
            ->add('parcelaDeduzir', 'money', $fieldOptions['parcelaDeduzir'])
            ->add('idTabelaIrrf', 'hidden', $fieldOptions['idTabelaIrrf'])
        ;
    }

    /**
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     */
    public function prePersist($faixaDescontoIrrf)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();

        list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        $tabelaIrrf = $entityManager->getRepository(TabelaIrrf::class)->findOneBy(['codTabela' => $codTabela, 'timestamp' => $timestamp]);

        $faixaDescontoIrrf->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);


        $faixaDescontoIrrfModel = new FaixaDescontoIrrfModel($entityManager);
        $codFaixa = $faixaDescontoIrrfModel->getProximoCodFaixa();

        $faixaDescontoIrrf->setCodFaixa($codFaixa);
    }

    /**
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     */
    public function postPersist($faixaDescontoIrrf)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($faixaDescontoIrrf->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     */
    public function postUpdate($faixaDescontoIrrf)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($faixaDescontoIrrf->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     */
    public function postRemove($faixaDescontoIrrf)
    {
        $this->forceRedirect('/recursos-humanos/folha-pagamento/irrf/tabela-irrf/' . $this->getObjectKey($faixaDescontoIrrf->getFkFolhapagamentoTabelaIrrf()) .'/show');
    }

    /**
     * @param ErrorElement $errorElement
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     */
    public function validate(ErrorElement $errorElement, $faixaDescontoIrrf)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $faixaDescontoIrrfModel = new FaixaDescontoIrrfModel($entityManager);

        $vlInicial = $faixaDescontoIrrf->getVlInicial();
        $vlFinal = $faixaDescontoIrrf->getVlFinal();
        $aliquota = $faixaDescontoIrrf->getAliquota();
        $parcelaDeduzir = $faixaDescontoIrrf->getparcelaDeduzir();

        if ($vlInicial >= $vlFinal) {
            $error = $this->getTranslator()->trans('tabelaIrrf.errors.vlInicialMenorVlFinal', [], 'validators');
            $errorElement->with('vlInicial')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            return;
        }

        $oldObject = $entityManager->getUnitOfWork()->getOriginalEntityData($faixaDescontoIrrf);

        if (!empty($oldObject)) {
            $codFaixa = $oldObject['codFaixa'];
            $codTabela = $oldObject['codTabela'];
            $timestamp = $oldObject['timestamp'];

            $getNextCodFaixa = $faixaDescontoIrrfModel->getNextCodFaixa($codTabela, $timestamp, $codFaixa);

            if (!empty($getNextCodFaixa)) {
                $nextVlInicial = $getNextCodFaixa->getVlInicial();
                $nextVlFinal = $getNextCodFaixa->getVlFinal();
                $nextAliquota = $getNextCodFaixa->getAliquota();
                $nextParcelaDeduzir = $getNextCodFaixa->getParcelaDeduzir();

                if ($vlInicial >= $nextVlInicial) {
                    $error = $this->getTranslator()->trans('tabelaIrrf.errors.vlInicialMaior', ['value' => $nextVlInicial], 'validators');
                    $errorElement->with('vlInicial')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }

                if ($vlFinal >= $nextVlFinal) {
                    $error = $this->getTranslator()->trans('tabelaIrrf.errors.vlFinalMaior', ['value' => $nextVlFinal], 'validators');
                    $errorElement->with('vlFinal')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }

                if ($aliquota >= $nextAliquota) {
                    $error = $this->getTranslator()->trans('tabelaIrrf.errors.aliquotaMaior', ['value' => $nextAliquota], 'validators');
                    $errorElement->with('aliquota')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }

                if ($parcelaDeduzir >= $nextParcelaDeduzir) {
                    $error = $this->getTranslator()->trans('tabelaIrrf.errors.parcelaDeduzirMaior', ['value' => $nextParcelaDeduzir], 'validators');
                    $errorElement->with('parcelaDeduzir')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }
            }
        } else {
            $codFaixa = null;
            $getFiledIdTabelaIrrf = $this->getForm()->get('idTabelaIrrf')->getData();
            list($codTabela, $timestamp) = explode('~', $getFiledIdTabelaIrrf);
        }

        $getPrevFaixaDescontoIrrf = $faixaDescontoIrrfModel->getPrevOrLastCodFaixa($codTabela, $timestamp, $codFaixa);

        if (!empty($getPrevFaixaDescontoIrrf)) {
            $prevVlInicial = $getPrevFaixaDescontoIrrf->getVlInicial();
            $prevVlFinal = $getPrevFaixaDescontoIrrf->getVlFinal();
            $prevAliquota = $getPrevFaixaDescontoIrrf->getAliquota();
            $prevParcelaDeduzir = $getPrevFaixaDescontoIrrf->getParcelaDeduzir();

            if ($vlInicial <= $prevVlInicial) {
                $error = $this->getTranslator()->trans('tabelaIrrf.errors.vlInicialmenor', ['value' => $prevVlInicial], 'validators');
                $errorElement->with('vlInicial')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }

            if ($vlFinal <= $prevVlFinal) {
                $error = $this->getTranslator()->trans('tabelaIrrf.errors.vlFinalmenor', ['value' => $prevVlFinal], 'validators');
                $errorElement->with('vlFinal')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }

            if ($aliquota <= $prevAliquota) {
                $error = $this->getTranslator()->trans('tabelaIrrf.errors.aliquotaMenor', ['value' => $prevAliquota], 'validators');
                $errorElement->with('aliquota')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }

            if ($parcelaDeduzir <= $prevParcelaDeduzir) {
                $error = $this->getTranslator()->trans('tabelaIrrf.errors.parcelaDeduzirMenor', ['value' => $prevParcelaDeduzir], 'validators');
                $errorElement->with('parcelaDeduzir')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codFaixa')
            ->add('codTabela')
            ->add('timestamp')
            ->add('vlInicial')
            ->add('vlFinal')
            ->add('aliquota')
            ->add('parcelaDeduzir')
        ;
    }
}
