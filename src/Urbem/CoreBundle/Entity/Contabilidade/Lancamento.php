<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Lancamento
 */
class Lancamento
{
    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo;

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
     * @var integer
     */
    private $codHistorico;

    /**
     * @var string
     */
    private $complemento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao
     */
    private $fkContabilidadeLancamentoRetencao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    private $fkContabilidadeLancamentoEmpenho;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio
     */
    private $fkContabilidadeLancamentoBaixaPatrimonios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao
     */
    private $fkContabilidadeLancamentoBaixaPatrimonioAlienacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao
     */
    private $fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao
     */
    private $fkContabilidadeLancamentoDepreciacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita
     */
    private $fkContabilidadeLancamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    private $fkContabilidadeValorLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    private $fkContabilidadeLancamentoTransferencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    private $fkContabilidadeLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil
     */
    private $fkContabilidadeHistoricoContabil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeValorLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Lancamento
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Lancamento
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Lancamento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Lancamento
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
     * @return Lancamento
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
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return Lancamento
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return Lancamento
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonios(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonios->contains($fkContabilidadeLancamentoBaixaPatrimonio)) {
            $fkContabilidadeLancamentoBaixaPatrimonio->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonios->add($fkContabilidadeLancamentoBaixaPatrimonio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonio
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonios(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio $fkContabilidadeLancamentoBaixaPatrimonio)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonios->removeElement($fkContabilidadeLancamentoBaixaPatrimonio);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonio
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonios()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonios;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonioAlienacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonioAlienacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->contains($fkContabilidadeLancamentoBaixaPatrimonioAlienacao)) {
            $fkContabilidadeLancamentoBaixaPatrimonioAlienacao->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->add($fkContabilidadeLancamentoBaixaPatrimonioAlienacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonioAlienacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonioAlienacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->removeElement($fkContabilidadeLancamentoBaixaPatrimonioAlienacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonioAlienacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonioAlienacoes()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->contains($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)) {
            $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->add($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoBaixaPatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao
     */
    public function removeFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao $fkContabilidadeLancamentoBaixaPatrimonioDepreciacao)
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes->removeElement($fkContabilidadeLancamentoBaixaPatrimonioDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioDepreciacao
     */
    public function getFkContabilidadeLancamentoBaixaPatrimonioDepreciacoes()
    {
        return $this->fkContabilidadeLancamentoBaixaPatrimonioDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao)
    {
        if (false === $this->fkContabilidadeLancamentoDepreciacoes->contains($fkContabilidadeLancamentoDepreciacao)) {
            $fkContabilidadeLancamentoDepreciacao->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoDepreciacoes->add($fkContabilidadeLancamentoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao
     */
    public function removeFkContabilidadeLancamentoDepreciacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao $fkContabilidadeLancamentoDepreciacao)
    {
        $this->fkContabilidadeLancamentoDepreciacoes->removeElement($fkContabilidadeLancamentoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao
     */
    public function getFkContabilidadeLancamentoDepreciacoes()
    {
        return $this->fkContabilidadeLancamentoDepreciacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita)
    {
        if (false === $this->fkContabilidadeLancamentoReceitas->contains($fkContabilidadeLancamentoReceita)) {
            $fkContabilidadeLancamentoReceita->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoReceitas->add($fkContabilidadeLancamentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita
     */
    public function removeFkContabilidadeLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita $fkContabilidadeLancamentoReceita)
    {
        $this->fkContabilidadeLancamentoReceitas->removeElement($fkContabilidadeLancamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita
     */
    public function getFkContabilidadeLancamentoReceitas()
    {
        return $this->fkContabilidadeLancamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento
     * @return Lancamento
     */
    public function addFkContabilidadeValorLancamentos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento)
    {
        if (false === $this->fkContabilidadeValorLancamentos->contains($fkContabilidadeValorLancamento)) {
            $fkContabilidadeValorLancamento->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeValorLancamentos->add($fkContabilidadeValorLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento
     */
    public function removeFkContabilidadeValorLancamentos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento)
    {
        $this->fkContabilidadeValorLancamentos->removeElement($fkContabilidadeValorLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeValorLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    public function getFkContabilidadeValorLancamentos()
    {
        return $this->fkContabilidadeValorLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     * @return Lancamento
     */
    public function addFkContabilidadeLancamentoTransferencias(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia)
    {
        if (false === $this->fkContabilidadeLancamentoTransferencias->contains($fkContabilidadeLancamentoTransferencia)) {
            $fkContabilidadeLancamentoTransferencia->setFkContabilidadeLancamento($this);
            $this->fkContabilidadeLancamentoTransferencias->add($fkContabilidadeLancamentoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     */
    public function removeFkContabilidadeLancamentoTransferencias(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia)
    {
        $this->fkContabilidadeLancamentoTransferencias->removeElement($fkContabilidadeLancamentoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    public function getFkContabilidadeLancamentoTransferencias()
    {
        return $this->fkContabilidadeLancamentoTransferencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return Lancamento
     */
    public function setFkContabilidadeLote(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        $this->codLote = $fkContabilidadeLote->getCodLote();
        $this->exercicio = $fkContabilidadeLote->getExercicio();
        $this->tipo = $fkContabilidadeLote->getTipo();
        $this->codEntidade = $fkContabilidadeLote->getCodEntidade();
        $this->fkContabilidadeLote = $fkContabilidadeLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLote
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    public function getFkContabilidadeLote()
    {
        return $this->fkContabilidadeLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeHistoricoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil $fkContabilidadeHistoricoContabil
     * @return Lancamento
     */
    public function setFkContabilidadeHistoricoContabil(\Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil $fkContabilidadeHistoricoContabil)
    {
        $this->codHistorico = $fkContabilidadeHistoricoContabil->getCodHistorico();
        $this->exercicio = $fkContabilidadeHistoricoContabil->getExercicio();
        $this->fkContabilidadeHistoricoContabil = $fkContabilidadeHistoricoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeHistoricoContabil
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil
     */
    public function getFkContabilidadeHistoricoContabil()
    {
        return $this->fkContabilidadeHistoricoContabil;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeLancamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao
     * @return Lancamento
     */
    public function setFkContabilidadeLancamentoRetencao(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao)
    {
        $fkContabilidadeLancamentoRetencao->setFkContabilidadeLancamento($this);
        $this->fkContabilidadeLancamentoRetencao = $fkContabilidadeLancamentoRetencao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeLancamentoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao
     */
    public function getFkContabilidadeLancamentoRetencao()
    {
        return $this->fkContabilidadeLancamentoRetencao;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeLancamentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho
     * @return Lancamento
     */
    public function setFkContabilidadeLancamentoEmpenho(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho)
    {
        $fkContabilidadeLancamentoEmpenho->setFkContabilidadeLancamento($this);
        $this->fkContabilidadeLancamentoEmpenho = $fkContabilidadeLancamentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeLancamentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    public function getFkContabilidadeLancamentoEmpenho()
    {
        return $this->fkContabilidadeLancamentoEmpenho;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->sequencia, $this->exercicio);
    }
}
