<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Terceiros
 */
class Terceiros
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
    private $codProprietario;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    private $fkFrotaTerceirosHistorico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade
     */
    private $fkFrotaVeiculoPropriedade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

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
     * @return Terceiros
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
     * @return Terceiros
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
     * Set codProprietario
     *
     * @param integer $codProprietario
     * @return Terceiros
     */
    public function setCodProprietario($codProprietario)
    {
        $this->codProprietario = $codProprietario;
        return $this;
    }

    /**
     * Get codProprietario
     *
     * @return integer
     */
    public function getCodProprietario()
    {
        return $this->codProprietario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Terceiros
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->codProprietario = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaTerceirosHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico
     * @return Terceiros
     */
    public function setFkFrotaTerceirosHistorico(\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico)
    {
        $fkFrotaTerceirosHistorico->setFkFrotaTerceiros($this);
        $this->fkFrotaTerceirosHistorico = $fkFrotaTerceirosHistorico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaTerceirosHistorico
     *
     * @return \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    public function getFkFrotaTerceirosHistorico()
    {
        return $this->fkFrotaTerceirosHistorico;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaVeiculoPropriedade
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoPropriedade $fkFrotaVeiculoPropriedade
     * @return Terceiros
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
        if (is_object($this->getFkSwCgm())) {
            return sprintf(
                "Veículo de %s - %s",
                $this->getFkSwCgm()->getNumcgm(),
                $this->getFkSwCgm()->getNomCgm()
            );
        } else {
            return "Veiculo";
        }
    }
}
