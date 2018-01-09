<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoAutorizacaoEmpenhoHistorico
 */
class ConfiguracaoAutorizacaoEmpenhoHistorico
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Historico
     */
    private $fkEmpenhoHistorico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracaoAutorizacao
     *
     * @param integer $codConfiguracaoAutorizacao
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function setCodConfiguracaoAutorizacao($codConfiguracaoAutorizacao)
    {
        $this->codConfiguracaoAutorizacao = $codConfiguracaoAutorizacao;
        return $this;
    }

    /**
     * Get codConfiguracaoAutorizacao
     *
     * @return integer
     */
    public function getCodConfiguracaoAutorizacao()
    {
        return $this->codConfiguracaoAutorizacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Historico $fkEmpenhoHistorico
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function setFkEmpenhoHistorico(\Urbem\CoreBundle\Entity\Empenho\Historico $fkEmpenhoHistorico)
    {
        $this->codHistorico = $fkEmpenhoHistorico->getCodHistorico();
        $this->exercicio = $fkEmpenhoHistorico->getExercicio();
        $this->fkEmpenhoHistorico = $fkEmpenhoHistorico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoHistorico
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Historico
     */
    public function getFkEmpenhoHistorico()
    {
        return $this->fkEmpenhoHistorico;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     * @return ConfiguracaoAutorizacaoEmpenhoHistorico
     */
    public function setFkFolhapagamentoConfiguracaoAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)
    {
        $this->codConfiguracaoAutorizacao = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho->getCodConfiguracaoAutorizacao();
        $this->exercicio = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho->getExercicio();
        $this->timestamp = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenho = $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenho()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenho;
    }
}
