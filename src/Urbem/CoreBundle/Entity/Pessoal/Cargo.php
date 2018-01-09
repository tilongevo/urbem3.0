<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Cargo
 */
class Cargo
{
    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $cargoCc;

    /**
     * @var boolean
     */
    private $funcaoGratificada;

    /**
     * @var integer
     */
    private $codEscolaridade;

    /**
     * @var string
     */
    private $atribuicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    private $fkConcursoConcursoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor
     */
    private $fkFolhapagamentoTcemgEntidadeCargoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo
     */
    private $fkFolhapagamentoTcemgEntidadeRequisitosCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    private $fkFolhapagamentoTcmbaCargoServidorTemporarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito
     */
    private $fkPessoalCargoRequisitos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao
     */
    private $fkPessoalCargoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboCargo
     */
    private $fkPessoalCboCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao
     */
    private $fkPessoalContratoServidorFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao
     */
    private $fkPessoalLoteFeriasFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    private $fkFolhapagamentoTcmbaCargoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos
     */
    private $fkPessoalArquivoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao
     */
    private $fkPessoalCargoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    private $fkPessoalEspecialidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEscolaridade
     */
    private $fkSwEscolaridade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkConcursoConcursoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventoCasoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcemgEntidadeCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoRequisitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCboCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcmbaCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalArquivoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return Cargo
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
     * Set descricao
     *
     * @param string $descricao
     * @return Cargo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set cargoCc
     *
     * @param boolean $cargoCc
     * @return Cargo
     */
    public function setCargoCc($cargoCc)
    {
        $this->cargoCc = $cargoCc;
        return $this;
    }

    /**
     * Get cargoCc
     *
     * @return boolean
     */
    public function getCargoCc()
    {
        return $this->cargoCc;
    }

    /**
     * Set funcaoGratificada
     *
     * @param boolean $funcaoGratificada
     * @return Cargo
     */
    public function setFuncaoGratificada($funcaoGratificada)
    {
        $this->funcaoGratificada = $funcaoGratificada;
        return $this;
    }

    /**
     * Get funcaoGratificada
     *
     * @return boolean
     */
    public function getFuncaoGratificada()
    {
        return $this->funcaoGratificada;
    }

    /**
     * Set codEscolaridade
     *
     * @param integer $codEscolaridade
     * @return Cargo
     */
    public function setCodEscolaridade($codEscolaridade)
    {
        $this->codEscolaridade = $codEscolaridade;
        return $this;
    }

    /**
     * Get codEscolaridade
     *
     * @return integer
     */
    public function getCodEscolaridade()
    {
        return $this->codEscolaridade;
    }

    /**
     * Set atribuicoes
     *
     * @param string $atribuicoes
     * @return Cargo
     */
    public function setAtribuicoes($atribuicoes)
    {
        $this->atribuicoes = $atribuicoes;
        return $this;
    }

