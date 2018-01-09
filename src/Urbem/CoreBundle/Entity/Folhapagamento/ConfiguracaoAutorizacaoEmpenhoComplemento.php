<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoAutorizacaoEmpenhoComplemento
 */
class ConfiguracaoAutorizacaoEmpenhoComplemento
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
     * @var string
     */
    private $complementoItem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho;

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
     * @return ConfiguracaoAutorizacaoEmpenhoComplemento
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
     * @return ConfiguracaoAutorizacaoEmpenhoComplemento
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
     * @return ConfiguracaoAutorizacaoEmpenhoComplemento
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
     * Set complementoItem
     *
     * @param string $complementoItem
     * @return ConfiguracaoAutorizacaoEmpenhoComplemento
     */
    public function setComplementoItem($complementoItem)
    {
        $this->complementoItem = $complementoItem;
        return $this;
    }

    /**
     * Get complementoItem
     *
     * @return string
     */
    public function getComplementoItem()
    {
        return $this->complementoItem;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     * @return ConfiguracaoAutorizacaoEmpenhoComplemento
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
