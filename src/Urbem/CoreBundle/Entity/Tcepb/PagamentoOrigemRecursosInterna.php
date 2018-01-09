<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * PagamentoOrigemRecursosInterna
 */
class PagamentoOrigemRecursosInterna
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
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $codOrigemRecursos;

    /**
     * @var string
     */
    private $exercicioOrigemRecurso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    private $fkTcepbTipoOrigemRecurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PagamentoOrigemRecursosInterna
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
     * @return PagamentoOrigemRecursosInterna
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
     * @return PagamentoOrigemRecursosInterna
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
     * Set codOrigemRecursos
     *
     * @param integer $codOrigemRecursos
     * @return PagamentoOrigemRecursosInterna
     */
    public function setCodOrigemRecursos($codOrigemRecursos)
    {
        $this->codOrigemRecursos = $codOrigemRecursos;
        return $this;
    }

    /**
     * Get codOrigemRecursos
     *
     * @return integer
     */
    public function getCodOrigemRecursos()
    {
        return $this->codOrigemRecursos;
    }

    /**
     * Set exercicioOrigemRecurso
     *
     * @param string $exercicioOrigemRecurso
     * @return PagamentoOrigemRecursosInterna
     */
    public function setExercicioOrigemRecurso($exercicioOrigemRecurso)
    {
        $this->exercicioOrigemRecurso = $exercicioOrigemRecurso;
        return $this;
    }

    /**
     * Get exercicioOrigemRecurso
     *
     * @return string
     */
    public function getExercicioOrigemRecurso()
    {
        return $this->exercicioOrigemRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoOrigemRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso
     * @return PagamentoOrigemRecursosInterna
     */
    public function setFkTcepbTipoOrigemRecurso(\Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso)
    {
        $this->codOrigemRecursos = $fkTcepbTipoOrigemRecurso->getCodTipo();
        $this->exercicioOrigemRecurso = $fkTcepbTipoOrigemRecurso->getExercicio();
        $this->fkTcepbTipoOrigemRecurso = $fkTcepbTipoOrigemRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoOrigemRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    public function getFkTcepbTipoOrigemRecurso()
    {
        return $this->fkTcepbTipoOrigemRecurso;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return PagamentoOrigemRecursosInterna
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
     * OneToOne (owning side)
     * Get fkTesourariaPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    public function getFkTesourariaPagamento()
    {
        return $this->fkTesourariaPagamento;
    }
}
