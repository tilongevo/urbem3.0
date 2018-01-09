<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * TipoPagamento
 */
class TipoPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

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
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $tipoPagamento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return TipoPagamento
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TipoPagamento
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
     * @return TipoPagamento
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
     * Set tipo
     *
     * @param string $tipo
     * @return TipoPagamento
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
     * Set tipoPagamento
     *
     * @param string $tipoPagamento
     * @return TipoPagamento
     */
    public function setTipoPagamento($tipoPagamento)
    {
        $this->tipoPagamento = $tipoPagamento;
        return $this;
    }

    /**
     * Get tipoPagamento
     *
     * @return string
     */
    public function getTipoPagamento()
    {
        return $this->tipoPagamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoPagamento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TipoPagamento
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
