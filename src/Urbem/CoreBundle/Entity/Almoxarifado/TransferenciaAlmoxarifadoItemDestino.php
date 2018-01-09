<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * TransferenciaAlmoxarifadoItemDestino
 */
class TransferenciaAlmoxarifadoItemDestino
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codCentroDestino;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino
     */
    private $fkAlmoxarifadoPedidoTransferenciaItemDestino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodTransferencia($codTransferencia)
    {
        $this->codTransferencia = $codTransferencia;
        return $this;
    }

    /**
     * Get codTransferencia
     *
     * @return integer
     */
    public function getCodTransferencia()
    {
        return $this->codTransferencia;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codCentroDestino
     *
     * @param integer $codCentroDestino
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodCentroDestino($codCentroDestino)
    {
        $this->codCentroDestino = $codCentroDestino;
        return $this;
    }

    /**
     * Get codCentroDestino
     *
     * @return integer
     */
    public function getCodCentroDestino()
    {
        return $this->codCentroDestino;
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoPedidoTransferenciaItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setFkAlmoxarifadoPedidoTransferenciaItemDestino(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino)
    {
        $this->exercicio = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getExercicio();
        $this->codTransferencia = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getCodTransferencia();
        $this->codItem = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getCodItem();
        $this->codMarca = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getCodMarca();
        $this->codCentro = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getCodCentro();
        $this->codCentroDestino = $fkAlmoxarifadoPedidoTransferenciaItemDestino->getCodCentroDestino();
        $this->fkAlmoxarifadoPedidoTransferenciaItemDestino = $fkAlmoxarifadoPedidoTransferenciaItemDestino;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoPedidoTransferenciaItemDestino
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItemDestino()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItemDestino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return TransferenciaAlmoxarifadoItemDestino
     */
    public function setFkAlmoxarifadoLancamentoMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->codLancamento = $fkAlmoxarifadoLancamentoMaterial->getCodLancamento();
        $this->codItem = $fkAlmoxarifadoLancamentoMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoLancamentoMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoLancamentoMaterial->getCodAlmoxarifado();
        $this->codCentroDestino = $fkAlmoxarifadoLancamentoMaterial->getCodCentro();
        $this->fkAlmoxarifadoLancamentoMaterial = $fkAlmoxarifadoLancamentoMaterial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMaterial()
    {
        return $this->fkAlmoxarifadoLancamentoMaterial;
    }
}
