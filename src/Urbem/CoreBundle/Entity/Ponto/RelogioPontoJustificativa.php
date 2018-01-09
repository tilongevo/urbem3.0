<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * RelogioPontoJustificativa
 */
class RelogioPontoJustificativa
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codJustificativa;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var \DateTime
     */
    private $periodoInicio;

    /**
     * @var \DateTime
     */
    private $periodoTermino;

    /**
     * @var \DateTime
     */
    private $horasFalta;

    /**
     * @var \DateTime
     */
    private $horasAbonar;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativaExclusao
     */
    private $fkPontoRelogioPontoJustificativaExclusao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    private $fkPontoDadosRelogioPonto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\Justificativa
     */
    private $fkPontoJustificativa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RelogioPontoJustificativa
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return RelogioPontoJustificativa
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
     * Set codJustificativa
     *
     * @param integer $codJustificativa
     * @return RelogioPontoJustificativa
     */
    public function setCodJustificativa($codJustificativa)
    {
        $this->codJustificativa = $codJustificativa;
        return $this;
    }

    /**
     * Get codJustificativa
     *
     * @return integer
     */
    public function getCodJustificativa()
    {
        return $this->codJustificativa;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return RelogioPontoJustificativa
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
     * Set periodoInicio
     *
     * @param \DateTime $periodoInicio
     * @return RelogioPontoJustificativa
     */
    public function setPeriodoInicio(\DateTime $periodoInicio)
    {
        $this->periodoInicio = $periodoInicio;
        return $this;
    }

    /**
     * Get periodoInicio
     *
     * @return \DateTime
     */
    public function getPeriodoInicio()
    {
        return $this->periodoInicio;
    }

    /**
     * Set periodoTermino
     *
     * @param \DateTime $periodoTermino
     * @return RelogioPontoJustificativa
     */
    public function setPeriodoTermino(\DateTime $periodoTermino)
    {
        $this->periodoTermino = $periodoTermino;
        return $this;
    }

    /**
     * Get periodoTermino
     *
     * @return \DateTime
     */
    public function getPeriodoTermino()
    {
        return $this->periodoTermino;
    }

    /**
     * Set horasFalta
     *
     * @param \DateTime $horasFalta
     * @return RelogioPontoJustificativa
     */
    public function setHorasFalta(\DateTime $horasFalta)
    {
        $this->horasFalta = $horasFalta;
        return $this;
    }

    /**
     * Get horasFalta
     *
     * @return \DateTime
     */
    public function getHorasFalta()
    {
        return $this->horasFalta;
    }

    /**
     * Set horasAbonar
     *
     * @param \DateTime $horasAbonar
     * @return RelogioPontoJustificativa
     */
    public function setHorasAbonar(\DateTime $horasAbonar)
    {
        $this->horasAbonar = $horasAbonar;
        return $this;
    }

    /**
     * Get horasAbonar
     *
     * @return \DateTime
     */
    public function getHorasAbonar()
    {
        return $this->horasAbonar;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return RelogioPontoJustificativa
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoDadosRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto
     * @return RelogioPontoJustificativa
     */
    public function setFkPontoDadosRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto $fkPontoDadosRelogioPonto)
    {
        $this->codContrato = $fkPontoDadosRelogioPonto->getCodContrato();
        $this->fkPontoDadosRelogioPonto = $fkPontoDadosRelogioPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoDadosRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPonto
     */
    public function getFkPontoDadosRelogioPonto()
    {
        return $this->fkPontoDadosRelogioPonto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Justificativa $fkPontoJustificativa
     * @return RelogioPontoJustificativa
     */
    public function setFkPontoJustificativa(\Urbem\CoreBundle\Entity\Ponto\Justificativa $fkPontoJustificativa)
    {
        $this->codJustificativa = $fkPontoJustificativa->getCodJustificativa();
        $this->fkPontoJustificativa = $fkPontoJustificativa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoJustificativa
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Justificativa
     */
    public function getFkPontoJustificativa()
    {
        return $this->fkPontoJustificativa;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoRelogioPontoJustificativaExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativaExclusao $fkPontoRelogioPontoJustificativaExclusao
     * @return RelogioPontoJustificativa
     */
    public function setFkPontoRelogioPontoJustificativaExclusao(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativaExclusao $fkPontoRelogioPontoJustificativaExclusao)
    {
        $fkPontoRelogioPontoJustificativaExclusao->setFkPontoRelogioPontoJustificativa($this);
        $this->fkPontoRelogioPontoJustificativaExclusao = $fkPontoRelogioPontoJustificativaExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoRelogioPontoJustificativaExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativaExclusao
     */
    public function getFkPontoRelogioPontoJustificativaExclusao()
    {
        return $this->fkPontoRelogioPontoJustificativaExclusao;
    }
}
