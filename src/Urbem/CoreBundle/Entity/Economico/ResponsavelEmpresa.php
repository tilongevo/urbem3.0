<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ResponsavelEmpresa
 */
class ResponsavelEmpresa
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var integer
     */
    private $numcgmRespTecnico;

    /**
     * PK
     * @var integer
     */
    private $sequenciaRespTecnico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    private $fkEconomicoResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    private $fkEconomicoResponsavelTecnico;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ResponsavelEmpresa
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ResponsavelEmpresa
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set numcgmRespTecnico
     *
     * @param integer $numcgmRespTecnico
     * @return ResponsavelEmpresa
     */
    public function setNumcgmRespTecnico($numcgmRespTecnico)
    {
        $this->numcgmRespTecnico = $numcgmRespTecnico;
        return $this;
    }

    /**
     * Get numcgmRespTecnico
     *
     * @return integer
     */
    public function getNumcgmRespTecnico()
    {
        return $this->numcgmRespTecnico;
    }

    /**
     * Set sequenciaRespTecnico
     *
     * @param integer $sequenciaRespTecnico
     * @return ResponsavelEmpresa
     */
    public function setSequenciaRespTecnico($sequenciaRespTecnico)
    {
        $this->sequenciaRespTecnico = $sequenciaRespTecnico;
        return $this;
    }

    /**
     * Get sequenciaRespTecnico
     *
     * @return integer
     */
    public function getSequenciaRespTecnico()
    {
        return $this->sequenciaRespTecnico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     * @return ResponsavelEmpresa
     */
    public function setFkEconomicoResponsavel(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        $this->numcgm = $fkEconomicoResponsavel->getNumcgm();
        $this->sequencia = $fkEconomicoResponsavel->getSequencia();
        $this->fkEconomicoResponsavel = $fkEconomicoResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    public function getFkEconomicoResponsavel()
    {
        return $this->fkEconomicoResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico
     * @return ResponsavelEmpresa
     */
    public function setFkEconomicoResponsavelTecnico(\Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico $fkEconomicoResponsavelTecnico)
    {
        $this->numcgmRespTecnico = $fkEconomicoResponsavelTecnico->getNumcgm();
        $this->sequenciaRespTecnico = $fkEconomicoResponsavelTecnico->getSequencia();
        $this->fkEconomicoResponsavelTecnico = $fkEconomicoResponsavelTecnico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavelTecnico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico
     */
    public function getFkEconomicoResponsavelTecnico()
    {
        return $this->fkEconomicoResponsavelTecnico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getNumcgm(), $this->getNumcgmRespTecnico());
    }
}
