<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoEsgotamento
 */
class TipoEsgotamento
{
    /**
     * PK
     * @var integer
     */
    private $codEsgotamento;

    /**
     * @var string
     */
    private $nomEsgotamento;

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
     * Set codEsgotamento
     *
     * @param integer $codEsgotamento
     * @return TipoEsgotamento
     */
    public function setCodEsgotamento($codEsgotamento)
    {
        $this->codEsgotamento = $codEsgotamento;
        return $this;
    }

    /**
     * Get codEsgotamento
     *
     * @return integer
     */
    public function getCodEsgotamento()
    {
        return $this->codEsgotamento;
    }

    /**
     * Set nomEsgotamento
     *
     * @param string $nomEsgotamento
     * @return TipoEsgotamento
     */
    public function setNomEsgotamento($nomEsgotamento)
    {
        $this->nomEsgotamento = $nomEsgotamento;
        return $this;
    }

    /**
     * Get nomEsgotamento
     *
     * @return string
     */
    public function getNomEsgotamento()
    {
        return $this->nomEsgotamento;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoEsgotamento
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoEsgotamento($this);
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
