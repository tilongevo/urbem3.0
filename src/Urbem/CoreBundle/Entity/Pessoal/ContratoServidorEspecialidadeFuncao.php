<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorEspecialidadeFuncao
 */
class ContratoServidorEspecialidadeFuncao
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidade;

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
     * @return ContratoServidorEspecialidadeFuncao
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
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return ContratoServidorEspecialidadeFuncao
     */
    public function setCodEspecialidade($codEspecialidade)
    {
        $this->codEspecialidade = $codEspecialidade;
        return $this;
    }

    /**
     * Get codEspecialidade
     *
     * @return integer
     */
    public function getCodEspecialidade()
    {
        return $this->codEspecialidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorEspecialidadeFuncao
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
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorEspecialidadeFuncao
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
     * Set fkPessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return ContratoServidorEspecialidadeFuncao
     */
    public function setFkPessoalEspecialidade(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        $this->codEspecialidade = $fkPessoalEspecialidade->getCodEspecialidade();
        $this->fkPessoalEspecialidade = $fkPessoalEspecialidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalEspecialidade
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    public function getFkPessoalEspecialidade()
    {
        return $this->fkPessoalEspecialidade;
    }
}
