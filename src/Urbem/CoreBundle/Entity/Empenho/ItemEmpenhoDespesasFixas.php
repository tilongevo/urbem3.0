<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ItemEmpenhoDespesasFixas
 */
class ItemEmpenhoDespesasFixas
{
    /**
     * PK
     * @var integer
     */
    private $numItem;

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
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * PK
     * @var integer
     */
    private $codDespesaFixa;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $consumo;

    /**
     * @var \DateTime
     */
    private $dtDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;


    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemEmpenhoDespesasFixas
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return ItemEmpenhoDespesasFixas
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
     * @return ItemEmpenhoDespesasFixas
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
     * @return ItemEmpenhoDespesasFixas
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
     * Set codDespesaFixa
     *
     * @param integer $codDespesaFixa
     * @return ItemEmpenhoDespesasFixas
     */
    public function setCodDespesaFixa($codDespesaFixa)
    {
        $this->codDespesaFixa = $codDespesaFixa;
        return $this;
    }

    /**
     * Get codDespesaFixa
     *
     * @return integer
     */
    public function getCodDespesaFixa()
    {
        return $this->codDespesaFixa;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ItemEmpenhoDespesasFixas
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
     * Set consumo
     *
     * @param string $consumo
     * @return ItemEmpenhoDespesasFixas
     */
    public function setConsumo($consumo = null)
    {
        $this->consumo = $consumo;
        return $this;
    }

    /**
     * Get consumo
     *
     * @return string
     */
    public function getConsumo()
    {
        return $this->consumo;
    }

    /**
     * Set dtDocumento
     *
     * @param \DateTime $dtDocumento
     * @return ItemEmpenhoDespesasFixas
     */
    public function setDtDocumento(\DateTime $dtDocumento = null)
    {
        $this->dtDocumento = $dtDocumento;
        return $this;
    }

    /**
     * Get dtDocumento
     *
     * @return \DateTime
     */
    public function getDtDocumento()
    {
        return $this->dtDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return ItemEmpenhoDespesasFixas
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkEmpenhoItemPreEmpenho->getExercicio();
        $this->numItem = $fkEmpenhoItemPreEmpenho->getNumItem();
        $this->fkEmpenhoItemPreEmpenho = $fkEmpenhoItemPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoItemPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenho()
    {
        return $this->fkEmpenhoItemPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return ItemEmpenhoDespesasFixas
     */
    public function setFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        $this->codDespesaFixa = $fkEmpenhoDespesasFixas->getCodDespesaFixa();
        $this->codDespesa = $fkEmpenhoDespesasFixas->getCodDespesa();
        $this->exercicio = $fkEmpenhoDespesasFixas->getExercicio();
        $this->codEntidade = $fkEmpenhoDespesasFixas->getCodEntidade();
        $this->fkEmpenhoDespesasFixas = $fkEmpenhoDespesasFixas;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoDespesasFixas
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    public function getFkEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoDespesasFixas;
    }
}
