<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorOcorrencia
 */
class ContratoServidorOcorrencia
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codOcorrencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Ocorrencia
     */
    private $fkPessoalOcorrencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorOcorrencia
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
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorOcorrencia
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codOcorrencia
     *
     * @param integer $codOcorrencia
     * @return ContratoServidorOcorrencia
     */
    public function setCodOcorrencia($codOcorrencia)
    {
        $this->codOcorrencia = $codOcorrencia;
        return $this;
    }

    /**
     * Get codOcorrencia
     *
     * @return integer
     */
    public function getCodOcorrencia()
    {
        return $this->codOcorrencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorOcorrencia
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalOcorrencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia
     * @return ContratoServidorOcorrencia
     */
    public function setFkPessoalOcorrencia(\Urbem\CoreBundle\Entity\Pessoal\Ocorrencia $fkPessoalOcorrencia)
    {
        $this->codOcorrencia = $fkPessoalOcorrencia->getCodOcorrencia();
        $this->fkPessoalOcorrencia = $fkPessoalOcorrencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalOcorrencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Ocorrencia
     */
    public function getFkPessoalOcorrencia()
    {
        return $this->fkPessoalOcorrencia;
    }
}
