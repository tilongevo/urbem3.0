<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * TipoVinculoStnReceita
 */
class TipoVinculoStnReceita
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita
     */
    private $fkStnVinculoStnReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnVinculoStnReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoVinculoStnReceita
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoVinculoStnReceita
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
     * Add StnVinculoStnReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita
     * @return TipoVinculoStnReceita
     */
    public function addFkStnVinculoStnReceitas(\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita)
    {
        if (false === $this->fkStnVinculoStnReceitas->contains($fkStnVinculoStnReceita)) {
            $fkStnVinculoStnReceita->setFkStnTipoVinculoStnReceita($this);
            $this->fkStnVinculoStnReceitas->add($fkStnVinculoStnReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoStnReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita
     */
    public function removeFkStnVinculoStnReceitas(\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita $fkStnVinculoStnReceita)
    {
        $this->fkStnVinculoStnReceitas->removeElement($fkStnVinculoStnReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoStnReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoStnReceita
     */
    public function getFkStnVinculoStnReceitas()
    {
        return $this->fkStnVinculoStnReceitas;
    }
}
