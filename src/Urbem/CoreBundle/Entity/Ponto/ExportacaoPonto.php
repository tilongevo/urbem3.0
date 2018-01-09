<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ExportacaoPonto
 */
class ExportacaoPonto
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $lancamento;

    /**
     * @var string
     */
    private $formato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\TipoInformacao
     */
    private $fkPontoTipoInformacao;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ExportacaoPonto
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ExportacaoPonto
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ExportacaoPonto
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
     * Set lancamento
     *
     * @param string $lancamento
     * @return ExportacaoPonto
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;
        return $this;
    }

    /**
     * Get lancamento
     *
     * @return string
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * Set formato
     *
     * @param string $formato
     * @return ExportacaoPonto
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;
        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ExportacaoPonto
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ExportacaoPonto
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoTipoInformacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\TipoInformacao $fkPontoTipoInformacao
     * @return ExportacaoPonto
     */
    public function setFkPontoTipoInformacao(\Urbem\CoreBundle\Entity\Ponto\TipoInformacao $fkPontoTipoInformacao)
    {
        $this->codTipo = $fkPontoTipoInformacao->getCodTipo();
        $this->fkPontoTipoInformacao = $fkPontoTipoInformacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoTipoInformacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\TipoInformacao
     */
    public function getFkPontoTipoInformacao()
    {
        return $this->fkPontoTipoInformacao;
    }
}
