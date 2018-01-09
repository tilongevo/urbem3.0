<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VigenciaCnae
 */
class VigenciaCnae
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelCnae
     */
    private $fkEconomicoNivelCnaes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoNivelCnaes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return VigenciaCnae
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
     * @return VigenciaCnae
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
     * @return VigenciaCnae
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
     * Add EconomicoNivelCnae
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae
     * @return VigenciaCnae
     */
    public function addFkEconomicoNivelCnaes(\Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae)
    {
        if (false === $this->fkEconomicoNivelCnaes->contains($fkEconomicoNivelCnae)) {
            $fkEconomicoNivelCnae->setFkEconomicoVigenciaCnae($this);
            $this->fkEconomicoNivelCnaes->add($fkEconomicoNivelCnae);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelCnae
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae
     */
    public function removeFkEconomicoNivelCnaes(\Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae)
    {
        $this->fkEconomicoNivelCnaes->removeElement($fkEconomicoNivelCnae);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelCnaes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelCnae
     */
    public function getFkEconomicoNivelCnaes()
    {
        return $this->fkEconomicoNivelCnaes;
    }
}
