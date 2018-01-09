<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Solicitante
 */
class Solicitante
{
    /**
     * PK
     * @var integer
     */
    private $solicitante;

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
     * Set solicitante
     *
     * @param integer $solicitante
     * @return Solicitante
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
        return $this;
    }

    /**
     * Get solicitante
     *
     * @return integer
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Solicitante
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
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Solicitante
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->solicitante = $fkSwCgm->getNumcgm();
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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkSwCgm();
    }
}
