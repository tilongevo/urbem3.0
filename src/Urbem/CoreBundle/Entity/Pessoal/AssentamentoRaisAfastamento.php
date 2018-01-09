<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoRaisAfastamento
 */
class AssentamentoRaisAfastamento
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
    private $codRais;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario
     */
    private $fkPessoalAssentamentoAfastamentoTemporario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\RaisAfastamento
     */
    private $fkPessoalRaisAfastamento;

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
     * @return AssentamentoRaisAfastamento
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
     * @return AssentamentoRaisAfastamento
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
     * Set codRais
     *
     * @param integer $codRais
     * @return AssentamentoRaisAfastamento
     */
    public function setCodRais($codRais)
    {
        $this->codRais = $codRais;
        return $this;
    }

    /**
     * Get codRais
     *
     * @return integer
     */
    public function getCodRais()
    {
        return $this->codRais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalRaisAfastamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\RaisAfastamento $fkPessoalRaisAfastamento
     * @return AssentamentoRaisAfastamento
     */
    public function setFkPessoalRaisAfastamento(\Urbem\CoreBundle\Entity\Pessoal\RaisAfastamento $fkPessoalRaisAfastamento)
    {
        $this->codRais = $fkPessoalRaisAfastamento->getCodRais();
        $this->fkPessoalRaisAfastamento = $fkPessoalRaisAfastamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalRaisAfastamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\RaisAfastamento
     */
    public function getFkPessoalRaisAfastamento()
    {
        return $this->fkPessoalRaisAfastamento;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamentoAfastamentoTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $fkPessoalAssentamentoAfastamentoTemporario
     * @return AssentamentoRaisAfastamento
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
