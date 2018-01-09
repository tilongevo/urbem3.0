<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransferenciaOrdemPagamentoRetencao
 */
class TransferenciaOrdemPagamentoRetencao
{
    /**
     * PK
     * @var string
     */
    private $tipo;

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
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * @var integer
     */
    private $sequencial = 1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencao;


    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaOrdemPagamentoRetencao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaOrdemPagamentoRetencao
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
     * @return TransferenciaOrdemPagamentoRetencao
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
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaOrdemPagamentoRetencao
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return TransferenciaOrdemPagamentoRetencao
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return TransferenciaOrdemPagamentoRetencao
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set sequencial
     *
     * @param integer $sequencial
     * @return TransferenciaOrdemPagamentoRetencao
     */
    public function setSequencial($sequencial)
    {
        $this->sequencial = $sequencial;
        return $this;
    }

    /**
     * Get sequencial
     *
     * @return integer
     */
    public function getSequencial()
    {
        return $this->sequencial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return TransferenciaOrdemPagamentoRetencao
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
     * Set fkEmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return TransferenciaOrdemPagamentoRetencao
     */
    public function setFkEmpenhoOrdemPagamentoRetencao(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        $this->exercicio = $fkEmpenhoOrdemPagamentoRetencao->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamentoRetencao->getCodEntidade();
        $this->codOrdem = $fkEmpenhoOrdemPagamentoRetencao->getCodOrdem();
        $this->codPlano = $fkEmpenhoOrdemPagamentoRetencao->getCodPlano();
        $this->sequencial = $fkEmpenhoOrdemPagamentoRetencao->getSequencial();
        $this->fkEmpenhoOrdemPagamentoRetencao = $fkEmpenhoOrdemPagamentoRetencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamentoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    public function getFkEmpenhoOrdemPagamentoRetencao()
    {
        return $this->fkEmpenhoOrdemPagamentoRetencao;
    }
}
