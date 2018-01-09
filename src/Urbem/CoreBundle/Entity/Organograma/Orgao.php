<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * Orgao
 */
class Orgao
{
    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $numCgmPf;

    /**
     * @var integer
     */
    private $codCalendar;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $criacao;

    /**
     * @var \DateTime
     */
    private $inativacao;

    /**
     * @var string
     */
    private $siglaOrgao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Comunicado
     */
    private $fkAdministracaoComunicados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    private $fkAdministracaoImpressoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    private $fkSwUltimoAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    private $fkFrotaTerceirosHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao
     */
    private $fkImaConfiguracaoBanparaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao
     */
    private $fkImaConfiguracaoBbOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao
     */
    private $fkImaConfiguracaoBescOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao
     */
    private $fkImaConfiguracaoBanrisulOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao
     */
    private $fkImaConfiguracaoHsbcOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    private $fkOrganogramaDeParaOrgaoHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    private $fkOrganogramaDeParaOrgaoHistoricos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel
     */
    private $fkOrganogramaOrgaoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaSetor
     */
    private $fkOrganogramaDeParaSetores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm
     */
    private $fkOrganogramaOrgaoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao
     */
    private $fkOrganogramaOrgaoDescricoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao
     */
    private $fkPessoalContratoPensionistaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao
     */
    private $fkPessoalContratoServidorOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade
     */
    private $fkPessoalDeParaOrgaoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao
     */
    private $fkPessoalLoteFeriasOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao
     */
    private $fkPessoalDeParaLotacaoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao
     */
    private $fkPontoConfiguracaoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    private $fkTcepeFonteRecursoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    private $fkOrganogramaDeParaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    private $fkOrganogramaDeParaOrgoes1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamentoPadrao
     */
    private $fkSwAndamentoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    private $fkPatrimonioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    private $fkTcmbaFonteRecursoLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    private $fkCalendarioCalendarioCadastro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoComunicados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoImpressoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwUltimoAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaTerceirosHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanparaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBbOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBescOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanrisulOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgaoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgaoHistoricos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaSetores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgaoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgaoDescricoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaOrgaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaLotacaoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoConfiguracaoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgoes1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAndamentoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaFonteRecursoLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Orgao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set numCgmPf
     *
     * @param integer $numCgmPf
     * @return Orgao
     */
    public function setNumCgmPf($numCgmPf)
    {
        $this->numCgmPf = $numCgmPf;
        return $this;
    }

    /**
     * Get numCgmPf
     *
     * @return integer
     */
    public function getNumCgmPf()
    {
        return $this->numCgmPf;
    }

    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return Orgao
     */
    public function setCodCalendar($codCalendar)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Orgao
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
     * Set criacao
     *
     * @param \DateTime $criacao
     * @return Orgao
     */
    public function setCriacao(\DateTime $criacao)
    {
        $this->criacao = $criacao;
        return $this;
    }

    /**
     * Get criacao
     *
     * @return \DateTime
     */
    public function getCriacao()
    {
        return $this->criacao;
    }

    /**
     * Set inativacao
     *
     * @param \DateTime $inativacao
     * @return Orgao
     */
    public function setInativacao(\DateTime $inativacao = null)
    {
        $this->inativacao = $inativacao;
        return $this;
    }

    /**
     * Get inativacao
     *
     * @return \DateTime
     */
    public function getInativacao()
    {
        return $this->inativacao;
    }

    /**
     * Set siglaOrgao
     *
     * @param string $siglaOrgao
     * @return Orgao
     */
    public function setSiglaOrgao($siglaOrgao = null)
    {
        $this->siglaOrgao = $siglaOrgao;
        return $this;
    }

