<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * PenalidadeBaixaProcesso
 */
class PenalidadeBaixaProcesso
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampInicio;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa
     */
    private $fkFiscalizacaoPenalidadeBaixa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampInicio = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return PenalidadeBaixaProcesso
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set timestampInicio
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampInicio
     * @return PenalidadeBaixaProcesso
     */
    public function setTimestampInicio(\Urbem\CoreBundle\Helper\DateTimePK $timestampInicio)
    {
        $this->timestampInicio = $timestampInicio;
        return $this;
    }

    /**
     * Get timestampInicio
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampInicio()
    {
        return $this->timestampInicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return PenalidadeBaixaProcesso
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return PenalidadeBaixaProcesso
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return PenalidadeBaixaProcesso
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoPenalidadeBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa
     * @return PenalidadeBaixaProcesso
     */
    public function setFkFiscalizacaoPenalidadeBaixa(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidadeBaixa->getCodPenalidade();
        $this->timestampInicio = $fkFiscalizacaoPenalidadeBaixa->getTimestampInicio();
        $this->fkFiscalizacaoPenalidadeBaixa = $fkFiscalizacaoPenalidadeBaixa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoPenalidadeBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa
     */
    public function getFkFiscalizacaoPenalidadeBaixa()
    {
        return $this->fkFiscalizacaoPenalidadeBaixa;
    }
}
