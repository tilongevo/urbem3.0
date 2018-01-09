<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * BaixaNaturezaJuridica
 */
class BaixaNaturezaJuridica
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica
     */
    private $fkEconomicoNaturezaJuridica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return BaixaNaturezaJuridica
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return BaixaNaturezaJuridica
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return BaixaNaturezaJuridica
     */
    public function setMotivo($motivo)
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
     * Set EconomicoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica $fkEconomicoNaturezaJuridica
     * @return BaixaNaturezaJuridica
     */
    public function setFkEconomicoNaturezaJuridica(\Urbem\CoreBundle\Entity\Economico\NaturezaJuridica $fkEconomicoNaturezaJuridica)
    {
        $this->codNatureza = $fkEconomicoNaturezaJuridica->getCodNatureza();
        $this->fkEconomicoNaturezaJuridica = $fkEconomicoNaturezaJuridica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoNaturezaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica
     */
    public function getFkEconomicoNaturezaJuridica()
    {
        return $this->fkEconomicoNaturezaJuridica;
    }
}
