<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

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
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoNorma
     */
    private $fkTcepeTipoNorma;


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
     * Set fkTcepeTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoNorma $fkTcepeTipoNorma
     * @return VinculoTipoNorma
     */
    public function setFkTcepeTipoNorma(\Urbem\CoreBundle\Entity\Tcepe\TipoNorma $fkTcepeTipoNorma)
    {
        $this->codTipo = $fkTcepeTipoNorma->getCodTipo();
        $this->fkTcepeTipoNorma = $fkTcepeTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoNorma
     */
    public function getFkTcepeTipoNorma()
    {
        return $this->fkTcepeTipoNorma;
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
