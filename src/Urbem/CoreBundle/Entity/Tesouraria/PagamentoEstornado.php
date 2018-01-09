<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * PagamentoEstornado
 */
class PagamentoEstornado
{
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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAnulado;

    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * @var string
     */
    private $exercicioBoletim;

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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnulada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamento;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAnulado = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PagamentoEstornado
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
     * Set timestampAnulado
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulado
     * @return PagamentoEstornado
     */
    public function setTimestampAnulado(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulado)
    {
        $this->timestampAnulado = $timestampAnulado;
        return $this;
    }

    /**
     * Get timestampAnulado
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAnulado()
    {
        return $this->timestampAnulado;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoEstornado
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codAutenticacao
     *
     * @param integer $codAutenticacao
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * Set exercicioBoletim
     *
     * @param string $exercicioBoletim
     * @return PagamentoEstornado
     */
    public function setExercicioBoletim($exercicioBoletim)
    {
        $this->exercicioBoletim = $exercicioBoletim;
        return $this;
    }

    /**
     * Get exercicioBoletim
     *
     * @return string
     */
    public function getExercicioBoletim()
    {
        return $this->exercicioBoletim;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * ManyToOne (inverse side)
     * Set fkTesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PagamentoEstornado
     */
    public function setFkTesourariaPagamento(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        $this->codEntidade = $fkTesourariaPagamento->getCodEntidade();
        $this->exercicio = $fkTesourariaPagamento->getExercicio();
        $this->timestamp = $fkTesourariaPagamento->getTimestamp();
        $this->codNota = $fkTesourariaPagamento->getCodNota();
        $this->fkTesourariaPagamento = $fkTesourariaPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    public function getFkTesourariaPagamento()
    {
        return $this->fkTesourariaPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaBoletim
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim
     * @return PagamentoEstornado
     */
    public function setFkTesourariaBoletim(\Urbem\CoreBundle\Entity\Tesouraria\Boletim $fkTesourariaBoletim)
    {
        $this->codBoletim = $fkTesourariaBoletim->getCodBoletim();
        $this->codEntidade = $fkTesourariaBoletim->getCodEntidade();
        $this->exercicioBoletim = $fkTesourariaBoletim->getExercicio();
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
     * @return PagamentoEstornado
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
     * @return PagamentoEstornado
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
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacaoPagaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada
     * @return PagamentoEstornado
     */
    public function setFkEmpenhoNotaLiquidacaoPagaAnulada(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacaoPagaAnulada->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodEntidade();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestamp();
        $this->timestampAnulado = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestampAnulada();
        $this->fkEmpenhoNotaLiquidacaoPagaAnulada = $fkEmpenhoNotaLiquidacaoPagaAnulada;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnulada()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnulada;
    }
}
