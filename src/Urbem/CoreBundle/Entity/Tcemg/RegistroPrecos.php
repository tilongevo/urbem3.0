<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * RegistroPrecos
 */
class RegistroPrecos
{
    const PROCESSO_LOTE_SIM = 1;
    const PROCESSO_LOTE_NAO = 2;

    const DESCONTO_TABELA_SIM = 1;
    const DESCONTO_TABELA_NAO = 2;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * PK
     * @var boolean
     */
    private $interno = true;

    /**
     * @var \DateTime
     */
    private $dataAberturaRegistroPrecos;

    /**
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * @var string
     */
    private $numeroProcessoLicitacao;

    /**
     * @var integer
     */
    private $codigoModalidadeLicitacao;

    /**
     * @var integer
     */
    private $numeroModalidade;

    /**
     * @var \DateTime
     */
    private $dataAtaRegistroPreco;

    /**
     * @var \DateTime
     */
    private $dataAtaRegistroPrecoValidade;

    /**
     * @var string
     */
    private $objeto;

    /**
     * @var integer
     */
    private $cgmResponsavel;

    /**
     * @var integer
     */
    private $descontoTabela;

    /**
     * @var integer
     */
    private $processoLote;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos
     */
    private $fkTcemgLoteRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao
     */
    private $fkTcemgRegistroPrecosLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos
     */
    private $fkTcemgEmpenhoRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao
     */
    private $fkTcemgRegistroPrecosOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgLoteRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecosLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgEmpenhoRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistroPrecosOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RegistroPrecos
     */
    public function setCodEntidade($codEntidade = null)
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
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return RegistroPrecos
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos = null)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RegistroPrecos
     */
    public function setExercicio($exercicio = null)
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
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return RegistroPrecos
     */
    public function setNumcgmGerenciador($numcgmGerenciador = null)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return RegistroPrecos
     */
    public function setInterno($interno = null)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set dataAberturaRegistroPrecos
     *
     * @param \DateTime $dataAberturaRegistroPrecos
     * @return RegistroPrecos
     */
    public function setDataAberturaRegistroPrecos(\DateTime $dataAberturaRegistroPrecos = null)
    {
        $this->dataAberturaRegistroPrecos = $dataAberturaRegistroPrecos;
        return $this;
    }

    /**
     * Get dataAberturaRegistroPrecos
     *
     * @return \DateTime
     */
    public function getDataAberturaRegistroPrecos()
    {
        return $this->dataAberturaRegistroPrecos;
    }

    /**
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return RegistroPrecos
     */
    public function setExercicioLicitacao($exercicioLicitacao = null)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * Set numeroProcessoLicitacao
     *
     * @param string $numeroProcessoLicitacao
     * @return RegistroPrecos
     */
    public function setNumeroProcessoLicitacao($numeroProcessoLicitacao = null)
    {
        $this->numeroProcessoLicitacao = $numeroProcessoLicitacao;
        return $this;
    }

    /**
     * Get numeroProcessoLicitacao
     *
     * @return string
     */
    public function getNumeroProcessoLicitacao()
    {
        return $this->numeroProcessoLicitacao;
    }

    /**
     * Set codigoModalidadeLicitacao
     *
     * @param integer $codigoModalidadeLicitacao
     * @return RegistroPrecos
     */
    public function setCodigoModalidadeLicitacao($codigoModalidadeLicitacao = null)
    {
        $this->codigoModalidadeLicitacao = $codigoModalidadeLicitacao;
        return $this;
    }

    /**
     * Get codigoModalidadeLicitacao
     *
     * @return integer
     */
    public function getCodigoModalidadeLicitacao()
    {
        return $this->codigoModalidadeLicitacao;
    }

    /**
     * Set numeroModalidade
     *
     * @param integer $numeroModalidade
     * @return RegistroPrecos
     */
    public function setNumeroModalidade($numeroModalidade = null)
    {
        $this->numeroModalidade = $numeroModalidade;
        return $this;
    }

    /**
     * Get numeroModalidade
     *
     * @return integer
     */
    public function getNumeroModalidade()
    {
        return $this->numeroModalidade;
    }

    /**
     * Set dataAtaRegistroPreco
     *
     * @param \DateTime $dataAtaRegistroPreco
     * @return RegistroPrecos
     */
    public function setDataAtaRegistroPreco(\DateTime $dataAtaRegistroPreco = null)
    {
        $this->dataAtaRegistroPreco = $dataAtaRegistroPreco;
        return $this;
    }

    /**
     * Get dataAtaRegistroPreco
     *
     * @return \DateTime
     */
    public function getDataAtaRegistroPreco()
    {
        return $this->dataAtaRegistroPreco;
    }

    /**
     * Set dataAtaRegistroPrecoValidade
     *
     * @param \DateTime $dataAtaRegistroPrecoValidade
     * @return RegistroPrecos
     */
    public function setDataAtaRegistroPrecoValidade(\DateTime $dataAtaRegistroPrecoValidade = null)
    {
        $this->dataAtaRegistroPrecoValidade = $dataAtaRegistroPrecoValidade;
        return $this;
    }

    /**
     * Get dataAtaRegistroPrecoValidade
     *
     * @return \DateTime
     */
    public function getDataAtaRegistroPrecoValidade()
    {
        return $this->dataAtaRegistroPrecoValidade;
    }

    /**
     * Set objeto
     *
     * @param string $objeto
     * @return RegistroPrecos
     */
    public function setObjeto($objeto = null)
    {
        $this->objeto = $objeto;
        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set cgmResponsavel
     *
     * @param integer $cgmResponsavel
     * @return RegistroPrecos
     */
    public function setCgmResponsavel($cgmResponsavel = null)
    {
        $this->cgmResponsavel = $cgmResponsavel;
        return $this;
    }

    /**
     * Get cgmResponsavel
     *
     * @return integer
     */
    public function getCgmResponsavel()
    {
        return $this->cgmResponsavel;
    }

    /**
     * Set descontoTabela
     *
     * @param integer $descontoTabela
     * @return RegistroPrecos
     */
    public function setDescontoTabela($descontoTabela = null)
    {
        $this->descontoTabela = $descontoTabela;
        return $this;
    }

    /**
     * Get descontoTabela
     *
     * @return integer
     */
    public function getDescontoTabela()
    {
        return $this->descontoTabela;
    }

    /**
     * Set processoLote
     *
     * @param integer $processoLote
     * @return RegistroPrecos
     */
    public function setProcessoLote($processoLote = null)
    {
        $this->processoLote = $processoLote;
        return $this;
    }

    /**
     * Get processoLote
     *
     * @return integer
     */
    public function getProcessoLote()
    {
        return $this->processoLote;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgLoteRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos
     * @return RegistroPrecos
     */
    public function addFkTcemgLoteRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos)
    {
        if (false === $this->fkTcemgLoteRegistroPrecos->contains($fkTcemgLoteRegistroPrecos)) {
            $fkTcemgLoteRegistroPrecos->setFkTcemgRegistroPrecos($this);
            $this->fkTcemgLoteRegistroPrecos->add($fkTcemgLoteRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgLoteRegistroPrecos
     *
     * @param array $fkTcemgLoteRegistroPrecos
     * @return RegistroPrecos
     */
    public function setFkTcemgLoteRegistroPrecos(array $fkTcemgLoteRegistroPrecos)
    {
        foreach ($fkTcemgLoteRegistroPrecos as $fkTcemgLoteRegistroPreco) {
            $this->addFkTcemgLoteRegistroPrecos($fkTcemgLoteRegistroPreco);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgLoteRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos
     */
    public function removeFkTcemgLoteRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos)
    {
        $this->fkTcemgLoteRegistroPrecos->removeElement($fkTcemgLoteRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgLoteRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos
     */
    public function getFkTcemgLoteRegistroPrecos()
    {
        return $this->fkTcemgLoteRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao
     * @return RegistroPrecos
     */
    public function addFkTcemgRegistroPrecosLicitacoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao)
    {
        if (false === $this->fkTcemgRegistroPrecosLicitacoes->contains($fkTcemgRegistroPrecosLicitacao)) {
            $fkTcemgRegistroPrecosLicitacao->setFkTcemgRegistroPrecos($this);
            $this->fkTcemgRegistroPrecosLicitacoes->add($fkTcemgRegistroPrecosLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgEmpenhoRegistroPrecos
     *
     * @param array $fkTcemgRegistroPrecosLicitacoes
     * @return RegistroPrecos
     */
    public function setFkTcemgRegistroPrecosLicitacoes(array $fkTcemgRegistroPrecosLicitacoes)
    {
        foreach ($fkTcemgRegistroPrecosLicitacoes as $fkTcemgRegistroPrecosLicitacao) {
            $this->addFkTcemgRegistroPrecosLicitacoes($fkTcemgRegistroPrecosLicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao
     */
    public function removeFkTcemgRegistroPrecosLicitacoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao $fkTcemgRegistroPrecosLicitacao)
    {
        $this->fkTcemgRegistroPrecosLicitacoes->removeElement($fkTcemgRegistroPrecosLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosLicitacao
     */
    public function getFkTcemgRegistroPrecosLicitacoes()
    {
        return $this->fkTcemgRegistroPrecosLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgEmpenhoRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos
     * @return RegistroPrecos
     */
    public function addFkTcemgEmpenhoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos)
    {
        if (false === $this->fkTcemgEmpenhoRegistroPrecos->contains($fkTcemgEmpenhoRegistroPrecos)) {
            $fkTcemgEmpenhoRegistroPrecos->setFkTcemgRegistroPrecos($this);
            $this->fkTcemgEmpenhoRegistroPrecos->add($fkTcemgEmpenhoRegistroPrecos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgEmpenhoRegistroPrecos
     *
     * @param array $fkTcemgEmpenhoRegistroPrecos
     * @return RegistroPrecos
     */
    public function setFkTcemgEmpenhoRegistroPrecos(array $fkTcemgEmpenhoRegistroPrecos)
    {
        foreach ($fkTcemgEmpenhoRegistroPrecos as $fkTcemgEmpenhoRegistroPreco) {
            $this->addFkTcemgEmpenhoRegistroPrecos($fkTcemgEmpenhoRegistroPreco);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgEmpenhoRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos
     */
    public function removeFkTcemgEmpenhoRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos $fkTcemgEmpenhoRegistroPrecos)
    {
        $this->fkTcemgEmpenhoRegistroPrecos->removeElement($fkTcemgEmpenhoRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgEmpenhoRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\EmpenhoRegistroPrecos
     */
    public function getFkTcemgEmpenhoRegistroPrecos()
    {
        return $this->fkTcemgEmpenhoRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao
     * @return RegistroPrecos
     */
    public function addFkTcemgRegistroPrecosOrgoes(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgao $fkTcemgRegistroPrecosOrgao)
    {
        if (false === $this->fkTcemgRegistroPrecosOrgoes->contains($fkTcemgRegistroPrecosOrgao)) {
            $fkTcemgRegistroPrecosOrgao->setFkTcemgRegistroPrecos($this);
            $this->fkTcemgRegistroPrecosOrgoes->add($fkTcemgRegistroPrecosOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgao
     *
     * @param array $fkTcemgRegistroPrecosOrgao
     * @return RegistroPrecos
     */
    public function setFkTcemgRegistroPrecosOrgoes(array $fkTcemgRegistroPrecosOrgaos)
    {
        foreach ($fkTcemgRegistroPrecosOrgaos as $fkTcemgRegistroPrecosOrgao) {
            $this->addFkTcemgRegistroPrecosOrgoes($fkTcemgRegistroPrecosOrgao);
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return RegistroPrecos
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm = null)
    {
        $this->numcgmGerenciador = $fkSwCgm->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return RegistroPrecos
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade = null)
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
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return RegistroPrecos
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica = null)
    {
        $this->cgmResponsavel = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%010d/%s', (int) $this->numeroRegistroPrecos, $this->exercicio);
    }
}
