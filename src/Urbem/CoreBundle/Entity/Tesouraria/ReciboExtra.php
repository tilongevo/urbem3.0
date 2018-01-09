<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ReciboExtra
 */
class ReciboExtra
{
    /**
     * PK
     * @var integer
     */
    private $codReciboExtra;

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
    private $tipoRecibo;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var integer
     */
    private $codTerminal;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $historico;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao
     */
    private $fkTesourariaReciboExtraAnulacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco
     */
    private $fkTesourariaReciboExtraBanco;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor
     */
    private $fkTesourariaReciboExtraCredor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso
     */
    private $fkTesourariaReciboExtraRecurso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra
     */
    private $fkEmpenhoOrdemPagamentoReciboExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura
     */
    private $fkTesourariaReciboExtraAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia
     */
    private $fkTesourariaReciboExtraTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra
     */
    private $fkTesourariaChequeEmissaoReciboExtras;

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
     * @var \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoOrdemPagamentoReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return ReciboExtra
     */
    public function setCodReciboExtra($codReciboExtra)
    {
        $this->codReciboExtra = $codReciboExtra;
        return $this;
    }

    /**
     * Get codReciboExtra
     *
     * @return integer
     */
    public function getCodReciboExtra()
    {
        return $this->codReciboExtra;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReciboExtra
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
     * @return ReciboExtra
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
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return ReciboExtra
     */
    public function setTipoRecibo($tipoRecibo)
    {
        $this->tipoRecibo = $tipoRecibo;
        return $this;
    }

    /**
     * Get tipoRecibo
     *
     * @return string
     */
    public function getTipoRecibo()
    {
        return $this->tipoRecibo;
    }

    /**
     * Set timestampUsuario
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario
     * @return ReciboExtra
     */
    public function setTimestampUsuario(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampUsuario = null)
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return ReciboExtra
     */
    public function setCgmUsuario($cgmUsuario = null)
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
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return ReciboExtra
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal = null)
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
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return ReciboExtra
     */
    public function setCodTerminal($codTerminal = null)
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ReciboExtra
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
     * Set historico
     *
     * @param string $historico
     * @return ReciboExtra
     */
    public function setHistorico($historico = null)
    {
        $this->historico = $historico;
        return $this;
    }

