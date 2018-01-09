<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AreaUnidadeDependente
 */
class AreaUnidadeDependente
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
    private $codConstrucaoDependente;

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
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    private $fkImobiliarioUnidadeDependente;

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
     * @return AreaUnidadeDependente
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
     * @return AreaUnidadeDependente
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente)
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
     * @return AreaUnidadeDependente
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
     * @return AreaUnidadeDependente
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
     * @return AreaUnidadeDependente
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
     * @return AreaUnidadeDependente
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
     * Set fkImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     * @return AreaUnidadeDependente
     */
    public function setFkImobiliarioUnidadeDependente(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeDependente->getInscricaoMunicipal();
        $this->codConstrucaoDependente = $fkImobiliarioUnidadeDependente->getCodConstrucaoDependente();
        $this->codTipo = $fkImobiliarioUnidadeDependente->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeDependente->getCodConstrucao();
        $this->fkImobiliarioUnidadeDependente = $fkImobiliarioUnidadeDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeDependente
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    public function getFkImobiliarioUnidadeDependente()
    {
        return $this->fkImobiliarioUnidadeDependente;
    }
}
