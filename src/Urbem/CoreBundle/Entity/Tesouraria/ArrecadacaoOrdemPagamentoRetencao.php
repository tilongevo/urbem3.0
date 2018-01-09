<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ArrecadacaoOrdemPagamentoRetencao
 */
class ArrecadacaoOrdemPagamentoRetencao
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

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
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $sequencial = 1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ArrecadacaoOrdemPagamentoRetencao
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoOrdemPagamentoRetencao
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
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoOrdemPagamentoRetencao
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ArrecadacaoOrdemPagamentoRetencao
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
     * @return ArrecadacaoOrdemPagamentoRetencao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ArrecadacaoOrdemPagamentoRetencao
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
     * Set sequencial
     *
     * @param integer $sequencial
     * @return ArrecadacaoOrdemPagamentoRetencao
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
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return ArrecadacaoOrdemPagamentoRetencao
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return ArrecadacaoOrdemPagamentoRetencao
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
