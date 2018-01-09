<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PrevisaoOrcamentaria
 */
class PrevisaoOrcamentaria
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa
     */
    private $fkOrcamentoPrevisaoDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoPrevisaoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PrevisaoOrcamentaria
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
     * OneToMany (owning side)
     * Add OrcamentoPrevisaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa
     * @return PrevisaoOrcamentaria
     */
    public function addFkOrcamentoPrevisaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa)
    {
        if (false === $this->fkOrcamentoPrevisaoDespesas->contains($fkOrcamentoPrevisaoDespesa)) {
            $fkOrcamentoPrevisaoDespesa->setFkOrcamentoPrevisaoOrcamentaria($this);
            $this->fkOrcamentoPrevisaoDespesas->add($fkOrcamentoPrevisaoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoPrevisaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa
     */
    public function removeFkOrcamentoPrevisaoDespesas(\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa $fkOrcamentoPrevisaoDespesa)
    {
        $this->fkOrcamentoPrevisaoDespesas->removeElement($fkOrcamentoPrevisaoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoPrevisaoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PrevisaoDespesa
     */
    public function getFkOrcamentoPrevisaoDespesas()
    {
        return $this->fkOrcamentoPrevisaoDespesas;
    }
}
