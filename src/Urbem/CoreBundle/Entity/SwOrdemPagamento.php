<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwOrdemPagamento
 */
class SwOrdemPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao
     */
    private $fkSwPagamentoLiquidacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwPagamentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtEmissao = new \DateTime;
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return SwOrdemPagamento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwOrdemPagamento
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
     * Set observacao
     *
     * @param string $observacao
     * @return SwOrdemPagamento
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
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return SwOrdemPagamento
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return SwOrdemPagamento
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
     * OneToMany (owning side)
     * Add SwPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao
     * @return SwOrdemPagamento
     */
    public function addFkSwPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao)
    {
        if (false === $this->fkSwPagamentoLiquidacoes->contains($fkSwPagamentoLiquidacao)) {
            $fkSwPagamentoLiquidacao->setFkSwOrdemPagamento($this);
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
}
