<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * TipoContaLancamentoRp
 */
class TipoContaLancamentoRp
{
    /**
     * PK
     * @var integer
     */
    private $codTipoConta;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    private $fkContabilidadeContaLancamentoRps;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeContaLancamentoRps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoConta
     *
     * @param integer $codTipoConta
     * @return TipoContaLancamentoRp
     */
    public function setCodTipoConta($codTipoConta)
    {
        $this->codTipoConta = $codTipoConta;
        return $this;
    }

    /**
     * Get codTipoConta
     *
     * @return integer
     */
    public function getCodTipoConta()
    {
        return $this->codTipoConta;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoContaLancamentoRp
     */
    public function setDescricao($descricao = null)
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
     * Add ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     * @return TipoContaLancamentoRp
     */
    public function addFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        if (false === $this->fkContabilidadeContaLancamentoRps->contains($fkContabilidadeContaLancamentoRp)) {
            $fkContabilidadeContaLancamentoRp->setFkContabilidadeTipoContaLancamentoRp($this);
            $this->fkContabilidadeContaLancamentoRps->add($fkContabilidadeContaLancamentoRp);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp
     */
    public function removeFkContabilidadeContaLancamentoRps(\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp $fkContabilidadeContaLancamentoRp)
    {
        $this->fkContabilidadeContaLancamentoRps->removeElement($fkContabilidadeContaLancamentoRp);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeContaLancamentoRps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ContaLancamentoRp
     */
    public function getFkContabilidadeContaLancamentoRps()
    {
        return $this->fkContabilidadeContaLancamentoRps;
    }
}
