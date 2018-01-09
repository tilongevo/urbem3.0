<?php
 
namespace Urbem\CoreBundle\Entity\Tcerj;

/**
 * Fundamento
 */
class Fundamento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoNorma;

    /**
     * @var integer
     */
    private $codFundamentoLegal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNorma;


    /**
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return Fundamento
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
     * Set codFundamentoLegal
     *
     * @param integer $codFundamentoLegal
     * @return Fundamento
     */
    public function setCodFundamentoLegal($codFundamentoLegal)
    {
        $this->codFundamentoLegal = $codFundamentoLegal;
        return $this;
    }

    /**
     * Get codFundamentoLegal
     *
     * @return integer
     */
    public function getCodFundamentoLegal()
    {
        return $this->codFundamentoLegal;
    }

    /**
     * OneToOne (owning side)
     * Set NormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return Fundamento
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
