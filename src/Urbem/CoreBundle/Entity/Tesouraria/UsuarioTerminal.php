<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * UsuarioTerminal
 */
class UsuarioTerminal
{
    /**
     * PK
     * @var integer
     */
    private $codTerminal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * PK
     * @var integer
     */
    private $cgmUsuario;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var boolean
     */
    private $responsavel = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminalExcluido
     */
    private $fkTesourariaUsuarioTerminalExcluido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    private $fkTesourariaAberturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletins;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBorderos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    private $fkTesourariaBoletimReabertos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    private $fkTesourariaBoletimLiberados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    private $fkTesourariaBoletimFechados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    private $fkTesourariaPagamentoEstornados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Fechamento
     */
    private $fkTesourariaFechamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    private $fkTesourariaTransferenciaEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    private $fkTesourariaArrecadacaoEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    private $fkTesourariaDotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    private $fkTesourariaBoletimLiberadoCancelados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    private $fkTesourariaDoteProcessados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    private $fkTesourariaTerminal;

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
        $this->fkTesourariaArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaAberturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBorderos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimReabertos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLiberados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimFechados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentoEstornados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaFechamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaDotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLiberadoCancelados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaDoteProcessados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampUsuario = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return UsuarioTerminal
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
     * @return UsuarioTerminal
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
     * @return UsuarioTerminal
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
     * @return UsuarioTerminal
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
     * Set responsavel
     *
     * @param boolean $responsavel
     * @return UsuarioTerminal
     */
    public function setResponsavel($responsavel = null)
    {
        $this->responsavel = $responsavel;
        return $this;
    }

