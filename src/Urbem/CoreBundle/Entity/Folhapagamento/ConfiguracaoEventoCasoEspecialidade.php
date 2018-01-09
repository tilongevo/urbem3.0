<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventoCasoEspecialidade
 */
class ConfiguracaoEventoCasoEspecialidade
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codCaso;

    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidade;

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
     * @return ConfiguracaoEventoCasoEspecialidade
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEventoCasoEspecialidade
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ConfiguracaoEventoCasoEspecialidade
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
     * Set codCaso
     *
     * @param integer $codCaso
     * @return ConfiguracaoEventoCasoEspecialidade
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
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return ConfiguracaoEventoCasoEspecialidade
     */
    public function setCodEspecialidade($codEspecialidade)
    {
        $this->codEspecialidade = $codEspecialidade;
        return $this;
    }

    /**
     * Get codEspecialidade
     *
     * @return integer
     */
    public function getCodEspecialidade()
    {
        return $this->codEspecialidade;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ConfiguracaoEventoCasoEspecialidade
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo
     * @return ConfiguracaoEventoCasoEspecialidade
     */
    public function setFkFolhapagamentoConfiguracaoEventoCasoCargo(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo)
    {
        $this->codCaso = $fkFolhapagamentoConfiguracaoEventoCasoCargo->getCodCaso();
        $this->codEvento = $fkFolhapagamentoConfiguracaoEventoCasoCargo->getCodEvento();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEventoCasoCargo->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEventoCasoCargo->getCodConfiguracao();
        $this->codCargo = $fkFolhapagamentoConfiguracaoEventoCasoCargo->getCodCargo();
        $this->fkFolhapagamentoConfiguracaoEventoCasoCargo = $fkFolhapagamentoConfiguracaoEventoCasoCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoCargo()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return ConfiguracaoEventoCasoEspecialidade
     */
    public function setFkPessoalEspecialidade(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        $this->codEspecialidade = $fkPessoalEspecialidade->getCodEspecialidade();
        $this->fkPessoalEspecialidade = $fkPessoalEspecialidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEspecialidade
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    public function getFkPessoalEspecialidade()
    {
        return $this->fkPessoalEspecialidade;
    }
}
