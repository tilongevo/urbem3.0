<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * VeiculoPropriedade
 */
class VeiculoPropriedade
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $proprio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    private $fkFrotaTerceiros;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Proprio
     */
    private $fkFrotaProprio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return VeiculoPropriedade
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return VeiculoPropriedade
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
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
     * Set proprio
     *
     * @param boolean $proprio
     * @return VeiculoPropriedade
     */
    public function setProprio($proprio)
    {
        $this->proprio = $proprio;
        return $this;
    }

    /**
     * Get proprio
     *
     * @return boolean
     */
    public function getProprio()
    {
        return $this->proprio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return VeiculoPropriedade
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaTerceiros
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros
     * @return VeiculoPropriedade
     */
    public function setFkFrotaTerceiros(\Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros)
    {
        $fkFrotaTerceiros->setFkFrotaVeiculoPropriedade($this);
        $this->fkFrotaTerceiros = $fkFrotaTerceiros;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaTerceiros
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    public function getFkFrotaTerceiros()
    {
        return $this->fkFrotaTerceiros;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaProprio
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio
     * @return VeiculoPropriedade
     */
    public function setFkFrotaProprio(\Urbem\CoreBundle\Entity\Frota\Proprio $fkFrotaProprio)
    {
        $fkFrotaProprio->setFkFrotaVeiculoPropriedade($this);
        $this->fkFrotaProprio = $fkFrotaProprio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaProprio
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Proprio
     */
    public function getFkFrotaProprio()
    {
        return $this->fkFrotaProprio;
    }
}
