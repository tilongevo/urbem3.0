<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * PenalidadeBaixa
 */
class PenalidadeBaixa
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
     * @var \DateTime
     */
    private $timestampTermino;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso
     */
    private $fkFiscalizacaoPenalidadeBaixaProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidade;

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
     * @return PenalidadeBaixa
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
     * @return PenalidadeBaixa
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
     * Set timestampTermino
     *
     * @param \DateTime $timestampTermino
     * @return PenalidadeBaixa
     */
    public function setTimestampTermino(\DateTime $timestampTermino = null)
    {
        $this->timestampTermino = $timestampTermino;
        return $this;
    }

    /**
     * Get timestampTermino
     *
     * @return \DateTime
     */
    public function getTimestampTermino()
    {
        return $this->timestampTermino;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return PenalidadeBaixa
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return PenalidadeBaixa
     */
    public function setFkFiscalizacaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidade->getCodPenalidade();
        $this->fkFiscalizacaoPenalidade = $fkFiscalizacaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidade()
    {
        return $this->fkFiscalizacaoPenalidade;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoPenalidadeBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso
     * @return PenalidadeBaixa
     */
    public function setFkFiscalizacaoPenalidadeBaixaProcesso(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso $fkFiscalizacaoPenalidadeBaixaProcesso)
    {
        $fkFiscalizacaoPenalidadeBaixaProcesso->setFkFiscalizacaoPenalidadeBaixa($this);
        $this->fkFiscalizacaoPenalidadeBaixaProcesso = $fkFiscalizacaoPenalidadeBaixaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoPenalidadeBaixaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixaProcesso
     */
    public function getFkFiscalizacaoPenalidadeBaixaProcesso()
    {
        return $this->fkFiscalizacaoPenalidadeBaixaProcesso;
    }
}