    /**
     * Get responsavel
     *
     * @return boolean
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return UsuarioTerminal
     */
    public function addFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        if (false === $this->fkTesourariaArrecadacoes->contains($fkTesourariaArrecadacao)) {
            $fkTesourariaArrecadacao->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaArrecadacoes->add($fkTesourariaArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     */
    public function removeFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->fkTesourariaArrecadacoes->removeElement($fkTesourariaArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacoes()
    {
        return $this->fkTesourariaArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaAbertura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura
     * @return UsuarioTerminal
     */
    public function addFkTesourariaAberturas(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        if (false === $this->fkTesourariaAberturas->contains($fkTesourariaAbertura)) {
            $fkTesourariaAbertura->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaAberturas->add($fkTesourariaAbertura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaAbertura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura
     */
    public function removeFkTesourariaAberturas(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        $this->fkTesourariaAberturas->removeElement($fkTesourariaAbertura);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaAberturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    public function getFkTesourariaAberturas()
    {
        return $this->fkTesourariaAberturas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBoletins(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        if (false === $this->fkTesourariaBoletins->contains($fkTesourariaBoletim)) {
            $fkTesourariaBoletim->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBoletins->add($fkTesourariaBoletim);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     */
    public function removeFkTesourariaBoletins(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->fkTesourariaBoletins->removeElement($fkTesourariaBoletim);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletins
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    public function getFkTesourariaBoletins()
    {
        return $this->fkTesourariaBoletins;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        if (false === $this->fkTesourariaBorderos->contains($fkTesourariaBordero)) {
            $fkTesourariaBordero->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBorderos->add($fkTesourariaBordero);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     */
    public function removeFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        $this->fkTesourariaBorderos->removeElement($fkTesourariaBordero);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBorderos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    public function getFkTesourariaBorderos()
    {
        return $this->fkTesourariaBorderos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimReaberto
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBoletimReabertos(\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto)
    {
        if (false === $this->fkTesourariaBoletimReabertos->contains($fkTesourariaBoletimReaberto)) {
            $fkTesourariaBoletimReaberto->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBoletimReabertos->add($fkTesourariaBoletimReaberto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimReaberto
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto
     */
    public function removeFkTesourariaBoletimReabertos(\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto $fkTesourariaBoletimReaberto)
    {
        $this->fkTesourariaBoletimReabertos->removeElement($fkTesourariaBoletimReaberto);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimReabertos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto
     */
    public function getFkTesourariaBoletimReabertos()
    {
        return $this->fkTesourariaBoletimReabertos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLiberado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBoletimLiberados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado)
    {
        if (false === $this->fkTesourariaBoletimLiberados->contains($fkTesourariaBoletimLiberado)) {
            $fkTesourariaBoletimLiberado->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBoletimLiberados->add($fkTesourariaBoletimLiberado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado
     */
    public function removeFkTesourariaBoletimLiberados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado $fkTesourariaBoletimLiberado)
    {
        $this->fkTesourariaBoletimLiberados->removeElement($fkTesourariaBoletimLiberado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado
     */
    public function getFkTesourariaBoletimLiberados()
    {
        return $this->fkTesourariaBoletimLiberados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBoletimFechados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        if (false === $this->fkTesourariaBoletimFechados->contains($fkTesourariaBoletimFechado)) {
            $fkTesourariaBoletimFechado->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBoletimFechados->add($fkTesourariaBoletimFechado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     */
    public function removeFkTesourariaBoletimFechados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        $this->fkTesourariaBoletimFechados->removeElement($fkTesourariaBoletimFechado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimFechados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado
     */
    public function getFkTesourariaBoletimFechados()
    {
        return $this->fkTesourariaBoletimFechados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     * @return UsuarioTerminal
     */
    public function addFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        if (false === $this->fkTesourariaPagamentoEstornados->contains($fkTesourariaPagamentoEstornado)) {
            $fkTesourariaPagamentoEstornado->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaPagamentoEstornados->add($fkTesourariaPagamentoEstornado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     */
    public function removeFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        $this->fkTesourariaPagamentoEstornados->removeElement($fkTesourariaPagamentoEstornado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentoEstornados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    public function getFkTesourariaPagamentoEstornados()
    {
        return $this->fkTesourariaPagamentoEstornados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaFechamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento
     * @return UsuarioTerminal
     */
    public function addFkTesourariaFechamentos(\Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento)
    {
        if (false === $this->fkTesourariaFechamentos->contains($fkTesourariaFechamento)) {
            $fkTesourariaFechamento->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaFechamentos->add($fkTesourariaFechamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaFechamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento
     */
    public function removeFkTesourariaFechamentos(\Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento)
    {
        $this->fkTesourariaFechamentos->removeElement($fkTesourariaFechamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaFechamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Fechamento
     */
    public function getFkTesourariaFechamentos()
    {
        return $this->fkTesourariaFechamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return UsuarioTerminal
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaTransferencias->add($fkTesourariaTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     */
    public function removeFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->fkTesourariaTransferencias->removeElement($fkTesourariaTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencias()
    {
        return $this->fkTesourariaTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     * @return UsuarioTerminal
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaTransferenciaEstornadas->add($fkTesourariaTransferenciaEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     */
    public function removeFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        $this->fkTesourariaTransferenciaEstornadas->removeElement($fkTesourariaTransferenciaEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    public function getFkTesourariaTransferenciaEstornadas()
    {
        return $this->fkTesourariaTransferenciaEstornadas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return UsuarioTerminal
     */
    public function addFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        if (false === $this->fkTesourariaReciboExtras->contains($fkTesourariaReciboExtra)) {
            $fkTesourariaReciboExtra->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaReciboExtras->add($fkTesourariaReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     */
    public function removeFkTesourariaReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->fkTesourariaReciboExtras->removeElement($fkTesourariaReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtras()
    {
        return $this->fkTesourariaReciboExtras;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return UsuarioTerminal
     */
    public function addFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        if (false === $this->fkTesourariaPagamentos->contains($fkTesourariaPagamento)) {
            $fkTesourariaPagamento->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaPagamentos->add($fkTesourariaPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     */
    public function removeFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        $this->fkTesourariaPagamentos->removeElement($fkTesourariaPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    public function getFkTesourariaPagamentos()
    {
        return $this->fkTesourariaPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     * @return UsuarioTerminal
     */
    public function addFkTesourariaArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadas->contains($fkTesourariaArrecadacaoEstornada)) {
            $fkTesourariaArrecadacaoEstornada->setFkTesourariaUsuarioTerminal($this);
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
     * OneToMany (owning side)
     * Add TesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     * @return UsuarioTerminal
     */
    public function addFkTesourariaDotes(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        if (false === $this->fkTesourariaDotes->contains($fkTesourariaDote)) {
            $fkTesourariaDote->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaDotes->add($fkTesourariaDote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     */
    public function removeFkTesourariaDotes(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        $this->fkTesourariaDotes->removeElement($fkTesourariaDote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaDotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    public function getFkTesourariaDotes()
    {
        return $this->fkTesourariaDotes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     * @return UsuarioTerminal
     */
    public function addFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        if (false === $this->fkTesourariaBoletimLiberadoCancelados->contains($fkTesourariaBoletimLiberadoCancelado)) {
            $fkTesourariaBoletimLiberadoCancelado->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaBoletimLiberadoCancelados->add($fkTesourariaBoletimLiberadoCancelado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberadoCancelado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado
     */
    public function removeFkTesourariaBoletimLiberadoCancelados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado $fkTesourariaBoletimLiberadoCancelado)
    {
        $this->fkTesourariaBoletimLiberadoCancelados->removeElement($fkTesourariaBoletimLiberadoCancelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberadoCancelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado
     */
    public function getFkTesourariaBoletimLiberadoCancelados()
    {
        return $this->fkTesourariaBoletimLiberadoCancelados;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     * @return UsuarioTerminal
     */
    public function addFkTesourariaDoteProcessados(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        if (false === $this->fkTesourariaDoteProcessados->contains($fkTesourariaDoteProcessado)) {
            $fkTesourariaDoteProcessado->setFkTesourariaUsuarioTerminal($this);
            $this->fkTesourariaDoteProcessados->add($fkTesourariaDoteProcessado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     */
    public function removeFkTesourariaDoteProcessados(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        $this->fkTesourariaDoteProcessados->removeElement($fkTesourariaDoteProcessado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaDoteProcessados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    public function getFkTesourariaDoteProcessados()
    {
        return $this->fkTesourariaDoteProcessados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal
     * @return UsuarioTerminal
     */
    public function setFkTesourariaTerminal(\Urbem\CoreBundle\Entity\Tesouraria\Terminal $fkTesourariaTerminal)
    {
        $this->codTerminal = $fkTesourariaTerminal->getCodTerminal();
        $this->timestampTerminal = $fkTesourariaTerminal->getTimestampTerminal();
        $this->fkTesourariaTerminal = $fkTesourariaTerminal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTerminal
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Terminal
     */
    public function getFkTesourariaTerminal()
    {
        return $this->fkTesourariaTerminal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return UsuarioTerminal
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmUsuario = $fkSwCgm->getNumcgm();
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
     * OneToOne (inverse side)
     * Set TesourariaUsuarioTerminalExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminalExcluido $fkTesourariaUsuarioTerminalExcluido
     * @return UsuarioTerminal
     */
    public function setFkTesourariaUsuarioTerminalExcluido(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminalExcluido $fkTesourariaUsuarioTerminalExcluido)
    {
        $fkTesourariaUsuarioTerminalExcluido->setFkTesourariaUsuarioTerminal($this);
        $this->fkTesourariaUsuarioTerminalExcluido = $fkTesourariaUsuarioTerminalExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaUsuarioTerminalExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminalExcluido
     */
    public function getFkTesourariaUsuarioTerminalExcluido()
    {
        return $this->fkTesourariaUsuarioTerminalExcluido;
    }
}
