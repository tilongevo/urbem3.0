<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoReceita
 */
class LancamentoReceita
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
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * @var boolean
     */
    private $estorno = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LancamentoReceita
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
     * @return LancamentoReceita
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
     * @return LancamentoReceita
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
     * @return LancamentoReceita
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
     * @return LancamentoReceita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return LancamentoReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoReceita
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
     * Set fkContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return LancamentoReceita
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
     * ManyToOne (inverse side)
     * Get fkContabilidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamento()
    {
        return $this->fkContabilidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return LancamentoReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
