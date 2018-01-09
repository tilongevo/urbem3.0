<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoDestinoLixo
 */
class TipoDestinoLixo
{
    /**
     * PK
     * @var integer
     */
    private $codDestinoLixo;

    /**
     * @var string
     */
    private $nomDestinoLixo;

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
     * Set codDestinoLixo
     *
     * @param integer $codDestinoLixo
     * @return TipoDestinoLixo
     */
    public function setCodDestinoLixo($codDestinoLixo)
    {
        $this->codDestinoLixo = $codDestinoLixo;
        return $this;
    }

    /**
     * Get codDestinoLixo
     *
     * @return integer
     */
    public function getCodDestinoLixo()
    {
        return $this->codDestinoLixo;
    }

    /**
     * Set nomDestinoLixo
     *
     * @param string $nomDestinoLixo
     * @return TipoDestinoLixo
     */
    public function setNomDestinoLixo($nomDestinoLixo)
    {
        $this->nomDestinoLixo = $nomDestinoLixo;
        return $this;
    }

    /**
     * Get nomDestinoLixo
     *
     * @return string
     */
    public function getNomDestinoLixo()
    {
        return $this->nomDestinoLixo;
    }

    /**
     * OneToMany (owning side)
     * Add CseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return TipoDestinoLixo
     */
    public function addFkCseDomicilios(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        if (false === $this->fkCseDomicilios->contains($fkCseDomicilio)) {
            $fkCseDomicilio->setFkCseTipoDestinoLixo($this);
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
