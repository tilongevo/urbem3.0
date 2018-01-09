<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPagamentoLiquidacao
 */
class SwPagamentoLiquidacao
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
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * @var integer
     */
    private $vlPagamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPagamento
     */
    private $fkSwPagamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    private $fkSwNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwOrdemPagamento
     */
    private $fkSwOrdemPagamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwPagamentoLiquidacao
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
     * @return SwPagamentoLiquidacao
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
     * @return SwPagamentoLiquidacao
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return SwPagamentoLiquidacao
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set vlPagamento
     *
     * @param integer $vlPagamento
     * @return SwPagamentoLiquidacao
     */
    public function setVlPagamento($vlPagamento)
    {
        $this->vlPagamento = $vlPagamento;
        return $this;
    }

    /**
     * Get vlPagamento
     *
     * @return integer
     */
    public function getVlPagamento()
    {
        return $this->vlPagamento;
    }

    /**
     * OneToMany (owning side)
     * Add SwPagamento
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento
     * @return SwPagamentoLiquidacao
     */
    public function addFkSwPagamentos(\Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento)
    {
        if (false === $this->fkSwPagamentos->contains($fkSwPagamento)) {
            $fkSwPagamento->setFkSwPagamentoLiquidacao($this);
            $this->fkSwPagamentos->add($fkSwPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPagamento
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento
     */
    public function removeFkSwPagamentos(\Urbem\CoreBundle\Entity\SwPagamento $fkSwPagamento)
    {
        $this->fkSwPagamentos->removeElement($fkSwPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPagamento
     */
    public function getFkSwPagamentos()
    {
        return $this->fkSwPagamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao
     * @return SwPagamentoLiquidacao
     */
    public function setFkSwNotaLiquidacao(\Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao)
    {
        $this->codEmpenho = $fkSwNotaLiquidacao->getCodEmpenho();
        $this->exercicio = $fkSwNotaLiquidacao->getExercicio();
        $this->codNota = $fkSwNotaLiquidacao->getCodNota();
        $this->fkSwNotaLiquidacao = $fkSwNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    public function getFkSwNotaLiquidacao()
    {
        return $this->fkSwNotaLiquidacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\SwOrdemPagamento $fkSwOrdemPagamento
     * @return SwPagamentoLiquidacao
     */
    public function setFkSwOrdemPagamento(\Urbem\CoreBundle\Entity\SwOrdemPagamento $fkSwOrdemPagamento)
    {
        $this->codOrdem = $fkSwOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkSwOrdemPagamento->getExercicio();
        $this->fkSwOrdemPagamento = $fkSwOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\SwOrdemPagamento
     */
    public function getFkSwOrdemPagamento()
    {
        return $this->fkSwOrdemPagamento;
    }
}
