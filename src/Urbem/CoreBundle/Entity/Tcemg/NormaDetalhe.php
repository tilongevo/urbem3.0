<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * NormaDetalhe
 */
class NormaDetalhe
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $tipoLeiOrigemDecreto;

    /**
     * @var integer
     */
    private $tipoLeiAlteracaoOrcamentaria;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoLeiOrigemDecreto
     */
    private $fkTcemgTipoLeiOrigemDecreto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoLeiAlteracaoOrcamentaria
     */
    private $fkTcemgTipoLeiAlteracaoOrcamentaria;


    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return NormaDetalhe
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
     * Set tipoLeiOrigemDecreto
     *
     * @param integer $tipoLeiOrigemDecreto
     * @return NormaDetalhe
     */
    public function setTipoLeiOrigemDecreto($tipoLeiOrigemDecreto = null)
    {
        $this->tipoLeiOrigemDecreto = $tipoLeiOrigemDecreto;
        return $this;
    }

    /**
     * Get tipoLeiOrigemDecreto
     *
     * @return integer
     */
    public function getTipoLeiOrigemDecreto()
    {
        return $this->tipoLeiOrigemDecreto;
    }

    /**
     * Set tipoLeiAlteracaoOrcamentaria
     *
     * @param integer $tipoLeiAlteracaoOrcamentaria
     * @return NormaDetalhe
     */
    public function setTipoLeiAlteracaoOrcamentaria($tipoLeiAlteracaoOrcamentaria = null)
    {
        $this->tipoLeiAlteracaoOrcamentaria = $tipoLeiAlteracaoOrcamentaria;
        return $this;
    }

    /**
     * Get tipoLeiAlteracaoOrcamentaria
     *
     * @return integer
     */
    public function getTipoLeiAlteracaoOrcamentaria()
    {
        return $this->tipoLeiAlteracaoOrcamentaria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoLeiOrigemDecreto
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoLeiOrigemDecreto $fkTcemgTipoLeiOrigemDecreto
     * @return NormaDetalhe
     */
    public function setFkTcemgTipoLeiOrigemDecreto(\Urbem\CoreBundle\Entity\Tcemg\TipoLeiOrigemDecreto $fkTcemgTipoLeiOrigemDecreto)
    {
        $this->tipoLeiOrigemDecreto = $fkTcemgTipoLeiOrigemDecreto->getCodTipoLei();
        $this->fkTcemgTipoLeiOrigemDecreto = $fkTcemgTipoLeiOrigemDecreto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoLeiOrigemDecreto
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoLeiOrigemDecreto
     */
    public function getFkTcemgTipoLeiOrigemDecreto()
    {
        return $this->fkTcemgTipoLeiOrigemDecreto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgTipoLeiAlteracaoOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoLeiAlteracaoOrcamentaria $fkTcemgTipoLeiAlteracaoOrcamentaria
     * @return NormaDetalhe
     */
    public function setFkTcemgTipoLeiAlteracaoOrcamentaria(\Urbem\CoreBundle\Entity\Tcemg\TipoLeiAlteracaoOrcamentaria $fkTcemgTipoLeiAlteracaoOrcamentaria)
    {
        $this->tipoLeiAlteracaoOrcamentaria = $fkTcemgTipoLeiAlteracaoOrcamentaria->getCodTipoLei();
        $this->fkTcemgTipoLeiAlteracaoOrcamentaria = $fkTcemgTipoLeiAlteracaoOrcamentaria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoLeiAlteracaoOrcamentaria
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoLeiAlteracaoOrcamentaria
     */
    public function getFkTcemgTipoLeiAlteracaoOrcamentaria()
    {
        return $this->fkTcemgTipoLeiAlteracaoOrcamentaria;
    }

    /**
     * OneToOne (owning side)
     * Set NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaDetalhe
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
