<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * EmissaoDocumento
 */
class EmissaoDocumento
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
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $timestampEmissao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    private $fkImobiliarioLicencaDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampEmissao = new \DateTime;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return EmissaoDocumento
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
     * @return EmissaoDocumento
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
     * @return EmissaoDocumento
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EmissaoDocumento
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
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return EmissaoDocumento
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set timestampEmissao
     *
     * @param \DateTime $timestampEmissao
     * @return EmissaoDocumento
     */
    public function setTimestampEmissao(\DateTime $timestampEmissao)
    {
        $this->timestampEmissao = $timestampEmissao;
        return $this;
    }

    /**
     * Get timestampEmissao
     *
     * @return \DateTime
     */
    public function getTimestampEmissao()
    {
        return $this->timestampEmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return EmissaoDocumento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento
     * @return EmissaoDocumento
     */
    public function setFkImobiliarioLicencaDocumento(\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento)
    {
        $this->codLicenca = $fkImobiliarioLicencaDocumento->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicencaDocumento->getExercicio();
        $this->timestamp = $fkImobiliarioLicencaDocumento->getTimestamp();
        $this->fkImobiliarioLicencaDocumento = $fkImobiliarioLicencaDocumento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioLicencaDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    public function getFkImobiliarioLicencaDocumento()
    {
        return $this->fkImobiliarioLicencaDocumento;
    }
}
