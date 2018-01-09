<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * SubDivisao
 */
class SubDivisao
{
    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * @var integer
     */
    private $codRegime;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor
     */
    private $fkFolhapagamentoTcemgEntidadeCargoServidores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    private $fkImaExportacaoTcmBaSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao
     */
    private $fkPessoalAssentamentoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao
     */
    private $fkPessoalCasoCausaSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao
     */
    private $fkPessoalContratoServidorSubDivisaoFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho
     */
    private $fkPessoalDeParaTipoRegimeTrabalhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo
     */
    private $fkPessoalDeParaTipoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba
     */
    private $fkPessoalDeParaTipoCargoTcmbas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    private $fkPessoalEspecialidadeSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao
     */
    private $fkPessoalVinculoRegimeSubdivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    private $fkTcealDeParaTipoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    private $fkTcernSubDivisaoDescricaoSiais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao
     */
    private $fkImaCagedSubDivisoes;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    private $fkPessoalRegime;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTcemgEntidadeCargoServidores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaExportacaoTcmBaSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAssentamentoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCasoCausaSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorSubDivisaoFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaTipoRegimeTrabalhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaTipoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaTipoCargoTcmbas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidadeSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalVinculoRegimeSubdivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealDeParaTipoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernSubDivisaoDescricaoSiais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaCagedSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCargoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return SubDivisao
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
     * Set codRegime
     *
     * @param integer $codRegime
     * @return SubDivisao
     */
    public function setCodRegime($codRegime)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SubDivisao
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
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao
     * @return SubDivisao
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->contains($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)) {
            $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->add($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->removeElement($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcemgEntidadeCargoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor
     * @return SubDivisao
     */
    public function addFkFolhapagamentoTcemgEntidadeCargoServidores(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor $fkFolhapagamentoTcemgEntidadeCargoServidor)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeCargoServidores->contains($fkFolhapagamentoTcemgEntidadeCargoServidor)) {
            $fkFolhapagamentoTcemgEntidadeCargoServidor->setFkPessoalSubDivisao($this);
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
     * Add ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     * @return SubDivisao
     */
    public function addFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        if (false === $this->fkImaExportacaoTcmBaSubDivisoes->contains($fkImaExportacaoTcmBaSubDivisao)) {
            $fkImaExportacaoTcmBaSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkImaExportacaoTcmBaSubDivisoes->add($fkImaExportacaoTcmBaSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     */
    public function removeFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        $this->fkImaExportacaoTcmBaSubDivisoes->removeElement($fkImaExportacaoTcmBaSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaExportacaoTcmBaSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    public function getFkImaExportacaoTcmBaSubDivisoes()
    {
        return $this->fkImaExportacaoTcmBaSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAssentamentoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao
     * @return SubDivisao
     */
    public function addFkPessoalAssentamentoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao)
    {
        if (false === $this->fkPessoalAssentamentoSubDivisoes->contains($fkPessoalAssentamentoSubDivisao)) {
            $fkPessoalAssentamentoSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkPessoalAssentamentoSubDivisoes->add($fkPessoalAssentamentoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAssentamentoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao
     */
    public function removeFkPessoalAssentamentoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao $fkPessoalAssentamentoSubDivisao)
    {
        $this->fkPessoalAssentamentoSubDivisoes->removeElement($fkPessoalAssentamentoSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAssentamentoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao
     */
    public function getFkPessoalAssentamentoSubDivisoes()
    {
        return $this->fkPessoalAssentamentoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCasoCausaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao
     * @return SubDivisao
     */
    public function addFkPessoalCasoCausaSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao)
    {
        if (false === $this->fkPessoalCasoCausaSubDivisoes->contains($fkPessoalCasoCausaSubDivisao)) {
            $fkPessoalCasoCausaSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkPessoalCasoCausaSubDivisoes->add($fkPessoalCasoCausaSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCasoCausaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao
     */
    public function removeFkPessoalCasoCausaSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao)
    {
        $this->fkPessoalCasoCausaSubDivisoes->removeElement($fkPessoalCasoCausaSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCasoCausaSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao
     */
    public function getFkPessoalCasoCausaSubDivisoes()
    {
        return $this->fkPessoalCasoCausaSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorSubDivisaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao
     * @return SubDivisao
     */
    public function addFkPessoalContratoServidorSubDivisaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao)
    {
        if (false === $this->fkPessoalContratoServidorSubDivisaoFuncoes->contains($fkPessoalContratoServidorSubDivisaoFuncao)) {
            $fkPessoalContratoServidorSubDivisaoFuncao->setFkPessoalSubDivisao($this);
            $this->fkPessoalContratoServidorSubDivisaoFuncoes->add($fkPessoalContratoServidorSubDivisaoFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorSubDivisaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao
     */
    public function removeFkPessoalContratoServidorSubDivisaoFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao $fkPessoalContratoServidorSubDivisaoFuncao)
    {
        $this->fkPessoalContratoServidorSubDivisaoFuncoes->removeElement($fkPessoalContratoServidorSubDivisaoFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorSubDivisaoFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao
     */
    public function getFkPessoalContratoServidorSubDivisaoFuncoes()
    {
        return $this->fkPessoalContratoServidorSubDivisaoFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaTipoRegimeTrabalho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho
     * @return SubDivisao
     */
    public function addFkPessoalDeParaTipoRegimeTrabalhos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho)
    {
        if (false === $this->fkPessoalDeParaTipoRegimeTrabalhos->contains($fkPessoalDeParaTipoRegimeTrabalho)) {
            $fkPessoalDeParaTipoRegimeTrabalho->setFkPessoalSubDivisao($this);
            $this->fkPessoalDeParaTipoRegimeTrabalhos->add($fkPessoalDeParaTipoRegimeTrabalho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoRegimeTrabalho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho
     */
    public function removeFkPessoalDeParaTipoRegimeTrabalhos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho $fkPessoalDeParaTipoRegimeTrabalho)
    {
        $this->fkPessoalDeParaTipoRegimeTrabalhos->removeElement($fkPessoalDeParaTipoRegimeTrabalho);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoRegimeTrabalhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoRegimeTrabalho
     */
    public function getFkPessoalDeParaTipoRegimeTrabalhos()
    {
        return $this->fkPessoalDeParaTipoRegimeTrabalhos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo
     * @return SubDivisao
     */
    public function addFkPessoalDeParaTipoCargos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo)
    {
        if (false === $this->fkPessoalDeParaTipoCargos->contains($fkPessoalDeParaTipoCargo)) {
            $fkPessoalDeParaTipoCargo->setFkPessoalSubDivisao($this);
            $this->fkPessoalDeParaTipoCargos->add($fkPessoalDeParaTipoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo
     */
    public function removeFkPessoalDeParaTipoCargos(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo $fkPessoalDeParaTipoCargo)
    {
        $this->fkPessoalDeParaTipoCargos->removeElement($fkPessoalDeParaTipoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargo
     */
    public function getFkPessoalDeParaTipoCargos()
    {
        return $this->fkPessoalDeParaTipoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaTipoCargoTcmba
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba
     * @return SubDivisao
     */
    public function addFkPessoalDeParaTipoCargoTcmbas(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba)
    {
        if (false === $this->fkPessoalDeParaTipoCargoTcmbas->contains($fkPessoalDeParaTipoCargoTcmba)) {
            $fkPessoalDeParaTipoCargoTcmba->setFkPessoalSubDivisao($this);
            $this->fkPessoalDeParaTipoCargoTcmbas->add($fkPessoalDeParaTipoCargoTcmba);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaTipoCargoTcmba
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba
     */
    public function removeFkPessoalDeParaTipoCargoTcmbas(\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba $fkPessoalDeParaTipoCargoTcmba)
    {
        $this->fkPessoalDeParaTipoCargoTcmbas->removeElement($fkPessoalDeParaTipoCargoTcmba);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaTipoCargoTcmbas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaTipoCargoTcmba
     */
    public function getFkPessoalDeParaTipoCargoTcmbas()
    {
        return $this->fkPessoalDeParaTipoCargoTcmbas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     * @return SubDivisao
     */
    public function addFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        if (false === $this->fkPessoalEspecialidadeSubDivisoes->contains($fkPessoalEspecialidadeSubDivisao)) {
            $fkPessoalEspecialidadeSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkPessoalEspecialidadeSubDivisoes->add($fkPessoalEspecialidadeSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     */
    public function removeFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        $this->fkPessoalEspecialidadeSubDivisoes->removeElement($fkPessoalEspecialidadeSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidadeSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    public function getFkPessoalEspecialidadeSubDivisoes()
    {
        return $this->fkPessoalEspecialidadeSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalVinculoRegimeSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao
     * @return SubDivisao
     */
    public function addFkPessoalVinculoRegimeSubdivisoes(\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao)
    {
        if (false === $this->fkPessoalVinculoRegimeSubdivisoes->contains($fkPessoalVinculoRegimeSubdivisao)) {
            $fkPessoalVinculoRegimeSubdivisao->setFkPessoalSubDivisao($this);
            $this->fkPessoalVinculoRegimeSubdivisoes->add($fkPessoalVinculoRegimeSubdivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalVinculoRegimeSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao
     */
    public function removeFkPessoalVinculoRegimeSubdivisoes(\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao $fkPessoalVinculoRegimeSubdivisao)
    {
        $this->fkPessoalVinculoRegimeSubdivisoes->removeElement($fkPessoalVinculoRegimeSubdivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalVinculoRegimeSubdivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\VinculoRegimeSubdivisao
     */
    public function getFkPessoalVinculoRegimeSubdivisoes()
    {
        return $this->fkPessoalVinculoRegimeSubdivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     * @return SubDivisao
     */
    public function addFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        if (false === $this->fkTcealDeParaTipoCargos->contains($fkTcealDeParaTipoCargo)) {
            $fkTcealDeParaTipoCargo->setFkPessoalSubDivisao($this);
            $this->fkTcealDeParaTipoCargos->add($fkTcealDeParaTipoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     */
    public function removeFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        $this->fkTcealDeParaTipoCargos->removeElement($fkTcealDeParaTipoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealDeParaTipoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    public function getFkTcealDeParaTipoCargos()
    {
        return $this->fkTcealDeParaTipoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     * @return SubDivisao
     */
    public function addFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        if (false === $this->fkTcernSubDivisaoDescricaoSiais->contains($fkTcernSubDivisaoDescricaoSiai)) {
            $fkTcernSubDivisaoDescricaoSiai->setFkPessoalSubDivisao($this);
            $this->fkTcernSubDivisaoDescricaoSiais->add($fkTcernSubDivisaoDescricaoSiai);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     */
    public function removeFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        $this->fkTcernSubDivisaoDescricaoSiais->removeElement($fkTcernSubDivisaoDescricaoSiai);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernSubDivisaoDescricaoSiais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    public function getFkTcernSubDivisaoDescricaoSiais()
    {
        return $this->fkTcernSubDivisaoDescricaoSiais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao
     * @return SubDivisao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->contains($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao->setFkPessoalSubDivisao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->add($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoSubdivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao $fkFolhapagamentoConfiguracaoEmpenhoSubdivisao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoSubdivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoSubdivisao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoSubdivisoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoSubdivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCagedSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao
     * @return SubDivisao
     */
    public function addFkImaCagedSubDivisoes(\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao)
    {
        if (false === $this->fkImaCagedSubDivisoes->contains($fkImaCagedSubDivisao)) {
            $fkImaCagedSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkImaCagedSubDivisoes->add($fkImaCagedSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCagedSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao
     */
    public function removeFkImaCagedSubDivisoes(\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao)
    {
        $this->fkImaCagedSubDivisoes->removeElement($fkImaCagedSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCagedSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao
     */
    public function getFkImaCagedSubDivisoes()
    {
        return $this->fkImaCagedSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCargoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao
     * @return SubDivisao
     */
    public function addFkPessoalCargoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao)
    {
        if (false === $this->fkPessoalCargoSubDivisoes->contains($fkPessoalCargoSubDivisao)) {
            $fkPessoalCargoSubDivisao->setFkPessoalSubDivisao($this);
            $this->fkPessoalCargoSubDivisoes->add($fkPessoalCargoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao
     */
    public function removeFkPessoalCargoSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao $fkPessoalCargoSubDivisao)
    {
        $this->fkPessoalCargoSubDivisoes->removeElement($fkPessoalCargoSubDivisao);
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
     * @return SubDivisao
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalSubDivisao($this);
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
     * ManyToOne (inverse side)
     * Set fkPessoalRegime
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime
     * @return SubDivisao
     */
    public function setFkPessoalRegime(\Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime)
    {
        $this->codRegime = $fkPessoalRegime->getCodRegime();
        $this->fkPessoalRegime = $fkPessoalRegime;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalRegime
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    public function getFkPessoalRegime()
    {
        return $this->fkPessoalRegime;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
