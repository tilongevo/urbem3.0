<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Proprio
 */
class Proprio
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
     * @var integer
     */
    private $codBem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade
     */
    private $fkFrotaVeiculoPropriedade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

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
     * @return Proprio
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
     * @return Proprio
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
     * Set codBem
     *
     * @param integer $codBem
     * @return Proprio
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return Proprio
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaVeiculoPropriedade
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade
     * @return Proprio
     */
    public function setFkFrotaVeiculoPropriedade(\Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade)
    {
        $this->codVeiculo = $fkFrotaVeiculoPropriedade->getCodVeiculo();
        $this->timestamp = $fkFrotaVeiculoPropriedade->getTimestamp();
        $this->fkFrotaVeiculoPropriedade = $fkFrotaVeiculoPropriedade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaVeiculoPropriedade
     *
     * @return \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade
     */
    public function getFkFrotaVeiculoPropriedade()
    {
        return $this->fkFrotaVeiculoPropriedade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkPatrimonioBem;
    }
}
