<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Arrecadacao
 */
class Arrecadacao
{
    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * @var integer
     */
    private $codAutenticacao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $dtAutenticacao;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var \DateTime
     */
    private $timestampTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var \DateTime
     */
    private $timestampUsuario;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var boolean
     */
    private $devolucao = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao
     */
    private $fkContabilidadeLancamentoBaixaPatrimonioAlienacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    private $fkTesourariaArrecadacaoCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    private $fkTesourariaArrecadacaoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao
     */
    private $fkTesourariaArrecadacaoOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    private $fkTesourariaBoletimLoteArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia
     */
    private $fkTesourariaBoletimLoteArrecadacaoInconsistencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao
     */
    private $fkTesourariaConciliacaoLancamentoArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    private $fkTesourariaArrecadacaoEstornadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    private $fkTesourariaAutenticacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacaoLancamentoArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return Arrecadacao
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Arrecadacao
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
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return Arrecadacao
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return Arrecadacao
     */
    public function setCodAutenticacao($codAutenticacao)
    {
        $this->codAutenticacao = $codAutenticacao;
        return $this;
    }

    /**
     * Get codAutenticacao
     *
     * @return integer
     */
    public function getCodAutenticacao()
    {
        return $this->codAutenticacao;
    }

    /**
     * Set dtAutenticacao
     *
     * @param DateTimeMicrosecondPK $dtAutenticacao
     * @return Arrecadacao
     */
    public function setDtAutenticacao(DateTimeMicrosecondPK $dtAutenticacao)
    {
        $this->dtAutenticacao = $dtAutenticacao;
        return $this;
    }

