<?php
 
namespace Urbem\CoreBundle\Entity\Tcesc;

/**
 * TipoCertidao
 */
class TipoCertidao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoCertidao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge
     */
    private $fkTcescTipoCertidaoEsfinges;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcescTipoCertidaoEsfinges = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoCertidao
     *
     * @param integer $codTipoCertidao
     * @return TipoCertidao
     */
    public function setCodTipoCertidao($codTipoCertidao)
    {
        $this->codTipoCertidao = $codTipoCertidao;
        return $this;
    }

    /**
     * Get codTipoCertidao
     *
     * @return integer
     */
    public function getCodTipoCertidao()
    {
        return $this->codTipoCertidao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCertidao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add TcescTipoCertidaoEsfinge
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge
     * @return TipoCertidao
     */
    public function addFkTcescTipoCertidaoEsfinges(\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge)
    {
        if (false === $this->fkTcescTipoCertidaoEsfinges->contains($fkTcescTipoCertidaoEsfinge)) {
            $fkTcescTipoCertidaoEsfinge->setFkTcescTipoCertidao($this);
            $this->fkTcescTipoCertidaoEsfinges->add($fkTcescTipoCertidaoEsfinge);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcescTipoCertidaoEsfinge
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge
     */
    public function removeFkTcescTipoCertidaoEsfinges(\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge)
    {
        $this->fkTcescTipoCertidaoEsfinges->removeElement($fkTcescTipoCertidaoEsfinge);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcescTipoCertidaoEsfinges
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge
     */
    public function getFkTcescTipoCertidaoEsfinges()
    {
        return $this->fkTcescTipoCertidaoEsfinges;
    }
}
