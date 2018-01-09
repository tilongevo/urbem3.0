<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * ArrecadacaoEstornada
 */
class ArrecadacaoEstornada
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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEstornada;

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
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita
     */
    private $fkTesourariaArrecadacaoEstornadaReceita;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    private $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada
     */
    private $fkTesourariaArrecadacaoReceitaDedutoraEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada
     */
    private $fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

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
        $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * Set timestampEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada
     * @return ArrecadacaoEstornada
     */
    public function setTimestampEstornada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada)
    {
        $this->timestampEstornada = $timestampEstornada;
        return $this;
    }

    /**
     * Get timestampEstornada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampEstornada()
    {
        return $this->timestampEstornada;
    }

    /**
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * Set observacao
     *
     * @param string $observacao
     * @return ArrecadacaoEstornada
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ArrecadacaoEstornada
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
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return ArrecadacaoEstornada
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
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     * @return ArrecadacaoEstornada
     */
    public function addFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->contains($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)) {
            $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao->setFkTesourariaArrecadacaoEstornada($this);
            $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->add($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->removeElement($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    public function getFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoReceitaDedutoraEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada
     * @return ArrecadacaoEstornada
     */
    public function addFkTesourariaArrecadacaoReceitaDedutoraEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->contains($fkTesourariaArrecadacaoReceitaDedutoraEstornada)) {
            $fkTesourariaArrecadacaoReceitaDedutoraEstornada->setFkTesourariaArrecadacaoEstornada($this);
            $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->add($fkTesourariaArrecadacaoReceitaDedutoraEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoReceitaDedutoraEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada
     */
    public function removeFkTesourariaArrecadacaoReceitaDedutoraEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada $fkTesourariaArrecadacaoReceitaDedutoraEstornada)
    {
        $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas->removeElement($fkTesourariaArrecadacaoReceitaDedutoraEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoReceitaDedutoraEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceitaDedutoraEstornada
     */
    public function getFkTesourariaArrecadacaoReceitaDedutoraEstornadas()
    {
        return $this->fkTesourariaArrecadacaoReceitaDedutoraEstornadas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada
     * @return ArrecadacaoEstornada
     */
    public function addFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->contains($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)) {
            $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada->setFkTesourariaArrecadacaoEstornada($this);
            $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->add($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada
     */
    public function removeFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)
    {
        $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->removeElement($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function getFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas()
    {
        return $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return ArrecadacaoEstornada
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * @return ArrecadacaoEstornada
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
     * OneToOne (inverse side)
     * Set TesourariaArrecadacaoEstornadaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita
     * @return ArrecadacaoEstornada
     */
    public function setFkTesourariaArrecadacaoEstornadaReceita(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita $fkTesourariaArrecadacaoEstornadaReceita)
    {
        $fkTesourariaArrecadacaoEstornadaReceita->setFkTesourariaArrecadacaoEstornada($this);
        $this->fkTesourariaArrecadacaoEstornadaReceita = $fkTesourariaArrecadacaoEstornadaReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaArrecadacaoEstornadaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaReceita
     */
    public function getFkTesourariaArrecadacaoEstornadaReceita()
    {
        return $this->fkTesourariaArrecadacaoEstornadaReceita;
    }
}
