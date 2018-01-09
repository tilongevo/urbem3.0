<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * PagamentoTipoDocumento
 */
class PagamentoTipoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

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
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoDocumento
     */
    private $fkTcemgTipoDocumento;

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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return PagamentoTipoDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PagamentoTipoDocumento
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
     * @return PagamentoTipoDocumento
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
     * @param DateTimeMicrosecondPK $timestamp
     * @return $this
     */
    public function setTimestamp(DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
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
     * @return PagamentoTipoDocumento
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
     * @return PagamentoTipoDocumento
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
     * Set fkTcemgTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoDocumento $fkTcemgTipoDocumento
     * @return PagamentoTipoDocumento
     */
    public function setFkTcemgTipoDocumento(\Urbem\CoreBundle\Entity\Tcemg\TipoDocumento $fkTcemgTipoDocumento)
    {
        $this->codTipoDocumento = $fkTcemgTipoDocumento->getCodTipo();
        $this->fkTcemgTipoDocumento = $fkTcemgTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoDocumento
     */
    public function getFkTcemgTipoDocumento()
    {
        return $this->fkTcemgTipoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PagamentoTipoDocumento
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
