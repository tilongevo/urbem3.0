<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaImovelNovaEdificacao
 */
class LicencaImovelNovaEdificacao
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
    private $codTipo;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    private $fkImobiliarioConstrucaoEdificacao;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaImovelNovaEdificacao
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
     * @return LicencaImovelNovaEdificacao
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
     * @return LicencaImovelNovaEdificacao
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LicencaImovelNovaEdificacao
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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return LicencaImovelNovaEdificacao
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
     * Set fkImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     * @return LicencaImovelNovaEdificacao
     */
    public function setFkImobiliarioConstrucaoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        $this->codTipo = $fkImobiliarioConstrucaoEdificacao->getCodTipo();
        $this->codConstrucao = $fkImobiliarioConstrucaoEdificacao->getCodConstrucao();
        $this->fkImobiliarioConstrucaoEdificacao = $fkImobiliarioConstrucaoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucaoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    public function getFkImobiliarioConstrucaoEdificacao()
    {
        return $this->fkImobiliarioConstrucaoEdificacao;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return LicencaImovelNovaEdificacao
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
