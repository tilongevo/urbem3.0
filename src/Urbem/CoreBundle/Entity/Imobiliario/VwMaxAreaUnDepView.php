<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwMaxAreaUnDepView
 */
class VwMaxAreaUnDepView
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codConstrucaoDependente;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $area;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return VwMaxAreaUnDep
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codConstrucaoDependente
     *
     * @param integer $codConstrucaoDependente
     * @return VwMaxAreaUnDep
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente = null)
    {
        $this->codConstrucaoDependente = $codConstrucaoDependente;
        return $this;
    }

    /**
     * Get codConstrucaoDependente
     *
     * @return integer
     */
    public function getCodConstrucaoDependente()
    {
        return $this->codConstrucaoDependente;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VwMaxAreaUnDep
     */
    public function setCodTipo($codTipo = null)
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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return VwMaxAreaUnDep
     */
    public function setCodConstrucao($codConstrucao = null)
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwMaxAreaUnDep
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return VwMaxAreaUnDep
     */
    public function setArea($area = null)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * Get area
     *
     * @return integer
     */
    public function getArea()
    {
        return $this->area;
    }
}
