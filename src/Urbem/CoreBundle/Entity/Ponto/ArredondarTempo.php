<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ArredondarTempo
 */
class ArredondarTempo
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
     * @var \DateTime
     */
    private $horaEntrada1;

    /**
     * @var \DateTime
     */
    private $horaSaida1;

    /**
     * @var \DateTime
     */
    private $horaEntrada2;

    /**
     * @var \DateTime
     */
    private $horaSaida2;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

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
     * @return ArredondarTempo
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
     * @return ArredondarTempo
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
     * Set horaEntrada1
     *
     * @param \DateTime $horaEntrada1
     * @return ArredondarTempo
     */
    public function setHoraEntrada1(\DateTime $horaEntrada1)
    {
        $this->horaEntrada1 = $horaEntrada1;
        return $this;
    }

    /**
     * Get horaEntrada1
     *
     * @return \DateTime
     */
    public function getHoraEntrada1()
    {
        return $this->horaEntrada1;
    }

    /**
     * Set horaSaida1
     *
     * @param \DateTime $horaSaida1
     * @return ArredondarTempo
     */
    public function setHoraSaida1(\DateTime $horaSaida1)
    {
        $this->horaSaida1 = $horaSaida1;
        return $this;
    }

    /**
     * Get horaSaida1
     *
     * @return \DateTime
     */
    public function getHoraSaida1()
    {
        return $this->horaSaida1;
    }

    /**
     * Set horaEntrada2
     *
     * @param \DateTime $horaEntrada2
     * @return ArredondarTempo
     */
    public function setHoraEntrada2(\DateTime $horaEntrada2)
    {
        $this->horaEntrada2 = $horaEntrada2;
        return $this;
    }

    /**
     * Get horaEntrada2
     *
     * @return \DateTime
     */
    public function getHoraEntrada2()
    {
        return $this->horaEntrada2;
    }

    /**
     * Set horaSaida2
     *
     * @param \DateTime $horaSaida2
     * @return ArredondarTempo
     */
    public function setHoraSaida2(\DateTime $horaSaida2)
    {
        $this->horaSaida2 = $horaSaida2;
        return $this;
    }

    /**
     * Get horaSaida2
     *
     * @return \DateTime
     */
    public function getHoraSaida2()
    {
        return $this->horaSaida2;
    }

    /**
     * OneToOne (owning side)
     * Set PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return ArredondarTempo
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
