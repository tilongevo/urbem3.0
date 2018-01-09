<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * ModalidadeDespesa
 */
class ModalidadeDespesa
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
    private $codModalidade;

    /**
     * @var string
     */
    private $modalidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    private $fkTcepeOrcamentoModalidadeDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeOrcamentoModalidadeDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ModalidadeDespesa
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeDespesa
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
     * Set modalidade
     *
     * @param string $modalidade
     * @return ModalidadeDespesa
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;
        return $this;
    }

    /**
     * Get modalidade
     *
     * @return string
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     * @return ModalidadeDespesa
     */
    public function addFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        if (false === $this->fkTcepeOrcamentoModalidadeDespesas->contains($fkTcepeOrcamentoModalidadeDespesa)) {
            $fkTcepeOrcamentoModalidadeDespesa->setFkTcepeModalidadeDespesa($this);
            $this->fkTcepeOrcamentoModalidadeDespesas->add($fkTcepeOrcamentoModalidadeDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa
     */
    public function removeFkTcepeOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa $fkTcepeOrcamentoModalidadeDespesa)
    {
        $this->fkTcepeOrcamentoModalidadeDespesas->removeElement($fkTcepeOrcamentoModalidadeDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeOrcamentoModalidadeDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\OrcamentoModalidadeDespesa
     */
    public function getFkTcepeOrcamentoModalidadeDespesas()
    {
        return $this->fkTcepeOrcamentoModalidadeDespesas;
    }
}
