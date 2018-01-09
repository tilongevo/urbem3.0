<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoAutorizacaoEmpenhoDescricao
 */
class ConfiguracaoAutorizacaoEmpenhoDescricao
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
    private $descricao;

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
     * @return ConfiguracaoAutorizacaoEmpenhoDescricao
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
     * @return ConfiguracaoAutorizacaoEmpenhoDescricao
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
     * @return ConfiguracaoAutorizacaoEmpenhoDescricao
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
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoAutorizacaoEmpenhoDescricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     * @return ConfiguracaoAutorizacaoEmpenhoDescricao
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
