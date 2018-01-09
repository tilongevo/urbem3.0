<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BairroValorM2
 */
class BairroValorM2
{
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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valorM2Territorial;

    /**
     * @var integer
     */
    private $valorM2Predial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairro
     */
    private $fkSwBairro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codBairro
     *
     * @param integer $codBairro
     * @return BairroValorM2
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
     * @return BairroValorM2
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
     * @return BairroValorM2
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return BairroValorM2
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return BairroValorM2
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return BairroValorM2
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valorM2Territorial
     *
     * @param integer $valorM2Territorial
     * @return BairroValorM2
     */
    public function setValorM2Territorial($valorM2Territorial)
    {
        $this->valorM2Territorial = $valorM2Territorial;
        return $this;
    }

    /**
     * Get valorM2Territorial
     *
     * @return integer
     */
    public function getValorM2Territorial()
    {
        return $this->valorM2Territorial;
    }

    /**
     * Set valorM2Predial
     *
     * @param integer $valorM2Predial
     * @return BairroValorM2
     */
    public function setValorM2Predial($valorM2Predial)
    {
        $this->valorM2Predial = $valorM2Predial;
        return $this;
    }

    /**
     * Get valorM2Predial
     *
     * @return integer
     */
    public function getValorM2Predial()
    {
        return $this->valorM2Predial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return BairroValorM2
     */
    public function setFkSwBairro(\Urbem\CoreBundle\Entity\SwBairro $fkSwBairro)
    {
        $this->codBairro = $fkSwBairro->getCodBairro();
        $this->codUf = $fkSwBairro->getCodUf();
        $this->codMunicipio = $fkSwBairro->getCodMunicipio();
        $this->fkSwBairro = $fkSwBairro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairro
     */
    public function getFkSwBairro()
    {
        return $this->fkSwBairro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return BairroValorM2
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