    /**
     * Get dtAutenticacao
     *
     * @return DateTimeMicrosecondPK
     */
    public function getDtAutenticacao()
    {
        return $this->dtAutenticacao;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Arrecadacao
     */
    public function setCodBoletim($codBoletim)
    {
        $this->codBoletim = $codBoletim;
        return $this;
    }

    /**
     * Get codBoletim
     *
     * @return integer
     */
    public function getCodBoletim()
    {
        return $this->codBoletim;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Arrecadacao
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return Arrecadacao
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return Arrecadacao
     */
    public function setCgmUsuario($cgmUsuario)
    {
        $this->cgmUsuario = $cgmUsuario;
        return $this;
    }

    /**
     * Get cgmUsuario
     *
     * @return integer
     */
    public function getCgmUsuario()
    {
        return $this->cgmUsuario;
    }

    /**
     * Set timestampUsuario
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario
     * @return Arrecadacao
     */
    public function setTimestampUsuario(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario)
    {
        $this->timestampUsuario = $timestampUsuario;
        return $this;
    }

    /**
     * Get timestampUsuario
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampUsuario()
    {
        return $this->timestampUsuario;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Arrecadacao
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Arrecadacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return Arrecadacao
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
     * Set devolucao
     *
     * @param boolean $devolucao
     * @return Arrecadacao
     */
    public function setDevolucao($devolucao)
    {
        $this->devolucao = $devolucao;
        return $this;
    }

    /**
     * Get devolucao
     *
     * @return boolean
     */
    public function getDevolucao()
    {
        return $this->devolucao;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoBaixaPatrimonioAlienacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao
     * @return Arrecadacao
     */
    public function addFkContabilidadeLancamentoBaixaPatrimonioAlienacoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoBaixaPatrimonioAlienacao $fkContabilidadeLancamentoBaixaPatrimonioAlienacao)
    {
        if (false === $this->fkContabilidadeLancamentoBaixaPatrimonioAlienacoes->contains($fkContabilidadeLancamentoBaixaPatrimonioAlienacao)) {
            $fkContabilidadeLancamentoBaixaPatrimonioAlienacao->setFkTesourariaArrecadacao($this);
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
     * Add TesourariaArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne
     * @return Arrecadacao
     */
    public function addFkTesourariaArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne)
    {
        if (false === $this->fkTesourariaArrecadacaoCarnes->contains($fkTesourariaArrecadacaoCarne)) {
            $fkTesourariaArrecadacaoCarne->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaArrecadacaoCarnes->add($fkTesourariaArrecadacaoCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne
     */
    public function removeFkTesourariaArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne)
    {
        $this->fkTesourariaArrecadacaoCarnes->removeElement($fkTesourariaArrecadacaoCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    public function getFkTesourariaArrecadacaoCarnes()
    {
        return $this->fkTesourariaArrecadacaoCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     * @return Arrecadacao
     */
    public function addFkTesourariaArrecadacaoReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitas->contains($fkTesourariaArrecadacaoReceita)) {
            $fkTesourariaArrecadacaoReceita->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaArrecadacaoReceitas->add($fkTesourariaArrecadacaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita
     */
    public function removeFkTesourariaArrecadacaoReceitas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita $fkTesourariaArrecadacaoReceita)
    {
        $this->fkTesourariaArrecadacaoReceitas->removeElement($fkTesourariaArrecadacaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita
     */
    public function getFkTesourariaArrecadacaoReceitas()
    {
        return $this->fkTesourariaArrecadacaoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao
     * @return Arrecadacao
     */
    public function addFkTesourariaArrecadacaoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->contains($fkTesourariaArrecadacaoOrdemPagamentoRetencao)) {
            $fkTesourariaArrecadacaoOrdemPagamentoRetencao->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->add($fkTesourariaArrecadacaoOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao
     */
    public function removeFkTesourariaArrecadacaoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao)
    {
        $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->removeElement($fkTesourariaArrecadacaoOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao
     */
    public function getFkTesourariaArrecadacaoOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     * @return Arrecadacao
     */
    public function addFkTesourariaBoletimLoteArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacoes->contains($fkTesourariaBoletimLoteArrecadacao)) {
            $fkTesourariaBoletimLoteArrecadacao->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaBoletimLoteArrecadacoes->add($fkTesourariaBoletimLoteArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     */
    public function removeFkTesourariaBoletimLoteArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        $this->fkTesourariaBoletimLoteArrecadacoes->removeElement($fkTesourariaBoletimLoteArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao
     */
    public function getFkTesourariaBoletimLoteArrecadacoes()
    {
        return $this->fkTesourariaBoletimLoteArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteArrecadacaoInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia
     * @return Arrecadacao
     */
    public function addFkTesourariaBoletimLoteArrecadacaoInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->contains($fkTesourariaBoletimLoteArrecadacaoInconsistencia)) {
            $fkTesourariaBoletimLoteArrecadacaoInconsistencia->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->add($fkTesourariaBoletimLoteArrecadacaoInconsistencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteArrecadacaoInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia
     */
    public function removeFkTesourariaBoletimLoteArrecadacaoInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia)
    {
        $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->removeElement($fkTesourariaBoletimLoteArrecadacaoInconsistencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteArrecadacaoInconsistencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia
     */
    public function getFkTesourariaBoletimLoteArrecadacaoInconsistencias()
    {
        return $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao
     * @return Arrecadacao
     */
    public function addFkTesourariaConciliacaoLancamentoArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoArrecadacoes->contains($fkTesourariaConciliacaoLancamentoArrecadacao)) {
            $fkTesourariaConciliacaoLancamentoArrecadacao->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaConciliacaoLancamentoArrecadacoes->add($fkTesourariaConciliacaoLancamentoArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao
     */
    public function removeFkTesourariaConciliacaoLancamentoArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao)
    {
        $this->fkTesourariaConciliacaoLancamentoArrecadacoes->removeElement($fkTesourariaConciliacaoLancamentoArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao
     */
    public function getFkTesourariaConciliacaoLancamentoArrecadacoes()
    {
        return $this->fkTesourariaConciliacaoLancamentoArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     * @return Arrecadacao
     */
    public function addFkTesourariaArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadas->contains($fkTesourariaArrecadacaoEstornada)) {
            $fkTesourariaArrecadacaoEstornada->setFkTesourariaArrecadacao($this);
            $this->fkTesourariaArrecadacaoEstornadas->add($fkTesourariaArrecadacaoEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     */
    public function removeFkTesourariaArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        $this->fkTesourariaArrecadacaoEstornadas->removeElement($fkTesourariaArrecadacaoEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    public function getFkTesourariaArrecadacaoEstornadas()
    {
        return $this->fkTesourariaArrecadacaoEstornadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return Arrecadacao
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Arrecadacao
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
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Arrecadacao
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicio = $fkTesourariaBoletim->getExercicio();
        $this->fkTesourariaBoletim = $fkTesourariaBoletim;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaBoletim
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletim()
    {
        return $this->fkTesourariaBoletim;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return Arrecadacao
     */
    public function setFkTesourariaAutenticacao(\Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao)
    {
        $this->codAutenticacao = $fkTesourariaAutenticacao->getCodAutenticacao();
        $this->dtAutenticacao = $fkTesourariaAutenticacao->getDtAutenticacao();
        $this->fkTesourariaAutenticacao = $fkTesourariaAutenticacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaAutenticacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao
     */
    public function getFkTesourariaAutenticacao()
    {
        return $this->fkTesourariaAutenticacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Arrecadacao
     */
    public function setFkTesourariaUsuarioTerminal(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        $this->codTerminal = $fkTesourariaUsuarioTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaUsuarioTerminal->getTimestampTerminal();
        $this->cgmUsuario = $fkTesourariaUsuarioTerminal->getCgmUsuario();
        $this->timestampUsuario = $fkTesourariaUsuarioTerminal->getTimestampUsuario();
        $this->fkTesourariaUsuarioTerminal = $fkTesourariaUsuarioTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaUsuarioTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminal()
    {
        return $this->fkTesourariaUsuarioTerminal;
    }

    /**
     * @return float
     */
    public function getValorArrecadado()
    {
        $arrecadacaoReceita = $this->fkTesourariaArrecadacaoReceitas->last();
        $valor = $arrecadacaoReceita->getVlArrecadacao();
        return $valor;
    }

    /**
     * @return float
     */
    public function getValorEstornado()
    {
        $valor = 0.00;
        if ($this->fkTesourariaArrecadacaoEstornadas->count()) {
            foreach ($this->fkTesourariaArrecadacaoEstornadas as $arrecadacaoEstornada) {
                $valor += $arrecadacaoEstornada->getFkTesourariaArrecadacaoEstornadaReceita()->getVlEstornado();
            }
        }
        return $valor;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codArrecadacao, $this->exercicio);
    }
}
