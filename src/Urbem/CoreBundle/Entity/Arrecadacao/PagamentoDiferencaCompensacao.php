<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * PagamentoDiferencaCompensacao
 */
class PagamentoDiferencaCompensacao
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaPagamento;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    private $fkArrecadacaoCompensacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca
     */
    private $fkArrecadacaoPagamentoDiferenca;


    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return PagamentoDiferencaCompensacao
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return PagamentoDiferencaCompensacao
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
     * Set ocorrenciaPagamento
     *
     * @param integer $ocorrenciaPagamento
     * @return PagamentoDiferencaCompensacao
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return PagamentoDiferencaCompensacao
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
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return PagamentoDiferencaCompensacao
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     * @return PagamentoDiferencaCompensacao
     */
    public function setFkArrecadacaoCompensacao(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        $this->codCompensacao = $fkArrecadacaoCompensacao->getCodCompensacao();
        $this->fkArrecadacaoCompensacao = $fkArrecadacaoCompensacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCompensacao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    public function getFkArrecadacaoCompensacao()
    {
        return $this->fkArrecadacaoCompensacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoPagamentoDiferenca
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca
     * @return PagamentoDiferencaCompensacao
     */
    public function setFkArrecadacaoPagamentoDiferenca(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca $fkArrecadacaoPagamentoDiferenca)
    {
        $this->numeracao = $fkArrecadacaoPagamentoDiferenca->getNumeracao();
        $this->codConvenio = $fkArrecadacaoPagamentoDiferenca->getCodConvenio();
        $this->ocorrenciaPagamento = $fkArrecadacaoPagamentoDiferenca->getOcorrenciaPagamento();
        $this->codCalculo = $fkArrecadacaoPagamentoDiferenca->getCodCalculo();
        $this->fkArrecadacaoPagamentoDiferenca = $fkArrecadacaoPagamentoDiferenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoPagamentoDiferenca
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoDiferenca
     */
    public function getFkArrecadacaoPagamentoDiferenca()
    {
        return $this->fkArrecadacaoPagamentoDiferenca;
    }
}
