<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoLicencaDocumento
 */
class TipoLicencaDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca
     */
    private $fkImobiliarioTipoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;


    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoLicencaDocumento
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return TipoLicencaDocumento
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
     * @return TipoLicencaDocumento
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca $fkImobiliarioTipoLicenca
     * @return TipoLicencaDocumento
     */
    public function setFkImobiliarioTipoLicenca(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca $fkImobiliarioTipoLicenca)
    {
        $this->codTipo = $fkImobiliarioTipoLicenca->getCodTipo();
        $this->fkImobiliarioTipoLicenca = $fkImobiliarioTipoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca
     */
    public function getFkImobiliarioTipoLicenca()
    {
        return $this->fkImobiliarioTipoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return TipoLicencaDocumento
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
}
