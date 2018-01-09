<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaImovelUnidadeDependente
 */
class LicencaImovelUnidadeDependente
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
     * PK
     * @var integer
     */
    private $codConstrucaoDependente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    private $fkImobiliarioLicencaImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    private $fkImobiliarioUnidadeDependente;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaImovelUnidadeDependente
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
     * @return LicencaImovelUnidadeDependente
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
     * @return LicencaImovelUnidadeDependente
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
     * @return LicencaImovelUnidadeDependente
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
     * @return LicencaImovelUnidadeDependente
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
     * Set codConstrucaoDependente
     *
     * @param integer $codConstrucaoDependente
     * @return LicencaImovelUnidadeDependente
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente)
    {
        $this->codConstrucaoDependente = $codConstrucaoDependente;
        return $this;
    }

    /**
     * Get codConstrucaoDependente
     *
     * @return integer
     */
    public function getCodConstrucaoDependente()
    {
        return $this->codConstrucaoDependente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return LicencaImovelUnidadeDependente
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
     * Set fkImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     * @return LicencaImovelUnidadeDependente
     */
    public function setFkImobiliarioUnidadeDependente(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeDependente->getInscricaoMunicipal();
        $this->codConstrucaoDependente = $fkImobiliarioUnidadeDependente->getCodConstrucaoDependente();
        $this->codTipo = $fkImobiliarioUnidadeDependente->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeDependente->getCodConstrucao();
        $this->fkImobiliarioUnidadeDependente = $fkImobiliarioUnidadeDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeDependente
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    public function getFkImobiliarioUnidadeDependente()
    {
        return $this->fkImobiliarioUnidadeDependente;
    }
}
