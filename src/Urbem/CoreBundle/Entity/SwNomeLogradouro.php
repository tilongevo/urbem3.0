<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwNomeLogradouro
 */
class SwNomeLogradouro
{
    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $nomLogradouro;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTipoLogradouro
     */
    private $fkSwTipoLogradouro;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return SwNomeLogradouro
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwNomeLogradouro
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
     * Set nomLogradouro
     *
     * @param string $nomLogradouro
     * @return SwNomeLogradouro
     */
    public function setNomLogradouro($nomLogradouro)
    {
        $this->nomLogradouro = $nomLogradouro;
        return $this;
    }

    /**
     * Get nomLogradouro
     *
     * @return string
     */
    public function getNomLogradouro()
    {
        return $this->nomLogradouro;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwNomeLogradouro
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return SwNomeLogradouro
     */
    public function setDtInicio(\DateTime $dtInicio = null)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return SwNomeLogradouro
     */
    public function setDtFim(\DateTime $dtFim = null)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return SwNomeLogradouro
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
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return SwNomeLogradouro
     */
    public function setFkSwLogradouro(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        $this->codLogradouro = $fkSwLogradouro->getCodLogradouro();
        $this->fkSwLogradouro = $fkSwLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwLogradouro
     */
    public function getFkSwLogradouro()
    {
        return $this->fkSwLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTipoLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwTipoLogradouro $fkSwTipoLogradouro
     * @return SwNomeLogradouro
     */
    public function setFkSwTipoLogradouro(\Urbem\CoreBundle\Entity\SwTipoLogradouro $fkSwTipoLogradouro)
    {
        $this->codTipo = $fkSwTipoLogradouro->getCodTipo();
        $this->fkSwTipoLogradouro = $fkSwTipoLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwTipoLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwTipoLogradouro
     */
    public function getFkSwTipoLogradouro()
    {
        return $this->fkSwTipoLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return SwNomeLogradouro
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

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->getNomLogradouro()) || is_null($this->getFkSwTipoLogradouro())) {
            return "Nome do Logradouro";
        }

        return sprintf('%s %s', $this->getFkSwTipoLogradouro()->getNomTipo(), $this->getNomLogradouro());
    }
}
