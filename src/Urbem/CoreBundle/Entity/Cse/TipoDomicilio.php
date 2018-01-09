<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoDomicilio
 */
class TipoDomicilio
{
    /**
     * PK
     * @var integer
     */
    private $codDomicilio;

    /**
     * @var string
     */
    private $nomDomicilio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    private $fkCseDomicilios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseDomicilios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDomicilio
     *
     * @param integer $codDomicilio
     * @return TipoDomicilio
     */
    public function setCodDomicilio($codDomicilio)
    {
        $this->codDomicilio = $codDomicilio;
        return $this;
    }

    /**
     * Get codDomicilio
     *
     * @return integer
     */
    public function getCodDomicilio()
    {
        return $this->codDomicilio;
    }

    /**
     * Set nomDomicilio
     *
     * @param string $nomDomicilio
     * @return TipoDomicilio
     */
    public function setNomDomicilio($nomDomicilio)
    {
        $this->nomDomicilio = $nomDomicilio;
        return $this;
    }

    /**
     * Get nomDomicilio
     *
     * @return string
     */
    public function getNomDomicilio()
    {
        return $this->nomDomicilio;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoDomicilio
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoDomicilio($this);
            $this->fkCseDomicilios->add($fkCseDomicilio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     */
    public function removeFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        $this->fkCseDomicilios->removeElement($fkCseDomicilio);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseDomicilios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    public function getFkCseDomicilios()
    {
        return $this->fkCseDomicilios;
    }
}
