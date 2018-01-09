<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * PensaoBanco
 */
class PensaoBanco
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
    private $codPensao;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var string
     */
    private $contaCorrente;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    private $fkPessoalPensao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PensaoBanco
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
     * Set codPensao
     *
     * @param integer $codPensao
     * @return PensaoBanco
     */
    public function setCodPensao($codPensao)
    {
        $this->codPensao = $codPensao;
        return $this;
    }

    /**
     * Get codPensao
     *
     * @return integer
     */
    public function getCodPensao()
    {
        return $this->codPensao;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return PensaoBanco
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return PensaoBanco
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set contaCorrente
     *
     * @param string $contaCorrente
     * @return PensaoBanco
     */
    public function setContaCorrente($contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;
        return $this;
    }

    /**
     * Get contaCorrente
     *
     * @return string
     */
    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return PensaoBanco
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalPensao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao
     * @return PensaoBanco
     */
    public function setFkPessoalPensao(\Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao)
    {
        $this->codPensao = $fkPessoalPensao->getCodPensao();
        $this->timestamp = $fkPessoalPensao->getTimestamp();
        $this->fkPessoalPensao = $fkPessoalPensao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalPensao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    public function getFkPessoalPensao()
    {
        return $this->fkPessoalPensao;
    }

    public function __toString()
    {
        return (string) $this->getFkMonetarioAgencia()->getFkMonetarioBanco();
    }
}
