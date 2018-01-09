<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * PagamentoDiferenca
 */
class PagamentoDiferenca
{
    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaPagamento;

    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao
     */
    private $fkArrecadacaoPagamentoDiferencaCompensacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoPagamentoDiferencaCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return PagamentoDiferenca
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return PagamentoDiferenca
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set ocorrenciaPagamento
     *
     * @param integer $ocorrenciaPagamento
     * @return PagamentoDiferenca
     */
    public function setOcorrenciaPagamento($ocorrenciaPagamento)
    {
        $this->ocorrenciaPagamento = $ocorrenciaPagamento;
        return $this;
    }

    /**
     * Get ocorrenciaPagamento
     *
     * @return integer
     */
    public function getOcorrenciaPagamento()
    {
        return $this->ocorrenciaPagamento;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return PagamentoDiferenca
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return PagamentoDiferenca
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
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoDiferencaCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao
     * @return PagamentoDiferenca
     */
    public function addFkArrecadacaoPagamentoDiferencaCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao)
    {
        if (false === $this->fkArrecadacaoPagamentoDiferencaCompensacoes->contains($fkArrecadacaoPagamentoDiferencaCompensacao)) {
            $fkArrecadacaoPagamentoDiferencaCompensacao->setFkArrecadacaoPagamentoDiferenca($this);
            $this->fkArrecadacaoPagamentoDiferencaCompensacoes->add($fkArrecadacaoPagamentoDiferencaCompensacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoDiferencaCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao
     */
    public function removeFkArrecadacaoPagamentoDiferencaCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao $fkArrecadacaoPagamentoDiferencaCompensacao)
    {
        $this->fkArrecadacaoPagamentoDiferencaCompensacoes->removeElement($fkArrecadacaoPagamentoDiferencaCompensacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoDiferencaCompensacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferencaCompensacao
     */
    public function getFkArrecadacaoPagamentoDiferencaCompensacoes()
    {
        return $this->fkArrecadacaoPagamentoDiferencaCompensacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return PagamentoDiferenca
     */
    public function setFkArrecadacaoPagamento(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        $this->numeracao = $fkArrecadacaoPagamento->getNumeracao();
        $this->ocorrenciaPagamento = $fkArrecadacaoPagamento->getOcorrenciaPagamento();
        $this->codConvenio = $fkArrecadacaoPagamento->getCodConvenio();
        $this->fkArrecadacaoPagamento = $fkArrecadacaoPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    public function getFkArrecadacaoPagamento()
    {
        return $this->fkArrecadacaoPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return PagamentoDiferenca
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }
}
