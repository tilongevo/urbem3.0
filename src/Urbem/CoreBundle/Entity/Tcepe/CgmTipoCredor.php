<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * CgmTipoCredor
 */
class CgmTipoCredor
{
    /**
     * PK
     * @var integer
     */
    private $cgmCredor;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipoCredor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoCredor
     */
    private $fkTcepeTipoCredor;


    /**
     * Set cgmCredor
     *
     * @param integer $cgmCredor
     * @return CgmTipoCredor
     */
    public function setCgmCredor($cgmCredor)
    {
        $this->cgmCredor = $cgmCredor;
        return $this;
    }

    /**
     * Get cgmCredor
     *
     * @return integer
     */
    public function getCgmCredor()
    {
        return $this->cgmCredor;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CgmTipoCredor
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
     * Set codTipoCredor
     *
     * @param integer $codTipoCredor
     * @return CgmTipoCredor
     */
    public function setCodTipoCredor($codTipoCredor)
    {
        $this->codTipoCredor = $codTipoCredor;
        return $this;
    }

    /**
     * Get codTipoCredor
     *
     * @return integer
     */
    public function getCodTipoCredor()
    {
        return $this->codTipoCredor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return CgmTipoCredor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmCredor = $fkSwCgm->getNumcgm();
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
     * Set fkTcepeTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoCredor $fkTcepeTipoCredor
     * @return CgmTipoCredor
     */
    public function setFkTcepeTipoCredor(\Urbem\CoreBundle\Entity\Tcepe\TipoCredor $fkTcepeTipoCredor)
    {
        $this->codTipoCredor = $fkTcepeTipoCredor->getCodTipoCredor();
        $this->fkTcepeTipoCredor = $fkTcepeTipoCredor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoCredor
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoCredor
     */
    public function getFkTcepeTipoCredor()
    {
        return $this->fkTcepeTipoCredor;
    }
}
