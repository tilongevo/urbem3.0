<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * PensaoValor
 */
class PensaoValor
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
    private $valor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    private $fkPessoalPensao;

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
     * @return PensaoValor
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
     * @return PensaoValor
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
     * Set valor
     *
     * @param integer $valor
     * @return PensaoValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalPensao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao
     * @return PensaoValor
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
        return (string) $this->getValor();
    }
}
