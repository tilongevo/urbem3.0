<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoAfastamentoTemporarioDuracao
 */
class AssentamentoAfastamentoTemporarioDuracao
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $dia;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    private $fkPessoalAssentamentoAfastamentoTemporario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return AssentamentoAfastamentoTemporarioDuracao
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoAfastamentoTemporarioDuracao
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
     * Set dia
     *
     * @param integer $dia
     * @return AssentamentoAfastamentoTemporarioDuracao
     */
    public function setDia($dia = null)
    {
        $this->dia = $dia;
        return $this;
    }

    /**
     * Get dia
     *
     * @return integer
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamentoAfastamentoTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario
     * @return AssentamentoAfastamentoTemporarioDuracao
     */
    public function setFkPessoalAssentamentoAfastamentoTemporario(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAfastamentoTemporario->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamentoAfastamentoTemporario->getTimestamp();
        $this->fkPessoalAssentamentoAfastamentoTemporario = $fkPessoalAssentamentoAfastamentoTemporario;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAssentamentoAfastamentoTemporario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    public function getFkPessoalAssentamentoAfastamentoTemporario()
    {
        return $this->fkPessoalAssentamentoAfastamentoTemporario;
    }
}
