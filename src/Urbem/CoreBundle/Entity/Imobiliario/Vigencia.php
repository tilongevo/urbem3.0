<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Vigencia
 */
class Vigencia
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    private $fkImobiliarioNiveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return Vigencia
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
     * @return Vigencia
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
     * @return Vigencia
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
     * Add ImobiliarioNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel
     * @return Vigencia
     */
    public function addFkImobiliarioNiveis(\Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel)
    {
        if (false === $this->fkImobiliarioNiveis->contains($fkImobiliarioNivel)) {
            $fkImobiliarioNivel->setFkImobiliarioVigencia($this);
            $this->fkImobiliarioNiveis->add($fkImobiliarioNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel
     */
    public function removeFkImobiliarioNiveis(\Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel)
    {
        $this->fkImobiliarioNiveis->removeElement($fkImobiliarioNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    public function getFkImobiliarioNiveis()
    {
        return $this->fkImobiliarioNiveis;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ($this->dtInicio)
            ? $this->dtInicio->format('d/m/Y')
            : (string) $this->codVigencia;
    }
}
