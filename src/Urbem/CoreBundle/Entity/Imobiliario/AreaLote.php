<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AreaLote
 */
class AreaLote
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $areaReal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return AreaLote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AreaLote
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
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return AreaLote
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return AreaLote
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set areaReal
     *
     * @param integer $areaReal
     * @return AreaLote
     */
    public function setAreaReal($areaReal)
    {
        $this->areaReal = $areaReal;
        return $this;
    }

    /**
     * Get areaReal
     *
     * @return integer
     */
    public function getAreaReal()
    {
        return $this->areaReal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return AreaLote
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return AreaLote
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s', number_format($this->areaReal, 2, ',', '.'), $this->fkAdministracaoUnidadeMedida->getSimbolo());
    }
}
