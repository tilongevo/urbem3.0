<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TcemgEntidadeCargoServidor
 */
class TcemgEntidadeCargoServidor
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
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoCargoServidor
     */
    private $fkTcemgTipoCargoServidor;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcemgEntidadeCargoServidor
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
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return TcemgEntidadeCargoServidor
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return TcemgEntidadeCargoServidor
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TcemgEntidadeCargoServidor
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
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return TcemgEntidadeCargoServidor
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return TcemgEntidadeCargoServidor
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
     * Set fkTcemgTipoCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoCargoServidor $fkTcemgTipoCargoServidor
     * @return TcemgEntidadeCargoServidor
     */
    public function setFkTcemgTipoCargoServidor(\Urbem\CoreBundle\Entity\Tcemg\TipoCargoServidor $fkTcemgTipoCargoServidor)
    {
        $this->codTipo = $fkTcemgTipoCargoServidor->getCodTipo();
        $this->fkTcemgTipoCargoServidor = $fkTcemgTipoCargoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoCargoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoCargoServidor
     */
    public function getFkTcemgTipoCargoServidor()
    {
        return $this->fkTcemgTipoCargoServidor;
    }
}
