<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwImovelAtivoView
 */
class VwImovelAtivoView
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codSublote;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtCadastro;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return VwImovelAtivo
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return VwImovelAtivo
     */
    public function setCodLote($codLote = null)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codSublote
     *
     * @param integer $codSublote
     * @return VwImovelAtivo
     */
    public function setCodSublote($codSublote = null)
    {
        $this->codSublote = $codSublote;
        return $this;
    }

    /**
     * Get codSublote
     *
     * @return integer
     */
    public function getCodSublote()
    {
        return $this->codSublote;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwImovelAtivo
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return VwImovelAtivo
     */
    public function setDtCadastro(\DateTime $dtCadastro = null)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }
}
