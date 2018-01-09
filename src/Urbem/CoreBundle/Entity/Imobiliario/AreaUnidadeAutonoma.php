<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AreaUnidadeAutonoma
 */
class AreaUnidadeAutonoma
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $area;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonoma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return AreaUnidadeAutonoma
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return AreaUnidadeAutonoma
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
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return AreaUnidadeAutonoma
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AreaUnidadeAutonoma
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
     * Set area
     *
     * @param integer $area
     * @return AreaUnidadeAutonoma
     */
    public function setArea($area)
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

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return AreaUnidadeAutonoma
     */
    public function setFkImobiliarioUnidadeAutonoma(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeAutonoma->getInscricaoMunicipal();
        $this->codTipo = $fkImobiliarioUnidadeAutonoma->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeAutonoma->getCodConstrucao();
        $this->fkImobiliarioUnidadeAutonoma = $fkImobiliarioUnidadeAutonoma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeAutonoma
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonoma()
    {
        return $this->fkImobiliarioUnidadeAutonoma;
    }
}
