<?php
 
namespace Urbem\CoreBundle\Entity\Tcepr;

/**
 * ResponsavelModulo
 */
class ResponsavelModulo 
{
    /**
     * PK
     * @var integer
     */
    private $codResponsavel;

    /**
     * @var integer
     */
    private $idTipoModulo;

    /**
     * @var integer
     */
    private $idTipoResponsavelModulo;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtInicioVinculo;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var string
     */
    private $descricaoBaixa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepr\TipoModulo
     */
    private $fkTceprTipoModulo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepr\TipoResponsavelModulo
     */
    private $fkTceprTipoResponsavelModulo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set codResponsavel
     *
     * @param integer $codResponsavel
     * @return ResponsavelModulo
     */
    public function setCodResponsavel($codResponsavel)
    {
        $this->codResponsavel = $codResponsavel;
        return $this;
    }

    /**
     * Get codResponsavel
     *
     * @return integer
     */
    public function getCodResponsavel()
    {
        return $this->codResponsavel;
    }

    /**
     * Set idTipoModulo
     *
     * @param integer $idTipoModulo
     * @return ResponsavelModulo
     */
    public function setIdTipoModulo($idTipoModulo)
    {
        $this->idTipoModulo = $idTipoModulo;
        return $this;
    }

    /**
     * Get idTipoModulo
     *
     * @return integer
     */
    public function getIdTipoModulo()
    {
        return $this->idTipoModulo;
    }

    /**
     * Set idTipoResponsavelModulo
     *
     * @param integer $idTipoResponsavelModulo
     * @return ResponsavelModulo
     */
    public function setIdTipoResponsavelModulo($idTipoResponsavelModulo)
    {
        $this->idTipoResponsavelModulo = $idTipoResponsavelModulo;
        return $this;
    }

    /**
     * Get idTipoResponsavelModulo
     *
     * @return integer
     */
    public function getIdTipoResponsavelModulo()
    {
        return $this->idTipoResponsavelModulo;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ResponsavelModulo
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set dtInicioVinculo
     *
     * @param \DateTime $dtInicioVinculo
     * @return ResponsavelModulo
     */
    public function setDtInicioVinculo(\DateTime $dtInicioVinculo)
    {
        $this->dtInicioVinculo = $dtInicioVinculo;
        return $this;
    }

    /**
     * Get dtInicioVinculo
     *
     * @return \DateTime
     */
    public function getDtInicioVinculo()
    {
        return $this->dtInicioVinculo;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return ResponsavelModulo
     */
    public function setDtBaixa(\DateTime $dtBaixa = null)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * Get dtBaixa
     *
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set descricaoBaixa
     *
     * @param string $descricaoBaixa
     * @return ResponsavelModulo
     */
    public function setDescricaoBaixa($descricaoBaixa = null)
    {
        $this->descricaoBaixa = $descricaoBaixa;
        return $this;
    }

    /**
     * Get descricaoBaixa
     *
     * @return string
     */
    public function getDescricaoBaixa()
    {
        return $this->descricaoBaixa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceprTipoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepr\TipoModulo $fkTceprTipoModulo
     * @return ResponsavelModulo
     */
    public function setFkTceprTipoModulo(\Urbem\CoreBundle\Entity\Tcepr\TipoModulo $fkTceprTipoModulo)
    {
        $this->idTipoModulo = $fkTceprTipoModulo->getIdTipoModulo();
        $this->fkTceprTipoModulo = $fkTceprTipoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceprTipoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Tcepr\TipoModulo
     */
    public function getFkTceprTipoModulo()
    {
        return $this->fkTceprTipoModulo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceprTipoResponsavelModulo
     *
     * @param \Urbem\CoreBundle\Entity\Tcepr\TipoResponsavelModulo $fkTceprTipoResponsavelModulo
     * @return ResponsavelModulo
     */
    public function setFkTceprTipoResponsavelModulo(\Urbem\CoreBundle\Entity\Tcepr\TipoResponsavelModulo $fkTceprTipoResponsavelModulo)
    {
        $this->idTipoResponsavelModulo = $fkTceprTipoResponsavelModulo->getIdTipoResponsavelModulo();
        $this->fkTceprTipoResponsavelModulo = $fkTceprTipoResponsavelModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceprTipoResponsavelModulo
     *
     * @return \Urbem\CoreBundle\Entity\Tcepr\TipoResponsavelModulo
     */
    public function getFkTceprTipoResponsavelModulo()
    {
        return $this->fkTceprTipoResponsavelModulo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ResponsavelModulo
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

}
