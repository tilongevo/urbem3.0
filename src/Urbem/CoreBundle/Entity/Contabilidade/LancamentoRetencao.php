<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoRetencao
 */
class LancamentoRetencao
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
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $codOrdem;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $exercicioRetencao;

    /**
     * @var boolean
     */
    private $estorno = false;

    /**
     * @var integer
     */
    private $sequencial = 1;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LancamentoRetencao
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
     * @return LancamentoRetencao
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
     * @return LancamentoRetencao
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
     * @return LancamentoRetencao
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
     * @return LancamentoRetencao
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return LancamentoRetencao
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return LancamentoRetencao
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
     * Set exercicioRetencao
     *
     * @param string $exercicioRetencao
     * @return LancamentoRetencao
     */
    public function setExercicioRetencao($exercicioRetencao)
    {
        $this->exercicioRetencao = $exercicioRetencao;
        return $this;
    }

    /**
     * Get exercicioRetencao
     *
     * @return string
     */
    public function getExercicioRetencao()
    {
        return $this->exercicioRetencao;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoRetencao
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
     * Set sequencial
     *
     * @param integer $sequencial
     * @return LancamentoRetencao
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
     * Set fkEmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return LancamentoRetencao
     */
    public function setFkEmpenhoOrdemPagamentoRetencao(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        $this->exercicioRetencao = $fkEmpenhoOrdemPagamentoRetencao->getExercicio();
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

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return LancamentoRetencao
     */
    public function setFkContabilidadeLancamento(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        $this->sequencia = $fkContabilidadeLancamento->getSequencia();
        $this->codLote = $fkContabilidadeLancamento->getCodLote();
        $this->tipo = $fkContabilidadeLancamento->getTipo();
        $this->exercicio = $fkContabilidadeLancamento->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamento->getCodEntidade();
        $this->fkContabilidadeLancamento = $fkContabilidadeLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamento()
    {
        return $this->fkContabilidadeLancamento;
    }
}
