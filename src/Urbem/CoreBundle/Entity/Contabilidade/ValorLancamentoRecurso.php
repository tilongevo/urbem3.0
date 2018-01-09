<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ValorLancamentoRecurso
 */
class ValorLancamentoRecurso
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
    private $tipo;

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
     * PK
     * @var string
     */
    private $tipoValor;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * @var integer
     */
    private $vlRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    private $fkContabilidadeValorLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ValorLancamentoRecurso
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
     * @return ValorLancamentoRecurso
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
     * @return ValorLancamentoRecurso
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
     * @return ValorLancamentoRecurso
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
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return ValorLancamentoRecurso
     */
    public function setTipoValor($tipoValor)
    {
        $this->tipoValor = $tipoValor;
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return string
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ValorLancamentoRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return ValorLancamentoRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set vlRecurso
     *
     * @param integer $vlRecurso
     * @return ValorLancamentoRecurso
     */
    public function setVlRecurso($vlRecurso)
    {
        $this->vlRecurso = $vlRecurso;
        return $this;
    }

    /**
     * Get vlRecurso
     *
     * @return integer
     */
    public function getVlRecurso()
    {
        return $this->vlRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento
     * @return ValorLancamentoRecurso
     */
    public function setFkContabilidadeValorLancamento(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento)
    {
        $this->codLote = $fkContabilidadeValorLancamento->getCodLote();
        $this->tipo = $fkContabilidadeValorLancamento->getTipo();
        $this->sequencia = $fkContabilidadeValorLancamento->getSequencia();
        $this->exercicio = $fkContabilidadeValorLancamento->getExercicio();
        $this->tipoValor = $fkContabilidadeValorLancamento->getTipoValor();
        $this->codEntidade = $fkContabilidadeValorLancamento->getCodEntidade();
        $this->fkContabilidadeValorLancamento = $fkContabilidadeValorLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeValorLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    public function getFkContabilidadeValorLancamento()
    {
        return $this->fkContabilidadeValorLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return ValorLancamentoRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }
}
