<?php

namespace Urbem\CoreBundle\Entity\Administracao;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Usuario
 */
class Usuario extends BaseUser
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * @var string
     */
    private $status = 'A';

    /**
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @var \DateTime
     */
    protected $credentialsExpireAt;

    /**
     * @var string
     */
    private $profilePicture;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    private $fkAlmoxarifadoAlmoxarife;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario
     */
    private $fkAdministracaoGrupoUsuarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Auditoria
     */
    private $fkAdministracaoAuditorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Comunicado
     */
    private $fkAdministracaoComunicados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    private $fkAdministracaoDepartamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Local
     */
    private $fkAdministracaoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Setor
     */
    private $fkAdministracaoSetores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    private $fkAdministracaoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    private $fkAlmoxarifadoNaturezaLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada
     */
    private $fkAlmoxarifadoRequisicaoHomologadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    private $fkArrecadacaoCompensacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    private $fkArrecadacaoNotaAvulsas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada
     */
    private $fkArrecadacaoNotaAvulsaCanceladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Permissao
     */
    private $fkArrecadacaoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    private $fkComprasSolicitacaoHomologadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao
     */
    private $fkComprasSolicitacaoHomologadaAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtivas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    private $fkDividaDividaEstornos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\CobrancaJudicial
     */
    private $fkDividaCobrancaJudiciais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    private $fkDividaDividaRemissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    private $fkDividaDividaCanceladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento
     */
    private $fkDividaEmissaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao
     */
    private $fkEmpenhoPermissaoAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    private $fkSwUltimoAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado
     */
    private $fkFiscalizacaoProcessoFiscalCancelados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    private $fkFolhapagamentoReajustes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao
     */
    private $fkFolhapagamentoReajusteExclusoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento
     */
    private $fkImobiliarioEmissaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade
     */
    private $fkOrcamentoUsuarioEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Inventario
     */
    private $fkPatrimonioInventarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao
     */
    private $fkPontoCompensacaoHorasExclusoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao
     */
    private $fkPontoConfiguracaoRelogioPontoExclusoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao
     */
    private $fkPontoEscalaContratoExclusoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssinaturaDigital
     */
    private $fkSwAssinaturaDigitais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCgas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCgas1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDespacho
     */
    private $fkSwDespachos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPermissaoAutorizacao
     */
    private $fkSwPermissaoAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Permissao
     */
    private $fkAdministracaoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora
     */
    private $fkAdministracaoUsuarioImpressoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    private $fkImobiliarioPermissoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->fkAdministracaoGrupoUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoAuditorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoComunicados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoDepartamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoModulos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoSetores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoNaturezaLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicaoHomologadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCompensacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoEmissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoNotaAvulsas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoNotaAvulsaCanceladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoHomologadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoHomologadaAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaAtivas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaEstornos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaCobrancaJudiciais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaRemissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaCanceladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaEmissaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPermissaoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwUltimoAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalCancelados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajustes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteExclusoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioEmissaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoUsuarioEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioInventarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoCompensacaoHorasExclusoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoConfiguracaoRelogioPontoExclusoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoEscalaContratoExclusoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAssinaturaDigitais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgas1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwDespachos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwPermissaoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDiariasDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoUsuarioImpressoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioPermissoes = new \Doctrine\Common\Collections\ArrayCollection();

        $this->salt = 'CGQ5wqL7VEr[<(rF,4~CZX5#';
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Usuario
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Usuario
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
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return Usuario
     */
    public function setDtCadastro(\DateTime $dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Usuario
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * Add AdministracaoGrupoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkFkAdministracaoGrupoUsuarios
     * @return Usuario
     */
    public function addFkAdministracaoGrupoUsuarios(\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkAdministracaoGrupoUsuario)
    {
        if (false === $this->fkAdministracaoGrupoUsuarios->contains($fkAdministracaoGrupoUsuario)) {
            $fkAdministracaoGrupoUsuario->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoGrupoUsuarios->add($fkAdministracaoGrupoUsuario);
        }

        return $this;
    }

    /**
     * Remove AdministracaoGrupoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkFkAdministracaoGrupoUsuarios
     */
    public function removeFkAdministracaoGrupoUsuarios(\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario $fkAdministracaoGrupoUsuario)
    {
        $this->fkAdministracaoGrupoUsuarios->removeElement($fkAdministracaoGrupoUsuario);
    }

    /**
     * Get fkAdministracaoGrupoUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\GrupoUsuario
     */
    public function getFkAdministracaoGrupoUsuarios()
    {
        return $this->fkAdministracaoGrupoUsuarios;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria
     * @return Usuario
     */
    public function addFkAdministracaoAuditorias(\Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria)
    {
        if (false === $this->fkAdministracaoAuditorias->contains($fkAdministracaoAuditoria)) {
            $fkAdministracaoAuditoria->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoAuditorias->add($fkAdministracaoAuditoria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria
     */
    public function removeFkAdministracaoAuditorias(\Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria)
    {
        $this->fkAdministracaoAuditorias->removeElement($fkAdministracaoAuditoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAuditorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Auditoria
     */
    public function getFkAdministracaoAuditorias()
    {
        return $this->fkAdministracaoAuditorias;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoComunicado
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado
     * @return Usuario
     */
    public function addFkAdministracaoComunicados(\Urbem\CoreBundle\Entity\Administracao\Comunicado $fkAdministracaoComunicado)
    {
        if (false === $this->fkAdministracaoComunicados->contains($fkAdministracaoComunicado)) {
            $fkAdministracaoComunicado->setFkAdministracaoUsuario($this);
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
     * Add AdministracaoDepartamento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento
     * @return Usuario
     */
    public function addFkAdministracaoDepartamentos(\Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento)
    {
        if (false === $this->fkAdministracaoDepartamentos->contains($fkAdministracaoDepartamento)) {
            $fkAdministracaoDepartamento->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoDepartamentos->add($fkAdministracaoDepartamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoDepartamento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento
     */
    public function removeFkAdministracaoDepartamentos(\Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento)
    {
        $this->fkAdministracaoDepartamentos->removeElement($fkAdministracaoDepartamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoDepartamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    public function getFkAdministracaoDepartamentos()
    {
        return $this->fkAdministracaoDepartamentos;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Usuario
     */
    public function addFkAdministracaoModulos(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        if (false === $this->fkAdministracaoModulos->contains($fkAdministracaoModulo)) {
            $fkAdministracaoModulo->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoModulos->add($fkAdministracaoModulo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     */
    public function removeFkAdministracaoModulos(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->fkAdministracaoModulos->removeElement($fkAdministracaoModulo);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModulos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulos()
    {
        return $this->fkAdministracaoModulos;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal
     * @return Usuario
     */
    public function addFkAdministracaoLocais(\Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal)
    {
        if (false === $this->fkAdministracaoLocais->contains($fkAdministracaoLocal)) {
            $fkAdministracaoLocal->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoLocais->add($fkAdministracaoLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal
     */
    public function removeFkAdministracaoLocais(\Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal)
    {
        $this->fkAdministracaoLocais->removeElement($fkAdministracaoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Local
     */
    public function getFkAdministracaoLocais()
    {
        return $this->fkAdministracaoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     * @return Usuario
     */
    public function addFkAdministracaoSetores(\Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor)
    {
        if (false === $this->fkAdministracaoSetores->contains($fkAdministracaoSetor)) {
            $fkAdministracaoSetor->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoSetores->add($fkAdministracaoSetor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     */
    public function removeFkAdministracaoSetores(\Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor)
    {
        $this->fkAdministracaoSetores->removeElement($fkAdministracaoSetor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoSetores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Setor
     */
    public function getFkAdministracaoSetores()
    {
        return $this->fkAdministracaoSetores;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade
     * @return Usuario
     */
    public function addFkAdministracaoUnidades(\Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade)
    {
        if (false === $this->fkAdministracaoUnidades->contains($fkAdministracaoUnidade)) {
            $fkAdministracaoUnidade->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoUnidades->add($fkAdministracaoUnidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade
     */
    public function removeFkAdministracaoUnidades(\Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade)
    {
        $this->fkAdministracaoUnidades->removeElement($fkAdministracaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    public function getFkAdministracaoUnidades()
    {
        return $this->fkAdministracaoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     * @return Usuario
     */
    public function addFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        if (false === $this->fkAlmoxarifadoNaturezaLancamentos->contains($fkAlmoxarifadoNaturezaLancamento)) {
            $fkAlmoxarifadoNaturezaLancamento->setFkAdministracaoUsuario($this);
            $this->fkAlmoxarifadoNaturezaLancamentos->add($fkAlmoxarifadoNaturezaLancamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     */
    public function removeFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        $this->fkAlmoxarifadoNaturezaLancamentos->removeElement($fkAlmoxarifadoNaturezaLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoNaturezaLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    public function getFkAlmoxarifadoNaturezaLancamentos()
    {
        return $this->fkAlmoxarifadoNaturezaLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada $fkAlmoxarifadoRequisicaoHomologada
     * @return Usuario
     */
    public function addFkAlmoxarifadoRequisicaoHomologadas(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada $fkAlmoxarifadoRequisicaoHomologada)
    {
        if (false === $this->fkAlmoxarifadoRequisicaoHomologadas->contains($fkAlmoxarifadoRequisicaoHomologada)) {
            $fkAlmoxarifadoRequisicaoHomologada->setFkAdministracaoUsuario($this);
            $this->fkAlmoxarifadoRequisicaoHomologadas->add($fkAlmoxarifadoRequisicaoHomologada);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada $fkAlmoxarifadoRequisicaoHomologada
     */
    public function removeFkAlmoxarifadoRequisicaoHomologadas(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada $fkAlmoxarifadoRequisicaoHomologada)
    {
        $this->fkAlmoxarifadoRequisicaoHomologadas->removeElement($fkAlmoxarifadoRequisicaoHomologada);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicaoHomologadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada
     */
    public function getFkAlmoxarifadoRequisicaoHomologadas()
    {
        return $this->fkAlmoxarifadoRequisicaoHomologadas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     * @return Usuario
     */
    public function addFkArrecadacaoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        if (false === $this->fkArrecadacaoCompensacoes->contains($fkArrecadacaoCompensacao)) {
            $fkArrecadacaoCompensacao->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoCompensacoes->add($fkArrecadacaoCompensacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     */
    public function removeFkArrecadacaoCompensacoes(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        $this->fkArrecadacaoCompensacoes->removeElement($fkArrecadacaoCompensacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCompensacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    public function getFkArrecadacaoCompensacoes()
    {
        return $this->fkArrecadacaoCompensacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return Usuario
     */
    public function addFkArrecadacaoDocumentoEmissoes(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        if (false === $this->fkArrecadacaoDocumentoEmissoes->contains($fkArrecadacaoDocumentoEmissao)) {
            $fkArrecadacaoDocumentoEmissao->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoDocumentoEmissoes->add($fkArrecadacaoDocumentoEmissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     */
    public function removeFkArrecadacaoDocumentoEmissoes(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        $this->fkArrecadacaoDocumentoEmissoes->removeElement($fkArrecadacaoDocumentoEmissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoEmissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    public function getFkArrecadacaoDocumentoEmissoes()
    {
        return $this->fkArrecadacaoDocumentoEmissoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     * @return Usuario
     */
    public function addFkArrecadacaoNotaAvulsas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        if (false === $this->fkArrecadacaoNotaAvulsas->contains($fkArrecadacaoNotaAvulsa)) {
            $fkArrecadacaoNotaAvulsa->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoNotaAvulsas->add($fkArrecadacaoNotaAvulsa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     */
    public function removeFkArrecadacaoNotaAvulsas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        $this->fkArrecadacaoNotaAvulsas->removeElement($fkArrecadacaoNotaAvulsa);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoNotaAvulsas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    public function getFkArrecadacaoNotaAvulsas()
    {
        return $this->fkArrecadacaoNotaAvulsas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return Usuario
     */
    public function addFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        if (false === $this->fkArrecadacaoPagamentos->contains($fkArrecadacaoPagamento)) {
            $fkArrecadacaoPagamento->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoPagamentos->add($fkArrecadacaoPagamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     */
    public function removeFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        $this->fkArrecadacaoPagamentos->removeElement($fkArrecadacaoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    public function getFkArrecadacaoPagamentos()
    {
        return $this->fkArrecadacaoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoNotaAvulsaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada
     * @return Usuario
     */
    public function addFkArrecadacaoNotaAvulsaCanceladas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada)
    {
        if (false === $this->fkArrecadacaoNotaAvulsaCanceladas->contains($fkArrecadacaoNotaAvulsaCancelada)) {
            $fkArrecadacaoNotaAvulsaCancelada->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoNotaAvulsaCanceladas->add($fkArrecadacaoNotaAvulsaCancelada);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoNotaAvulsaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada
     */
    public function removeFkArrecadacaoNotaAvulsaCanceladas(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada $fkArrecadacaoNotaAvulsaCancelada)
    {
        $this->fkArrecadacaoNotaAvulsaCanceladas->removeElement($fkArrecadacaoNotaAvulsaCancelada);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoNotaAvulsaCanceladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsaCancelada
     */
    public function getFkArrecadacaoNotaAvulsaCanceladas()
    {
        return $this->fkArrecadacaoNotaAvulsaCanceladas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao
     * @return Usuario
     */
    public function addFkArrecadacaoPermissoes(\Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao)
    {
        if (false === $this->fkArrecadacaoPermissoes->contains($fkArrecadacaoPermissao)) {
            $fkArrecadacaoPermissao->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoPermissoes->add($fkArrecadacaoPermissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao
     */
    public function removeFkArrecadacaoPermissoes(\Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao)
    {
        $this->fkArrecadacaoPermissoes->removeElement($fkArrecadacaoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Permissao
     */
    public function getFkArrecadacaoPermissoes()
    {
        return $this->fkArrecadacaoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     * @return Usuario
     */
    public function addFkComprasSolicitacaoHomologadas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        if (false === $this->fkComprasSolicitacaoHomologadas->contains($fkComprasSolicitacaoHomologada)) {
            $fkComprasSolicitacaoHomologada->setFkAdministracaoUsuario($this);
            $this->fkComprasSolicitacaoHomologadas->add($fkComprasSolicitacaoHomologada);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     */
    public function removeFkComprasSolicitacaoHomologadas(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        $this->fkComprasSolicitacaoHomologadas->removeElement($fkComprasSolicitacaoHomologada);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoHomologadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    public function getFkComprasSolicitacaoHomologadas()
    {
        return $this->fkComprasSolicitacaoHomologadas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoHomologadaAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao
     * @return Usuario
     */
    public function addFkComprasSolicitacaoHomologadaAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoHomologadaAnulacoes->contains($fkComprasSolicitacaoHomologadaAnulacao)) {
            $fkComprasSolicitacaoHomologadaAnulacao->setFkAdministracaoUsuario($this);
            $this->fkComprasSolicitacaoHomologadaAnulacoes->add($fkComprasSolicitacaoHomologadaAnulacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoHomologadaAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao
     */
    public function removeFkComprasSolicitacaoHomologadaAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao $fkComprasSolicitacaoHomologadaAnulacao)
    {
        $this->fkComprasSolicitacaoHomologadaAnulacoes->removeElement($fkComprasSolicitacaoHomologadaAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoHomologadaAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaAnulacao
     */
    public function getFkComprasSolicitacaoHomologadaAnulacoes()
    {
        return $this->fkComprasSolicitacaoHomologadaAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return Usuario
     */
    public function addFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        if (false === $this->fkComprasSolicitacoes->contains($fkComprasSolicitacao)) {
            $fkComprasSolicitacao->setFkAdministracaoUsuario($this);
            $this->fkComprasSolicitacoes->add($fkComprasSolicitacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     */
    public function removeFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->fkComprasSolicitacoes->removeElement($fkComprasSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacoes()
    {
        return $this->fkComprasSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return Usuario
     */
    public function addFkDividaDividaAtivas(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        if (false === $this->fkDividaDividaAtivas->contains($fkDividaDividaAtiva)) {
            $fkDividaDividaAtiva->setFkAdministracaoUsuario($this);
            $this->fkDividaDividaAtivas->add($fkDividaDividaAtiva);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     */
    public function removeFkDividaDividaAtivas(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->fkDividaDividaAtivas->removeElement($fkDividaDividaAtiva);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaAtivas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtivas()
    {
        return $this->fkDividaDividaAtivas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno
     * @return Usuario
     */
    public function addFkDividaDividaEstornos(\Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno)
    {
        if (false === $this->fkDividaDividaEstornos->contains($fkDividaDividaEstorno)) {
            $fkDividaDividaEstorno->setFkAdministracaoUsuario($this);
            $this->fkDividaDividaEstornos->add($fkDividaDividaEstorno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno
     */
    public function removeFkDividaDividaEstornos(\Urbem\CoreBundle\Entity\Divida\DividaEstorno $fkDividaDividaEstorno)
    {
        $this->fkDividaDividaEstornos->removeElement($fkDividaDividaEstorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaEstornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEstorno
     */
    public function getFkDividaDividaEstornos()
    {
        return $this->fkDividaDividaEstornos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaCobrancaJudicial
     *
     * @param \Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial
     * @return Usuario
     */
    public function addFkDividaCobrancaJudiciais(\Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial)
    {
        if (false === $this->fkDividaCobrancaJudiciais->contains($fkDividaCobrancaJudicial)) {
            $fkDividaCobrancaJudicial->setFkAdministracaoUsuario($this);
            $this->fkDividaCobrancaJudiciais->add($fkDividaCobrancaJudicial);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaCobrancaJudicial
     *
     * @param \Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial
     */
    public function removeFkDividaCobrancaJudiciais(\Urbem\CoreBundle\Entity\Divida\CobrancaJudicial $fkDividaCobrancaJudicial)
    {
        $this->fkDividaCobrancaJudiciais->removeElement($fkDividaCobrancaJudicial);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaCobrancaJudiciais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\CobrancaJudicial
     */
    public function getFkDividaCobrancaJudiciais()
    {
        return $this->fkDividaCobrancaJudiciais;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     * @return Usuario
     */
    public function addFkDividaDividaRemissoes(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        if (false === $this->fkDividaDividaRemissoes->contains($fkDividaDividaRemissao)) {
            $fkDividaDividaRemissao->setFkAdministracaoUsuario($this);
            $this->fkDividaDividaRemissoes->add($fkDividaDividaRemissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaRemissao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao
     */
    public function removeFkDividaDividaRemissoes(\Urbem\CoreBundle\Entity\Divida\DividaRemissao $fkDividaDividaRemissao)
    {
        $this->fkDividaDividaRemissoes->removeElement($fkDividaDividaRemissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaRemissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaRemissao
     */
    public function getFkDividaDividaRemissoes()
    {
        return $this->fkDividaDividaRemissoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada
     * @return Usuario
     */
    public function addFkDividaDividaCanceladas(\Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada)
    {
        if (false === $this->fkDividaDividaCanceladas->contains($fkDividaDividaCancelada)) {
            $fkDividaDividaCancelada->setFkAdministracaoUsuario($this);
            $this->fkDividaDividaCanceladas->add($fkDividaDividaCancelada);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaCancelada
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada
     */
    public function removeFkDividaDividaCanceladas(\Urbem\CoreBundle\Entity\Divida\DividaCancelada $fkDividaDividaCancelada)
    {
        $this->fkDividaDividaCanceladas->removeElement($fkDividaDividaCancelada);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaCanceladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaCancelada
     */
    public function getFkDividaDividaCanceladas()
    {
        return $this->fkDividaDividaCanceladas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento
     * @return Usuario
     */
    public function addFkDividaEmissaoDocumentos(\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento)
    {
        if (false === $this->fkDividaEmissaoDocumentos->contains($fkDividaEmissaoDocumento)) {
            $fkDividaEmissaoDocumento->setFkAdministracaoUsuario($this);
            $this->fkDividaEmissaoDocumentos->add($fkDividaEmissaoDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento
     */
    public function removeFkDividaEmissaoDocumentos(\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento $fkDividaEmissaoDocumento)
    {
        $this->fkDividaEmissaoDocumentos->removeElement($fkDividaEmissaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaEmissaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\EmissaoDocumento
     */
    public function getFkDividaEmissaoDocumentos()
    {
        return $this->fkDividaEmissaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPermissaoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao
     * @return Usuario
     */
    public function addFkEmpenhoPermissaoAutorizacoes(\Urbem\CoreBundle\Entity\Empenho\PermissaoAutorizacao $fkEmpenhoPermissaoAutorizacao)
    {
        if (false === $this->fkEmpenhoPermissaoAutorizacoes->contains($fkEmpenhoPermissaoAutorizacao)) {
            $fkEmpenhoPermissaoAutorizacao->setFkAdministracaoUsuario($this);
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
     * Add EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return Usuario
     */
    public function addFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        if (false === $this->fkEmpenhoPreEmpenhos->contains($fkEmpenhoPreEmpenho)) {
            $fkEmpenhoPreEmpenho->setFkAdministracaoUsuario($this);
            $this->fkEmpenhoPreEmpenhos->add($fkEmpenhoPreEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     */
    public function removeFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->fkEmpenhoPreEmpenhos->removeElement($fkEmpenhoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenhos()
    {
        return $this->fkEmpenhoPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     * @return Usuario
     */
    public function addFkSwUltimoAndamentos(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        if (false === $this->fkSwUltimoAndamentos->contains($fkSwUltimoAndamento)) {
            $fkSwUltimoAndamento->setFkAdministracaoUsuario($this);
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
     * Add FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return Usuario
     */
    public function addFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscais->contains($fkFiscalizacaoProcessoFiscal)) {
            $fkFiscalizacaoProcessoFiscal->setFkAdministracaoUsuario($this);
            $this->fkFiscalizacaoProcessoFiscais->add($fkFiscalizacaoProcessoFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     */
    public function removeFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->fkFiscalizacaoProcessoFiscais->removeElement($fkFiscalizacaoProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscais()
    {
        return $this->fkFiscalizacaoProcessoFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado
     * @return Usuario
     */
    public function addFkFiscalizacaoProcessoFiscalCancelados(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalCancelados->contains($fkFiscalizacaoProcessoFiscalCancelado)) {
            $fkFiscalizacaoProcessoFiscalCancelado->setFkAdministracaoUsuario($this);
            $this->fkFiscalizacaoProcessoFiscalCancelados->add($fkFiscalizacaoProcessoFiscalCancelado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado
     */
    public function removeFkFiscalizacaoProcessoFiscalCancelados(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado $fkFiscalizacaoProcessoFiscalCancelado)
    {
        $this->fkFiscalizacaoProcessoFiscalCancelados->removeElement($fkFiscalizacaoProcessoFiscalCancelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalCancelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCancelado
     */
    public function getFkFiscalizacaoProcessoFiscalCancelados()
    {
        return $this->fkFiscalizacaoProcessoFiscalCancelados;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajuste
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste
     * @return Usuario
     */
    public function addFkFolhapagamentoReajustes(\Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste)
    {
        if (false === $this->fkFolhapagamentoReajustes->contains($fkFolhapagamentoReajuste)) {
            $fkFolhapagamentoReajuste->setFkAdministracaoUsuario($this);
            $this->fkFolhapagamentoReajustes->add($fkFolhapagamentoReajuste);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajuste
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste
     */
    public function removeFkFolhapagamentoReajustes(\Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste)
    {
        $this->fkFolhapagamentoReajustes->removeElement($fkFolhapagamentoReajuste);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajustes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    public function getFkFolhapagamentoReajustes()
    {
        return $this->fkFolhapagamentoReajustes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao
     * @return Usuario
     */
    public function addFkFolhapagamentoReajusteExclusoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao)
    {
        if (false === $this->fkFolhapagamentoReajusteExclusoes->contains($fkFolhapagamentoReajusteExclusao)) {
            $fkFolhapagamentoReajusteExclusao->setFkAdministracaoUsuario($this);
            $this->fkFolhapagamentoReajusteExclusoes->add($fkFolhapagamentoReajusteExclusao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao
     */
    public function removeFkFolhapagamentoReajusteExclusoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao)
    {
        $this->fkFolhapagamentoReajusteExclusoes->removeElement($fkFolhapagamentoReajusteExclusao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteExclusoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao
     */
    public function getFkFolhapagamentoReajusteExclusoes()
    {
        return $this->fkFolhapagamentoReajusteExclusoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento
     * @return Usuario
     */
    public function addFkImobiliarioEmissaoDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento)
    {
        if (false === $this->fkImobiliarioEmissaoDocumentos->contains($fkImobiliarioEmissaoDocumento)) {
            $fkImobiliarioEmissaoDocumento->setFkAdministracaoUsuario($this);
            $this->fkImobiliarioEmissaoDocumentos->add($fkImobiliarioEmissaoDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento
     */
    public function removeFkImobiliarioEmissaoDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento $fkImobiliarioEmissaoDocumento)
    {
        $this->fkImobiliarioEmissaoDocumentos->removeElement($fkImobiliarioEmissaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioEmissaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento
     */
    public function getFkImobiliarioEmissaoDocumentos()
    {
        return $this->fkImobiliarioEmissaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoUsuarioEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade
     * @return Usuario
     */
    public function addFkOrcamentoUsuarioEntidades(\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade)
    {
        if (false === $this->fkOrcamentoUsuarioEntidades->contains($fkOrcamentoUsuarioEntidade)) {
            $fkOrcamentoUsuarioEntidade->setFkAdministracaoUsuario($this);
            $this->fkOrcamentoUsuarioEntidades->add($fkOrcamentoUsuarioEntidade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoUsuarioEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade
     */
    public function removeFkOrcamentoUsuarioEntidades(\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade $fkOrcamentoUsuarioEntidade)
    {
        $this->fkOrcamentoUsuarioEntidades->removeElement($fkOrcamentoUsuarioEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoUsuarioEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade
     */
    public function getFkOrcamentoUsuarioEntidades()
    {
        return $this->fkOrcamentoUsuarioEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventario
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario
     * @return Usuario
     */
    public function addFkPatrimonioInventarios(\Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario)
    {
        if (false === $this->fkPatrimonioInventarios->contains($fkPatrimonioInventario)) {
            $fkPatrimonioInventario->setFkAdministracaoUsuario($this);
            $this->fkPatrimonioInventarios->add($fkPatrimonioInventario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventario
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario
     */
    public function removeFkPatrimonioInventarios(\Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario)
    {
        $this->fkPatrimonioInventarios->removeElement($fkPatrimonioInventario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Inventario
     */
    public function getFkPatrimonioInventarios()
    {
        return $this->fkPatrimonioInventarios;
    }

    /**
     * OneToMany (owning side)
     * Add PontoCompensacaoHorasExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao
     * @return Usuario
     */
    public function addFkPontoCompensacaoHorasExclusoes(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao)
    {
        if (false === $this->fkPontoCompensacaoHorasExclusoes->contains($fkPontoCompensacaoHorasExclusao)) {
            $fkPontoCompensacaoHorasExclusao->setFkAdministracaoUsuario($this);
            $this->fkPontoCompensacaoHorasExclusoes->add($fkPontoCompensacaoHorasExclusao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoCompensacaoHorasExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao
     */
    public function removeFkPontoCompensacaoHorasExclusoes(\Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao $fkPontoCompensacaoHorasExclusao)
    {
        $this->fkPontoCompensacaoHorasExclusoes->removeElement($fkPontoCompensacaoHorasExclusao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoCompensacaoHorasExclusoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CompensacaoHorasExclusao
     */
    public function getFkPontoCompensacaoHorasExclusoes()
    {
        return $this->fkPontoCompensacaoHorasExclusoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoRelogioPontoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao
     * @return Usuario
     */
    public function addFkPontoConfiguracaoRelogioPontoExclusoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao)
    {
        if (false === $this->fkPontoConfiguracaoRelogioPontoExclusoes->contains($fkPontoConfiguracaoRelogioPontoExclusao)) {
            $fkPontoConfiguracaoRelogioPontoExclusao->setFkAdministracaoUsuario($this);
            $this->fkPontoConfiguracaoRelogioPontoExclusoes->add($fkPontoConfiguracaoRelogioPontoExclusao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoRelogioPontoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao
     */
    public function removeFkPontoConfiguracaoRelogioPontoExclusoes(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao)
    {
        $this->fkPontoConfiguracaoRelogioPontoExclusoes->removeElement($fkPontoConfiguracaoRelogioPontoExclusao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoRelogioPontoExclusoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao
     */
    public function getFkPontoConfiguracaoRelogioPontoExclusoes()
    {
        return $this->fkPontoConfiguracaoRelogioPontoExclusoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoEscalaContratoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao
     * @return Usuario
     */
    public function addFkPontoEscalaContratoExclusoes(\Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao)
    {
        if (false === $this->fkPontoEscalaContratoExclusoes->contains($fkPontoEscalaContratoExclusao)) {
            $fkPontoEscalaContratoExclusao->setFkAdministracaoUsuario($this);
            $this->fkPontoEscalaContratoExclusoes->add($fkPontoEscalaContratoExclusao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoEscalaContratoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao
     */
    public function removeFkPontoEscalaContratoExclusoes(\Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao)
    {
        $this->fkPontoEscalaContratoExclusoes->removeElement($fkPontoEscalaContratoExclusao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoEscalaContratoExclusoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao
     */
    public function getFkPontoEscalaContratoExclusoes()
    {
        return $this->fkPontoEscalaContratoExclusoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return Usuario
     */
    public function addFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        if (false === $this->fkSwAndamentos->contains($fkSwAndamento)) {
            $fkSwAndamento->setFkAdministracaoUsuario($this);
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
     * Add SwAssinaturaDigital
     *
     * @param \Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital
     * @return Usuario
     */
    public function addFkSwAssinaturaDigitais(\Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital)
    {
        if (false === $this->fkSwAssinaturaDigitais->contains($fkSwAssinaturaDigital)) {
            $fkSwAssinaturaDigital->setFkAdministracaoUsuario($this);
            $this->fkSwAssinaturaDigitais->add($fkSwAssinaturaDigital);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssinaturaDigital
     *
     * @param \Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital
     */
    public function removeFkSwAssinaturaDigitais(\Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital)
    {
        $this->fkSwAssinaturaDigitais->removeElement($fkSwAssinaturaDigital);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssinaturaDigitais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssinaturaDigital
     */
    public function getFkSwAssinaturaDigitais()
    {
        return $this->fkSwAssinaturaDigitais;
    }

    /**
     * OneToMany (owning side)
     * Add SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return Usuario
     */
    public function addFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        if (false === $this->fkSwCgas->contains($fkSwCga)) {
            $fkSwCga->setFkAdministracaoUsuario($this);
            $this->fkSwCgas->add($fkSwCga);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     */
    public function removeFkSwCgas(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->fkSwCgas->removeElement($fkSwCga);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCgas()
    {
        return $this->fkSwCgas;
    }

    /**
     * OneToMany (owning side)
     * Add SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return Usuario
     */
    public function addFkSwCgas1(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        if (false === $this->fkSwCgas1->contains($fkSwCga)) {
            $fkSwCga->setFkAdministracaoUsuario1($this);
            $this->fkSwCgas1->add($fkSwCga);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     */
    public function removeFkSwCgas1(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->fkSwCgas1->removeElement($fkSwCga);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgas1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCgas1()
    {
        return $this->fkSwCgas1;
    }

    /**
     * OneToMany (owning side)
     * Add SwDespacho
     *
     * @param \Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho
     * @return Usuario
     */
    public function addFkSwDespachos(\Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho)
    {
        if (false === $this->fkSwDespachos->contains($fkSwDespacho)) {
            $fkSwDespacho->setFkAdministracaoUsuario($this);
            $this->fkSwDespachos->add($fkSwDespacho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDespacho
     *
     * @param \Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho
     */
    public function removeFkSwDespachos(\Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho)
    {
        $this->fkSwDespachos->removeElement($fkSwDespacho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDespachos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDespacho
     */
    public function getFkSwDespachos()
    {
        return $this->fkSwDespachos;
    }

    /**
     * OneToMany (owning side)
     * Add SwPermissaoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPermissaoAutorizacao $fkSwPermissaoAutorizacao
     * @return Usuario
     */
    public function addFkSwPermissaoAutorizacoes(\Urbem\CoreBundle\Entity\SwPermissaoAutorizacao $fkSwPermissaoAutorizacao)
    {
        if (false === $this->fkSwPermissaoAutorizacoes->contains($fkSwPermissaoAutorizacao)) {
            $fkSwPermissaoAutorizacao->setFkAdministracaoUsuario($this);
            $this->fkSwPermissaoAutorizacoes->add($fkSwPermissaoAutorizacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPermissaoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPermissaoAutorizacao $fkSwPermissaoAutorizacao
     */
    public function removeFkSwPermissaoAutorizacoes(\Urbem\CoreBundle\Entity\SwPermissaoAutorizacao $fkSwPermissaoAutorizacao)
    {
        $this->fkSwPermissaoAutorizacoes->removeElement($fkSwPermissaoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPermissaoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPermissaoAutorizacao
     */
    public function getFkSwPermissaoAutorizacoes()
    {
        return $this->fkSwPermissaoAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return Usuario
     */
    public function addFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        if (false === $this->fkSwPreEmpenhos->contains($fkSwPreEmpenho)) {
            $fkSwPreEmpenho->setFkAdministracaoUsuario($this);
            $this->fkSwPreEmpenhos->add($fkSwPreEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     */
    public function removeFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->fkSwPreEmpenhos->removeElement($fkSwPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenhos()
    {
        return $this->fkSwPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao
     * @return Usuario
     */
    public function addFkAdministracaoPermissoes(\Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao)
    {
        if (false === $this->fkAdministracaoPermissoes->contains($fkAdministracaoPermissao)) {
            $fkAdministracaoPermissao->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoPermissoes->add($fkAdministracaoPermissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao
     */
    public function removeFkAdministracaoPermissoes(\Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao)
    {
        $this->fkAdministracaoPermissoes->removeElement($fkAdministracaoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Permissao
     */
    public function getFkAdministracaoPermissoes()
    {
        return $this->fkAdministracaoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return Usuario
     */
    public function addFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        if (false === $this->fkSwProcessos->contains($fkSwProcesso)) {
            $fkSwProcesso->setFkAdministracaoUsuario($this);
            $this->fkSwProcessos->add($fkSwProcesso);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     */
    public function removeFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->fkSwProcessos->removeElement($fkSwProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcessos()
    {
        return $this->fkSwProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return Usuario
     */
    public function addFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        if (false === $this->fkDiariasDiarias->contains($fkDiariasDiaria)) {
            $fkDiariasDiaria->setFkAdministracaoUsuario($this);
            $this->fkDiariasDiarias->add($fkDiariasDiaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     */
    public function removeFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->fkDiariasDiarias->removeElement($fkDiariasDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiarias()
    {
        return $this->fkDiariasDiarias;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return Usuario
     */
    public function addFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        if (false === $this->fkAlmoxarifadoRequisicoes->contains($fkAlmoxarifadoRequisicao)) {
            $fkAlmoxarifadoRequisicao->setFkAdministracaoUsuario($this);
            $this->fkAlmoxarifadoRequisicoes->add($fkAlmoxarifadoRequisicao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     */
    public function removeFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->fkAlmoxarifadoRequisicoes->removeElement($fkAlmoxarifadoRequisicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicoes()
    {
        return $this->fkAlmoxarifadoRequisicoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return Usuario
     */
    public function addFkArrecadacaoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        if (false === $this->fkArrecadacaoLotes->contains($fkArrecadacaoLote)) {
            $fkArrecadacaoLote->setFkAdministracaoUsuario($this);
            $this->fkArrecadacaoLotes->add($fkArrecadacaoLote);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     */
    public function removeFkArrecadacaoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->fkArrecadacaoLotes->removeElement($fkArrecadacaoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLotes()
    {
        return $this->fkArrecadacaoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoUsuarioImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora
     * @return Usuario
     */
    public function addFkAdministracaoUsuarioImpressoras(\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora)
    {
        if (false === $this->fkAdministracaoUsuarioImpressoras->contains($fkAdministracaoUsuarioImpressora)) {
            $fkAdministracaoUsuarioImpressora->setFkAdministracaoUsuario($this);
            $this->fkAdministracaoUsuarioImpressoras->add($fkAdministracaoUsuarioImpressora);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUsuarioImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora
     */
    public function removeFkAdministracaoUsuarioImpressoras(\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora)
    {
        $this->fkAdministracaoUsuarioImpressoras->removeElement($fkAdministracaoUsuarioImpressora);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUsuarioImpressoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora
     */
    public function getFkAdministracaoUsuarioImpressoras()
    {
        return $this->fkAdministracaoUsuarioImpressoras;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return Usuario
     */
    public function addFkDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        if (false === $this->fkDividaParcelamentos->contains($fkDividaParcelamento)) {
            $fkDividaParcelamento->setFkAdministracaoUsuario($this);
            $this->fkDividaParcelamentos->add($fkDividaParcelamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     */
    public function removeFkDividaParcelamentos(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->fkDividaParcelamentos->removeElement($fkDividaParcelamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamentos()
    {
        return $this->fkDividaParcelamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao
     * @return Usuario
     */
    public function addFkImobiliarioPermissoes(\Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao)
    {
        if (false === $this->fkImobiliarioPermissoes->contains($fkImobiliarioPermissao)) {
            $fkImobiliarioPermissao->setFkAdministracaoUsuario($this);
            $this->fkImobiliarioPermissoes->add($fkImobiliarioPermissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao
     */
    public function removeFkImobiliarioPermissoes(\Urbem\CoreBundle\Entity\Imobiliario\Permissao $fkImobiliarioPermissao)
    {
        $this->fkImobiliarioPermissoes->removeElement($fkImobiliarioPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Permissao
     */
    public function getFkImobiliarioPermissoes()
    {
        return $this->fkImobiliarioPermissoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return Usuario
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoAlmoxarife
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife
     * @return Usuario
     */
    public function setFkAlmoxarifadoAlmoxarife(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife)
    {
        $fkAlmoxarifadoAlmoxarife->setFkAdministracaoUsuario($this);
        $this->fkAlmoxarifadoAlmoxarife = $fkAlmoxarifadoAlmoxarife;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarife
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    public function getFkAlmoxarifadoAlmoxarife()
    {
        return $this->fkAlmoxarifadoAlmoxarife;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Usuario
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generateID(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->id = (new \Doctrine\ORM\Id\SequenceGenerator('administracao.usuario_id_seq', 1))->generate($args->getObjectManager(), $this);
        $this->numcgm = $this->id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkSwCgm();
    }
}
