<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * CondominioAreaComum
 */
class CondominioAreaComum
{
    /**
     * PK
     * @var integer
     */
    private $codCondominio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $areaTotalComum;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    private $fkImobiliarioCondominio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondominio
     *
     * @param integer $codCondominio
     * @return CondominioAreaComum
     */
    public function setCodCondominio($codCondominio)
    {
        $this->codCondominio = $codCondominio;
        return $this;
    }

    /**
     * Get codCondominio
     *
     * @return integer
     */
    public function getCodCondominio()
    {
        return $this->codCondominio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CondominioAreaComum
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
     * Set areaTotalComum
     *
     * @param integer $areaTotalComum
     * @return CondominioAreaComum
     */
    public function setAreaTotalComum($areaTotalComum)
    {
        $this->areaTotalComum = $areaTotalComum;
        return $this;
    }

    /**
     * Get areaTotalComum
     *
     * @return integer
     */
    public function getAreaTotalComum()
    {
        return $this->areaTotalComum;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return CondominioAreaComum
     */
    public function setFkImobiliarioCondominio(\Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio)
    {
        $this->codCondominio = $fkImobiliarioCondominio->getCodCondominio();
        $this->fkImobiliarioCondominio = $fkImobiliarioCondominio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCondominio
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    public function getFkImobiliarioCondominio()
    {
        return $this->fkImobiliarioCondominio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return number_format($this->areaTotalComum, 2, ',', '.');
    }
}
