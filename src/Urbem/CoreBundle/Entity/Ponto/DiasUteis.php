<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * DiasUteis
 */
class DiasUteis
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\DiasTurno
     */
    private $fkPessoalDiasTurno;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return DiasUteis
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
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DiasUteis
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return DiasUteis
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return DiasUteis
     */
    public function setFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoParametrosGerais->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoParametrosGerais->getTimestamp();
        $this->fkPontoConfiguracaoParametrosGerais = $fkPontoConfiguracaoParametrosGerais;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoConfiguracaoParametrosGerais
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    public function getFkPontoConfiguracaoParametrosGerais()
    {
        return $this->fkPontoConfiguracaoParametrosGerais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDiasTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno
     * @return DiasUteis
     */
    public function setFkPessoalDiasTurno(\Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno)
    {
        $this->codDia = $fkPessoalDiasTurno->getCodDia();
        $this->fkPessoalDiasTurno = $fkPessoalDiasTurno;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDiasTurno
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\DiasTurno
     */
    public function getFkPessoalDiasTurno()
    {
        return $this->fkPessoalDiasTurno;
    }
}
