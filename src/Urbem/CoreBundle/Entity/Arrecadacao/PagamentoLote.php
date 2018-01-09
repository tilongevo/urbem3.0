<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * PagamentoLote
 */
class PagamentoLote
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
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;


    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return PagamentoLote
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
     * @return PagamentoLote
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
     * Set codLote
     *
     * @param integer $codLote
     * @return PagamentoLote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PagamentoLote
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return PagamentoLote
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return PagamentoLote
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
     * Set fkArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return PagamentoLote
     */
    public function setFkArrecadacaoLote(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->exercicio = $fkArrecadacaoLote->getExercicio();
        $this->codLote = $fkArrecadacaoLote->getCodLote();
        $this->fkArrecadacaoLote = $fkArrecadacaoLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLote()
    {
        return $this->fkArrecadacaoLote;
    }
}
