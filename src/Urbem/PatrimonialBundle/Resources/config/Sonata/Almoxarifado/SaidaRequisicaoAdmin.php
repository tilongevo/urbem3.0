<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\RequisicaoItemModel;

/**
 * Class SaidaRequisicaoAdmin
 */
class SaidaRequisicaoAdmin extends DevolucaoRequisicaoAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_saida_devolucao_requisicao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/saida/requisicao';

    const TIPO_REQUISICAO = "S";

    /**
     * {@inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form  = $this->getForm();

        /** @var Form $fkAlmoxarifadoRequisicaoItemForm */
        foreach ($form->get('fkAlmoxarifadoRequisicaoItens') as $fkAlmoxarifadoRequisicaoItemForm) {
            /** @var boolean $devolver */
            $devolver = $fkAlmoxarifadoRequisicaoItemForm->get('devolverItem')->getData();
            $quantidade = $fkAlmoxarifadoRequisicaoItemForm->get('quantidade')->getData();
            $quantidade = abs($quantidade);

            /**
             * Validaçao efetuada somente se a opçao de devolvero
             * item estiver marcada e a quantidade for maior que 0 (zero)
             */
            if (true == $devolver
                && $quantidade > 0) {
                /** @var RequisicaoItem $requisicaoItem */
                $requisicaoItem = $fkAlmoxarifadoRequisicaoItemForm->getNormData();

                $saldos = (new RequisicaoItemModel($entityManager))
                    ->getSaldoEstoqueRequisitadoAtendido($requisicaoItem);

                $saldoEstoque = abs($saldos['saldo_estoque']);

                /**
                 * Quantidade de saída (Qauntidade inserida.) não pode ser maior que saldo atual (Saldo em Estoque).
                 */
                if ($saldoEstoque < $quantidade) {
                    $message = $this->trans('patrimonial.anulacaoRequisicao.error.quantidadeMaiorQueOSaldoAtual', [], 'flashes');
                    $errorElement->with('fkAlmoxarifadoRequisicaoItens')->addViolation($message);
                }

                $valorTotalSaldoSolicitado = $saldoEstoque + $quantidade;
                $saldoRequerido = abs($saldos['saldo_requerido']);

                /**
                 * Quantidade de saída (Saldo em estoque + Quantidade inserida.)
                 * não pode ser maior que saldo requisitado.
                 */
                if ($saldoRequerido < $valorTotalSaldoSolicitado) {
                    $message = $this->trans('patrimonial.anulacaoRequisicao.error.saldoTotalSolicitadoMaiorQueOSaldoRequerido', [], 'flashes');
                    $errorElement->with('fkAlmoxarifadoRequisicaoItens')->addViolation($message);
                }
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($requisicao)
    {
        $this->geraDadosProcessoRequisicao();
    }
}
