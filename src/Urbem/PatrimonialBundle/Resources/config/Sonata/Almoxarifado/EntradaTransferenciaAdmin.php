<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;

/**
 * Class EntradaTransferenciaAdmin
 */
class EntradaTransferenciaAdmin extends SaidaTransferenciaAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_entrada_transferencia';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/entrada/transferencia';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoEditar = false;

    public $tipoNatureza = 'E';
}
