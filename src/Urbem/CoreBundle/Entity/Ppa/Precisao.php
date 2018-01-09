<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * Precisao
 */
class Precisao
{
    /**
     * PK
     * @var integer
     */
    private $codPrecisao;

    /**
     * @var string
     */
    private $nivel;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPrecisao
     */
    private $fkPpaPpaPrecisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaPpaPrecisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPrecisao
     *
     * @param integer $codPrecisao
     * @return Precisao
     */
    public function setCodPrecisao($codPrecisao)
    {
        $this->codPrecisao = $codPrecisao;
        return $this;
    }

    /**
     * Get codPrecisao
     *
     * @return integer
     */
    public function getCodPrecisao()
    {
        return $this->codPrecisao;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     * @return Precisao
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaPrecisao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao
     * @return Precisao
     */
    public function addFkPpaPpaPrecisoes(\Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao)
    {
        if (false === $this->fkPpaPpaPrecisoes->contains($fkPpaPpaPrecisao)) {
            $fkPpaPpaPrecisao->setFkPpaPrecisao($this);
            $this->fkPpaPpaPrecisoes->add($fkPpaPpaPrecisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaPrecisao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao
     */
    public function removeFkPpaPpaPrecisoes(\Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao)
    {
        $this->fkPpaPpaPrecisoes->removeElement($fkPpaPpaPrecisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaPrecisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPrecisao
     */
    public function getFkPpaPpaPrecisoes()
    {
        return $this->fkPpaPpaPrecisoes;
    }
}
