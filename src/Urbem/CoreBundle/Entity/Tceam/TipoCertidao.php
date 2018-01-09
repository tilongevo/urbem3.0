<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento
     */
    private $fkTceamTipoCertidaoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTceamTipoCertidaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TceamTipoCertidaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento
     * @return TipoCertidao
     */
    public function addFkTceamTipoCertidaoDocumentos(\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento)
    {
        if (false === $this->fkTceamTipoCertidaoDocumentos->contains($fkTceamTipoCertidaoDocumento)) {
            $fkTceamTipoCertidaoDocumento->setFkTceamTipoCertidao($this);
            $this->fkTceamTipoCertidaoDocumentos->add($fkTceamTipoCertidaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoCertidaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento
     */
    public function removeFkTceamTipoCertidaoDocumentos(\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento)
    {
        $this->fkTceamTipoCertidaoDocumentos->removeElement($fkTceamTipoCertidaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoCertidaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento
     */
    public function getFkTceamTipoCertidaoDocumentos()
    {
        return $this->fkTceamTipoCertidaoDocumentos;
    }
}
