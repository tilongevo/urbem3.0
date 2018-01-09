<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwDocumento
 */
class SwDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoAssunto
     */
    private $fkSwDocumentoAssuntos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    private $fkSwDocumentoProcessos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwDocumentoAssuntos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwDocumentoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return SwDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set nomDocumento
     *
     * @param string $nomDocumento
     * @return SwDocumento
     */
    public function setNomDocumento($nomDocumento)
    {
        $this->nomDocumento = $nomDocumento;
        return $this;
    }

    /**
     * Get nomDocumento
     *
     * @return string
     */
    public function getNomDocumento()
    {
        return $this->nomDocumento;
    }

    /**
     * OneToMany (owning side)
     * Add SwDocumentoAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto
     * @return SwDocumento
     */
    public function addFkSwDocumentoAssuntos(\Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto)
    {
        if (false === $this->fkSwDocumentoAssuntos->contains($fkSwDocumentoAssunto)) {
            $fkSwDocumentoAssunto->setFkSwDocumento($this);
            $this->fkSwDocumentoAssuntos->add($fkSwDocumentoAssunto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDocumentoAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto
     */
    public function removeFkSwDocumentoAssuntos(\Urbem\CoreBundle\Entity\SwDocumentoAssunto $fkSwDocumentoAssunto)
    {
        $this->fkSwDocumentoAssuntos->removeElement($fkSwDocumentoAssunto);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDocumentoAssuntos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoAssunto
     */
    public function getFkSwDocumentoAssuntos()
    {
        return $this->fkSwDocumentoAssuntos;
    }

    /**
     * OneToMany (owning side)
     * Add SwDocumentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso
     * @return SwDocumento
     */
    public function addFkSwDocumentoProcessos(\Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso)
    {
        if (false === $this->fkSwDocumentoProcessos->contains($fkSwDocumentoProcesso)) {
            $fkSwDocumentoProcesso->setFkSwDocumento($this);
            $this->fkSwDocumentoProcessos->add($fkSwDocumentoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDocumentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso
     */
    public function removeFkSwDocumentoProcessos(\Urbem\CoreBundle\Entity\SwDocumentoProcesso $fkSwDocumentoProcesso)
    {
        $this->fkSwDocumentoProcessos->removeElement($fkSwDocumentoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDocumentoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDocumentoProcesso
     */
    public function getFkSwDocumentoProcessos()
    {
        return $this->fkSwDocumentoProcessos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomDocumento;
    }
}
