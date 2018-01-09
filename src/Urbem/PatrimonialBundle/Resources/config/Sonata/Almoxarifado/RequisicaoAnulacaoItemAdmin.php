<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class RequisicaoAnulacaoItemAdmin
 */
class RequisicaoAnulacaoItemAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var RequisicaoItem $requisicaoItem */
        $requisicaoItem = $this->getSubject();

        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $this->modelManager->find(CatalogoItem::class, $requisicaoItem->getCodItem());
        /** @var CentroCusto $centroCusto */
        $centroCusto = $this->modelManager->find(CentroCusto::class, $requisicaoItem->getCodCentro());
        /** @var Marca $marca */
        $marca = $this->modelManager->find(Marca::class, $requisicaoItem->getCodMarca());

        $this->label = (string) $catalogoItem;

        $saldos = (new RequisicaoItemModel($entityManager))->getQtdeAnuladaAtendidaRequisitada($requisicaoItem);

        $qtdAnulada = (true == array_key_exists('qtd_anulada', $saldos)) ? $saldos['qtd_anulada'] : 0 ;
        $qtdAtendida = (true == array_key_exists('qtd_atendidada', $saldos)) ? $saldos['qtd_atendidada'] : 0 ;
        $qtdRequisitada = (true == array_key_exists('qtd_requisitada', $saldos)) ? $saldos['qtd_requisitada'] : 0 ;
        $quantidade = (($qtdRequisitada - $qtdAtendida) - $qtdAnulada);

        $fieldOptions = [];
        $fieldOptions['item'] = [
            'data' => (string) $catalogoItem,
            'label' => 'label.almoxarifado.requisicao.itensItem',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['marca'] = [
            'data' => (string) $marca,
            'label' => 'label.almoxarifado.requisicao.itensMarca',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['centroCusto'] = [
            'data' => (string) $centroCusto,
            'label' => 'label.almoxarifado.requisicao.itensCentroCusto',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['requisitada'] = [
            'data' => number_format($qtdRequisitada, 4, ',', ' '),
            'label' => 'label.almoxarifado.requisicao.itensQtdRequisitada',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['atendida'] = [
            'data' => number_format($qtdAtendida, 4, ',', ' '),
            'label' => 'label.almoxarifado.requisicao.itensQtdAtendida',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['anulada'] = [
            'data' => number_format($qtdAnulada, 4, ',', ' '),
            'label' => 'label.almoxarifado.requisicao.itensQtdAnulada',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['quantidadeAnular'] = [
            'attr' => ['class' => 'quantity '],
            'data' => number_format($quantidade, 4, ',', ' '),
            'label' => 'label.almoxarifado.requisicao.itensQuantidade',
            'mapped' => false
        ];

        $formMapper
            ->add('item', 'text', $fieldOptions['item'])
            ->add('marca', 'text', $fieldOptions['marca'])
            ->add('centroCusto', 'text', $fieldOptions['centroCusto'])
            ->add('requisitada', 'text', $fieldOptions['requisitada'])
            ->add('atendida', 'text', $fieldOptions['atendida'])
            ->add('anulada', 'text', $fieldOptions['anulada'])
            ->add('quantidadeAnular', 'text', $fieldOptions['quantidadeAnular'])
        ;
    }
}
