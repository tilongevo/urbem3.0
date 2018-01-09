<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * BairroAliquota
 */
class BairroAliquota
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
    private $aliquotaTerritorial;

    /**
     * @var integer
     */
    private $aliquotaPredial;

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
     * @return BairroAliquota
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
     * @return BairroAliquota
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
     * @return BairroAliquota
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
     * @return BairroAliquota
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
     * @return BairroAliquota
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
     * @return BairroAliquota
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
     * Set aliquotaTerritorial
     *
     * @param integer $aliquotaTerritorial
     * @return BairroAliquota
     */
    public function setAliquotaTerritorial($aliquotaTerritorial)
    {
        $this->aliquotaTerritorial = $aliquotaTerritorial;
        return $this;
    }

    /**
     * Get aliquotaTerritorial
     *
     * @return integer
     */
    public function getAliquotaTerritorial()
    {
        return $this->aliquotaTerritorial;
    }

    /**
     * Set aliquotaPredial
     *
     * @param integer $aliquotaPredial
     * @return BairroAliquota
     */
    public function setAliquotaPredial($aliquotaPredial)
    {
        $this->aliquotaPredial = $aliquotaPredial;
        return $this;
    }

    /**
     * Get aliquotaPredial
     *
     * @return integer
     */
    public function getAliquotaPredial()
    {
        return $this->aliquotaPredial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairro $fkSwBairro
     * @return BairroAliquota
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
     * @return BairroAliquota
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
