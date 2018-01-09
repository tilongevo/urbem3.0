<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgaPessoaJuridica
 */
class SwCgaPessoaJuridica
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $nomFantasia;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $inscEstadual;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCga;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgaPessoaJuridica
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwCgaPessoaJuridica
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
     * Set nomFantasia
     *
     * @param string $nomFantasia
     * @return SwCgaPessoaJuridica
     */
    public function setNomFantasia($nomFantasia)
    {
        $this->nomFantasia = $nomFantasia;
        return $this;
    }

    /**
     * Get nomFantasia
     *
     * @return string
     */
    public function getNomFantasia()
    {
        return $this->nomFantasia;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     * @return SwCgaPessoaJuridica
     */
    public function setCnpj($cnpj = null)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set inscEstadual
     *
     * @param string $inscEstadual
     * @return SwCgaPessoaJuridica
     */
    public function setInscEstadual($inscEstadual)
    {
        $this->inscEstadual = $inscEstadual;
        return $this;
    }

    /**
     * Get inscEstadual
     *
     * @return string
     */
    public function getInscEstadual()
    {
        return $this->inscEstadual;
    }

    /**
     * OneToOne (owning side)
     * Set SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwCgaPessoaJuridica
     */
    public function setFkSwCga(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->numcgm = $fkSwCga->getNumcgm();
        $this->timestamp = $fkSwCga->getTimestamp();
        $this->fkSwCga = $fkSwCga;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCga
     *
     * @return \Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCga()
    {
        return $this->fkSwCga;
    }
}
