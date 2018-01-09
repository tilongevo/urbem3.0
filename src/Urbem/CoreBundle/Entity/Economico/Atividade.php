<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Atividade
 */
class Atividade
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $nomAtividade;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var integer
     */
    private $codVigencia;

    /**
     * @var integer
     */
    private $codNivel;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal
     */
    private $fkEconomicoAtividadeCnaeFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade
     */
    private $fkComprasFornecedorAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao
     */
    private $fkEconomicoAtividadeProfissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    private $fkEconomicoAtividadeModalidadeLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    private $fkEconomicoAtividadeCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AliquotaAtividade
     */
    private $fkEconomicoAliquotaAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    private $fkEconomicoElementoAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor
     */
    private $fkEconomicoNivelAtividadeValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon
     */
    private $fkEconomicoProcessoAtividadeCadEcons;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade
     */
    private $fkFiscalizacaoDocumentoAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    private $fkEconomicoServicoAtividades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    private $fkEconomicoNivelAtividade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasFornecedorAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeProfissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeModalidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAliquotaAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoNivelAtividadeValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoAtividadeCadEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoDocumentoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoServicoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return Atividade
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Atividade
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
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
     * Set nomAtividade
     *
     * @param string $nomAtividade
     * @return Atividade
     */
    public function setNomAtividade($nomAtividade)
    {
        $this->nomAtividade = $nomAtividade;
        return $this;
    }

    /**
     * Get nomAtividade
     *
     * @return string
     */
    public function getNomAtividade()
    {
        return $this->nomAtividade;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return Atividade
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return Atividade
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return Atividade
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade
     * @return Atividade
     */
    public function addFkComprasFornecedorAtividades(\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade)
    {
        if (false === $this->fkComprasFornecedorAtividades->contains($fkComprasFornecedorAtividade)) {
            $fkComprasFornecedorAtividade->setFkEconomicoAtividade($this);
            $this->fkComprasFornecedorAtividades->add($fkComprasFornecedorAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade
     */
    public function removeFkComprasFornecedorAtividades(\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade)
    {
        $this->fkComprasFornecedorAtividades->removeElement($fkComprasFornecedorAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade
     */
    public function getFkComprasFornecedorAtividades()
    {
        return $this->fkComprasFornecedorAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao
     * @return Atividade
     */
    public function addFkEconomicoAtividadeProfissoes(\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao)
    {
        if (false === $this->fkEconomicoAtividadeProfissoes->contains($fkEconomicoAtividadeProfissao)) {
            $fkEconomicoAtividadeProfissao->setFkEconomicoAtividade($this);
            $this->fkEconomicoAtividadeProfissoes->add($fkEconomicoAtividadeProfissao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao
     */
    public function removeFkEconomicoAtividadeProfissoes(\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao $fkEconomicoAtividadeProfissao)
    {
        $this->fkEconomicoAtividadeProfissoes->removeElement($fkEconomicoAtividadeProfissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeProfissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeProfissao
     */
    public function getFkEconomicoAtividadeProfissoes()
    {
        return $this->fkEconomicoAtividadeProfissoes;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     * @return Atividade
     */
    public function addFkEconomicoAtividadeModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeLancamentos->contains($fkEconomicoAtividadeModalidadeLancamento)) {
            $fkEconomicoAtividadeModalidadeLancamento->setFkEconomicoAtividade($this);
            $this->fkEconomicoAtividadeModalidadeLancamentos->add($fkEconomicoAtividadeModalidadeLancamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento
     */
    public function removeFkEconomicoAtividadeModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento $fkEconomicoAtividadeModalidadeLancamento)
    {
        $this->fkEconomicoAtividadeModalidadeLancamentos->removeElement($fkEconomicoAtividadeModalidadeLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeLancamento
     */
    public function getFkEconomicoAtividadeModalidadeLancamentos()
    {
        return $this->fkEconomicoAtividadeModalidadeLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     * @return Atividade
     */
    public function addFkEconomicoAtividadeCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        if (false === $this->fkEconomicoAtividadeCadastroEconomicos->contains($fkEconomicoAtividadeCadastroEconomico)) {
            $fkEconomicoAtividadeCadastroEconomico->setFkEconomicoAtividade($this);
            $this->fkEconomicoAtividadeCadastroEconomicos->add($fkEconomicoAtividadeCadastroEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     */
    public function removeFkEconomicoAtividadeCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        $this->fkEconomicoAtividadeCadastroEconomicos->removeElement($fkEconomicoAtividadeCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    public function getFkEconomicoAtividadeCadastroEconomicos()
    {
        return $this->fkEconomicoAtividadeCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAliquotaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AliquotaAtividade $fkEconomicoAliquotaAtividade
     * @return Atividade
     */
    public function addFkEconomicoAliquotaAtividades(\Urbem\CoreBundle\Entity\Economico\AliquotaAtividade $fkEconomicoAliquotaAtividade)
    {
        if (false === $this->fkEconomicoAliquotaAtividades->contains($fkEconomicoAliquotaAtividade)) {
            $fkEconomicoAliquotaAtividade->setFkEconomicoAtividade($this);
            $this->fkEconomicoAliquotaAtividades->add($fkEconomicoAliquotaAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAliquotaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AliquotaAtividade $fkEconomicoAliquotaAtividade
     */
    public function removeFkEconomicoAliquotaAtividades(\Urbem\CoreBundle\Entity\Economico\AliquotaAtividade $fkEconomicoAliquotaAtividade)
    {
        $this->fkEconomicoAliquotaAtividades->removeElement($fkEconomicoAliquotaAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAliquotaAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AliquotaAtividade
     */
    public function getFkEconomicoAliquotaAtividades()
    {
        return $this->fkEconomicoAliquotaAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade
     * @return Atividade
     */
    public function addFkEconomicoElementoAtividades(\Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade)
    {
        if (false === $this->fkEconomicoElementoAtividades->contains($fkEconomicoElementoAtividade)) {
            $fkEconomicoElementoAtividade->setFkEconomicoAtividade($this);
            $this->fkEconomicoElementoAtividades->add($fkEconomicoElementoAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade
     */
    public function removeFkEconomicoElementoAtividades(\Urbem\CoreBundle\Entity\Economico\ElementoAtividade $fkEconomicoElementoAtividade)
    {
        $this->fkEconomicoElementoAtividades->removeElement($fkEconomicoElementoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtividade
     */
    public function getFkEconomicoElementoAtividades()
    {
        return $this->fkEconomicoElementoAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoNivelAtividadeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor
     * @return Atividade
     */
    public function addFkEconomicoNivelAtividadeValores(\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor)
    {
        if (false === $this->fkEconomicoNivelAtividadeValores->contains($fkEconomicoNivelAtividadeValor)) {
            $fkEconomicoNivelAtividadeValor->setFkEconomicoAtividade($this);
            $this->fkEconomicoNivelAtividadeValores->add($fkEconomicoNivelAtividadeValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelAtividadeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor
     */
    public function removeFkEconomicoNivelAtividadeValores(\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor)
    {
        $this->fkEconomicoNivelAtividadeValores->removeElement($fkEconomicoNivelAtividadeValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelAtividadeValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor
     */
    public function getFkEconomicoNivelAtividadeValores()
    {
        return $this->fkEconomicoNivelAtividadeValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoAtividadeCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon
     * @return Atividade
     */
    public function addFkEconomicoProcessoAtividadeCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon)
    {
        if (false === $this->fkEconomicoProcessoAtividadeCadEcons->contains($fkEconomicoProcessoAtividadeCadEcon)) {
            $fkEconomicoProcessoAtividadeCadEcon->setFkEconomicoAtividade($this);
            $this->fkEconomicoProcessoAtividadeCadEcons->add($fkEconomicoProcessoAtividadeCadEcon);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoAtividadeCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon
     */
    public function removeFkEconomicoProcessoAtividadeCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon)
    {
        $this->fkEconomicoProcessoAtividadeCadEcons->removeElement($fkEconomicoProcessoAtividadeCadEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoAtividadeCadEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon
     */
    public function getFkEconomicoProcessoAtividadeCadEcons()
    {
        return $this->fkEconomicoProcessoAtividadeCadEcons;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoDocumentoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade
     * @return Atividade
     */
    public function addFkFiscalizacaoDocumentoAtividades(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade)
    {
        if (false === $this->fkFiscalizacaoDocumentoAtividades->contains($fkFiscalizacaoDocumentoAtividade)) {
            $fkFiscalizacaoDocumentoAtividade->setFkEconomicoAtividade($this);
            $this->fkFiscalizacaoDocumentoAtividades->add($fkFiscalizacaoDocumentoAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoDocumentoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade
     */
    public function removeFkFiscalizacaoDocumentoAtividades(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade)
    {
        $this->fkFiscalizacaoDocumentoAtividades->removeElement($fkFiscalizacaoDocumentoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoDocumentoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade
     */
    public function getFkFiscalizacaoDocumentoAtividades()
    {
        return $this->fkFiscalizacaoDocumentoAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoServicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade
     * @return Atividade
     */
    public function addFkEconomicoServicoAtividades(\Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade)
    {
        if (false === $this->fkEconomicoServicoAtividades->contains($fkEconomicoServicoAtividade)) {
            $fkEconomicoServicoAtividade->setFkEconomicoAtividade($this);
            $this->fkEconomicoServicoAtividades->add($fkEconomicoServicoAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoServicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade
     */
    public function removeFkEconomicoServicoAtividades(\Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade)
    {
        $this->fkEconomicoServicoAtividades->removeElement($fkEconomicoServicoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoServicoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    public function getFkEconomicoServicoAtividades()
    {
        return $this->fkEconomicoServicoAtividades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoNivelAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade
     * @return Atividade
     */
    public function setFkEconomicoNivelAtividade(\Urbem\CoreBundle\Entity\Economico\NivelAtividade $fkEconomicoNivelAtividade)
    {
        $this->codNivel = $fkEconomicoNivelAtividade->getCodNivel();
        $this->codVigencia = $fkEconomicoNivelAtividade->getCodVigencia();
        $this->fkEconomicoNivelAtividade = $fkEconomicoNivelAtividade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoNivelAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NivelAtividade
     */
    public function getFkEconomicoNivelAtividade()
    {
        return $this->fkEconomicoNivelAtividade;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoAtividadeCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal
     * @return Atividade
     */
    public function setFkEconomicoAtividadeCnaeFiscal(\Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal)
    {
        $fkEconomicoAtividadeCnaeFiscal->setFkEconomicoAtividade($this);
        $this->fkEconomicoAtividadeCnaeFiscal = $fkEconomicoAtividadeCnaeFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoAtividadeCnaeFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal
     */
    public function getFkEconomicoAtividadeCnaeFiscal()
    {
        return $this->fkEconomicoAtividadeCnaeFiscal;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) sprintf('%s - %s', $this->codEstrutural, $this->nomAtividade);
    }
}
