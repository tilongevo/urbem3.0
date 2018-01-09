<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgaLogradouro
 */
class SwCgaLogradouro
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * PK
     * @var string
     */
    private $cep;

    /**
     * PK
     * @var integer
     */
    private $codBairro;

    /**
     * PK
     * @var integer
     */
    private $codMunicipio;

    /**
     * PK
     * @var integer
     */
    private $codUf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCga;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    private $fkSwCepLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgaLogradouro
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
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return SwCgaLogradouro
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
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwCgaLogradouro
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return SwCgaLogradouro
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set codBairro
     *
     * @param integer $codBairro
     * @return SwCgaLogradouro
     */
    public function setCodBairro($codBairro)
    {
        $this->codBairro = $codBairro;
        return $this;
    }

    /**
     * Get codBairro
     *
     * @return integer
     */
    public function getCodBairro()
    {
        return $this->codBairro;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return SwCgaLogradouro
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return SwCgaLogradouro
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwCgaLogradouro
     */
    public function setFkSwCga(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->numcgm = $fkSwCga->getNumcgm();
        $this->timestamp = $fkSwCga->getTimestamp();
        $this->fkSwCga = $fkSwCga;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCga
     *
     * @return \Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCga()
    {
        return $this->fkSwCga;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     * @return SwCgaLogradouro
     */
    public function setFkSwBairroLogradouro(\Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro)
    {
        $this->codUf = $fkSwBairroLogradouro->getCodUf();
        $this->codMunicipio = $fkSwBairroLogradouro->getCodMunicipio();
        $this->codBairro = $fkSwBairroLogradouro->getCodBairro();
        $this->codLogradouro = $fkSwBairroLogradouro->getCodLogradouro();
        $this->fkSwBairroLogradouro = $fkSwBairroLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairroLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    public function getFkSwBairroLogradouro()
    {
        return $this->fkSwBairroLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     * @return SwCgaLogradouro
     */
    public function setFkSwCepLogradouro(\Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro)
    {
        $this->cep = $fkSwCepLogradouro->getCep();
        $this->codLogradouro = $fkSwCepLogradouro->getCodLogradouro();
        $this->fkSwCepLogradouro = $fkSwCepLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCepLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    public function getFkSwCepLogradouro()
    {
        return $this->fkSwCepLogradouro;
    }
}
