<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Grafica
 */
class Grafica
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    private $fkFiscalizacaoAutorizacaoNotas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoAutorizacaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Grafica
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Grafica
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     * @return Grafica
     */
    public function addFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        if (false === $this->fkFiscalizacaoAutorizacaoNotas->contains($fkFiscalizacaoAutorizacaoNotas)) {
            $fkFiscalizacaoAutorizacaoNotas->setFkFiscalizacaoGrafica($this);
            $this->fkFiscalizacaoAutorizacaoNotas->add($fkFiscalizacaoAutorizacaoNotas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     */
    public function removeFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        $this->fkFiscalizacaoAutorizacaoNotas->removeElement($fkFiscalizacaoAutorizacaoNotas);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutorizacaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    public function getFkFiscalizacaoAutorizacaoNotas()
    {
        return $this->fkFiscalizacaoAutorizacaoNotas;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Grafica
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
