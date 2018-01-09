<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgaLogradouroCorrespondencia
 */
class SwCgaLogradouroCorrespondencia
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
    private $timestampCga;

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
     * @var \Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    private $fkSwCepLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampCga = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgaLogradouroCorrespondencia
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
     * Set timestampCga
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampCga
     * @return SwCgaLogradouroCorrespondencia
     */
    public function setTimestampCga(\Urbem\CoreBundle\Helper\DateTimePK $timestampCga)
    {
        $this->timestampCga = $timestampCga;
        return $this;
    }

    /**
     * Get timestampCga
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampCga()
    {
        return $this->timestampCga;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwCgaLogradouroCorrespondencia
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
     * @return SwCgaLogradouroCorrespondencia
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
     * @return SwCgaLogradouroCorrespondencia
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
     * @return SwCgaLogradouroCorrespondencia
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
     * @return SwCgaLogradouroCorrespondencia
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
     * @return SwCgaLogradouroCorrespondencia
     */
    public function setFkSwCga(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->numcgm = $fkSwCga->getNumcgm();
        $this->timestampCga = $fkSwCga->getTimestamp();
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
     * Set fkSwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     * @return SwCgaLogradouroCorrespondencia
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     * @return SwCgaLogradouroCorrespondencia
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
}
