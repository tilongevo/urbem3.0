<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaDocumento
 */
class LicencaDocumento
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
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $numDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento
     */
    private $fkImobiliarioEmissaoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

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
     * @return LicencaDocumento
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
     * @return LicencaDocumento
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
     * @return LicencaDocumento
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return LicencaDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return LicencaDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return LicencaDocumento
     */
    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return LicencaDocumento
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
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return LicencaDocumento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento
     * @return LicencaDocumento
     */
    public function setFkImobiliarioEmissaoDocumento(\Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento)
    {
        $fkImobiliarioEmissaoDocumento->setFkImobiliarioLicencaDocumento($this);
        $this->fkImobiliarioEmissaoDocumento = $fkImobiliarioEmissaoDocumento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioEmissaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento
     */
    public function getFkImobiliarioEmissaoDocumento()
    {
        return $this->fkImobiliarioEmissaoDocumento;
    }
}
