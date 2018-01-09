<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Unidade
 */
class Unidade
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
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var string
     */
    private $nomUnidade;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao
     */
    private $fkEmpenhoPermissaoAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    private $fkPatrimonioBemComprados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    private $fkPatrimonioVeiculoUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade
     */
    private $fkPessoalDeParaOrgaoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora
     */
    private $fkPpaAcaoUnidadeExecutoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    private $fkStnVinculoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc
     */
    private $fkTcemgArquivoCvcs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    private $fkTcemgUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    private $fkTcepeConfiguracaoOrdenadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    private $fkTcepeConfiguracaoGestores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    private $fkTcernUnidadeOrcamentarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    private $fkTcmbaConfiguracaoRatificadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    private $fkTcmgoConfiguracaoOrgaoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    private $fkTcemgContratoAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    private $fkTcemgRegistroPrecosOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    private $fkTcmbaConfiguracaoOrdenadores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoPermissaoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBemComprados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioVeiculoUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaOrgaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoUnidadeExecutoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoCvcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeConfiguracaoGestores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoRatificadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoConfiguracaoOrgaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoUnidadeResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecosOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaConfiguracaoOrdenadores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Unidade
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Unidade
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Unidade
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set nomUnidade
     *
     * @param string $nomUnidade
     * @return Unidade
     */
    public function setNomUnidade($nomUnidade)
    {
        $this->nomUnidade = $nomUnidade;
        return $this;
    }

    /**
     * Get nomUnidade
     *
     * @return string
     */
    public function getNomUnidade()
    {
        return $this->nomUnidade;
    }

    /**
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Unidade
     */
    public function setUsuarioResponsavel($usuarioResponsavel)
    {
        $this->usuarioResponsavel = $usuarioResponsavel;
        return $this;
    }

    /**
     * Get usuarioResponsavel
     *
     * @return integer
     */
    public function getUsuarioResponsavel()
    {
        return $this->usuarioResponsavel;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPermissaoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao
     * @return Unidade
     */
    public function addFkEmpenhoPermissaoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao)
    {
        if (false === $this->fkEmpenhoPermissaoAutorizacoes->contains($fkEmpenhoPermissaoAutorizacao)) {
            $fkEmpenhoPermissaoAutorizacao->setFkOrcamentoUnidade($this);
            $this->fkEmpenhoPermissaoAutorizacoes->add($fkEmpenhoPermissaoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPermissaoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao
     */
    public function removeFkEmpenhoPermissaoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao)
    {
        $this->fkEmpenhoPermissaoAutorizacoes->removeElement($fkEmpenhoPermissaoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPermissaoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao
     */
    public function getFkEmpenhoPermissaoAutorizacoes()
    {
        return $this->fkEmpenhoPermissaoAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return Unidade
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkOrcamentoUnidade($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Unidade
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkOrcamentoUnidade($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     * @return Unidade
     */
    public function addFkPatrimonioBemComprados(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        if (false === $this->fkPatrimonioBemComprados->contains($fkPatrimonioBemComprado)) {
            $fkPatrimonioBemComprado->setFkOrcamentoUnidade($this);
            $this->fkPatrimonioBemComprados->add($fkPatrimonioBemComprado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemComprado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado
     */
    public function removeFkPatrimonioBemComprados(\Urbem\CoreBundle\Entity\Patrimonio\BemComprado $fkPatrimonioBemComprado)
    {
        $this->fkPatrimonioBemComprados->removeElement($fkPatrimonioBemComprado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemComprados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemComprado
     */
    public function getFkPatrimonioBemComprados()
    {
        return $this->fkPatrimonioBemComprados;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioVeiculoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam
     * @return Unidade
     */
    public function addFkPatrimonioVeiculoUniorcans(\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam)
    {
        if (false === $this->fkPatrimonioVeiculoUniorcans->contains($fkPatrimonioVeiculoUniorcam)) {
            $fkPatrimonioVeiculoUniorcam->setFkOrcamentoUnidade($this);
            $this->fkPatrimonioVeiculoUniorcans->add($fkPatrimonioVeiculoUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioVeiculoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam
     */
    public function removeFkPatrimonioVeiculoUniorcans(\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam $fkPatrimonioVeiculoUniorcam)
    {
        $this->fkPatrimonioVeiculoUniorcans->removeElement($fkPatrimonioVeiculoUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioVeiculoUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\VeiculoUniorcam
     */
    public function getFkPatrimonioVeiculoUniorcans()
    {
        return $this->fkPatrimonioVeiculoUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade
     * @return Unidade
     */
    public function addFkPessoalDeParaOrgaoUnidades(\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade)
    {
        if (false === $this->fkPessoalDeParaOrgaoUnidades->contains($fkPessoalDeParaOrgaoUnidade)) {
            $fkPessoalDeParaOrgaoUnidade->setFkOrcamentoUnidade($this);
            $this->fkPessoalDeParaOrgaoUnidades->add($fkPessoalDeParaOrgaoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade
     */
    public function removeFkPessoalDeParaOrgaoUnidades(\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade)
    {
        $this->fkPessoalDeParaOrgaoUnidades->removeElement($fkPessoalDeParaOrgaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaOrgaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade
     */
    public function getFkPessoalDeParaOrgaoUnidades()
    {
        return $this->fkPessoalDeParaOrgaoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoUnidadeExecutora
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora
     * @return Unidade
     */
    public function addFkPpaAcaoUnidadeExecutoras(\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora)
    {
        if (false === $this->fkPpaAcaoUnidadeExecutoras->contains($fkPpaAcaoUnidadeExecutora)) {
            $fkPpaAcaoUnidadeExecutora->setFkOrcamentoUnidade($this);
            $this->fkPpaAcaoUnidadeExecutoras->add($fkPpaAcaoUnidadeExecutora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoUnidadeExecutora
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora
     */
    public function removeFkPpaAcaoUnidadeExecutoras(\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora $fkPpaAcaoUnidadeExecutora)
    {
        $this->fkPpaAcaoUnidadeExecutoras->removeElement($fkPpaAcaoUnidadeExecutora);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoUnidadeExecutoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora
     */
    public function getFkPpaAcaoUnidadeExecutoras()
    {
        return $this->fkPpaAcaoUnidadeExecutoras;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     * @return Unidade
     */
    public function addFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        if (false === $this->fkStnVinculoRecursos->contains($fkStnVinculoRecurso)) {
            $fkStnVinculoRecurso->setFkOrcamentoUnidade($this);
            $this->fkStnVinculoRecursos->add($fkStnVinculoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     */
    public function removeFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        $this->fkStnVinculoRecursos->removeElement($fkStnVinculoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    public function getFkStnVinculoRecursos()
    {
        return $this->fkStnVinculoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoCvc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc
     * @return Unidade
     */
    public function addFkTcemgArquivoCvcs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc)
    {
        if (false === $this->fkTcemgArquivoCvcs->contains($fkTcemgArquivoCvc)) {
            $fkTcemgArquivoCvc->setFkOrcamentoUnidade($this);
            $this->fkTcemgArquivoCvcs->add($fkTcemgArquivoCvc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoCvc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc
     */
    public function removeFkTcemgArquivoCvcs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc $fkTcemgArquivoCvc)
    {
        $this->fkTcemgArquivoCvcs->removeElement($fkTcemgArquivoCvc);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoCvcs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoCvc
     */
    public function getFkTcemgArquivoCvcs()
    {
        return $this->fkTcemgArquivoCvcs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return Unidade
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkOrcamentoUnidade($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     * @return Unidade
     */
    public function addFkTcemgUniorcans(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        if (false === $this->fkTcemgUniorcans->contains($fkTcemgUniorcam)) {
            $fkTcemgUniorcam->setFkOrcamentoUnidade($this);
            $this->fkTcemgUniorcans->add($fkTcemgUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     */
    public function removeFkTcemgUniorcans(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        $this->fkTcemgUniorcans->removeElement($fkTcemgUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    public function getFkTcemgUniorcans()
    {
        return $this->fkTcemgUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     * @return Unidade
     */
    public function addFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        if (false === $this->fkTcepeConfiguracaoOrdenadores->contains($fkTcepeConfiguracaoOrdenador)) {
            $fkTcepeConfiguracaoOrdenador->setFkOrcamentoUnidade($this);
            $this->fkTcepeConfiguracaoOrdenadores->add($fkTcepeConfiguracaoOrdenador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador
     */
    public function removeFkTcepeConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador $fkTcepeConfiguracaoOrdenador)
    {
        $this->fkTcepeConfiguracaoOrdenadores->removeElement($fkTcepeConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoOrdenador
     */
    public function getFkTcepeConfiguracaoOrdenadores()
    {
        return $this->fkTcepeConfiguracaoOrdenadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     * @return Unidade
     */
    public function addFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        if (false === $this->fkTcepeConfiguracaoGestores->contains($fkTcepeConfiguracaoGestor)) {
            $fkTcepeConfiguracaoGestor->setFkOrcamentoUnidade($this);
            $this->fkTcepeConfiguracaoGestores->add($fkTcepeConfiguracaoGestor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeConfiguracaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor
     */
    public function removeFkTcepeConfiguracaoGestores(\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor $fkTcepeConfiguracaoGestor)
    {
        $this->fkTcepeConfiguracaoGestores->removeElement($fkTcepeConfiguracaoGestor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeConfiguracaoGestores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\ConfiguracaoGestor
     */
    public function getFkTcepeConfiguracaoGestores()
    {
        return $this->fkTcepeConfiguracaoGestores;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     * @return Unidade
     */
    public function addFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        if (false === $this->fkTcernUnidadeOrcamentarias->contains($fkTcernUnidadeOrcamentaria)) {
            $fkTcernUnidadeOrcamentaria->setFkOrcamentoUnidade($this);
            $this->fkTcernUnidadeOrcamentarias->add($fkTcernUnidadeOrcamentaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     */
    public function removeFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        $this->fkTcernUnidadeOrcamentarias->removeElement($fkTcernUnidadeOrcamentaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    public function getFkTcernUnidadeOrcamentarias()
    {
        return $this->fkTcernUnidadeOrcamentarias;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     * @return Unidade
     */
    public function addFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        if (false === $this->fkTcmbaConfiguracaoRatificadores->contains($fkTcmbaConfiguracaoRatificador)) {
            $fkTcmbaConfiguracaoRatificador->setFkOrcamentoUnidade($this);
            $this->fkTcmbaConfiguracaoRatificadores->add($fkTcmbaConfiguracaoRatificador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoRatificador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador
     */
    public function removeFkTcmbaConfiguracaoRatificadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador $fkTcmbaConfiguracaoRatificador)
    {
        $this->fkTcmbaConfiguracaoRatificadores->removeElement($fkTcmbaConfiguracaoRatificador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoRatificadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoRatificador
     */
    public function getFkTcmbaConfiguracaoRatificadores()
    {
        return $this->fkTcmbaConfiguracaoRatificadores;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     * @return Unidade
     */
    public function addFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        if (false === $this->fkTcmgoConfiguracaoOrgaoUnidades->contains($fkTcmgoConfiguracaoOrgaoUnidade)) {
            $fkTcmgoConfiguracaoOrgaoUnidade->setFkOrcamentoUnidade($this);
            $this->fkTcmgoConfiguracaoOrgaoUnidades->add($fkTcmgoConfiguracaoOrgaoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoConfiguracaoOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade
     */
    public function removeFkTcmgoConfiguracaoOrgaoUnidades(\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade $fkTcmgoConfiguracaoOrgaoUnidade)
    {
        $this->fkTcmgoConfiguracaoOrgaoUnidades->removeElement($fkTcmgoConfiguracaoOrgaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoConfiguracaoOrgaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ConfiguracaoOrgaoUnidade
     */
    public function getFkTcmgoConfiguracaoOrgaoUnidades()
    {
        return $this->fkTcmgoConfiguracaoOrgaoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return Unidade
     */
    public function addFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        if (false === $this->fkTcmgoUnidadeResponsaveis->contains($fkTcmgoUnidadeResponsavel)) {
            $fkTcmgoUnidadeResponsavel->setFkOrcamentoUnidade($this);
            $this->fkTcmgoUnidadeResponsaveis->add($fkTcmgoUnidadeResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     */
    public function removeFkTcmgoUnidadeResponsaveis(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->fkTcmgoUnidadeResponsaveis->removeElement($fkTcmgoUnidadeResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoUnidadeResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsaveis()
    {
        return $this->fkTcmgoUnidadeResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return Unidade
     */
    public function addFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhos->contains($fkEmpenhoAutorizacaoEmpenho)) {
            $fkEmpenhoAutorizacaoEmpenho->setFkOrcamentoUnidade($this);
            $this->fkEmpenhoAutorizacaoEmpenhos->add($fkEmpenhoAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     */
    public function removeFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->fkEmpenhoAutorizacaoEmpenhos->removeElement($fkEmpenhoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenhos()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Unidade
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoUnidade($this);
            $this->fkOrcamentoDespesas->add($fkOrcamentoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     */
    public function removeFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->fkOrcamentoDespesas->removeElement($fkOrcamentoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesas()
    {
        return $this->fkOrcamentoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return Unidade
     */
    public function addFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        if (false === $this->fkPpaProgramaDados->contains($fkPpaProgramaDados)) {
            $fkPpaProgramaDados->setFkOrcamentoUnidade($this);
            $this->fkPpaProgramaDados->add($fkPpaProgramaDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     */
    public function removeFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->fkPpaProgramaDados->removeElement($fkPpaProgramaDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     * @return Unidade
     */
    public function addFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        if (false === $this->fkTcemgContratoAditivos->contains($fkTcemgContratoAditivo)) {
            $fkTcemgContratoAditivo->setFkOrcamentoUnidade($this);
            $this->fkTcemgContratoAditivos->add($fkTcemgContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     */
    public function removeFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        $this->fkTcemgContratoAditivos->removeElement($fkTcemgContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    public function getFkTcemgContratoAditivos()
    {
        return $this->fkTcemgContratoAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     * @return Unidade
     */
    public function addFkTcemgRegistroPrecosOrgoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        if (false === $this->fkTcemgRegistroPrecosOrgoes->contains($fkTcemgRegistroPrecosOrgao)) {
            $fkTcemgRegistroPrecosOrgao->setFkOrcamentoUnidade($this);
            $this->fkTcemgRegistroPrecosOrgoes->add($fkTcemgRegistroPrecosOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     */
    public function removeFkTcemgRegistroPrecosOrgoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        $this->fkTcemgRegistroPrecosOrgoes->removeElement($fkTcemgRegistroPrecosOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    public function getFkTcemgRegistroPrecosOrgoes()
    {
        return $this->fkTcemgRegistroPrecosOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     * @return Unidade
     */
    public function addFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        if (false === $this->fkTcmbaConfiguracaoOrdenadores->contains($fkTcmbaConfiguracaoOrdenador)) {
            $fkTcmbaConfiguracaoOrdenador->setFkOrcamentoUnidade($this);
            $this->fkTcmbaConfiguracaoOrdenadores->add($fkTcmbaConfiguracaoOrdenador);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaConfiguracaoOrdenador
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador
     */
    public function removeFkTcmbaConfiguracaoOrdenadores(\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador $fkTcmbaConfiguracaoOrdenador)
    {
        $this->fkTcmbaConfiguracaoOrdenadores->removeElement($fkTcmbaConfiguracaoOrdenador);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaConfiguracaoOrdenadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ConfiguracaoOrdenador
     */
    public function getFkTcmbaConfiguracaoOrdenadores()
    {
        return $this->fkTcmbaConfiguracaoOrdenadores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return Unidade
     */
    public function setFkOrcamentoOrgao(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->exercicio = $fkOrcamentoOrgao->getExercicio();
        $this->numOrgao = $fkOrcamentoOrgao->getNumOrgao();
        $this->fkOrcamentoOrgao = $fkOrcamentoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgao()
    {
        return $this->fkOrcamentoOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Unidade
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->usuarioResponsavel = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        $codigo = str_pad($this->fkOrcamentoOrgao->getNumOrgao(), 2, '0', STR_PAD_LEFT);
        $codigo.= '.' . str_pad($this->numUnidade, 2, '0', STR_PAD_LEFT);

        return $codigo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->numUnidade, $this->nomUnidade);
    }
}
