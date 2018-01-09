<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwEmpenho
 */
class SwEmpenho
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * @var \DateTime
     */
    private $dtEmpenho;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * @var integer
     */
    private $vlSaldoAnterior;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwInsuficienciaFinanceira
     */
    private $fkSwInsuficienciaFinanceira;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhamento
     */
    private $fkSwEmpenhamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    private $fkSwNotaLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao
     */
    private $fkSwEmpenhoAutorizacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwEmpenhamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwNotaLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwEmpenhoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwEmpenho
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set dtEmpenho
     *
     * @param \DateTime $dtEmpenho
     * @return SwEmpenho
     */
    public function setDtEmpenho(\DateTime $dtEmpenho)
    {
        $this->dtEmpenho = $dtEmpenho;
        return $this;
    }

    /**
     * Get dtEmpenho
     *
     * @return \DateTime
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return SwEmpenho
     */
    public function setDtVencimento(\DateTime $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return \DateTime
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set vlSaldoAnterior
     *
     * @param integer $vlSaldoAnterior
     * @return SwEmpenho
     */
    public function setVlSaldoAnterior($vlSaldoAnterior)
    {
        $this->vlSaldoAnterior = $vlSaldoAnterior;
        return $this;
    }

    /**
     * Get vlSaldoAnterior
     *
     * @return integer
     */
    public function getVlSaldoAnterior()
    {
        return $this->vlSaldoAnterior;
    }

    /**
     * OneToMany (owning side)
     * Add SwEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento
     * @return SwEmpenho
     */
    public function addFkSwEmpenhamentos(\Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento)
    {
        if (false === $this->fkSwEmpenhamentos->contains($fkSwEmpenhamento)) {
            $fkSwEmpenhamento->setFkSwEmpenho($this);
            $this->fkSwEmpenhamentos->add($fkSwEmpenhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento
     */
    public function removeFkSwEmpenhamentos(\Urbem\CoreBundle\Entity\SwEmpenhamento $fkSwEmpenhamento)
    {
        $this->fkSwEmpenhamentos->removeElement($fkSwEmpenhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwEmpenhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhamento
     */
    public function getFkSwEmpenhamentos()
    {
        return $this->fkSwEmpenhamentos;
    }

    /**
     * OneToMany (owning side)
     * Add SwNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao
     * @return SwEmpenho
     */
    public function addFkSwNotaLiquidacoes(\Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao)
    {
        if (false === $this->fkSwNotaLiquidacoes->contains($fkSwNotaLiquidacao)) {
            $fkSwNotaLiquidacao->setFkSwEmpenho($this);
            $this->fkSwNotaLiquidacoes->add($fkSwNotaLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao
     */
    public function removeFkSwNotaLiquidacoes(\Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao)
    {
        $this->fkSwNotaLiquidacoes->removeElement($fkSwNotaLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwNotaLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    public function getFkSwNotaLiquidacoes()
    {
        return $this->fkSwNotaLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao
     * @return SwEmpenho
     */
    public function addFkSwEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao)
    {
        if (false === $this->fkSwEmpenhoAutorizacoes->contains($fkSwEmpenhoAutorizacao)) {
            $fkSwEmpenhoAutorizacao->setFkSwEmpenho($this);
            $this->fkSwEmpenhoAutorizacoes->add($fkSwEmpenhoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao
     */
    public function removeFkSwEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao)
    {
        $this->fkSwEmpenhoAutorizacoes->removeElement($fkSwEmpenhoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwEmpenhoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao
     */
    public function getFkSwEmpenhoAutorizacoes()
    {
        return $this->fkSwEmpenhoAutorizacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwEmpenho
     */
    public function setFkSwPreEmpenho(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->codPreEmpenho = $fkSwPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwPreEmpenho->getExercicio();
        $this->fkSwPreEmpenho = $fkSwPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenho()
    {
        return $this->fkSwPreEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set SwInsuficienciaFinanceira
     *
     * @param \Urbem\CoreBundle\Entity\SwInsuficienciaFinanceira $fkSwInsuficienciaFinanceira
     * @return SwEmpenho
     */
    public function setFkSwInsuficienciaFinanceira(\Urbem\CoreBundle\Entity\SwInsuficienciaFinanceira $fkSwInsuficienciaFinanceira)
    {
        $fkSwInsuficienciaFinanceira->setFkSwEmpenho($this);
        $this->fkSwInsuficienciaFinanceira = $fkSwInsuficienciaFinanceira;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwInsuficienciaFinanceira
     *
     * @return \Urbem\CoreBundle\Entity\SwInsuficienciaFinanceira
     */
    public function getFkSwInsuficienciaFinanceira()
    {
        return $this->fkSwInsuficienciaFinanceira;
    }
}
