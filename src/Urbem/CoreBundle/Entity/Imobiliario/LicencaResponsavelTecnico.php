<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaResponsavelTecnico
 */
class LicencaResponsavelTecnico
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    private $fkEconomicoResponsavel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaResponsavelTecnico
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaResponsavelTecnico
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return LicencaResponsavelTecnico
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return LicencaResponsavelTecnico
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return LicencaResponsavelTecnico
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return LicencaResponsavelTecnico
     */
    public function setFkImobiliarioLicenca(\Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca)
    {
        $this->codLicenca = $fkImobiliarioLicenca->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicenca->getExercicio();
        $this->fkImobiliarioLicenca = $fkImobiliarioLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    public function getFkImobiliarioLicenca()
    {
        return $this->fkImobiliarioLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     * @return LicencaResponsavelTecnico
     */
    public function setFkEconomicoResponsavel(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        $this->numcgm = $fkEconomicoResponsavel->getNumcgm();
        $this->sequencia = $fkEconomicoResponsavel->getSequencia();
        $this->fkEconomicoResponsavel = $fkEconomicoResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    public function getFkEconomicoResponsavel()
    {
        return $this->fkEconomicoResponsavel;
    }
}
