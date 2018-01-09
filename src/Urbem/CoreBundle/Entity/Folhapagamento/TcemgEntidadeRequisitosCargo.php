<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TcemgEntidadeRequisitosCargo
 */
class TcemgEntidadeRequisitosCargo
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
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoRequisitosCargo
     */
    private $fkTcemgTipoRequisitosCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcemgEntidadeRequisitosCargo
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TcemgEntidadeRequisitosCargo
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
     * Set codCargo
     *
     * @param integer $codCargo
     * @return TcemgEntidadeRequisitosCargo
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
     * ManyToOne (inverse side)
     * Set fkTcemgTipoRequisitosCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRequisitosCargo $fkTcemgTipoRequisitosCargo
     * @return TcemgEntidadeRequisitosCargo
     */
    public function setFkTcemgTipoRequisitosCargo(\Urbem\CoreBundle\Entity\Tcemg\TipoRequisitosCargo $fkTcemgTipoRequisitosCargo)
    {
        $this->codTipo = $fkTcemgTipoRequisitosCargo->getCodTipo();
        $this->fkTcemgTipoRequisitosCargo = $fkTcemgTipoRequisitosCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoRequisitosCargo
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoRequisitosCargo
     */
    public function getFkTcemgTipoRequisitosCargo()
    {
        return $this->fkTcemgTipoRequisitosCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return TcemgEntidadeRequisitosCargo
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
}
