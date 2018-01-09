<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoSituacao
 */
class ConfiguracaoEmpenhoSituacao
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $situacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEmpenhoSituacao
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConfiguracaoEmpenhoSituacao
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoSituacao
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
     * Set situacao
     *
     * @param string $situacao
     * @return ConfiguracaoEmpenhoSituacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEmpenhoSituacao
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return ConfiguracaoEmpenhoSituacao
     */
    public function setFkFolhapagamentoConfiguracaoEmpenho(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEmpenho->getCodConfiguracao();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenho->getExercicio();
        $this->sequencia = $fkFolhapagamentoConfiguracaoEmpenho->getSequencia();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenho->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenho = $fkFolhapagamentoConfiguracaoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenho()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenho;
    }
}
