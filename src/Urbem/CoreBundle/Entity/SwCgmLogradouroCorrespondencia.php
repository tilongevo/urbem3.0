<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgmLogradouroCorrespondencia
 */
class SwCgmLogradouroCorrespondencia
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

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
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgmLogradouroCorrespondencia
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
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwCgmLogradouroCorrespondencia
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
     * @return SwCgmLogradouroCorrespondencia
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
     * @return SwCgmLogradouroCorrespondencia
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
     * @return SwCgmLogradouroCorrespondencia
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
     * @return SwCgmLogradouroCorrespondencia
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwCgmLogradouroCorrespondencia
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     * @return SwCgmLogradouroCorrespondencia
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
     * @return SwCgmLogradouroCorrespondencia
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
