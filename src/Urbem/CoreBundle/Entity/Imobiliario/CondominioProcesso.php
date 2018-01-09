<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * CondominioProcesso
 */
class CondominioProcesso
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
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Condominio
     */
    private $fkImobiliarioCondominio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

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
     * @return CondominioProcesso
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
     * @return CondominioProcesso
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return CondominioProcesso
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return CondominioProcesso
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Condominio $fkImobiliarioCondominio
     * @return CondominioProcesso
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
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return CondominioProcesso
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwProcesso;
    }
}
