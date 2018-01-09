<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwNotaLiquidacao
 */
class SwNotaLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLiquidacao
     */
    private $fkSwLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao
     */
    private $fkSwPagamentoLiquidacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwEmpenho
     */
    private $fkSwEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwPagamentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwNotaLiquidacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwNotaLiquidacao
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
     * Set codNota
     *
     * @param integer $codNota
     * @return SwNotaLiquidacao
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return SwNotaLiquidacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return SwNotaLiquidacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao
     * @return SwNotaLiquidacao
     */
    public function addFkSwLiquidacoes(\Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao)
    {
        if (false === $this->fkSwLiquidacoes->contains($fkSwLiquidacao)) {
            $fkSwLiquidacao->setFkSwNotaLiquidacao($this);
            $this->fkSwLiquidacoes->add($fkSwLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao
     */
    public function removeFkSwLiquidacoes(\Urbem\CoreBundle\Entity\SwLiquidacao $fkSwLiquidacao)
    {
        $this->fkSwLiquidacoes->removeElement($fkSwLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLiquidacao
     */
    public function getFkSwLiquidacoes()
    {
        return $this->fkSwLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao
     * @return SwNotaLiquidacao
     */
    public function addFkSwPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao)
    {
        if (false === $this->fkSwPagamentoLiquidacoes->contains($fkSwPagamentoLiquidacao)) {
            $fkSwPagamentoLiquidacao->setFkSwNotaLiquidacao($this);
            $this->fkSwPagamentoLiquidacoes->add($fkSwPagamentoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao
     */
    public function removeFkSwPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao)
    {
        $this->fkSwPagamentoLiquidacoes->removeElement($fkSwPagamentoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPagamentoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao
     */
    public function getFkSwPagamentoLiquidacoes()
    {
        return $this->fkSwPagamentoLiquidacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     * @return SwNotaLiquidacao
     */
    public function setFkSwEmpenho(\Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho)
    {
        $this->exercicio = $fkSwEmpenho->getExercicio();
        $this->codEmpenho = $fkSwEmpenho->getCodEmpenho();
        $this->fkSwEmpenho = $fkSwEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwEmpenho
     */
    public function getFkSwEmpenho()
    {
        return $this->fkSwEmpenho;
    }
}
