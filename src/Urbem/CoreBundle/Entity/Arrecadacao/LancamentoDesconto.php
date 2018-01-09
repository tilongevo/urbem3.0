<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * LancamentoDesconto
 */
class LancamentoDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * PK
     * @var integer
     */
    private $codDesconto;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    private $fkArrecadacaoLancamento;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoDesconto
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codDesconto
     *
     * @param integer $codDesconto
     * @return LancamentoDesconto
     */
    public function setCodDesconto($codDesconto)
    {
        $this->codDesconto = $codDesconto;
        return $this;
    }

    /**
     * Get codDesconto
     *
     * @return integer
     */
    public function getCodDesconto()
    {
        return $this->codDesconto;
    }

    /**
     * Set vencimento
     *
     * @param \DateTime $vencimento
     * @return LancamentoDesconto
     */
    public function setVencimento(\DateTime $vencimento)
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    /**
     * Get vencimento
     *
     * @return \DateTime
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return LancamentoDesconto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento
     * @return LancamentoDesconto
     */
    public function setFkArrecadacaoLancamento(\Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento)
    {
        $this->codLancamento = $fkArrecadacaoLancamento->getCodLancamento();
        $this->fkArrecadacaoLancamento = $fkArrecadacaoLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    public function getFkArrecadacaoLancamento()
    {
        return $this->fkArrecadacaoLancamento;
    }
}
