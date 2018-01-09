<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * DespesaAcao
 */
class DespesaAcao
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var string
     */
    private $exercicioDespesa;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;


    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return DespesaAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set exercicioDespesa
     *
     * @param string $exercicioDespesa
     * @return DespesaAcao
     */
    public function setExercicioDespesa($exercicioDespesa)
    {
        $this->exercicioDespesa = $exercicioDespesa;
        return $this;
    }

    /**
     * Get exercicioDespesa
     *
     * @return string
     */
    public function getExercicioDespesa()
    {
        return $this->exercicioDespesa;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return DespesaAcao
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
     * Set fkPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return DespesaAcao
     */
    public function setFkPpaAcao(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->codAcao = $fkPpaAcao->getCodAcao();
        $this->fkPpaAcao = $fkPpaAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcao()
    {
        return $this->fkPpaAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return DespesaAcao
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicioDespesa = $fkOrcamentoDespesa->getExercicio();
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
