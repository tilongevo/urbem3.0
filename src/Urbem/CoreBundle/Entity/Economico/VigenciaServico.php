<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VigenciaServico
 */
class VigenciaServico
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServico
     */
    private $fkEconomicoNivelServicos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoNivelServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return VigenciaServico
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
     * @return VigenciaServico
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
     * @return VigenciaServico
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
     * Add EconomicoNivelServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico
     * @return VigenciaServico
     */
    public function addFkEconomicoNivelServicos(\Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico)
    {
        if (false === $this->fkEconomicoNivelServicos->contains($fkEconomicoNivelServico)) {
            $fkEconomicoNivelServico->setFkEconomicoVigenciaServico($this);
            $this->fkEconomicoNivelServicos->add($fkEconomicoNivelServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico
     */
    public function removeFkEconomicoNivelServicos(\Urbem\CoreBundle\Entity\Economico\NivelServico $fkEconomicoNivelServico)
    {
        $this->fkEconomicoNivelServicos->removeElement($fkEconomicoNivelServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServico
     */
    public function getFkEconomicoNivelServicos()
    {
        return $this->fkEconomicoNivelServicos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        ($this->getDtInicio() instanceof \DateTime ? $date = $this->getDtInicio()->format('d/m/Y') : $date = $this->getDtInicio());
        return sprintf('%s - %s', $this->getCodVigencia(), $date);
    }
}
