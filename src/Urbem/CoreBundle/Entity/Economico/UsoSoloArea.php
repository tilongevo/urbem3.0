<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * UsoSoloArea
 */
class UsoSoloArea
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
     * @var integer
     */
    private $area;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversa;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return UsoSoloArea
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
     * @return UsoSoloArea
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
     * Set area
     *
     * @param integer $area
     * @return UsoSoloArea
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
     * Set EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return UsoSoloArea
     */
    public function setFkEconomicoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $this->codLicenca = $fkEconomicoLicencaDiversa->getCodLicenca();
        $this->exercicio = $fkEconomicoLicencaDiversa->getExercicio();
        $this->fkEconomicoLicencaDiversa = $fkEconomicoLicencaDiversa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversa()
    {
        return $this->fkEconomicoLicencaDiversa;
    }
}
