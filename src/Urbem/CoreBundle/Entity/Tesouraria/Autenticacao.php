<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Autenticacao
 */
class Autenticacao
{
    /**
     * PK
     * @var integer
     */
    private $codAutenticacao;

    /**
     * PK
     * @var DateTimeMicrosecondPK
     */
    private $dtAutenticacao;

    /**
     * @var string
     */
    private $tipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBorderos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    private $fkTesourariaPagamentoEstornados;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TipoAutenticacao
     */
    private $fkTesourariaTipoAutenticacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBorderos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentoEstornados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtAutenticacao = new DateTimeMicrosecondPK();
    }

    /**
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return Autenticacao
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
     * @return Autenticacao
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
     * Set tipo
     *
     * @param string $tipo
     * @return Autenticacao
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
     * OneToMany (owning side)
     * Add TesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return Autenticacao
     */
    public function addFkTesourariaArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        if (false === $this->fkTesourariaArrecadacoes->contains($fkTesourariaArrecadacao)) {
            $fkTesourariaArrecadacao->setFkTesourariaAutenticacao($this);
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
     * Add TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return Autenticacao
     */
    public function addFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        if (false === $this->fkTesourariaBorderos->contains($fkTesourariaBordero)) {
            $fkTesourariaBordero->setFkTesourariaAutenticacao($this);
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
     * Add TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     * @return Autenticacao
     */
    public function addFkTesourariaPagamentoEstornados(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        if (false === $this->fkTesourariaPagamentoEstornados->contains($fkTesourariaPagamentoEstornado)) {
            $fkTesourariaPagamentoEstornado->setFkTesourariaAutenticacao($this);
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
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return Autenticacao
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkTesourariaAutenticacao($this);
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
     * @return Autenticacao
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkTesourariaAutenticacao($this);
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
     * @return Autenticacao
     */
    public function addFkTesourariaPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        if (false === $this->fkTesourariaPagamentos->contains($fkTesourariaPagamento)) {
            $fkTesourariaPagamento->setFkTesourariaAutenticacao($this);
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
     * @return Autenticacao
     */
    public function addFkTesourariaArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadas->contains($fkTesourariaArrecadacaoEstornada)) {
            $fkTesourariaArrecadacaoEstornada->setFkTesourariaAutenticacao($this);
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
     * Set fkTesourariaTipoAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TipoAutenticacao $fkTesourariaTipoAutenticacao
     * @return Autenticacao
     */
    public function setFkTesourariaTipoAutenticacao(\Urbem\CoreBundle\Entity\Tesouraria\TipoAutenticacao $fkTesourariaTipoAutenticacao)
    {
        $this->tipo = $fkTesourariaTipoAutenticacao->getCodTipoAutenticacao();
        $this->fkTesourariaTipoAutenticacao = $fkTesourariaTipoAutenticacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTipoAutenticacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TipoAutenticacao
     */
    public function getFkTesourariaTipoAutenticacao()
    {
        return $this->fkTesourariaTipoAutenticacao;
    }
}
