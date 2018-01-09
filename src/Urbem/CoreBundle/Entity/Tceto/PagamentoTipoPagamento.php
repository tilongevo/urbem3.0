<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * PagamentoTipoPagamento
 */
class PagamentoTipoPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\TipoPagamento
     */
    private $fkTcetoTipoPagamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoTipoPagamento
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return PagamentoTipoPagamento
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
     * @return PagamentoTipoPagamento
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
     * Set timestamp
     *
     * @param DateTimeMicrosecondPK $timestamp
     * @return PagamentoTipoPagamento
     */
    public function setTimestamp(DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipoPagamento
     *
     * @param integer $codTipoPagamento
     * @return PagamentoTipoPagamento
     */
    public function setCodTipoPagamento($codTipoPagamento)
    {
        $this->codTipoPagamento = $codTipoPagamento;
        return $this;
    }

    /**
     * Get codTipoPagamento
     *
     * @return integer
     */
    public function getCodTipoPagamento()
    {
        return $this->codTipoPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PagamentoTipoPagamento
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
     * Set fkTcetoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TipoPagamento $fkTcetoTipoPagamento
     * @return PagamentoTipoPagamento
     */
    public function setFkTcetoTipoPagamento(\Urbem\CoreBundle\Entity\Tceto\TipoPagamento $fkTcetoTipoPagamento)
    {
        $this->codTipoPagamento = $fkTcetoTipoPagamento->getCodTipo();
        $this->fkTcetoTipoPagamento = $fkTcetoTipoPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoTipoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TipoPagamento
     */
    public function getFkTcetoTipoPagamento()
    {
        return $this->fkTcetoTipoPagamento;
    }
}
