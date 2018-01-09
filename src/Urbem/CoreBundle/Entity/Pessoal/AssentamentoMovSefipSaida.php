<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoMovSefipSaida
 */
class AssentamentoMovSefipSaida
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
    private $codSefipSaida;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    private $fkPessoalAssentamentoAfastamentoTemporario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    private $fkPessoalMovSefipSaida;

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
     * @return AssentamentoMovSefipSaida
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
     * @return AssentamentoMovSefipSaida
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
     * Set codSefipSaida
     *
     * @param integer $codSefipSaida
     * @return AssentamentoMovSefipSaida
     */
    public function setCodSefipSaida($codSefipSaida)
    {
        $this->codSefipSaida = $codSefipSaida;
        return $this;
    }

    /**
     * Get codSefipSaida
     *
     * @return integer
     */
    public function getCodSefipSaida()
    {
        return $this->codSefipSaida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida
     * @return AssentamentoMovSefipSaida
     */
    public function setFkPessoalMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida)
    {
        $this->codSefipSaida = $fkPessoalMovSefipSaida->getCodSefipSaida();
        $this->fkPessoalMovSefipSaida = $fkPessoalMovSefipSaida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    public function getFkPessoalMovSefipSaida()
    {
        return $this->fkPessoalMovSefipSaida;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamentoAfastamentoTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario
     * @return AssentamentoMovSefipSaida
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
