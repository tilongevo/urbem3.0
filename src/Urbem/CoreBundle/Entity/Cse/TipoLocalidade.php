<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoLocalidade
 */
class TipoLocalidade
{
    /**
     * PK
     * @var integer
     */
    private $codLocalidade;

    /**
     * @var string
     */
    private $nomLocalidade;

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
     * Set codLocalidade
     *
     * @param integer $codLocalidade
     * @return TipoLocalidade
     */
    public function setCodLocalidade($codLocalidade)
    {
        $this->codLocalidade = $codLocalidade;
        return $this;
    }

    /**
     * Get codLocalidade
     *
     * @return integer
     */
    public function getCodLocalidade()
    {
        return $this->codLocalidade;
    }

    /**
     * Set nomLocalidade
     *
     * @param string $nomLocalidade
     * @return TipoLocalidade
     */
    public function setNomLocalidade($nomLocalidade)
    {
        $this->nomLocalidade = $nomLocalidade;
        return $this;
    }

    /**
     * Get nomLocalidade
     *
     * @return string
     */
    public function getNomLocalidade()
    {
        return $this->nomLocalidade;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoLocalidade
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoLocalidade($this);
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
