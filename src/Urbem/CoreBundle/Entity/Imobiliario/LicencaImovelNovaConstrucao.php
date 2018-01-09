<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaImovelNovaConstrucao
 */
class LicencaImovelNovaConstrucao
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
     * @var integer
     */
    private $codConstrucao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    private $fkImobiliarioLicencaImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaImovelNovaConstrucao
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
     * @return LicencaImovelNovaConstrucao
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
     * @return LicencaImovelNovaConstrucao
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
     * @return LicencaImovelNovaConstrucao
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return LicencaImovelNovaConstrucao
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return LicencaImovelNovaConstrucao
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
     * OneToOne (owning side)
     * Get fkImobiliarioLicencaImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    public function getFkImobiliarioLicencaImovel()
    {
        return $this->fkImobiliarioLicencaImovel;
    }
}
