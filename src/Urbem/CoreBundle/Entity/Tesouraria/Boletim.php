<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * Boletim
 */
class Boletim
{
    /**
     * PK
     * @var integer
     */
    private $codBoletim;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var \DateTime
     */
    private $dtBoletim;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBorderos;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    private $fkTesourariaDoteProcessados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

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
        $this->fkTesourariaArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaAberturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBorderos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimFechados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentoEstornados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaFechamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaDoteProcessados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return Boletim
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Boletim
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Boletim
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Boletim
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
     * @return Boletim
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
     * @return Boletim
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
     * @return Boletim
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
     * Set dtBoletim
     *
     * @param \DateTime $dtBoletim
     * @return Boletim
     */
    public function setDtBoletim(\DateTime $dtBoletim)
    {
        $this->dtBoletim = $dtBoletim;
        return $this;
    }

    /**
     * Get dtBoletim
     *
     * @return \DateTime
     */
    public function getDtBoletim()
    {
        return $this->dtBoletim;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return Boletim
     */
    public function addFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        if (false === $this->fkTesourariaArrecadacoes->contains($fkTesourariaArrecadacao)) {
            $fkTesourariaArrecadacao->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaAberturas(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        if (false === $this->fkTesourariaAberturas->contains($fkTesourariaAbertura)) {
            $fkTesourariaAbertura->setFkTesourariaBoletim($this);
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
     * Add TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return Boletim
     */
    public function addFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        if (false === $this->fkTesourariaBorderos->contains($fkTesourariaBordero)) {
            $fkTesourariaBordero->setFkTesourariaBoletim($this);
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
     * Add TesourariaBoletimLoteArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao
     * @return Boletim
     */
    public function addFkTesourariaBoletimLoteArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacao $fkTesourariaBoletimLoteArrecadacao)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacoes->contains($fkTesourariaBoletimLoteArrecadacao)) {
            $fkTesourariaBoletimLoteArrecadacao->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaBoletimLoteArrecadacaoInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteArrecadacaoInconsistencia $fkTesourariaBoletimLoteArrecadacaoInconsistencia)
    {
        if (false === $this->fkTesourariaBoletimLoteArrecadacaoInconsistencias->contains($fkTesourariaBoletimLoteArrecadacaoInconsistencia)) {
            $fkTesourariaBoletimLoteArrecadacaoInconsistencia->setFkTesourariaBoletim($this);
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
     * Add TesourariaBoletimFechado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado
     * @return Boletim
     */
    public function addFkTesourariaBoletimFechados(\Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado $fkTesourariaBoletimFechado)
    {
        if (false === $this->fkTesourariaBoletimFechados->contains($fkTesourariaBoletimFechado)) {
            $fkTesourariaBoletimFechado->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        if (false === $this->fkTesourariaPagamentoEstornados->contains($fkTesourariaPagamentoEstornado)) {
            $fkTesourariaPagamentoEstornado->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaFechamentos(\Urbem\CoreBundle\Entity\Tesouraria\Fechamento $fkTesourariaFechamento)
    {
        if (false === $this->fkTesourariaFechamentos->contains($fkTesourariaFechamento)) {
            $fkTesourariaFechamento->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkTesourariaBoletim($this);
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
     * Add TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return Boletim
     */
    public function addFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        if (false === $this->fkTesourariaPagamentos->contains($fkTesourariaPagamento)) {
            $fkTesourariaPagamento->setFkTesourariaBoletim($this);
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
     * @return Boletim
     */
    public function addFkTesourariaArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadas->contains($fkTesourariaArrecadacaoEstornada)) {
            $fkTesourariaArrecadacaoEstornada->setFkTesourariaBoletim($this);
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
     * Add TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     * @return Boletim
     */
    public function addFkTesourariaDoteProcessados(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        if (false === $this->fkTesourariaDoteProcessados->contains($fkTesourariaDoteProcessado)) {
            $fkTesourariaDoteProcessado->setFkTesourariaBoletim($this);
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
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Boletim
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
     * Set fkTesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Boletim
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
     * @return string
     */
    public function __toString()
    {
        $dtBoletim = $this->dtBoletim ? $this->dtBoletim->format('d/m/Y') : null;
        return sprintf('%s - %s', $this->codBoletim, $dtBoletim);
    }
}
