<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoAbastecimento
 */
class TipoAbastecimento
{
    /**
     * PK
     * @var integer
     */
    private $codAbastecimento;

    /**
     * @var string
     */
    private $nomAbastecimento;

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
     * Set codAbastecimento
     *
     * @param integer $codAbastecimento
     * @return TipoAbastecimento
     */
    public function setCodAbastecimento($codAbastecimento)
    {
        $this->codAbastecimento = $codAbastecimento;
        return $this;
    }

    /**
     * Get codAbastecimento
     *
     * @return integer
     */
    public function getCodAbastecimento()
    {
        return $this->codAbastecimento;
    }

    /**
     * Set nomAbastecimento
     *
     * @param string $nomAbastecimento
     * @return TipoAbastecimento
     */
    public function setNomAbastecimento($nomAbastecimento)
    {
        $this->nomAbastecimento = $nomAbastecimento;
        return $this;
    }

    /**
     * Get nomAbastecimento
     *
     * @return string
     */
    public function getNomAbastecimento()
    {
        return $this->nomAbastecimento;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoAbastecimento
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoAbastecimento($this);
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
