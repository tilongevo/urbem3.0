<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * TipoCertidao
 */
class TipoCertidao
{
    /**
     * PK
     * @var integer
     */
    private $codCertidao;

    /**
     * @var string
     */
    private $nomCertidao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCertidao
     *
     * @param integer $codCertidao
     * @return TipoCertidao
     */
    public function setCodCertidao($codCertidao)
    {
        $this->codCertidao = $codCertidao;
        return $this;
    }

    /**
     * Get codCertidao
     *
     * @return integer
     */
    public function getCodCertidao()
    {
        return $this->codCertidao;
    }

    /**
     * Set nomCertidao
     *
     * @param string $nomCertidao
     * @return TipoCertidao
     */
    public function setNomCertidao($nomCertidao)
    {
        $this->nomCertidao = $nomCertidao;
        return $this;
    }

    /**
     * Get nomCertidao
     *
     * @return string
     */
    public function getNomCertidao()
    {
        return $this->nomCertidao;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return TipoCertidao
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseTipoCertidao($this);
            $this->fkCseCidadoes->add($fkCseCidadao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     */
    public function removeFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->fkCseCidadoes->removeElement($fkCseCidadao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadoes()
    {
        return $this->fkCseCidadoes;
    }
}