    /**
     * Get historico
     *
     * @return string
     */
    public function getHistorico()
    {
        return $this->historico;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ReciboExtra
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
     * Set valor
     *
     * @param integer $valor
     * @return ReciboExtra
     */
    public function setValor($valor)
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
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra
     * @return ReciboExtra
     */
    public function addFkEmpenhoOrdemPagamentoReciboExtras(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoReciboExtras->contains($fkEmpenhoOrdemPagamentoReciboExtra)) {
            $fkEmpenhoOrdemPagamentoReciboExtra->setFkTesourariaReciboExtra($this);
            $this->fkEmpenhoOrdemPagamentoReciboExtras->add($fkEmpenhoOrdemPagamentoReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra
     */
    public function removeFkEmpenhoOrdemPagamentoReciboExtras(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra)
    {
        $this->fkEmpenhoOrdemPagamentoReciboExtras->removeElement($fkEmpenhoOrdemPagamentoReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra
     */
    public function getFkEmpenhoOrdemPagamentoReciboExtras()
    {
        return $this->fkEmpenhoOrdemPagamentoReciboExtras;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura
     * @return ReciboExtra
     */
    public function addFkTesourariaReciboExtraAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura)
    {
        if (false === $this->fkTesourariaReciboExtraAssinaturas->contains($fkTesourariaReciboExtraAssinatura)) {
            $fkTesourariaReciboExtraAssinatura->setFkTesourariaReciboExtra($this);
            $this->fkTesourariaReciboExtraAssinaturas->add($fkTesourariaReciboExtraAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura
     */
    public function removeFkTesourariaReciboExtraAssinaturas(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura $fkTesourariaReciboExtraAssinatura)
    {
        $this->fkTesourariaReciboExtraAssinaturas->removeElement($fkTesourariaReciboExtraAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAssinatura
     */
    public function getFkTesourariaReciboExtraAssinaturas()
    {
        return $this->fkTesourariaReciboExtraAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia
     * @return ReciboExtra
     */
    public function addFkTesourariaReciboExtraTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraTransferencia $fkTesourariaReciboExtraTransferencia)
    {
        if (false === $this->fkTesourariaReciboExtraTransferencias->contains($fkTesourariaReciboExtraTransferencia)) {
            $fkTesourariaReciboExtraTransferencia->setFkTesourariaReciboExtra($this);
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
     * Add TesourariaChequeEmissaoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra
     * @return ReciboExtra
     */
    public function addFkTesourariaChequeEmissaoReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra)
    {
        if (false === $this->fkTesourariaChequeEmissaoReciboExtras->contains($fkTesourariaChequeEmissaoReciboExtra)) {
            $fkTesourariaChequeEmissaoReciboExtra->setFkTesourariaReciboExtra($this);
            $this->fkTesourariaChequeEmissaoReciboExtras->add($fkTesourariaChequeEmissaoReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra
     */
    public function removeFkTesourariaChequeEmissaoReciboExtras(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra $fkTesourariaChequeEmissaoReciboExtra)
    {
        $this->fkTesourariaChequeEmissaoReciboExtras->removeElement($fkTesourariaChequeEmissaoReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoReciboExtra
     */
    public function getFkTesourariaChequeEmissaoReciboExtras()
    {
        return $this->fkTesourariaChequeEmissaoReciboExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return ReciboExtra
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
     * @return ReciboExtra
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
     * @return ReciboExtra
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
     * Set TesourariaReciboExtraAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao $fkTesourariaReciboExtraAnulacao
     * @return ReciboExtra
     */
    public function setFkTesourariaReciboExtraAnulacao(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao $fkTesourariaReciboExtraAnulacao)
    {
        $fkTesourariaReciboExtraAnulacao->setFkTesourariaReciboExtra($this);
        $this->fkTesourariaReciboExtraAnulacao = $fkTesourariaReciboExtraAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaReciboExtraAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraAnulacao
     */
    public function getFkTesourariaReciboExtraAnulacao()
    {
        return $this->fkTesourariaReciboExtraAnulacao;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaReciboExtraBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco
     * @return ReciboExtra
     */
    public function setFkTesourariaReciboExtraBanco(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco $fkTesourariaReciboExtraBanco)
    {
        $fkTesourariaReciboExtraBanco->setFkTesourariaReciboExtra($this);
        $this->fkTesourariaReciboExtraBanco = $fkTesourariaReciboExtraBanco;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaReciboExtraBanco
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraBanco
     */
    public function getFkTesourariaReciboExtraBanco()
    {
        return $this->fkTesourariaReciboExtraBanco;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaReciboExtraCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor
     * @return ReciboExtra
     */
    public function setFkTesourariaReciboExtraCredor(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor $fkTesourariaReciboExtraCredor)
    {
        $fkTesourariaReciboExtraCredor->setFkTesourariaReciboExtra($this);
        $this->fkTesourariaReciboExtraCredor = $fkTesourariaReciboExtraCredor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaReciboExtraCredor
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraCredor
     */
    public function getFkTesourariaReciboExtraCredor()
    {
        return $this->fkTesourariaReciboExtraCredor;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaReciboExtraRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso
     * @return ReciboExtra
     */
    public function setFkTesourariaReciboExtraRecurso(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso)
    {
        $fkTesourariaReciboExtraRecurso->setFkTesourariaReciboExtra($this);
        $this->fkTesourariaReciboExtraRecurso = $fkTesourariaReciboExtraRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaReciboExtraRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso
     */
    public function getFkTesourariaReciboExtraRecurso()
    {
        return $this->fkTesourariaReciboExtraRecurso;
    }

    /**
     * @return string
     */
    public function getCodEntidadeComposto()
    {
        return sprintf('%s - %s', $this->codEntidade, $this->fkOrcamentoEntidade->getFkSwCgm()->getNomCgm());
    }

    /**
     * @return string
     */
    public function getCodReciboExtraComposto()
    {
        return sprintf('%s/%s', $this->codReciboExtra, $this->exercicio);
    }

    public function getValorPago()
    {
        $valorPago = 0.00;
        foreach ($this->fkTesourariaReciboExtraTransferencias as $reciboExtraTransferencia) {
            $valorPago += $reciboExtraTransferencia->getFkTesourariaTransferencia()->getValor();
            foreach ($reciboExtraTransferencia->getFkTesourariaTransferencia()->getFkTesourariaTransferenciaEstornadas() as $transferenciaEstornada) {
                $valorPago -= $transferenciaEstornada->getValor();
            }
        }
        return $valorPago;
    }

    public function getSaldo()
    {
        if ($this->fkTesourariaReciboExtraTransferencias->count()) {
            return $this->valor - $this->getValorPago();
        } else {
            return 0.00;
        }
    }

    public function getStatus()
    {
        if ($this->fkTesourariaReciboExtraAnulacao != null) {
            return 'label.reciboExtra.anulado';
        } elseif ($this->fkTesourariaReciboExtraTransferencias->count()) {
            return 'label.reciboExtra.arrecadado';
        } else {
            return 'label.reciboExtra.aReceber';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codReciboExtra . '/' . $this->exercicio;
    }
}
