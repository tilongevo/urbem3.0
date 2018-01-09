<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * InventarioAnulacao
 */
class InventarioAnulacao
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
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codInventario;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    private $fkAlmoxarifadoInventario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return InventarioAnulacao
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return InventarioAnulacao
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
     * Set codInventario
     *
     * @param integer $codInventario
     * @return InventarioAnulacao
     */
    public function setCodInventario($codInventario)
    {
        $this->codInventario = $codInventario;
        return $this;
    }

    /**
     * Get codInventario
     *
     * @return integer
     */
    public function getCodInventario()
    {
        return $this->codInventario;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return InventarioAnulacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return InventarioAnulacao
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoInventario
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario
     * @return InventarioAnulacao
     */
    public function setFkAlmoxarifadoInventario(\Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario)
    {
        $this->exercicio = $fkAlmoxarifadoInventario->getExercicio();
        $this->codAlmoxarifado = $fkAlmoxarifadoInventario->getCodAlmoxarifado();
        $this->codInventario = $fkAlmoxarifadoInventario->getCodInventario();
        $this->fkAlmoxarifadoInventario = $fkAlmoxarifadoInventario;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoInventario
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    public function getFkAlmoxarifadoInventario()
    {
        return $this->fkAlmoxarifadoInventario;
    }
}
