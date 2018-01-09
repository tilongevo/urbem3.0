<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * OrcamentoModalidadeDespesa
 */
class OrcamentoModalidadeDespesa
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\ModalidadeDespesa
     */
    private $fkTcepeModalidadeDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrcamentoModalidadeDespesa
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
     * @return OrcamentoModalidadeDespesa
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return OrcamentoModalidadeDespesa
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return OrcamentoModalidadeDespesa
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\ModalidadeDespesa $fkTcepeModalidadeDespesa
     * @return OrcamentoModalidadeDespesa
     */
    public function setFkTcepeModalidadeDespesa(\Urbem\CoreBundle\Entity\Tcepe\ModalidadeDespesa $fkTcepeModalidadeDespesa)
    {
        $this->exercicio = $fkTcepeModalidadeDespesa->getExercicio();
        $this->codModalidade = $fkTcepeModalidadeDespesa->getCodModalidade();
        $this->fkTcepeModalidadeDespesa = $fkTcepeModalidadeDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeModalidadeDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\ModalidadeDespesa
     */
    public function getFkTcepeModalidadeDespesa()
    {
        return $this->fkTcepeModalidadeDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return OrcamentoModalidadeDespesa
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return OrcamentoModalidadeDespesa
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicio = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }
}
