<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoCobertura
 */
class TipoCobertura
{
    /**
     * PK
     * @var integer
     */
    private $codCobertura;

    /**
     * @var string
     */
    private $nomCobertura;

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
     * Set codCobertura
     *
     * @param integer $codCobertura
     * @return TipoCobertura
     */
    public function setCodCobertura($codCobertura)
    {
        $this->codCobertura = $codCobertura;
        return $this;
    }

    /**
     * Get codCobertura
     *
     * @return integer
     */
    public function getCodCobertura()
    {
        return $this->codCobertura;
    }

    /**
     * Set nomCobertura
     *
     * @param string $nomCobertura
     * @return TipoCobertura
     */
    public function setNomCobertura($nomCobertura)
    {
        $this->nomCobertura = $nomCobertura;
        return $this;
    }

    /**
     * Get nomCobertura
     *
     * @return string
     */
    public function getNomCobertura()
    {
        return $this->nomCobertura;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoCobertura
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoCobertura($this);
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
