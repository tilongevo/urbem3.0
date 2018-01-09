<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FaixasDias
 */
class FaixasDias
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
    private $codFaixa;

    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    private $fkPontoFaixasHorasExtra;

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
     * @return FaixasDias
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
     * @return FaixasDias
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
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FaixasDias
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return FaixasDias
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
     * Set fkPontoFaixasHorasExtra
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra
     * @return FaixasDias
     */
    public function setFkPontoFaixasHorasExtra(\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra)
    {
        $this->codConfiguracao = $fkPontoFaixasHorasExtra->getCodConfiguracao();
        $this->timestamp = $fkPontoFaixasHorasExtra->getTimestamp();
        $this->codFaixa = $fkPontoFaixasHorasExtra->getCodFaixa();
        $this->fkPontoFaixasHorasExtra = $fkPontoFaixasHorasExtra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFaixasHorasExtra
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    public function getFkPontoFaixasHorasExtra()
    {
        return $this->fkPontoFaixasHorasExtra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDiasTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DiasTurno $fkPessoalDiasTurno
     * @return FaixasDias
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
