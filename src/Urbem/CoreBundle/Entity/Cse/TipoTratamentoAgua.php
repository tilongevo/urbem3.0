<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoTratamentoAgua
 */
class TipoTratamentoAgua
{
    /**
     * PK
     * @var integer
     */
    private $codTratamento;

    /**
     * @var string
     */
    private $nomTratamento;

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
     * Set codTratamento
     *
     * @param integer $codTratamento
     * @return TipoTratamentoAgua
     */
    public function setCodTratamento($codTratamento)
    {
        $this->codTratamento = $codTratamento;
        return $this;
    }

    /**
     * Get codTratamento
     *
     * @return integer
     */
    public function getCodTratamento()
    {
        return $this->codTratamento;
    }

    /**
     * Set nomTratamento
     *
     * @param string $nomTratamento
     * @return TipoTratamentoAgua
     */
    public function setNomTratamento($nomTratamento)
    {
        $this->nomTratamento = $nomTratamento;
        return $this;
    }

    /**
     * Get nomTratamento
     *
     * @return string
     */
    public function getNomTratamento()
    {
        return $this->nomTratamento;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoTratamentoAgua
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoTratamentoAgua($this);
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
