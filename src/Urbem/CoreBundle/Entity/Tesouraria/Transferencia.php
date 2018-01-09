<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Transferencia
 */
class Transferencia
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

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
     * @var string
     */
    private $tipo;

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
    private $codHistorico;

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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTransferencia;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codPlanoCredito;

    /**
     * @var integer
     */
    private $codPlanoDebito;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceal\TipoPagamento
     */
    private $fkTcealTipoPagamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento
     */
    private $fkTcetoTransferenciaTipoPagamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    private $fkTcetoTransferenciaTipoTransferencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso
     */
    private $fkTesourariaTransferenciaRecurso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor
     */
    private $fkTesourariaTransferenciaCredor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    private $fkContabilidadeLote;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia
     */
    private $fkTesourariaBoletimLoteTransferenciaInconsistencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    private $fkTesourariaBoletimLoteTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia
     */
    private $fkTesourariaChequeEmissaoTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao
     */
    private $fkTesourariaTransferenciaOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia
     */
    private $fkTesourariaReciboExtraTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    private $fkTesourariaTransferenciaEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    private $fkTcepeTipoTransferenciaRecebidas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    private $fkTcepeTipoTransferenciaConcedidas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil
     */
    private $fkContabilidadeHistoricoContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TipoTransferencia
     */
    private $fkTesourariaTipoTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaBoletimLoteTransferenciaInconsistencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBoletimLoteTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeTipoTransferenciaRecebidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeTipoTransferenciaConcedidas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampTransferencia = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Transferencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Transferencia
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
     * @return Transferencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return Transferencia
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
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return Transferencia
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
     * @return Transferencia
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
     * @return Transferencia
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
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return Transferencia
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Transferencia
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
     * @return Transferencia
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
     * @return Transferencia
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
     * @return Transferencia
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
     * Set timestampTransferencia
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTransferencia
     * @return Transferencia
     */
    public function setTimestampTransferencia(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTransferencia)
    {
        $this->timestampTransferencia = $timestampTransferencia;
        return $this;
    }

    /**
     * Get timestampTransferencia
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTransferencia()
    {
        return $this->timestampTransferencia;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Transferencia
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
     * Set codPlanoCredito
     *
     * @param integer $codPlanoCredito
     * @return Transferencia
     */
    public function setCodPlanoCredito($codPlanoCredito = null)
    {
        $this->codPlanoCredito = $codPlanoCredito;
        return $this;
    }

    /**
     * Get codPlanoCredito
     *
     * @return integer
     */
    public function getCodPlanoCredito()
    {
        return $this->codPlanoCredito;
    }

    /**
     * Set codPlanoDebito
     *
     * @param integer $codPlanoDebito
     * @return Transferencia
     */
    public function setCodPlanoDebito($codPlanoDebito = null)
    {
        $this->codPlanoDebito = $codPlanoDebito;
        return $this;
    }

    /**
     * Get codPlanoDebito
     *
     * @return integer
     */
    public function getCodPlanoDebito()
    {
        return $this->codPlanoDebito;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Transferencia
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Transferencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteTransferenciaInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia
     * @return Transferencia
     */
    public function addFkTesourariaBoletimLoteTransferenciaInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia)
    {
        if (false === $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->contains($fkTesourariaBoletimLoteTransferenciaInconsistencia)) {
            $fkTesourariaBoletimLoteTransferenciaInconsistencia->setFkTesourariaTransferencia($this);
            $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->add($fkTesourariaBoletimLoteTransferenciaInconsistencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteTransferenciaInconsistencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia
     */
    public function removeFkTesourariaBoletimLoteTransferenciaInconsistencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia $fkTesourariaBoletimLoteTransferenciaInconsistencia)
    {
        $this->fkTesourariaBoletimLoteTransferenciaInconsistencias->removeElement($fkTesourariaBoletimLoteTransferenciaInconsistencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteTransferenciaInconsistencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferenciaInconsistencia
     */
    public function getFkTesourariaBoletimLoteTransferenciaInconsistencias()
    {
        return $this->fkTesourariaBoletimLoteTransferenciaInconsistencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLoteTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia
     * @return Transferencia
     */
    public function addFkTesourariaBoletimLoteTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia)
    {
        if (false === $this->fkTesourariaBoletimLoteTransferencias->contains($fkTesourariaBoletimLoteTransferencia)) {
            $fkTesourariaBoletimLoteTransferencia->setFkTesourariaTransferencia($this);
            $this->fkTesourariaBoletimLoteTransferencias->add($fkTesourariaBoletimLoteTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLoteTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia
     */
    public function removeFkTesourariaBoletimLoteTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia $fkTesourariaBoletimLoteTransferencia)
    {
        $this->fkTesourariaBoletimLoteTransferencias->removeElement($fkTesourariaBoletimLoteTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLoteTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLoteTransferencia
     */
    public function getFkTesourariaBoletimLoteTransferencias()
    {
        return $this->fkTesourariaBoletimLoteTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia
     * @return Transferencia
     */
    public function addFkTesourariaChequeEmissaoTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia)
    {
        if (false === $this->fkTesourariaChequeEmissaoTransferencias->contains($fkTesourariaChequeEmissaoTransferencia)) {
            $fkTesourariaChequeEmissaoTransferencia->setFkTesourariaTransferencia($this);
            $this->fkTesourariaChequeEmissaoTransferencias->add($fkTesourariaChequeEmissaoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia
     */
    public function removeFkTesourariaChequeEmissaoTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia $fkTesourariaChequeEmissaoTransferencia)
    {
        $this->fkTesourariaChequeEmissaoTransferencias->removeElement($fkTesourariaChequeEmissaoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoTransferencia
     */
    public function getFkTesourariaChequeEmissaoTransferencias()
    {
        return $this->fkTesourariaChequeEmissaoTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao
     * @return Transferencia
     */
    public function addFkTesourariaTransferenciaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->contains($fkTesourariaTransferenciaOrdemPagamentoRetencao)) {
            $fkTesourariaTransferenciaOrdemPagamentoRetencao->setFkTesourariaTransferencia($this);
            $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->add($fkTesourariaTransferenciaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaTransferenciaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->removeElement($fkTesourariaTransferenciaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao
     */
    public function getFkTesourariaTransferenciaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia
     * @return Transferencia
     */
    public function addFkTesourariaReciboExtraTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia)
    {
        if (false === $this->fkTesourariaReciboExtraTransferencias->contains($fkTesourariaReciboExtraTransferencia)) {
            $fkTesourariaReciboExtraTransferencia->setFkTesourariaTransferencia($this);
            $this->fkTesourariaReciboExtraTransferencias->add($fkTesourariaReciboExtraTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia
     */
    public function removeFkTesourariaReciboExtraTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia)
    {
        $this->fkTesourariaReciboExtraTransferencias->removeElement($fkTesourariaReciboExtraTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia
     */
    public function getFkTesourariaReciboExtraTransferencias()
    {
        return $this->fkTesourariaReciboExtraTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     * @return Transferencia
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkTesourariaTransferencia($this);
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
     * Add TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     * @return Transferencia
     */
    public function addFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        if (false === $this->fkTcepeTipoTransferenciaRecebidas->contains($fkTcepeTipoTransferenciaRecebida)) {
            $fkTcepeTipoTransferenciaRecebida->setFkTesourariaTransferencia($this);
            $this->fkTcepeTipoTransferenciaRecebidas->add($fkTcepeTipoTransferenciaRecebida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaRecebida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida
     */
    public function removeFkTcepeTipoTransferenciaRecebidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida $fkTcepeTipoTransferenciaRecebida)
    {
        $this->fkTcepeTipoTransferenciaRecebidas->removeElement($fkTcepeTipoTransferenciaRecebida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaRecebidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaRecebida
     */
    public function getFkTcepeTipoTransferenciaRecebidas()
    {
        return $this->fkTcepeTipoTransferenciaRecebidas;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     * @return Transferencia
     */
    public function addFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        if (false === $this->fkTcepeTipoTransferenciaConcedidas->contains($fkTcepeTipoTransferenciaConcedida)) {
            $fkTcepeTipoTransferenciaConcedida->setFkTesourariaTransferencia($this);
            $this->fkTcepeTipoTransferenciaConcedidas->add($fkTcepeTipoTransferenciaConcedida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeTipoTransferenciaConcedida
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida
     */
    public function removeFkTcepeTipoTransferenciaConcedidas(\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida $fkTcepeTipoTransferenciaConcedida)
    {
        $this->fkTcepeTipoTransferenciaConcedidas->removeElement($fkTcepeTipoTransferenciaConcedida);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeTipoTransferenciaConcedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\TipoTransferenciaConcedida
     */
    public function getFkTcepeTipoTransferenciaConcedidas()
    {
        return $this->fkTcepeTipoTransferenciaConcedidas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return Transferencia
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
     * Set fkContabilidadeHistoricoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil $fkContabilidadeHistoricoContabil
     * @return Transferencia
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
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return Transferencia
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlanoCredito = $fkContabilidadePlanoAnalitica->getCodPlano();
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
     * Set fkTesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return Transferencia
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
     * @return Transferencia
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
     * ManyToOne (inverse side)
     * Set fkTesourariaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TipoTransferencia $fkTesourariaTipoTransferencia
     * @return Transferencia
     */
    public function setFkTesourariaTipoTransferencia(\Urbem\CoreBundle\Entity\Tesouraria\TipoTransferencia $fkTesourariaTipoTransferencia)
    {
        $this->codTipo = $fkTesourariaTipoTransferencia->getCodTipo();
        $this->fkTesourariaTipoTransferencia = $fkTesourariaTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TipoTransferencia
     */
    public function getFkTesourariaTipoTransferencia()
    {
        return $this->fkTesourariaTipoTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica1
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1
     * @return Transferencia
     */
    public function setFkContabilidadePlanoAnalitica1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1)
    {
        $this->codPlanoDebito = $fkContabilidadePlanoAnalitica1->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica1->getExercicio();
        $this->fkContabilidadePlanoAnalitica1 = $fkContabilidadePlanoAnalitica1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica1
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica1()
    {
        return $this->fkContabilidadePlanoAnalitica1;
    }

    /**
     * OneToOne (inverse side)
     * Set TcealTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\TipoPagamento $fkTcealTipoPagamento
     * @return Transferencia
     */
    public function setFkTcealTipoPagamento(\Urbem\CoreBundle\Entity\Tceal\TipoPagamento $fkTcealTipoPagamento)
    {
        $fkTcealTipoPagamento->setFkTesourariaTransferencia($this);
        $this->fkTcealTipoPagamento = $fkTcealTipoPagamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcealTipoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\TipoPagamento
     */
    public function getFkTcealTipoPagamento()
    {
        return $this->fkTcealTipoPagamento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoTransferenciaTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento
     * @return Transferencia
     */
    public function setFkTcetoTransferenciaTipoPagamento(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento)
    {
        $fkTcetoTransferenciaTipoPagamento->setFkTesourariaTransferencia($this);
        $this->fkTcetoTransferenciaTipoPagamento = $fkTcetoTransferenciaTipoPagamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoTransferenciaTipoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento
     */
    public function getFkTcetoTransferenciaTipoPagamento()
    {
        return $this->fkTcetoTransferenciaTipoPagamento;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoTransferenciaTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia
     * @return Transferencia
     */
    public function setFkTcetoTransferenciaTipoTransferencia(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia $fkTcetoTransferenciaTipoTransferencia)
    {
        $fkTcetoTransferenciaTipoTransferencia->setFkTesourariaTransferencia($this);
        $this->fkTcetoTransferenciaTipoTransferencia = $fkTcetoTransferenciaTipoTransferencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoTransferenciaTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoTransferencia
     */
    public function getFkTcetoTransferenciaTipoTransferencia()
    {
        return $this->fkTcetoTransferenciaTipoTransferencia;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaTransferenciaRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso
     * @return Transferencia
     */
    public function setFkTesourariaTransferenciaRecurso(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso)
    {
        $fkTesourariaTransferenciaRecurso->setFkTesourariaTransferencia($this);
        $this->fkTesourariaTransferenciaRecurso = $fkTesourariaTransferenciaRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaTransferenciaRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso
     */
    public function getFkTesourariaTransferenciaRecurso()
    {
        return $this->fkTesourariaTransferenciaRecurso;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaTransferenciaCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor
     * @return Transferencia
     */
    public function setFkTesourariaTransferenciaCredor(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor $fkTesourariaTransferenciaCredor)
    {
        $fkTesourariaTransferenciaCredor->setFkTesourariaTransferencia($this);
        $this->fkTesourariaTransferenciaCredor = $fkTesourariaTransferenciaCredor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaTransferenciaCredor
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaCredor
     */
    public function getFkTesourariaTransferenciaCredor()
    {
        return $this->fkTesourariaTransferenciaCredor;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return Transferencia
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
     * OneToOne (owning side)
     * Get fkContabilidadeLote
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lote
     */
    public function getFkContabilidadeLote()
    {
        return $this->fkContabilidadeLote;
    }

    /**
     * @return string
     */
    public function getCodPlanoContaCredito()
    {
        $planoConta = $this->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta();

        return sprintf('%s - %s', $planoConta->getCodConta(), $planoConta->getNomConta());
    }

    /**
     * @return string
     */
    public function getCodPlanoContaDebito()
    {
        $planoConta = $this->getFkContabilidadePlanoAnalitica1()->getFkContabilidadePlanoConta();

        return sprintf('%s - %s', $planoConta->getCodConta(), $planoConta->getNomConta());
    }

    /**
     * @return string
     */
    public function getRecibo()
    {
        return ($this->fkTesourariaReciboExtraTransferencias->count())
            ? (string) $this->fkTesourariaReciboExtraTransferencias->last()->getFkTesourariaReciboExtra()
            : null;
    }

    /**
     * @return string
     */
    public function getBoletim()
    {
        return sprintf('%s/%s', $this->codBoletim, $this->fkTesourariaBoletim->getExercicio());
    }

    /**
     * @return string
     */
    public function getRecurso()
    {
        return ($this->fkTesourariaTransferenciaRecurso)
            ? (string) $this->fkTesourariaTransferenciaRecurso->getFkOrcamentoRecurso()
            : null;
    }

    /**
     * @return float
     */
    public function getValorEstornado()
    {
        $valorEstornado = 0.00;
        foreach ($this->fkTesourariaTransferenciaEstornadas as $transferenciaEstornada) {
            $valorEstornado += $transferenciaEstornada->getValor();
        }
        return $valorEstornado;
    }
}
