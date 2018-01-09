<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa
     */
    private $fkTcepbOrcamentoModalidadeDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbOrcamentoModalidadeDespesas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcepbOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa
     * @return ModalidadeDespesa
     */
    public function addFkTcepbOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa)
    {
        if (false === $this->fkTcepbOrcamentoModalidadeDespesas->contains($fkTcepbOrcamentoModalidadeDespesa)) {
            $fkTcepbOrcamentoModalidadeDespesa->setFkTcepbModalidadeDespesa($this);
            $this->fkTcepbOrcamentoModalidadeDespesas->add($fkTcepbOrcamentoModalidadeDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbOrcamentoModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa
     */
    public function removeFkTcepbOrcamentoModalidadeDespesas(\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa $fkTcepbOrcamentoModalidadeDespesa)
    {
        $this->fkTcepbOrcamentoModalidadeDespesas->removeElement($fkTcepbOrcamentoModalidadeDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbOrcamentoModalidadeDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\OrcamentoModalidadeDespesa
     */
    public function getFkTcepbOrcamentoModalidadeDespesas()
    {
        return $this->fkTcepbOrcamentoModalidadeDespesas;
    }
}
