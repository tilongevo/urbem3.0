<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TransferenciaTipoPagamento
 */
class TransferenciaTipoPagamento
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
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\TipoPagamento
     */
    private $fkTcetoTipoPagamento;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaTipoPagamento
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
     * @return TransferenciaTipoPagamento
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
     * @return TransferenciaTipoPagamento
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
     * @return TransferenciaTipoPagamento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TransferenciaTipoPagamento
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
     * ManyToOne (inverse side)
     * Set fkTcetoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TipoPagamento $fkTcetoTipoPagamento
     * @return TransferenciaTipoPagamento
     */
    public function setFkTcetoTipoPagamento(\Urbem\CoreBundle\Entity\Tceto\TipoPagamento $fkTcetoTipoPagamento)
    {
        $this->codTipo = $fkTcetoTipoPagamento->getCodTipo();
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

    /**
     * OneToOne (owning side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaTipoPagamento
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
     * OneToOne (owning side)
     * Get fkTesourariaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencia()
    {
        return $this->fkTesourariaTransferencia;
    }
}
