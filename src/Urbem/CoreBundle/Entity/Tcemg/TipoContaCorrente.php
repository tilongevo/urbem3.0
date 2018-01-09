<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoContaCorrente
 */
class TipoContaCorrente
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura
     */
    private $fkContabilidadePlanoContaEstruturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePlanoContaEstruturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoContaCorrente
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
     * @return TipoContaCorrente
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
     * Add ContabilidadePlanoContaEstrutura
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura
     * @return TipoContaCorrente
     */
    public function addFkContabilidadePlanoContaEstruturas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura)
    {
        if (false === $this->fkContabilidadePlanoContaEstruturas->contains($fkContabilidadePlanoContaEstrutura)) {
            $fkContabilidadePlanoContaEstrutura->setFkTcemgTipoContaCorrente($this);
            $this->fkContabilidadePlanoContaEstruturas->add($fkContabilidadePlanoContaEstrutura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoContaEstrutura
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura
     */
    public function removeFkContabilidadePlanoContaEstruturas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura $fkContabilidadePlanoContaEstrutura)
    {
        $this->fkContabilidadePlanoContaEstruturas->removeElement($fkContabilidadePlanoContaEstrutura);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContaEstruturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoContaEstrutura
     */
    public function getFkContabilidadePlanoContaEstruturas()
    {
        return $this->fkContabilidadePlanoContaEstruturas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return TipoContaCorrente
     */
    public function addFkContabilidadePlanoContas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        if (false === $this->fkContabilidadePlanoContas->contains($fkContabilidadePlanoConta)) {
            $fkContabilidadePlanoConta->setFkTcemgTipoContaCorrente($this);
            $this->fkContabilidadePlanoContas->add($fkContabilidadePlanoConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     */
    public function removeFkContabilidadePlanoContas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->fkContabilidadePlanoContas->removeElement($fkContabilidadePlanoConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoContas()
    {
        return $this->fkContabilidadePlanoContas;
    }
}
