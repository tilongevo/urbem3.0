<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwLancamentoTransferencia
 */
class SwLancamentoTransferencia
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
    private $tipo = 'C';

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codDespesa;

    /**
     * @var integer
     */
    private $codTipoTransferencia;

    /**
     * @var boolean
     */
    private $estorno = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTipoTransferencia
     */
    private $fkSwTipoTransferencia;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwLancamentoTransferencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return SwLancamentoTransferencia
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return SwLancamentoTransferencia
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwLancamentoTransferencia
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
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return SwLancamentoTransferencia
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set codTipoTransferencia
     *
     * @param integer $codTipoTransferencia
     * @return SwLancamentoTransferencia
     */
    public function setCodTipoTransferencia($codTipoTransferencia)
    {
        $this->codTipoTransferencia = $codTipoTransferencia;
        return $this;
    }

    /**
     * Get codTipoTransferencia
     *
     * @return integer
     */
    public function getCodTipoTransferencia()
    {
        return $this->codTipoTransferencia;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return SwLancamentoTransferencia
     */
    public function setEstorno($estorno)
    {
        $this->estorno = $estorno;
        return $this;
    }

    /**
     * Get estorno
     *
     * @return boolean
     */
    public function getEstorno()
    {
        return $this->estorno;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\SwTipoTransferencia $fkSwTipoTransferencia
     * @return SwLancamentoTransferencia
     */
    public function setFkSwTipoTransferencia(\Urbem\CoreBundle\Entity\SwTipoTransferencia $fkSwTipoTransferencia)
    {
        $this->codTipoTransferencia = $fkSwTipoTransferencia->getCodTipo();
        $this->exercicio = $fkSwTipoTransferencia->getExercicio();
        $this->fkSwTipoTransferencia = $fkSwTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\SwTipoTransferencia
     */
    public function getFkSwTipoTransferencia()
    {
        return $this->fkSwTipoTransferencia;
    }

    /**
     * OneToOne (owning side)
     * Set SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwLancamentoTransferencia
     */
    public function setFkSwLancamento(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        $this->sequencia = $fkSwLancamento->getSequencia();
        $this->codLote = $fkSwLancamento->getCodLote();
        $this->tipo = $fkSwLancamento->getTipo();
        $this->exercicio = $fkSwLancamento->getExercicio();
        $this->fkSwLancamento = $fkSwLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwLancamento
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamento()
    {
        return $this->fkSwLancamento;
    }
}
