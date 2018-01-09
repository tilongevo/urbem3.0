<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * InfracaoBaixaProcesso
 */
class InfracaoBaixaProcesso
{
    /**
     * PK
     * @var integer
     */
    private $codInfracao;

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
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa
     */
    private $fkFiscalizacaoInfracaoBaixa;

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
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return InfracaoBaixaProcesso
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set timestampInicio
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampInicio
     * @return InfracaoBaixaProcesso
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
     * @return InfracaoBaixaProcesso
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
     * @return InfracaoBaixaProcesso
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
     * @return InfracaoBaixaProcesso
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
     * Set FiscalizacaoInfracaoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa
     * @return InfracaoBaixaProcesso
     */
    public function setFkFiscalizacaoInfracaoBaixa(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa)
    {
        $this->codInfracao = $fkFiscalizacaoInfracaoBaixa->getCodInfracao();
        $this->timestampInicio = $fkFiscalizacaoInfracaoBaixa->getTimestampInicio();
        $this->fkFiscalizacaoInfracaoBaixa = $fkFiscalizacaoInfracaoBaixa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoInfracaoBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa
     */
    public function getFkFiscalizacaoInfracaoBaixa()
    {
        return $this->fkFiscalizacaoInfracaoBaixa;
    }
}
