<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * NormaTipoNorma
 */
class NormaTipoNorma
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $codTipoNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNorma;


    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return NormaTipoNorma
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
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return NormaTipoNorma
     */
    public function setCodTipoNorma($codTipoNorma)
    {
        $this->codTipoNorma = $codTipoNorma;
        return $this;
    }

    /**
     * Get codTipoNorma
     *
     * @return integer
     */
    public function getCodTipoNorma()
    {
        return $this->codTipoNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaTipoNorma
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
     * ManyToOne (inverse side)
     * Set fkNormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return NormaTipoNorma
     */
    public function setFkNormasTipoNorma(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        $this->codTipoNorma = $fkNormasTipoNorma->getCodTipoNorma();
        $this->fkNormasTipoNorma = $fkNormasTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    public function getFkNormasTipoNorma()
    {
        return $this->fkNormasTipoNorma;
    }
}
