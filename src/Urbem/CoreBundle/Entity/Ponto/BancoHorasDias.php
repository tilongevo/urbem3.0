<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * BancoHorasDias
 */
class BancoHorasDias
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
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    private $fkPontoConfiguracaoBancoHoras;

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
     * @return BancoHorasDias
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
     * @return BancoHorasDias
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
     * @return BancoHorasDias
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
     * Set fkPontoConfiguracaoBancoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras
     * @return BancoHorasDias
     */
    public function setFkPontoConfiguracaoBancoHoras(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoBancoHoras->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoBancoHoras->getTimestamp();
        $this->fkPontoConfiguracaoBancoHoras = $fkPontoConfiguracaoBancoHoras;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoConfiguracaoBancoHoras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    public function getFkPontoConfiguracaoBancoHoras()
    {
        return $this->fkPontoConfiguracaoBancoHoras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDiasTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno
     * @return BancoHorasDias
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
