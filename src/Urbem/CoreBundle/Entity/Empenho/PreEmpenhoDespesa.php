<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * PreEmpenhoDespesa
 */
class PreEmpenhoDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var integer
     */
    private $codDespesa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return PreEmpenhoDespesa
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PreEmpenhoDespesa
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
     * Set codConta
     *
     * @param integer $codConta
     * @return PreEmpenhoDespesa
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return PreEmpenhoDespesa
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return PreEmpenhoDespesa
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
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return PreEmpenhoDespesa
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return PreEmpenhoDespesa
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicio = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }
}
