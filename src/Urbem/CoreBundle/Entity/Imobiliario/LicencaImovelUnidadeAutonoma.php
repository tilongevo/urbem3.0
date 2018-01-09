<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaImovelUnidadeAutonoma
 */
class LicencaImovelUnidadeAutonoma
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
    private $inscricaoMunicipal;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    private $fkImobiliarioLicencaImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonoma;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaImovelUnidadeAutonoma
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
     * @return LicencaImovelUnidadeAutonoma
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
     * @return LicencaImovelUnidadeAutonoma
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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return LicencaImovelUnidadeAutonoma
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LicencaImovelUnidadeAutonoma
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return LicencaImovelUnidadeAutonoma
     */
    public function setFkImobiliarioLicencaImovel(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel)
    {
        $this->codLicenca = $fkImobiliarioLicencaImovel->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicencaImovel->getExercicio();
        $this->inscricaoMunicipal = $fkImobiliarioLicencaImovel->getInscricaoMunicipal();
        $this->fkImobiliarioLicencaImovel = $fkImobiliarioLicencaImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicencaImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    public function getFkImobiliarioLicencaImovel()
    {
        return $this->fkImobiliarioLicencaImovel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return LicencaImovelUnidadeAutonoma
     */
    public function setFkImobiliarioUnidadeAutonoma(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeAutonoma->getInscricaoMunicipal();
        $this->codTipo = $fkImobiliarioUnidadeAutonoma->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeAutonoma->getCodConstrucao();
        $this->fkImobiliarioUnidadeAutonoma = $fkImobiliarioUnidadeAutonoma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeAutonoma
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonoma()
    {
        return $this->fkImobiliarioUnidadeAutonoma;
    }
}
