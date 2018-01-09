<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ObservacaoPagamento
 */
class ObservacaoPagamento
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
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TipoObservacao
     */
    private $fkArrecadacaoTipoObservacao;


    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return ObservacaoPagamento
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
     * @return ObservacaoPagamento
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
     * @return ObservacaoPagamento
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ObservacaoPagamento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ObservacaoPagamento
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return ObservacaoPagamento
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
     * Set fkArrecadacaoTipoObservacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TipoObservacao $fkArrecadacaoTipoObservacao
     * @return ObservacaoPagamento
     */
    public function setFkArrecadacaoTipoObservacao(\Urbem\CoreBundle\Entity\Arrecadacao\TipoObservacao $fkArrecadacaoTipoObservacao)
    {
        $this->codTipo = $fkArrecadacaoTipoObservacao->getCodTipo();
        $this->fkArrecadacaoTipoObservacao = $fkArrecadacaoTipoObservacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTipoObservacao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TipoObservacao
     */
    public function getFkArrecadacaoTipoObservacao()
    {
        return $this->fkArrecadacaoTipoObservacao;
    }
}
