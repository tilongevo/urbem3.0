<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ArquivoCargos
 */
class ArquivoCargos
{
    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * PK
     * @var integer
     */
    private $codTipoCargoTce;

    /**
     * @var string
     */
    private $periodo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce
     */
    private $fkTcepbTipoCargoTce;


    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ArquivoCargos
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set codTipoCargoTce
     *
     * @param integer $codTipoCargoTce
     * @return ArquivoCargos
     */
    public function setCodTipoCargoTce($codTipoCargoTce)
    {
        $this->codTipoCargoTce = $codTipoCargoTce;
        return $this;
    }

    /**
     * Get codTipoCargoTce
     *
     * @return integer
     */
    public function getCodTipoCargoTce()
    {
        return $this->codTipoCargoTce;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     * @return ArquivoCargos
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return ArquivoCargos
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoCargoTce
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce $fkTcepbTipoCargoTce
     * @return ArquivoCargos
     */
    public function setFkTcepbTipoCargoTce(\Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce $fkTcepbTipoCargoTce)
    {
        $this->codTipoCargoTce = $fkTcepbTipoCargoTce->getCodTipoCargoTce();
        $this->fkTcepbTipoCargoTce = $fkTcepbTipoCargoTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoCargoTce
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoCargoTce
     */
    public function getFkTcepbTipoCargoTce()
    {
        return $this->fkTcepbTipoCargoTce;
    }
}
