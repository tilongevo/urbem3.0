<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoGeradoExcluido
 */
class AssentamentoGeradoExcluido
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codAssentamentoGerado;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $timestampExcluido;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    private $fkPessoalAssentamentoGerado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampExcluido = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoGeradoExcluido
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
     * Set codAssentamentoGerado
     *
     * @param integer $codAssentamentoGerado
     * @return AssentamentoGeradoExcluido
     */
    public function setCodAssentamentoGerado($codAssentamentoGerado)
    {
        $this->codAssentamentoGerado = $codAssentamentoGerado;
        return $this;
    }

    /**
     * Get codAssentamentoGerado
     *
     * @return integer
     */
    public function getCodAssentamentoGerado()
    {
        return $this->codAssentamentoGerado;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AssentamentoGeradoExcluido
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set timestampExcluido
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampExcluido
     * @return AssentamentoGeradoExcluido
     */
    public function setTimestampExcluido(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampExcluido)
    {
        $this->timestampExcluido = $timestampExcluido;
        return $this;
    }

    /**
     * Get timestampExcluido
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampExcluido()
    {
        return $this->timestampExcluido;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     * @return AssentamentoGeradoExcluido
     */
    public function setFkPessoalAssentamentoGerado(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        $this->timestamp = $fkPessoalAssentamentoGerado->getTimestamp();
        $this->codAssentamentoGerado = $fkPessoalAssentamentoGerado->getCodAssentamentoGerado();
        $this->fkPessoalAssentamentoGerado = $fkPessoalAssentamentoGerado;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAssentamentoGerado
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    public function getFkPessoalAssentamentoGerado()
    {
        return $this->fkPessoalAssentamentoGerado;
    }
}
