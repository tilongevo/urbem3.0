<?php

namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Solicitacao
 */
class Solicitacao
{
    const STATUS_PENDENTE_ANALISE_PROPOSTA = 0;
    const STATUS_REPROVADO_ANALISE_PROPOSTA = 1;
    const STATUS_APROVADO_ANALISE_PROPOSTA = 2;
    const STATUS_PENDENTE_CUSTO_SOLICITACAO = 3;
    const STATUS_REPROVADO_CUSTO_SOLICITACAO = 4;
    const STATUS_APROVADO_CUSTO_SOLICITACAO = 5;
    const STATUS_PENDENTE_DOTACAO_ORCAMENTARIA = 6;
    const STATUS_REPROVADO_DOTACAO_ORCAMENTARIA = 7;
    const STATUS_APROVADO_DOTACAO_ORCAMENTARIA = 8;
    const STATUS_APROVADO = 9;

    const STATUS_LIST = [
        self::STATUS_PENDENTE_ANALISE_PROPOSTA => 'Proposta Pendente',
        self::STATUS_REPROVADO_ANALISE_PROPOSTA => 'Proposta Reprovada',
        self::STATUS_APROVADO_ANALISE_PROPOSTA => 'Proposta Aprovada',
        self::STATUS_PENDENTE_CUSTO_SOLICITACAO => 'Custo Pendente',
        self::STATUS_REPROVADO_CUSTO_SOLICITACAO => 'Custo Reprovado',
        self::STATUS_APROVADO_CUSTO_SOLICITACAO => 'Custo Aprovado',
        self::STATUS_PENDENTE_DOTACAO_ORCAMENTARIA => 'Dotação Pendente',
        self::STATUS_REPROVADO_DOTACAO_ORCAMENTARIA => 'Dotação Reprovada',
        self::STATUS_APROVADO_DOTACAO_ORCAMENTARIA => 'Dotação Aprovada',
        self::STATUS_APROVADO => 'Aprovado',
    ];

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
    private $codSolicitacao;

    /**
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * @var integer
     */
    private $cgmSolicitante;

    /**
     * @var integer
     */
    private $cgmRequisitante;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $prazoEntrega;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $registroPrecos = false;

    /**
     * @var integer
     */
    private $status = 0;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    private $fkComprasSolicitacaoHomologada;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega
     */
    private $fkComprasSolicitacaoEntrega;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio
     */
    private $fkComprasSolicitacaoConvenio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao
     */
    private $fkComprasSolicitacaoAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    private $codSolicitacaoExercicio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasSolicitacaoAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Solicitacao
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
     * @return Solicitacao
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return Solicitacao
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return Solicitacao
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set cgmSolicitante
     *
     * @param integer $cgmSolicitante
     * @return Solicitacao
     */
    public function setCgmSolicitante($cgmSolicitante)
    {
        $this->cgmSolicitante = $cgmSolicitante;
        return $this;
    }

    /**
     * Get cgmSolicitante
     *
     * @return integer
     */
    public function getCgmSolicitante()
    {
        return $this->cgmSolicitante;
    }

    /**
     * Set cgmRequisitante
     *
     * @param integer $cgmRequisitante
     * @return Solicitacao
     */
    public function setCgmRequisitante($cgmRequisitante)
    {
        $this->cgmRequisitante = $cgmRequisitante;
        return $this;
    }

