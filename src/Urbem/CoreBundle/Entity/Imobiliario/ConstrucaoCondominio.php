<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConstrucaoCondominio
 */
class ConstrucaoCondominio
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var integer
     */
    private $codCondominio;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;

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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return ConstrucaoCondominio
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
     * Set codCondominio
     *
     * @param integer $codCondominio
     * @return ConstrucaoCondominio
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
     * @return ConstrucaoCondominio
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
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return ConstrucaoCondominio
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return ConstrucaoCondominio
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
}
