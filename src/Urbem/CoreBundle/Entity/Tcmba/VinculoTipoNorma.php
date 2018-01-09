<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * VinculoTipoNorma
 */
class VinculoTipoNorma
{
    /**
     * PK
     * @var integer
     */
    private $codTipoNorma;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoNorma
     */
    private $fkTcmbaTipoNorma;


    /**
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return VinculoTipoNorma
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VinculoTipoNorma
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
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoNorma $fkTcmbaTipoNorma
     * @return VinculoTipoNorma
     */
    public function setFkTcmbaTipoNorma(\Urbem\CoreBundle\Entity\Tcmba\TipoNorma $fkTcmbaTipoNorma)
    {
        $this->codTipo = $fkTcmbaTipoNorma->getCodTipo();
        $this->fkTcmbaTipoNorma = $fkTcmbaTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoNorma
     */
    public function getFkTcmbaTipoNorma()
    {
        return $this->fkTcmbaTipoNorma;
    }

    /**
     * OneToOne (owning side)
     * Set NormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return VinculoTipoNorma
     */
    public function setFkNormasTipoNorma(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        $this->codTipoNorma = $fkNormasTipoNorma->getCodTipoNorma();
        $this->fkNormasTipoNorma = $fkNormasTipoNorma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkNormasTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    public function getFkNormasTipoNorma()
    {
        return $this->fkNormasTipoNorma;
    }
}
