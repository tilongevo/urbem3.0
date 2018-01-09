<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ContaDebito
 */
class ContaDebito
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
    private $tipoValor = 'D';

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    private $fkContabilidadeValorLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ContaDebito
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
     * @return ContaDebito
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
     * @return ContaDebito
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
     * @return ContaDebito
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
     * @return ContaDebito
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
     * @return ContaDebito
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ContaDebito
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
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return ContaDebito
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento
     * @return ContaDebito
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
     * OneToOne (owning side)
     * Get fkContabilidadeValorLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    public function getFkContabilidadeValorLancamento()
    {
        return $this->fkContabilidadeValorLancamento;
    }
}
