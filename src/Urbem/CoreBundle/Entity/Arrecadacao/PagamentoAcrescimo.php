<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * PagamentoAcrescimo
 */
class PagamentoAcrescimo
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
    private $ocorrenciaPagamento;

    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $valor;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimo;


    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return PagamentoAcrescimo
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
     * @return PagamentoAcrescimo
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
     * @return PagamentoAcrescimo
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
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return PagamentoAcrescimo
     */
    public function setCodAcrescimo($codAcrescimo)
    {
        $this->codAcrescimo = $codAcrescimo;
        return $this;
    }

    /**
     * Get codAcrescimo
     *
     * @return integer
     */
    public function getCodAcrescimo()
    {
        return $this->codAcrescimo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PagamentoAcrescimo
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return PagamentoAcrescimo
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
     * Set valor
     *
     * @param integer $valor
     * @return PagamentoAcrescimo
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
     * Set fkArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return PagamentoAcrescimo
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
     * @return PagamentoAcrescimo
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

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return PagamentoAcrescimo
     */
    public function setFkMonetarioAcrescimo(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo)
    {
        $this->codAcrescimo = $fkMonetarioAcrescimo->getCodAcrescimo();
        $this->codTipo = $fkMonetarioAcrescimo->getCodTipo();
        $this->fkMonetarioAcrescimo = $fkMonetarioAcrescimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    public function getFkMonetarioAcrescimo()
    {
        return $this->fkMonetarioAcrescimo;
    }
}
