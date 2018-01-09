<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TcmbaCargoServidorTemporario
 */
class TcmbaCargoServidorTemporario
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codTipoFuncao;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoServidorTemporario
     */
    private $fkTcmbaTipoFuncaoServidorTemporario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcmbaCargoServidorTemporario
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TcmbaCargoServidorTemporario
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codTipoFuncao
     *
     * @param integer $codTipoFuncao
     * @return TcmbaCargoServidorTemporario
     */
    public function setCodTipoFuncao($codTipoFuncao)
    {
        $this->codTipoFuncao = $codTipoFuncao;
        return $this;
    }

    /**
     * Get codTipoFuncao
     *
     * @return integer
     */
    public function getCodTipoFuncao()
    {
        return $this->codTipoFuncao;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return TcmbaCargoServidorTemporario
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
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return TcmbaCargoServidorTemporario
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoFuncaoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoServidorTemporario $fkTcmbaTipoFuncaoServidorTemporario
     * @return TcmbaCargoServidorTemporario
     */
    public function setFkTcmbaTipoFuncaoServidorTemporario(\Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoServidorTemporario $fkTcmbaTipoFuncaoServidorTemporario)
    {
        $this->codTipoFuncao = $fkTcmbaTipoFuncaoServidorTemporario->getCodTipoFuncao();
        $this->fkTcmbaTipoFuncaoServidorTemporario = $fkTcmbaTipoFuncaoServidorTemporario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoFuncaoServidorTemporario
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoFuncaoServidorTemporario
     */
    public function getFkTcmbaTipoFuncaoServidorTemporario()
    {
        return $this->fkTcmbaTipoFuncaoServidorTemporario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return TcmbaCargoServidorTemporario
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
