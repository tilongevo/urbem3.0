<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * InfracaoBaixa
 */
class InfracaoBaixa
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
     * @var \DateTime
     */
    private $timestampTermino;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso
     */
    private $fkFiscalizacaoInfracaoBaixaProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    private $fkFiscalizacaoInfracao;

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
     * @return InfracaoBaixa
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
     * @return InfracaoBaixa
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
     * @return InfracaoBaixa
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
     * @return InfracaoBaixa
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
     * Set fkFiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     * @return InfracaoBaixa
     */
    public function setFkFiscalizacaoInfracao(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        $this->codInfracao = $fkFiscalizacaoInfracao->getCodInfracao();
        $this->fkFiscalizacaoInfracao = $fkFiscalizacaoInfracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInfracao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    public function getFkFiscalizacaoInfracao()
    {
        return $this->fkFiscalizacaoInfracao;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoInfracaoBaixaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso
     * @return InfracaoBaixa
     */
    public function setFkFiscalizacaoInfracaoBaixaProcesso(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso $fkFiscalizacaoInfracaoBaixaProcesso)
    {
        $fkFiscalizacaoInfracaoBaixaProcesso->setFkFiscalizacaoInfracaoBaixa($this);
        $this->fkFiscalizacaoInfracaoBaixaProcesso = $fkFiscalizacaoInfracaoBaixaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoInfracaoBaixaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixaProcesso
     */
    public function getFkFiscalizacaoInfracaoBaixaProcesso()
    {
        return $this->fkFiscalizacaoInfracaoBaixaProcesso;
    }
}