    /**
     * Get atribuicoes
     *
     * @return string
     */
    public function getAtribuicoes()
    {
        return $this->atribuicoes;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEscolaridade
     */
    public function getFkSwEscolaridade()
    {
        return $this->fkSwEscolaridade;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEscolaridade $fkSwEscolaridade
     */
    public function setFkSwEscolaridade($fkSwEscolaridade)
    {
        $this->fkSwEscolaridade = $fkSwEscolaridade;
    }


    /**
     * OneToMany (owning side)
     * Add ConcursoConcursoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo
     * @return Cargo
     */
    public function addFkConcursoConcursoCargos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo)
    {
        if (false === $this->fkConcursoConcursoCargos->contains($fkConcursoConcursoCargo)) {
            $fkConcursoConcursoCargo->setFkPessoalCargo($this);
            $this->fkConcursoConcursoCargos->add($fkConcursoConcursoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoConcursoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo
     */
    public function removeFkConcursoConcursoCargos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo)
    {
        $this->fkConcursoConcursoCargos->removeElement($fkConcursoConcursoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoConcursoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    public function getFkConcursoConcursoCargos()
    {
        return $this->fkConcursoConcursoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo
     * @return Cargo
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoCargos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->contains($fkFolhapagamentoConfiguracaoEventoCasoCargo)) {
            $fkFolhapagamentoConfiguracaoEventoCasoCargo->setFkPessoalCargo($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->add($fkFolhapagamentoConfiguracaoEventoCasoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoCargos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->removeElement($fkFolhapagamentoConfiguracaoEventoCasoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoCargos()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcemgEntidadeCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor
     * @return Cargo
     */
    public function addFkFolhapagamentoTcemgEntidadeCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeCargoServidores->contains($fkFolhapagamentoTcemgEntidadeCargoServidor)) {
            $fkFolhapagamentoTcemgEntidadeCargoServidor->setFkPessoalCargo($this);
            $this->fkFolhapagamentoTcemgEntidadeCargoServidores->add($fkFolhapagamentoTcemgEntidadeCargoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor
     */
    public function removeFkFolhapagamentoTcemgEntidadeCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor)
    {
        $this->fkFolhapagamentoTcemgEntidadeCargoServidores->removeElement($fkFolhapagamentoTcemgEntidadeCargoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeCargoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor
     */
    public function getFkFolhapagamentoTcemgEntidadeCargoServidores()
    {
        return $this->fkFolhapagamentoTcemgEntidadeCargoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcemgEntidadeRequisitosCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo
     * @return Cargo
     */
    public function addFkFolhapagamentoTcemgEntidadeRequisitosCargos(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->contains($fkFolhapagamentoTcemgEntidadeRequisitosCargo)) {
            $fkFolhapagamentoTcemgEntidadeRequisitosCargo->setFkPessoalCargo($this);
            $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->add($fkFolhapagamentoTcemgEntidadeRequisitosCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeRequisitosCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo
     */
    public function removeFkFolhapagamentoTcemgEntidadeRequisitosCargos(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo $fkFolhapagamentoTcemgEntidadeRequisitosCargo)
    {
        $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos->removeElement($fkFolhapagamentoTcemgEntidadeRequisitosCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeRequisitosCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo
     */
    public function getFkFolhapagamentoTcemgEntidadeRequisitosCargos()
    {
        return $this->fkFolhapagamentoTcemgEntidadeRequisitosCargos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     * @return Cargo
     */
    public function addFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->contains($fkFolhapagamentoTcmbaCargoServidorTemporario)) {
            $fkFolhapagamentoTcmbaCargoServidorTemporario->setFkPessoalCargo($this);
            $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->add($fkFolhapagamentoTcmbaCargoServidorTemporario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     */
    public function removeFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->removeElement($fkFolhapagamentoTcmbaCargoServidorTemporario);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidorTemporarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    public function getFkFolhapagamentoTcmbaCargoServidorTemporarios()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidorTemporarios;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCargoRequisito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito
     * @return Cargo
     */
    public function addFkPessoalCargoRequisitos(\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito)
    {
        if (false === $this->fkPessoalCargoRequisitos->contains($fkPessoalCargoRequisito)) {
            $fkPessoalCargoRequisito->setFkPessoalCargo($this);
            $this->fkPessoalCargoRequisitos->add($fkPessoalCargoRequisito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoRequisito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito
     */
    public function removeFkPessoalCargoRequisitos(\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito)
    {
        $this->fkPessoalCargoRequisitos->removeElement($fkPessoalCargoRequisito);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoRequisitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito
     */
    public function getFkPessoalCargoRequisitos()
    {
        return $this->fkPessoalCargoRequisitos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCargoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao
     * @return Cargo
     */
    public function addFkPessoalCargoPadroes(\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao)
    {
        if (false === $this->fkPessoalCargoPadroes->contains($fkPessoalCargoPadrao)) {
            $fkPessoalCargoPadrao->setFkPessoalCargo($this);
            $this->fkPessoalCargoPadroes->add($fkPessoalCargoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao
     */
    public function removeFkPessoalCargoPadroes(\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao $fkPessoalCargoPadrao)
    {
        $this->fkPessoalCargoPadroes->removeElement($fkPessoalCargoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoPadrao
     */
    public function getFkPessoalCargoPadroes()
    {
        return $this->fkPessoalCargoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCboCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo
     * @return Cargo
     */
    public function addFkPessoalCboCargos(\Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo)
    {
        if (false === $this->fkPessoalCboCargos->contains($fkPessoalCboCargo)) {
            $fkPessoalCboCargo->setFkPessoalCargo($this);
            $this->fkPessoalCboCargos->add($fkPessoalCboCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCboCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo
     */
    public function removeFkPessoalCboCargos(\Urbem\CoreBundle\Entity\Pessoal\CboCargo $fkPessoalCboCargo)
    {
        $this->fkPessoalCboCargos->removeElement($fkPessoalCboCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCboCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboCargo
     */
    public function getFkPessoalCboCargos()
    {
        return $this->fkPessoalCboCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao
     * @return Cargo
     */
    public function addFkPessoalContratoServidorFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao)
    {
        if (false === $this->fkPessoalContratoServidorFuncoes->contains($fkPessoalContratoServidorFuncao)) {
            $fkPessoalContratoServidorFuncao->setFkPessoalCargo($this);
            $this->fkPessoalContratoServidorFuncoes->add($fkPessoalContratoServidorFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao
     */
    public function removeFkPessoalContratoServidorFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao $fkPessoalContratoServidorFuncao)
    {
        $this->fkPessoalContratoServidorFuncoes->removeElement($fkPessoalContratoServidorFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao
     */
    public function getFkPessoalContratoServidorFuncoes()
    {
        return $this->fkPessoalContratoServidorFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao
     * @return Cargo
     */
    public function addFkPessoalLoteFeriasFuncoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao)
    {
        if (false === $this->fkPessoalLoteFeriasFuncoes->contains($fkPessoalLoteFeriasFuncao)) {
            $fkPessoalLoteFeriasFuncao->setFkPessoalCargo($this);
            $this->fkPessoalLoteFeriasFuncoes->add($fkPessoalLoteFeriasFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao
     */
    public function removeFkPessoalLoteFeriasFuncoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao $fkPessoalLoteFeriasFuncao)
    {
        $this->fkPessoalLoteFeriasFuncoes->removeElement($fkPessoalLoteFeriasFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasFuncao
     */
    public function getFkPessoalLoteFeriasFuncoes()
    {
        return $this->fkPessoalLoteFeriasFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     * @return Cargo
     */
    public function addFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidores->contains($fkFolhapagamentoTcmbaCargoServidor)) {
            $fkFolhapagamentoTcmbaCargoServidor->setFkPessoalCargo($this);
            $this->fkFolhapagamentoTcmbaCargoServidores->add($fkFolhapagamentoTcmbaCargoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor
     */
    public function removeFkFolhapagamentoTcmbaCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor $fkFolhapagamentoTcmbaCargoServidor)
    {
        $this->fkFolhapagamentoTcmbaCargoServidores->removeElement($fkFolhapagamentoTcmbaCargoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidor
     */
    public function getFkFolhapagamentoTcmbaCargoServidores()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalArquivoCargos
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos
     * @return Cargo
     */
    public function addFkPessoalArquivoCargos(\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos)
    {
        if (false === $this->fkPessoalArquivoCargos->contains($fkPessoalArquivoCargos)) {
            $fkPessoalArquivoCargos->setFkPessoalCargo($this);
            $this->fkPessoalArquivoCargos->add($fkPessoalArquivoCargos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalArquivoCargos
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos
     */
    public function removeFkPessoalArquivoCargos(\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos $fkPessoalArquivoCargos)
    {
        $this->fkPessoalArquivoCargos->removeElement($fkPessoalArquivoCargos);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalArquivoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ArquivoCargos
     */
    public function getFkPessoalArquivoCargos()
    {
        return $this->fkPessoalArquivoCargos;
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao
     */
    public function getFkPessoalCargoSubDivisoes()
    {
        return $this->fkPessoalCargoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Cargo
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalCargo($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     * @return Cargo
     */
    public function addFkPessoalEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        if (false === $this->fkPessoalEspecialidades->contains($fkPessoalEspecialidade)) {
            $fkPessoalEspecialidade->setFkPessoalCargo($this);
            $this->fkPessoalEspecialidades->add($fkPessoalEspecialidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade
     */
    public function removeFkPessoalEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\Especialidade $fkPessoalEspecialidade)
    {
        $this->fkPessoalEspecialidades->removeElement($fkPessoalEspecialidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Especialidade
     */
    public function getFkPessoalEspecialidades()
    {
        return $this->fkPessoalEspecialidades;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codCargo . " - " . $this->descricao;
    }
}
