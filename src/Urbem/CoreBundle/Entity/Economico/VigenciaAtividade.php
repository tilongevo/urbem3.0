<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VigenciaAtividade
 */
class VigenciaAtividade
{
    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    private $fkEconomicoNivelAtividades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoNivelAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return VigenciaAtividade
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return VigenciaAtividade
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return VigenciaAtividade
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
     * OneToMany (owning side)
     * Add EconomicoNivelAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade
     * @return VigenciaAtividade
     */
    public function addFkEconomicoNivelAtividades(\Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade)
    {
        if (false === $this->fkEconomicoNivelAtividades->contains($fkEconomicoNivelAtividade)) {
            $fkEconomicoNivelAtividade->setFkEconomicoVigenciaAtividade($this);
            $this->fkEconomicoNivelAtividades->add($fkEconomicoNivelAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade
     */
    public function removeFkEconomicoNivelAtividades(\Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade)
    {
        $this->fkEconomicoNivelAtividades->removeElement($fkEconomicoNivelAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    public function getFkEconomicoNivelAtividades()
    {
        return $this->fkEconomicoNivelAtividades;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) ($this->dtInicio ? $this->dtInicio->format('d/m/Y') : '');
    }
}
