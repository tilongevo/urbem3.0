<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * CalendarioPonto
 */
class CalendarioPonto
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
     * @var integer
     */
    private $codCalendar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    private $fkCalendarioCalendarioCadastro;

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
     * @return CalendarioPonto
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
     * @return CalendarioPonto
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
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return CalendarioPonto
     */
    public function setCodCalendar($codCalendar)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCalendarioCalendarioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro
     * @return CalendarioPonto
     */
    public function setFkCalendarioCalendarioCadastro(\Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro)
    {
        $this->codCalendar = $fkCalendarioCalendarioCadastro->getCodCalendar();
        $this->fkCalendarioCalendarioCadastro = $fkCalendarioCalendarioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioCalendarioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    public function getFkCalendarioCalendarioCadastro()
    {
        return $this->fkCalendarioCalendarioCadastro;
    }

    /**
     * OneToOne (owning side)
     * Set PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return CalendarioPonto
     */
    public function setFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoParametrosGerais->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoParametrosGerais->getTimestamp();
        $this->fkPontoConfiguracaoParametrosGerais = $fkPontoConfiguracaoParametrosGerais;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoConfiguracaoParametrosGerais
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    public function getFkPontoConfiguracaoParametrosGerais()
    {
        return $this->fkPontoConfiguracaoParametrosGerais;
    }
}
