<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * ContasRgf2
 */
class ContasRgf2
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2
     */
    private $fkStnVinculoContasRgf2s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnVinculoContasRgf2s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ContasRgf2
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContasRgf2
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
     * Add StnVinculoContasRgf2
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2
     * @return ContasRgf2
     */
    public function addFkStnVinculoContasRgf2s(\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2)
    {
        if (false === $this->fkStnVinculoContasRgf2s->contains($fkStnVinculoContasRgf2)) {
            $fkStnVinculoContasRgf2->setFkStnContasRgf2($this);
            $this->fkStnVinculoContasRgf2s->add($fkStnVinculoContasRgf2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoContasRgf2
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2
     */
    public function removeFkStnVinculoContasRgf2s(\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2 $fkStnVinculoContasRgf2)
    {
        $this->fkStnVinculoContasRgf2s->removeElement($fkStnVinculoContasRgf2);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoContasRgf2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoContasRgf2
     */
    public function getFkStnVinculoContasRgf2s()
    {
        return $this->fkStnVinculoContasRgf2s;
    }
}
