<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * PagamentoTipoDocumentoPagamento
 */
class PagamentoTipoDocumentoPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $numDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoDocumentoPagamento
     */
    private $fkTcmbaTipoDocumentoPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PagamentoTipoDocumentoPagamento
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PagamentoTipoDocumentoPagamento
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
     * @return PagamentoTipoDocumentoPagamento
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
     * @param DateTimeMicrosecondPK $timestamp
     * @return PagamentoTipoDocumentoPagamento
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
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoTipoDocumentoPagamento
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
     * Set numDocumento
     *
     * @param string $numDocumento
     * @return PagamentoTipoDocumentoPagamento
     */
    public function setNumDocumento($numDocumento = null)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return string
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoDocumentoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoDocumentoPagamento $fkTcmbaTipoDocumentoPagamento
     * @return PagamentoTipoDocumentoPagamento
     */
    public function setFkTcmbaTipoDocumentoPagamento(\Urbem\CoreBundle\Entity\Tcmba\TipoDocumentoPagamento $fkTcmbaTipoDocumentoPagamento)
    {
        $this->codTipo = $fkTcmbaTipoDocumentoPagamento->getCodTipo();
        $this->fkTcmbaTipoDocumentoPagamento = $fkTcmbaTipoDocumentoPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoDocumentoPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoDocumentoPagamento
     */
    public function getFkTcmbaTipoDocumentoPagamento()
    {
        return $this->fkTcmbaTipoDocumentoPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PagamentoTipoDocumentoPagamento
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
}
