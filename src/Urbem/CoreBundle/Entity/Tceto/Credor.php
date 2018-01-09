<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * Credor
 */
class Credor
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\TipoCredor
     */
    private $fkTcetoTipoCredor;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Credor
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Credor
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
     * Set tipo
     *
     * @param integer $tipo
     * @return Credor
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Credor
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

    /**
     * ManyToOne (inverse side)
     * Set fkTcetoTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TipoCredor $fkTcetoTipoCredor
     * @return Credor
     */
    public function setFkTcetoTipoCredor(\Urbem\CoreBundle\Entity\Tceto\TipoCredor $fkTcetoTipoCredor)
    {
        $this->tipo = $fkTcetoTipoCredor->getCodTipo();
        $this->fkTcetoTipoCredor = $fkTcetoTipoCredor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoTipoCredor
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TipoCredor
     */
    public function getFkTcetoTipoCredor()
    {
        return $this->fkTcetoTipoCredor;
    }
}
