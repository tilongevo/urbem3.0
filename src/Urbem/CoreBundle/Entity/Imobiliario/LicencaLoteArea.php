<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaLoteArea
 */
class LicencaLoteArea
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
    private $codLote;

    /**
     * @var integer
     */
    private $area;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLote;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaLoteArea
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
     * @return LicencaLoteArea
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
     * Set codLote
     *
     * @param integer $codLote
     * @return LicencaLoteArea
     */
    public function setCodLote($codLote)
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
     * Set area
     *
     * @param integer $area
     * @return LicencaLoteArea
     */
    public function setArea($area)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * Get area
     *
     * @return integer
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return LicencaLoteArea
     */
    public function setFkImobiliarioLicencaLote(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        $this->codLicenca = $fkImobiliarioLicencaLote->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicencaLote->getExercicio();
        $this->codLote = $fkImobiliarioLicencaLote->getCodLote();
        $this->fkImobiliarioLicencaLote = $fkImobiliarioLicencaLote;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioLicencaLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    public function getFkImobiliarioLicencaLote()
    {
        return $this->fkImobiliarioLicencaLote;
    }
}
