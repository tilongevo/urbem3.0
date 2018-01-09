<?php
 
namespace Urbem\CoreBundle\Entity\Sefazrs;

/**
 * MunicipiosIptu
 */
class MunicipiosIptu
{
    /**
     * PK
     * @var integer
     */
    private $codSefaz;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;


    /**
     * Set codSefaz
     *
     * @param integer $codSefaz
     * @return MunicipiosIptu
     */
    public function setCodSefaz($codSefaz)
    {
        $this->codSefaz = $codSefaz;
        return $this;
    }

    /**
     * Get codSefaz
     *
     * @return integer
     */
    public function getCodSefaz()
    {
        return $this->codSefaz;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return MunicipiosIptu
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return MunicipiosIptu
     */
    public function setCodMunicipio($codMunicipio = null)
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
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return MunicipiosIptu
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }
}
