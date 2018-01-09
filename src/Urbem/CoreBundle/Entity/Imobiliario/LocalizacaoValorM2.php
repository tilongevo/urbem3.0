<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LocalizacaoValorM2
 */
class LocalizacaoValorM2
{
    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * @var integer
     */
    private $valorM2Territorial;

    /**
     * @var integer
     */
    private $valorM2Predial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return LocalizacaoValorM2
     */
    public function setCodLocalizacao($codLocalizacao)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return LocalizacaoValorM2
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return LocalizacaoValorM2
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return LocalizacaoValorM2
     */
    public function setDtVigencia(\DateTime $dtVigencia)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * Set valorM2Territorial
     *
     * @param integer $valorM2Territorial
     * @return LocalizacaoValorM2
     */
    public function setValorM2Territorial($valorM2Territorial)
    {
        $this->valorM2Territorial = $valorM2Territorial;
        return $this;
    }

    /**
     * Get valorM2Territorial
     *
     * @return integer
     */
    public function getValorM2Territorial()
    {
        return $this->valorM2Territorial;
    }

    /**
     * Set valorM2Predial
     *
     * @param integer $valorM2Predial
     * @return LocalizacaoValorM2
     */
    public function setValorM2Predial($valorM2Predial)
    {
        $this->valorM2Predial = $valorM2Predial;
        return $this;
    }

    /**
     * Get valorM2Predial
     *
     * @return integer
     */
    public function getValorM2Predial()
    {
        return $this->valorM2Predial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return LocalizacaoValorM2
     */
    public function setFkImobiliarioLocalizacao(\Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao)
    {
        $this->codLocalizacao = $fkImobiliarioLocalizacao->getCodLocalizacao();
        $this->fkImobiliarioLocalizacao = $fkImobiliarioLocalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLocalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    public function getFkImobiliarioLocalizacao()
    {
        return $this->fkImobiliarioLocalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return LocalizacaoValorM2
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
