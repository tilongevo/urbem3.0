<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * MovSefipRetorno
 */
class MovSefipRetorno
{
    /**
     * PK
     * @var integer
     */
    private $codSefipRetorno;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Sefip
     */
    private $fkPessoalSefip;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno
     */
    private $fkPessoalMovSefipSaidaMovSefipRetornos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalMovSefipSaidaMovSefipRetornos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSefipRetorno
     *
     * @param integer $codSefipRetorno
     * @return MovSefipRetorno
     */
    public function setCodSefipRetorno($codSefipRetorno)
    {
        $this->codSefipRetorno = $codSefipRetorno;
        return $this;
    }

    /**
     * Get codSefipRetorno
     *
     * @return integer
     */
    public function getCodSefipRetorno()
    {
        return $this->codSefipRetorno;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalMovSefipSaidaMovSefipRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno
     * @return MovSefipRetorno
     */
    public function addFkPessoalMovSefipSaidaMovSefipRetornos(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno)
    {
        if (false === $this->fkPessoalMovSefipSaidaMovSefipRetornos->contains($fkPessoalMovSefipSaidaMovSefipRetorno)) {
            $fkPessoalMovSefipSaidaMovSefipRetorno->setFkPessoalMovSefipRetorno($this);
            $this->fkPessoalMovSefipSaidaMovSefipRetornos->add($fkPessoalMovSefipSaidaMovSefipRetorno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalMovSefipSaidaMovSefipRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno
     */
    public function removeFkPessoalMovSefipSaidaMovSefipRetornos(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno $fkPessoalMovSefipSaidaMovSefipRetorno)
    {
        $this->fkPessoalMovSefipSaidaMovSefipRetornos->removeElement($fkPessoalMovSefipSaidaMovSefipRetorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalMovSefipSaidaMovSefipRetornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaidaMovSefipRetorno
     */
    public function getFkPessoalMovSefipSaidaMovSefipRetornos()
    {
        return $this->fkPessoalMovSefipSaidaMovSefipRetornos;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalSefip
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Sefip $fkPessoalSefip
     * @return MovSefipRetorno
     */
    public function setFkPessoalSefip(\Urbem\CoreBundle\Entity\Pessoal\Sefip $fkPessoalSefip)
    {
        $this->codSefipRetorno = $fkPessoalSefip->getCodSefip();
        $this->fkPessoalSefip = $fkPessoalSefip;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalSefip
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Sefip
     */
    public function getFkPessoalSefip()
    {
        return $this->fkPessoalSefip;
    }
}
