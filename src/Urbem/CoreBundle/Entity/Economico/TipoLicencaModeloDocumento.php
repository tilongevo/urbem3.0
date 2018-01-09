<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * TipoLicencaModeloDocumento
 */
class TipoLicencaModeloDocumento
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
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    private $fkEconomicoTipoLicencaDiversa;

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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoLicencaModeloDocumento
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoLicencaModeloDocumento
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return TipoLicencaModeloDocumento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TipoLicencaModeloDocumento
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
     * ManyToOne (inverse side)
     * Set fkEconomicoTipoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa
     * @return TipoLicencaModeloDocumento
     */
    public function setFkEconomicoTipoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa $fkEconomicoTipoLicencaDiversa)
    {
        $this->codTipo = $fkEconomicoTipoLicencaDiversa->getCodTipo();
        $this->fkEconomicoTipoLicencaDiversa = $fkEconomicoTipoLicencaDiversa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoTipoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa
     */
    public function getFkEconomicoTipoLicencaDiversa()
    {
        return $this->fkEconomicoTipoLicencaDiversa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return TipoLicencaModeloDocumento
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
