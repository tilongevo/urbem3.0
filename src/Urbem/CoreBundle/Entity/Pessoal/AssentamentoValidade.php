<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoValidade
 */
class AssentamentoValidade
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
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * @var boolean
     */
    private $cancelarDireito = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    private $fkPessoalAssentamento;

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
     * @return AssentamentoValidade
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
     * @return AssentamentoValidade
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
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return AssentamentoValidade
     */
    public function setDtInicial(\DateTime $dtInicial = null)
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
     * @return AssentamentoValidade
     */
    public function setDtFinal(\DateTime $dtFinal = null)
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
     * Set cancelarDireito
     *
     * @param boolean $cancelarDireito
     * @return AssentamentoValidade
     */
    public function setCancelarDireito($cancelarDireito)
    {
        $this->cancelarDireito = $cancelarDireito;
        return $this;
    }

    /**
     * Get cancelarDireito
     *
     * @return boolean
     */
    public function getCancelarDireito()
    {
        return $this->cancelarDireito;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     * @return AssentamentoValidade
     */
    public function setFkPessoalAssentamento(\Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamento->getCodAssentamento();
        $this->timestamp = $fkPessoalAssentamento->getTimestamp();
        $this->fkPessoalAssentamento = $fkPessoalAssentamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Assentamento
     */
    public function getFkPessoalAssentamento()
    {
        return $this->fkPessoalAssentamento;
    }
}
