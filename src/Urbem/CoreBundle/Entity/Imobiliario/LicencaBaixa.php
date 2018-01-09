<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaBaixa
 */
class LicencaBaixa
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var string
     */
    private $motivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa
     */
    private $fkImobiliarioTipoBaixa;

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
     * @return LicencaBaixa
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
     * @return LicencaBaixa
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return LicencaBaixa
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return LicencaBaixa
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LicencaBaixa
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return LicencaBaixa
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return LicencaBaixa
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return LicencaBaixa
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
     * Set fkImobiliarioTipoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa $fkImobiliarioTipoBaixa
     * @return LicencaBaixa
     */
    public function setFkImobiliarioTipoBaixa(\Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa $fkImobiliarioTipoBaixa)
    {
        $this->codTipo = $fkImobiliarioTipoBaixa->getCodTipo();
        $this->fkImobiliarioTipoBaixa = $fkImobiliarioTipoBaixa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoBaixa
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa
     */
    public function getFkImobiliarioTipoBaixa()
    {
        return $this->fkImobiliarioTipoBaixa;
    }
}
