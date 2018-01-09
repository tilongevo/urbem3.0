<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventoCasoSubDivisao
 */
class ConfiguracaoEventoCasoSubDivisao
{
    /**
     * PK
     * @var integer
     */
    private $codCaso;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCaso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCaso
     *
     * @param integer $codCaso
     * @return ConfiguracaoEventoCasoSubDivisao
     */
    public function setCodCaso($codCaso)
    {
        $this->codCaso = $codCaso;
        return $this;
    }

    /**
     * Get codCaso
     *
     * @return integer
     */
    public function getCodCaso()
    {
        return $this->codCaso;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ConfiguracaoEventoCasoSubDivisao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEventoCasoSubDivisao
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEventoCasoSubDivisao
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
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return ConfiguracaoEventoCasoSubDivisao
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return ConfiguracaoEventoCasoSubDivisao
     */
    public function setFkFolhapagamentoConfiguracaoEventoCaso(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->codCaso = $fkFolhapagamentoConfiguracaoEventoCaso->getCodCaso();
        $this->codEvento = $fkFolhapagamentoConfiguracaoEventoCaso->getCodEvento();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEventoCaso->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEventoCaso->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEventoCaso = $fkFolhapagamentoConfiguracaoEventoCaso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCaso()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCaso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return ConfiguracaoEventoCasoSubDivisao
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }
}
