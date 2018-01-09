<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * TransferenciaEstornada
 */
class TransferenciaEstornada
{
    /**
     * PK
     * @var integer
     */
    private $codLoteEstorno;

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
     * PK
     * @var integer
     */
    private $codLote;

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
     * @var DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestampUsuario;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEstornada;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao
     */
    private $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Boletim
     */
    private $fkTesourariaBoletim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

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
        $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLoteEstorno
     *
     * @param integer $codLoteEstorno
     * @return TransferenciaEstornada
     */
    public function setCodLoteEstorno($codLoteEstorno)
    {
        $this->codLoteEstorno = $codLoteEstorno;
        return $this;
    }

    /**
     * Get codLoteEstorno
     *
     * @return integer
     */
    public function getCodLoteEstorno()
    {
        return $this->codLoteEstorno;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaEstornada
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
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
     * Set timestampEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada
     * @return TransferenciaEstornada
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
     * Set observacao
     *
     * @param string $observacao
     * @return TransferenciaEstornada
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
     * Set valor
     *
     * @param integer $valor
     * @return TransferenciaEstornada
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
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     * @return TransferenciaEstornada
     */
    public function addFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->contains($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)) {
            $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao->setFkTesourariaTransferenciaEstornada($this);
            $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->add($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->removeElement($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao
     */
    public function getFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLote
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote
     * @return TransferenciaEstornada
     */
    public function setFkContabilidadeLote(\Urbem\CoreBundle\Entity\Contabilidade\Lote $fkContabilidadeLote)
    {
        $this->codLoteEstorno = $fkContabilidadeLote->getCodLote();
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
     * @return TransferenciaEstornada
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
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return TransferenciaEstornada
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
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaEstornada
     */
    public function setFkTesourariaTransferencia(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->codLote = $fkTesourariaTransferencia->getCodLote();
        $this->exercicio = $fkTesourariaTransferencia->getExercicio();
        $this->codEntidade = $fkTesourariaTransferencia->getCodEntidade();
        $this->tipo = $fkTesourariaTransferencia->getTipo();
        $this->fkTesourariaTransferencia = $fkTesourariaTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencia()
    {
        return $this->fkTesourariaTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaAutenticacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Autenticacao $fkTesourariaAutenticacao
     * @return TransferenciaEstornada
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
     * @return TransferenciaEstornada
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
        return sprintf('%s/%s', $this->codLoteEstorno, $this->exercicio);
    }
}
