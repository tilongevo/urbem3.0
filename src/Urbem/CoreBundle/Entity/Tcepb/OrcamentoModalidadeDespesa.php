<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

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
    private $codModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\ModalidadeDespesa
     */
    private $fkTcepbModalidadeDespesa;

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
     * Set fkTcepbModalidadeDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ModalidadeDespesa $fkTcepbModalidadeDespesa
     * @return OrcamentoModalidadeDespesa
     */
    public function setFkTcepbModalidadeDespesa(\Urbem\CoreBundle\Entity\Tcepb\ModalidadeDespesa $fkTcepbModalidadeDespesa)
    {
        $this->exercicio = $fkTcepbModalidadeDespesa->getExercicio();
        $this->codModalidade = $fkTcepbModalidadeDespesa->getCodModalidade();
        $this->fkTcepbModalidadeDespesa = $fkTcepbModalidadeDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbModalidadeDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\ModalidadeDespesa
     */
    public function getFkTcepbModalidadeDespesa()
    {
        return $this->fkTcepbModalidadeDespesa;
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