    /**
     * Get siglaOrgao
     *
     * @return string
     */
    public function getSiglaOrgao()
    {
        return $this->siglaOrgao;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoComunicado
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado
     * @return Orgao
     */
    public function addFkAdministracaoComunicados(\Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado)
    {
        if (false === $this->fkAdministracaoComunicados->contains($fkAdministracaoComunicado)) {
            $fkAdministracaoComunicado->setFkOrganogramaOrgao($this);
            $this->fkAdministracaoComunicados->add($fkAdministracaoComunicado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoComunicado
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado
     */
    public function removeFkAdministracaoComunicados(\Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado)
    {
        $this->fkAdministracaoComunicados->removeElement($fkAdministracaoComunicado);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoComunicados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Comunicado
     */
    public function getFkAdministracaoComunicados()
    {
        return $this->fkAdministracaoComunicados;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     * @return Orgao
     */
    public function addFkAdministracaoImpressoras(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        if (false === $this->fkAdministracaoImpressoras->contains($fkAdministracaoImpressora)) {
            $fkAdministracaoImpressora->setFkOrganogramaOrgao($this);
            $this->fkAdministracaoImpressoras->add($fkAdministracaoImpressora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     */
    public function removeFkAdministracaoImpressoras(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        $this->fkAdministracaoImpressoras->removeElement($fkAdministracaoImpressora);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoImpressoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    public function getFkAdministracaoImpressoras()
    {
        return $this->fkAdministracaoImpressoras;
    }

    /**
     * OneToMany (owning side)
     * Add SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     * @return Orgao
     */
    public function addFkSwUltimoAndamentos(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        if (false === $this->fkSwUltimoAndamentos->contains($fkSwUltimoAndamento)) {
            $fkSwUltimoAndamento->setFkOrganogramaOrgao($this);
            $this->fkSwUltimoAndamentos->add($fkSwUltimoAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     */
    public function removeFkSwUltimoAndamentos(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        $this->fkSwUltimoAndamentos->removeElement($fkSwUltimoAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwUltimoAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    public function getFkSwUltimoAndamentos()
    {
        return $this->fkSwUltimoAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao
     * @return Orgao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoLotacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLotacao->setFkOrganogramaOrgao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->add($fkFolhapagamentoConfiguracaoEmpenhoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao $fkFolhapagamentoConfiguracaoEmpenhoLotacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLotacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLotacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     * @return Orgao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao->setFkOrganogramaOrgao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTerceirosHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico
     * @return Orgao
     */
    public function addFkFrotaTerceirosHistoricos(\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico)
    {
        if (false === $this->fkFrotaTerceirosHistoricos->contains($fkFrotaTerceirosHistorico)) {
            $fkFrotaTerceirosHistorico->setFkOrganogramaOrgao($this);
            $this->fkFrotaTerceirosHistoricos->add($fkFrotaTerceirosHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTerceirosHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico
     */
    public function removeFkFrotaTerceirosHistoricos(\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico)
    {
        $this->fkFrotaTerceirosHistoricos->removeElement($fkFrotaTerceirosHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTerceirosHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    public function getFkFrotaTerceirosHistoricos()
    {
        return $this->fkFrotaTerceirosHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanparaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao
     * @return Orgao
     */
    public function addFkImaConfiguracaoBanparaOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao)
    {
        if (false === $this->fkImaConfiguracaoBanparaOrgoes->contains($fkImaConfiguracaoBanparaOrgao)) {
            $fkImaConfiguracaoBanparaOrgao->setFkOrganogramaOrgao($this);
            $this->fkImaConfiguracaoBanparaOrgoes->add($fkImaConfiguracaoBanparaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanparaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao
     */
    public function removeFkImaConfiguracaoBanparaOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao $fkImaConfiguracaoBanparaOrgao)
    {
        $this->fkImaConfiguracaoBanparaOrgoes->removeElement($fkImaConfiguracaoBanparaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanparaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaOrgao
     */
    public function getFkImaConfiguracaoBanparaOrgoes()
    {
        return $this->fkImaConfiguracaoBanparaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBbOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao
     * @return Orgao
     */
    public function addFkImaConfiguracaoBbOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao)
    {
        if (false === $this->fkImaConfiguracaoBbOrgoes->contains($fkImaConfiguracaoBbOrgao)) {
            $fkImaConfiguracaoBbOrgao->setFkOrganogramaOrgao($this);
            $this->fkImaConfiguracaoBbOrgoes->add($fkImaConfiguracaoBbOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao
     */
    public function removeFkImaConfiguracaoBbOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao $fkImaConfiguracaoBbOrgao)
    {
        $this->fkImaConfiguracaoBbOrgoes->removeElement($fkImaConfiguracaoBbOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbOrgao
     */
    public function getFkImaConfiguracaoBbOrgoes()
    {
        return $this->fkImaConfiguracaoBbOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBescOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao
     * @return Orgao
     */
    public function addFkImaConfiguracaoBescOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao)
    {
        if (false === $this->fkImaConfiguracaoBescOrgoes->contains($fkImaConfiguracaoBescOrgao)) {
            $fkImaConfiguracaoBescOrgao->setFkOrganogramaOrgao($this);
            $this->fkImaConfiguracaoBescOrgoes->add($fkImaConfiguracaoBescOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao
     */
    public function removeFkImaConfiguracaoBescOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao $fkImaConfiguracaoBescOrgao)
    {
        $this->fkImaConfiguracaoBescOrgoes->removeElement($fkImaConfiguracaoBescOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescOrgao
     */
    public function getFkImaConfiguracaoBescOrgoes()
    {
        return $this->fkImaConfiguracaoBescOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanrisulOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao
     * @return Orgao
     */
    public function addFkImaConfiguracaoBanrisulOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao)
    {
        if (false === $this->fkImaConfiguracaoBanrisulOrgoes->contains($fkImaConfiguracaoBanrisulOrgao)) {
            $fkImaConfiguracaoBanrisulOrgao->setFkOrganogramaOrgao($this);
            $this->fkImaConfiguracaoBanrisulOrgoes->add($fkImaConfiguracaoBanrisulOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao
     */
    public function removeFkImaConfiguracaoBanrisulOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao $fkImaConfiguracaoBanrisulOrgao)
    {
        $this->fkImaConfiguracaoBanrisulOrgoes->removeElement($fkImaConfiguracaoBanrisulOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulOrgao
     */
    public function getFkImaConfiguracaoBanrisulOrgoes()
    {
        return $this->fkImaConfiguracaoBanrisulOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao
     * @return Orgao
     */
    public function addFkImaConfiguracaoHsbcOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao)
    {
        if (false === $this->fkImaConfiguracaoHsbcOrgoes->contains($fkImaConfiguracaoHsbcOrgao)) {
            $fkImaConfiguracaoHsbcOrgao->setFkOrganogramaOrgao($this);
            $this->fkImaConfiguracaoHsbcOrgoes->add($fkImaConfiguracaoHsbcOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao
     */
    public function removeFkImaConfiguracaoHsbcOrgoes(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao $fkImaConfiguracaoHsbcOrgao)
    {
        $this->fkImaConfiguracaoHsbcOrgoes->removeElement($fkImaConfiguracaoHsbcOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcOrgao
     */
    public function getFkImaConfiguracaoHsbcOrgoes()
    {
        return $this->fkImaConfiguracaoHsbcOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     * @return Orgao
     */
    public function addFkOrganogramaDeParaOrgaoHistoricos(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        if (false === $this->fkOrganogramaDeParaOrgaoHistoricos->contains($fkOrganogramaDeParaOrgaoHistorico)) {
            $fkOrganogramaDeParaOrgaoHistorico->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaDeParaOrgaoHistoricos->add($fkOrganogramaDeParaOrgaoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     */
    public function removeFkOrganogramaDeParaOrgaoHistoricos(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        $this->fkOrganogramaDeParaOrgaoHistoricos->removeElement($fkOrganogramaDeParaOrgaoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgaoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    public function getFkOrganogramaDeParaOrgaoHistoricos()
    {
        return $this->fkOrganogramaDeParaOrgaoHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     * @return Orgao
     */
    public function addFkOrganogramaDeParaOrgaoHistoricos1(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        if (false === $this->fkOrganogramaDeParaOrgaoHistoricos1->contains($fkOrganogramaDeParaOrgaoHistorico)) {
            $fkOrganogramaDeParaOrgaoHistorico->setFkOrganogramaOrgao1($this);
            $this->fkOrganogramaDeParaOrgaoHistoricos1->add($fkOrganogramaDeParaOrgaoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     */
    public function removeFkOrganogramaDeParaOrgaoHistoricos1(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        $this->fkOrganogramaDeParaOrgaoHistoricos1->removeElement($fkOrganogramaDeParaOrgaoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgaoHistoricos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    public function getFkOrganogramaDeParaOrgaoHistoricos1()
    {
        return $this->fkOrganogramaDeParaOrgaoHistoricos1;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel
     * @return Orgao
     */
    public function addFkOrganogramaOrgaoNiveis(\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel)
    {
        if (false === $this->fkOrganogramaOrgaoNiveis->contains($fkOrganogramaOrgaoNivel)) {
            $fkOrganogramaOrgaoNivel->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaOrgaoNiveis->add($fkOrganogramaOrgaoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel
     */
    public function removeFkOrganogramaOrgaoNiveis(\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel)
    {
        $this->fkOrganogramaOrgaoNiveis->removeElement($fkOrganogramaOrgaoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgaoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel
     */
    public function getFkOrganogramaOrgaoNiveis()
    {
        return $this->fkOrganogramaOrgaoNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaSetor
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor
     * @return Orgao
     */
    public function addFkOrganogramaDeParaSetores(\Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor)
    {
        if (false === $this->fkOrganogramaDeParaSetores->contains($fkOrganogramaDeParaSetor)) {
            $fkOrganogramaDeParaSetor->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaDeParaSetores->add($fkOrganogramaDeParaSetor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaSetor
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor
     */
    public function removeFkOrganogramaDeParaSetores(\Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor)
    {
        $this->fkOrganogramaDeParaSetores->removeElement($fkOrganogramaDeParaSetor);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaSetores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaSetor
     */
    public function getFkOrganogramaDeParaSetores()
    {
        return $this->fkOrganogramaDeParaSetores;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgaoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm
     * @return Orgao
     */
    public function addFkOrganogramaOrgaoCgns(\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm)
    {
        if (false === $this->fkOrganogramaOrgaoCgns->contains($fkOrganogramaOrgaoCgm)) {
            $fkOrganogramaOrgaoCgm->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaOrgaoCgns->add($fkOrganogramaOrgaoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgaoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm
     */
    public function removeFkOrganogramaOrgaoCgns(\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm $fkOrganogramaOrgaoCgm)
    {
        $this->fkOrganogramaOrgaoCgns->removeElement($fkOrganogramaOrgaoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgaoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoCgm
     */
    public function getFkOrganogramaOrgaoCgns()
    {
        return $this->fkOrganogramaOrgaoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgaoDescricao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao $fkOrganogramaOrgaoDescricao
     * @return Orgao
     */
    public function addFkOrganogramaOrgaoDescricoes(\Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao $fkOrganogramaOrgaoDescricao)
    {
        if (false === $this->fkOrganogramaOrgaoDescricoes->contains($fkOrganogramaOrgaoDescricao)) {
            $fkOrganogramaOrgaoDescricao->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaOrgaoDescricoes->add($fkOrganogramaOrgaoDescricao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgaoDescricao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao $fkOrganogramaOrgaoDescricao
     */
    public function removeFkOrganogramaOrgaoDescricoes(\Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao $fkOrganogramaOrgaoDescricao)
    {
        $this->fkOrganogramaOrgaoDescricoes->removeElement($fkOrganogramaOrgaoDescricao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgaoDescricoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao
     */
    public function getFkOrganogramaOrgaoDescricoes()
    {
        return $this->fkOrganogramaOrgaoDescricoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao
     * @return Orgao
     */
    public function addFkPessoalContratoPensionistaOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao)
    {
        if (false === $this->fkPessoalContratoPensionistaOrgoes->contains($fkPessoalContratoPensionistaOrgao)) {
            $fkPessoalContratoPensionistaOrgao->setFkOrganogramaOrgao($this);
            $this->fkPessoalContratoPensionistaOrgoes->add($fkPessoalContratoPensionistaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao
     */
    public function removeFkPessoalContratoPensionistaOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao)
    {
        $this->fkPessoalContratoPensionistaOrgoes->removeElement($fkPessoalContratoPensionistaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao
     */
    public function getFkPessoalContratoPensionistaOrgoes()
    {
        return $this->fkPessoalContratoPensionistaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao
     * @return Orgao
     */
    public function addFkPessoalContratoServidorOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao)
    {
        if (false === $this->fkPessoalContratoServidorOrgoes->contains($fkPessoalContratoServidorOrgao)) {
            $fkPessoalContratoServidorOrgao->setFkOrganogramaOrgao($this);
            $this->fkPessoalContratoServidorOrgoes->add($fkPessoalContratoServidorOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao
     */
    public function removeFkPessoalContratoServidorOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao $fkPessoalContratoServidorOrgao)
    {
        $this->fkPessoalContratoServidorOrgoes->removeElement($fkPessoalContratoServidorOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao
     */
    public function getFkPessoalContratoServidorOrgoes()
    {
        return $this->fkPessoalContratoServidorOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaOrgaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade
     * @return Orgao
     */
    public function addFkPessoalDeParaOrgaoUnidades(\Urbem\CoreBundle\Entity\Pessoal\DeParaOrgaoUnidade $fkPessoalDeParaOrgaoUnidade)
    {
        if (false === $this->fkPessoalDeParaOrgaoUnidades->contains($fkPessoalDeParaOrgaoUnidade)) {
            $fkPessoalDeParaOrgaoUnidade->setFkOrganogramaOrgao($this);
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
     * Add PessoalLoteFeriasOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao
     * @return Orgao
     */
    public function addFkPessoalLoteFeriasOrgoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao)
    {
        if (false === $this->fkPessoalLoteFeriasOrgoes->contains($fkPessoalLoteFeriasOrgao)) {
            $fkPessoalLoteFeriasOrgao->setFkOrganogramaOrgao($this);
            $this->fkPessoalLoteFeriasOrgoes->add($fkPessoalLoteFeriasOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao
     */
    public function removeFkPessoalLoteFeriasOrgoes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao $fkPessoalLoteFeriasOrgao)
    {
        $this->fkPessoalLoteFeriasOrgoes->removeElement($fkPessoalLoteFeriasOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasOrgao
     */
    public function getFkPessoalLoteFeriasOrgoes()
    {
        return $this->fkPessoalLoteFeriasOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaLotacaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao
     * @return Orgao
     */
    public function addFkPessoalDeParaLotacaoOrgoes(\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao)
    {
        if (false === $this->fkPessoalDeParaLotacaoOrgoes->contains($fkPessoalDeParaLotacaoOrgao)) {
            $fkPessoalDeParaLotacaoOrgao->setFkOrganogramaOrgao($this);
            $this->fkPessoalDeParaLotacaoOrgoes->add($fkPessoalDeParaLotacaoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaLotacaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao
     */
    public function removeFkPessoalDeParaLotacaoOrgoes(\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao)
    {
        $this->fkPessoalDeParaLotacaoOrgoes->removeElement($fkPessoalDeParaLotacaoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaLotacaoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao
     */
    public function getFkPessoalDeParaLotacaoOrgoes()
    {
        return $this->fkPessoalDeParaLotacaoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao
     * @return Orgao
     */
    public function addFkPontoConfiguracaoLotacoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao)
    {
        if (false === $this->fkPontoConfiguracaoLotacoes->contains($fkPontoConfiguracaoLotacao)) {
            $fkPontoConfiguracaoLotacao->setFkOrganogramaOrgao($this);
            $this->fkPontoConfiguracaoLotacoes->add($fkPontoConfiguracaoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao
     */
    public function removeFkPontoConfiguracaoLotacoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao $fkPontoConfiguracaoLotacao)
    {
        $this->fkPontoConfiguracaoLotacoes->removeElement($fkPontoConfiguracaoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoLotacao
     */
    public function getFkPontoConfiguracaoLotacoes()
    {
        return $this->fkPontoConfiguracaoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return Orgao
     */
    public function addFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        if (false === $this->fkSwAndamentos->contains($fkSwAndamento)) {
            $fkSwAndamento->setFkOrganogramaOrgao($this);
            $this->fkSwAndamentos->add($fkSwAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     */
    public function removeFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        $this->fkSwAndamentos->removeElement($fkSwAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    public function getFkSwAndamentos()
    {
        return $this->fkSwAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     * @return Orgao
     */
    public function addFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        if (false === $this->fkTcepeFonteRecursoLotacoes->contains($fkTcepeFonteRecursoLotacao)) {
            $fkTcepeFonteRecursoLotacao->setFkOrganogramaOrgao($this);
            $this->fkTcepeFonteRecursoLotacoes->add($fkTcepeFonteRecursoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao
     */
    public function removeFkTcepeFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao $fkTcepeFonteRecursoLotacao)
    {
        $this->fkTcepeFonteRecursoLotacoes->removeElement($fkTcepeFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLotacao
     */
    public function getFkTcepeFonteRecursoLotacoes()
    {
        return $this->fkTcepeFonteRecursoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return Orgao
     */
    public function addFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        if (false === $this->fkEstagioEstagiarioEstagios->contains($fkEstagioEstagiarioEstagio)) {
            $fkEstagioEstagiarioEstagio->setFkOrganogramaOrgao($this);
            $this->fkEstagioEstagiarioEstagios->add($fkEstagioEstagiarioEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     */
    public function removeFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->fkEstagioEstagiarioEstagios->removeElement($fkEstagioEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagios()
    {
        return $this->fkEstagioEstagiarioEstagios;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     * @return Orgao
     */
    public function addFkOrganogramaDeParaOrgoes(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        if (false === $this->fkOrganogramaDeParaOrgoes->contains($fkOrganogramaDeParaOrgao)) {
            $fkOrganogramaDeParaOrgao->setFkOrganogramaOrgao($this);
            $this->fkOrganogramaDeParaOrgoes->add($fkOrganogramaDeParaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     */
    public function removeFkOrganogramaDeParaOrgoes(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        $this->fkOrganogramaDeParaOrgoes->removeElement($fkOrganogramaDeParaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    public function getFkOrganogramaDeParaOrgoes()
    {
        return $this->fkOrganogramaDeParaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     * @return Orgao
     */
    public function addFkOrganogramaDeParaOrgoes1(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        if (false === $this->fkOrganogramaDeParaOrgoes1->contains($fkOrganogramaDeParaOrgao)) {
            $fkOrganogramaDeParaOrgao->setFkOrganogramaOrgao1($this);
            $this->fkOrganogramaDeParaOrgoes1->add($fkOrganogramaDeParaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     */
    public function removeFkOrganogramaDeParaOrgoes1(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        $this->fkOrganogramaDeParaOrgoes1->removeElement($fkOrganogramaDeParaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgoes1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    public function getFkOrganogramaDeParaOrgoes1()
    {
        return $this->fkOrganogramaDeParaOrgoes1;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao
     * @return Orgao
     */
    public function addFkSwAndamentoPadroes(\Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao)
    {
        if (false === $this->fkSwAndamentoPadroes->contains($fkSwAndamentoPadrao)) {
            $fkSwAndamentoPadrao->setFkOrganogramaOrgao($this);
            $this->fkSwAndamentoPadroes->add($fkSwAndamentoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAndamentoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao
     */
    public function removeFkSwAndamentoPadroes(\Urbem\CoreBundle\Entity\SwAndamentoPadrao $fkSwAndamentoPadrao)
    {
        $this->fkSwAndamentoPadroes->removeElement($fkSwAndamentoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAndamentoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamentoPadrao
     */
    public function getFkSwAndamentoPadroes()
    {
        return $this->fkSwAndamentoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return Orgao
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkOrganogramaOrgao($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     * @return Orgao
     */
    public function addFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        if (false === $this->fkPatrimonioHistoricoBens->contains($fkPatrimonioHistoricoBem)) {
            $fkPatrimonioHistoricoBem->setFkOrganogramaOrgao($this);
            $this->fkPatrimonioHistoricoBens->add($fkPatrimonioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     */
    public function removeFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        $this->fkPatrimonioHistoricoBens->removeElement($fkPatrimonioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    public function getFkPatrimonioHistoricoBens()
    {
        return $this->fkPatrimonioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     * @return Orgao
     */
    public function addFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        if (false === $this->fkTcmbaFonteRecursoLotacoes->contains($fkTcmbaFonteRecursoLotacao)) {
            $fkTcmbaFonteRecursoLotacao->setFkOrganogramaOrgao($this);
            $this->fkTcmbaFonteRecursoLotacoes->add($fkTcmbaFonteRecursoLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao
     */
    public function removeFkTcmbaFonteRecursoLotacoes(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao $fkTcmbaFonteRecursoLotacao)
    {
        $this->fkTcmbaFonteRecursoLotacoes->removeElement($fkTcmbaFonteRecursoLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLotacao
     */
    public function getFkTcmbaFonteRecursoLotacoes()
    {
        return $this->fkTcmbaFonteRecursoLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Orgao
     */
    public function addFkAdministracaoUsuarios(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        if (false === $this->fkAdministracaoUsuarios->contains($fkAdministracaoUsuario)) {
            $fkAdministracaoUsuario->setFkOrganogramaOrgao($this);
            $this->fkAdministracaoUsuarios->add($fkAdministracaoUsuario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     */
    public function removeFkAdministracaoUsuarios(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->fkAdministracaoUsuarios->removeElement($fkAdministracaoUsuario);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuarios()
    {
        return $this->fkAdministracaoUsuarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Orgao
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numCgmPf = $fkSwCgmPessoaFisica->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkCalendarioCalendarioCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro
     * @return Orgao
     */
    public function setFkCalendarioCalendarioCadastro(\Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro $fkCalendarioCalendarioCadastro)
    {
        $this->codCalendar = $fkCalendarioCalendarioCadastro->getCodCalendar();
        $this->fkCalendarioCalendarioCadastro = $fkCalendarioCalendarioCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCalendarioCalendarioCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro
     */
    public function getFkCalendarioCalendarioCadastro()
    {
        return $this->fkCalendarioCalendarioCadastro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Orgao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    public function getCodigoComposto()
    {
        $orgaoNiveis = $this->getfkOrganogramaOrgaoNiveis();

        $exp = null;
        foreach ($orgaoNiveis as $orgaoNivel) {
            $mascara = strlen($orgaoNivel->getfkOrganogramaNivel()->getMascaracodigo());
            $exp[$orgaoNivel->getCodNivel()] = str_pad($orgaoNivel->getValor(), $mascara, '0', STR_PAD_LEFT);
        }
        if ($exp != null) {
            ksort($exp);
            $exp = implode('.', $exp);
        }

        return $exp;
    }

    public function getSituacao()
    {
        $inativacao = $this->getInativacao();
        $situacao = false;
        if ($inativacao == null) {
            $situacao = true;
        }
        return $situacao;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        $descricoes = $this->getFkOrganogramaOrgaoDescricoes();
        if ($descricoes->isEmpty()) {
            return "";
        }

        return $descricoes->last()->getDescricao();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->codOrgao, strtoupper($this->getDescricao()));
    }
}
