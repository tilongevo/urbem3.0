<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoCombustivelVinculo
 */
class TipoCombustivelVinculo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * PK
     * @var integer
     */
    private $codCombustivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivel
     */
    private $fkTcmbaTipoCombustivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    private $fkFrotaCombustivel;


    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoCombustivelVinculo
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return TipoCombustivelVinculo
     */
    public function setCodCombustivel($codCombustivel)
    {
        $this->codCombustivel = $codCombustivel;
        return $this;
    }

    /**
     * Get codCombustivel
     *
     * @return integer
     */
    public function getCodCombustivel()
    {
        return $this->codCombustivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivel $fkTcmbaTipoCombustivel
     * @return TipoCombustivelVinculo
     */
    public function setFkTcmbaTipoCombustivel(\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivel $fkTcmbaTipoCombustivel)
    {
        $this->codTipoTcm = $fkTcmbaTipoCombustivel->getCodTipoTcm();
        $this->fkTcmbaTipoCombustivel = $fkTcmbaTipoCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivel
     */
    public function getFkTcmbaTipoCombustivel()
    {
        return $this->fkTcmbaTipoCombustivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel
     * @return TipoCombustivelVinculo
     */
    public function setFkFrotaCombustivel(\Urbem\CoreBundle\Entity\Frota\Combustivel $fkFrotaCombustivel)
    {
        $this->codCombustivel = $fkFrotaCombustivel->getCodCombustivel();
        $this->fkFrotaCombustivel = $fkFrotaCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Combustivel
     */
    public function getFkFrotaCombustivel()
    {
        return $this->fkFrotaCombustivel;
    }
}
