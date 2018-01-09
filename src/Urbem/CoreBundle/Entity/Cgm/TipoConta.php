<?php
 
namespace Urbem\CoreBundle\Entity\Cgm;

/**
 * TipoConta
 */
class TipoConta
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\Conta
     */
    private $fkCgmContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCgmContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoConta
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
     * @return TipoConta
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
     * Add CgmConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta
     * @return TipoConta
     */
    public function addFkCgmContas(\Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta)
    {
        if (false === $this->fkCgmContas->contains($fkCgmConta)) {
            $fkCgmConta->setFkCgmTipoConta($this);
            $this->fkCgmContas->add($fkCgmConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CgmConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta
     */
    public function removeFkCgmContas(\Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta)
    {
        $this->fkCgmContas->removeElement($fkCgmConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkCgmContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\Conta
     */
    public function getFkCgmContas()
    {
        return $this->fkCgmContas;
    }
}
