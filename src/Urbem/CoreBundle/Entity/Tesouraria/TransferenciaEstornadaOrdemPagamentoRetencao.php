<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransferenciaEstornadaOrdemPagamentoRetencao
 */
class TransferenciaEstornadaOrdemPagamentoRetencao
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
    private $tipo;

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
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    private $fkTesourariaTransferenciaEstornada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencao;


    /**
     * Set codLoteEstorno
     *
     * @param integer $codLoteEstorno
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
     * Set fkTesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
     */
    public function setFkTesourariaTransferenciaEstornada(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        $this->codLoteEstorno = $fkTesourariaTransferenciaEstornada->getCodLoteEstorno();
        $this->exercicio = $fkTesourariaTransferenciaEstornada->getExercicio();
        $this->codEntidade = $fkTesourariaTransferenciaEstornada->getCodEntidade();
        $this->tipo = $fkTesourariaTransferenciaEstornada->getTipo();
        $this->codLote = $fkTesourariaTransferenciaEstornada->getCodLote();
        $this->fkTesourariaTransferenciaEstornada = $fkTesourariaTransferenciaEstornada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaTransferenciaEstornada
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    public function getFkTesourariaTransferenciaEstornada()
    {
        return $this->fkTesourariaTransferenciaEstornada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return TransferenciaEstornadaOrdemPagamentoRetencao
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
