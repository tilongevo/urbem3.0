<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * UsoSoloImovel
 */
class UsoSoloImovel
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
    private $inscricaoMunicipal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return UsoSoloImovel
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
     * @return UsoSoloImovel
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
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return UsoSoloImovel
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return UsoSoloImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return UsoSoloImovel
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
