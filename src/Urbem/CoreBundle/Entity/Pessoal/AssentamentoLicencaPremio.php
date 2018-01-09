<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoLicencaPremio
 */
class AssentamentoLicencaPremio
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamentoGerado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAssentamentoGerado
     *
     * @param integer $codAssentamentoGerado
     * @return AssentamentoLicencaPremio
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AssentamentoLicencaPremio
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return AssentamentoLicencaPremio
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return AssentamentoLicencaPremio
     */
    public function setDtFinal(\DateTime $dtFinal)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     * @return AssentamentoLicencaPremio
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