    /**
     * Get cgmRequisitante
     *
     * @return integer
     */
    public function getCgmRequisitante()
    {
        return $this->cgmRequisitante;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Solicitacao
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Solicitacao
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set prazoEntrega
     *
     * @param integer $prazoEntrega
     * @return Solicitacao
     */
    public function setPrazoEntrega($prazoEntrega = null)
    {
        $this->prazoEntrega = $prazoEntrega;
        return $this;
    }

    /**
     * Get prazoEntrega
     *
     * @return integer
     */
    public function getPrazoEntrega()
    {
        return $this->prazoEntrega;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Solicitacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set registroPrecos
     *
     * @param boolean $registroPrecos
     * @return Solicitacao
     */
    public function setRegistroPrecos($registroPrecos)
    {
        $this->registroPrecos = $registroPrecos;
        return $this;
    }

    /**
     * Get registroPrecos
     *
     * @return boolean
     */
    public function getRegistroPrecos()
    {
        return $this->registroPrecos;
    }

    /**
     * Set Status
     *
     * @param integer $status
     * @return Solicitacao
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this->status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao
     * @return Solicitacao
     */
    public function addFkComprasSolicitacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoAnulacoes->contains($fkComprasSolicitacaoAnulacao)) {
            $fkComprasSolicitacaoAnulacao->setFkComprasSolicitacao($this);
            $this->fkComprasSolicitacaoAnulacoes->add($fkComprasSolicitacaoAnulacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao
     */
    public function removeFkComprasSolicitacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao)
    {
        $this->fkComprasSolicitacaoAnulacoes->removeElement($fkComprasSolicitacaoAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao
     */
    public function getFkComprasSolicitacaoAnulacoes()
    {
        return $this->fkComprasSolicitacaoAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return Solicitacao
     */
    public function addFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        if (false === $this->fkComprasSolicitacaoItens->contains($fkComprasSolicitacaoItem)) {
            $fkComprasSolicitacaoItem->setFkComprasSolicitacao($this);
            $this->fkComprasSolicitacaoItens->add($fkComprasSolicitacaoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     */
    public function removeFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->fkComprasSolicitacaoItens->removeElement($fkComprasSolicitacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItens()
    {
        return $this->fkComprasSolicitacaoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Solicitacao
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
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return Solicitacao
     */
    public function setFkAlmoxarifadoAlmoxarifado(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoAlmoxarifado->getCodAlmoxarifado();
        $this->fkAlmoxarifadoAlmoxarifado = $fkAlmoxarifadoAlmoxarifado;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado()
    {
        return $this->fkAlmoxarifadoAlmoxarifado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Solicitacao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmSolicitante = $fkSwCgm->getNumcgm();
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
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Solicitacao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->cgmRequisitante = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return Solicitacao
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     * @return Solicitacao
     */
    public function setFkComprasSolicitacaoHomologada(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        $fkComprasSolicitacaoHomologada->setFkComprasSolicitacao($this);
        $this->fkComprasSolicitacaoHomologada = $fkComprasSolicitacaoHomologada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasSolicitacaoHomologada
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    public function getFkComprasSolicitacaoHomologada()
    {
        return $this->fkComprasSolicitacaoHomologada;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasSolicitacaoEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega
     * @return Solicitacao
     */
    public function setFkComprasSolicitacaoEntrega(\Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega $fkComprasSolicitacaoEntrega)
    {
        $fkComprasSolicitacaoEntrega->setFkComprasSolicitacao($this);
        $this->fkComprasSolicitacaoEntrega = $fkComprasSolicitacaoEntrega;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasSolicitacaoEntrega
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoEntrega
     */
    public function getFkComprasSolicitacaoEntrega()
    {
        return $this->fkComprasSolicitacaoEntrega;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasSolicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio
     * @return Solicitacao
     */
    public function setFkComprasSolicitacaoConvenio(\Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio $fkComprasSolicitacaoConvenio)
    {
        $fkComprasSolicitacaoConvenio->setFkComprasSolicitacao($this);
        $this->fkComprasSolicitacaoConvenio = $fkComprasSolicitacaoConvenio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasSolicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoConvenio
     */
    public function getFkComprasSolicitacaoConvenio()
    {
        return $this->fkComprasSolicitacaoConvenio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s - %s', $this->codSolicitacao, $this->codEntidade, $this->exercicio);
    }

    /**
     * @return string
     */
    public function getCodSolicitacaoExercicio()
    {
        return sprintf('%s/%s', $this->codSolicitacao, $this->exercicio);
    }
}
