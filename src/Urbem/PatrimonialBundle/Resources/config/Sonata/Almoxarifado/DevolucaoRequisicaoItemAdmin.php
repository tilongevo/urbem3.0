<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Orcamento\ContaDespesaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\ConfiguracaoLancamentoContaDespesaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Orcamento;

/**
 * Class DevolucaoRequisicaoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class DevolucaoRequisicaoItemAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $parentAdmin = $this->getParentFieldDescription()->getAdmin();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        // Models
        $requisicaoItemModel = new RequisicaoItemModel($entityManager);
        $contaDespesaModel = new ContaDespesaModel($entityManager);
        $configuracaoLancamentoContaDespesaItemModel = new ConfiguracaoLancamentoContaDespesaItemModel($entityManager);

        $exercicio = $this->getExercicio();

        /** @var RequisicaoItem $requisicaoItem */
        $requisicaoItem = $this->getSubject();

        $saldos = $requisicaoItemModel->getSaldoEstoqueRequisitadoAtendido($requisicaoItem);

        $configuracaoLancamentoContaDespesaItem = $configuracaoLancamentoContaDespesaItemModel
            ->findOneByRequisicaoItem($requisicaoItem);

        $saldos = (new RequisicaoItemModel($entityManager))->getSaldoEstoqueRequisitadoAtendido($requisicaoItem);
        $saldoEstoque = abs($saldos['saldo_estoque']);
        $saldoAtendido = abs($saldos['saldo_atendido']);
        $saldoRequisitado = abs($saldos['saldo_requisitado']);

        $fieldOptions = [];
        $fieldOptions['codItem'] = [
            'disabled' => true,
            'label' => 'label.item.codItem'
        ];

        $fieldOptions['codItemUnidadeMedida'] = [
            'disabled' => true,
            'label' => 'label.catalogoItem.codGrandeza',
        ];

        $fieldOptions['saldoAtual'] = [
            'attr' => ['class' => 'quantity '],
            'data' => number_format($saldoEstoque, 4),
            'disabled' => true,
            'label' => 'label.almoxarifado.requisicao.devolucao.saldoAtual',
            'mapped' => false
        ];

        $fieldOptions['saldoRequisitado'] = [
            'attr' => ['class' => 'quantity '],
            'data' => number_format($saldoRequisitado, 4),
            'disabled' => true,
            'label' => 'label.almoxarifado.requisicao.devolucao.saldoRequisitado',
            'mapped' => false
        ];

        $fieldOptions['saldoAtendido'] = [
            'attr' => ['class' => 'quantity '],
            'data' => number_format($saldoAtendido, 4),
            'disabled' => true,
            'label' => 'label.almoxarifado.requisicao.devolucao.saldoAtendido',
            'mapped' => false
        ];

        $fieldOptions['quantidade'] = [
            'attr' => ['class' => 'quantity check-empty '],
            'data' => $parentAdmin::TIPO_REQUISICAO == "E" ?
                number_format($saldoAtendido, 4) :
                number_format($saldoEstoque, 4),
            'label' => 'label.almoxarifado.requisicao.devolucao.quantidade',
            'mapped' => false
        ];

        $fieldOptions['codContaDespesa'] = [
            'attr' => ['class' => 'select2-parameters check-empty '],
            'class' => ContaDespesa::class,
            'choice_label' => 'codEstrutural',
            'label' => 'label.almoxarifado.requisicao.devolucao.codContaDespesa',
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['devolverItem'] = [
            'attr' => ['class' => 'show-fields-opt '],
            'data' => true,
            'label' => 'label.almoxarifado.requisicao.devolucao.devolver',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['complemento'] = [
            'attr' => ['class' => 'init-hidden '],
            'label' => 'label.almoxarifado.requisicao.devolucao.complemento',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codContaDespesa']['query_builder'] =
            (new ContaDespesaModel($entityManager))->getListaDeContasDepesas($exercicio);

        if (!is_null($configuracaoLancamentoContaDespesaItem)) {
            $fieldOptions['codContaDespesa']['choice_attr'] =
                function (
                    Orcamento\ContaDespesa $selectableContaDespesa,
                    $key,
                    $index
                ) use ($configuracaoLancamentoContaDespesaItem) {
                    $contaDespesa = $configuracaoLancamentoContaDespesaItem->getFkOrcamentoContaDespesa();

                    if ($selectableContaDespesa->getCodConta() == $contaDespesa->getCodConta()) {
                        return ['selected' => 'selected'];
                    }

                    return ['selected' => false];
                };

            $fieldOptions['codContaDespesa']['attr']['class'] .= 'init-readonly ';
        }

        $codItem = $requisicaoItem->getCodItem();
        $catalogoItemModel = new CatalogoItemModel($entityManager);
        $catalogoItem = $catalogoItemModel->getOneByCodItem($codItem);

        $itemDescricao = $catalogoItem->getDescricao();

        $itemUnidadeMedida = $catalogoItem
            ->getFkAdministracaoUnidadeMedida()
            ->getNomUnidade();

        $label = "{$itemDescricao} - {$itemUnidadeMedida}";

        $formMapper
            ->with($label)
            ->add('saldoAtual', 'text', $fieldOptions['saldoAtual'])
            ->add('saldoRequisitado', 'text', $fieldOptions['saldoRequisitado'])
            ->add('saldoAtendido', 'text', $fieldOptions['saldoAtendido'])
            // Campos editaveis
            ->add('quantidade', 'text', $fieldOptions['quantidade'])
            ->add('codContaDespesa', 'entity', $fieldOptions['codContaDespesa'])
            // Campos opcionais
            ->add('devolverItem', 'checkbox', $fieldOptions['devolverItem'])
        ;

        if ($requisicaoItemModel->isFrotaItem($requisicaoItem)) {
            $fieldOptions['codVeiculo'] = [
                'attr' => ['class' => 'select2-parameters init-hidden check-empty '],
                'class' => Frota\Veiculo::class,
                'label' => 'label.almoxarifado.requisicao.devolucao.codVeiculo',
                'mapped' => false,
                'required' => true,
                'placeholder' => 'label.selecione'
            ];

            $fieldOptions['km'] = [
                'attr' => ['class' => 'km init-hidden check-empty '],
                'label' => 'label.almoxarifado.requisicao.devolucao.km',
                'mapped' => false,
                'required' => true
            ];

            $formMapper->add('codVeiculo', 'entity', $fieldOptions['codVeiculo']);
            $formMapper->add('km', 'text', $fieldOptions['km']);
        }

        $formMapper->add('complemento', 'textarea', $fieldOptions['complemento']);
        $formMapper->end();
    }
}
