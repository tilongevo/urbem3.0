<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PrevisaoDespesa
 */
class PrevisaoDespesa
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
    private $periodo;

    /**
     * @var integer
     */
    private $vlPrevisto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\PrevisaoOrcamentaria
     */
    private $fkOrcamentoPrevisaoOrcamentaria;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PrevisaoDespesa
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
     * @return PrevisaoDespesa
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
     * Set periodo
     *
     * @param integer $periodo
     * @return PrevisaoDespesa
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set vlPrevisto
     *
     * @param integer $vlPrevisto
     * @return PrevisaoDespesa
     */
    public function setVlPrevisto($vlPrevisto = null)
    {
        $this->vlPrevisto = $vlPrevisto;
        return $this;
    }

    /**
     * Get vlPrevisto
     *
     * @return integer
     */
    public function getVlPrevisto()
    {
        return $this->vlPrevisto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return PrevisaoDespesa
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPrevisaoOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoOrcamentaria $fkOrcamentoPrevisaoOrcamentaria
     * @return PrevisaoDespesa
     */
    public function setFkOrcamentoPrevisaoOrcamentaria(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoOrcamentaria $fkOrcamentoPrevisaoOrcamentaria)
    {
        $this->exercicio = $fkOrcamentoPrevisaoOrcamentaria->getExercicio();
        $this->fkOrcamentoPrevisaoOrcamentaria = $fkOrcamentoPrevisaoOrcamentaria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPrevisaoOrcamentaria
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\PrevisaoOrcamentaria
     */
    public function getFkOrcamentoPrevisaoOrcamentaria()
    {
        return $this->fkOrcamentoPrevisaoOrcamentaria;
    }
}
