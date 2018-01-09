<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ItemPrestacaoContasAnulado
 */
class ItemPrestacaoContasAnulado
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    private $fkEmpenhoItemPrestacaoContas;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ItemPrestacaoContasAnulado
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ItemPrestacaoContasAnulado
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ItemPrestacaoContasAnulado
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
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemPrestacaoContasAnulado
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
     * OneToOne (owning side)
     * Set EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     * @return ItemPrestacaoContasAnulado
     */
    public function setFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        $this->numItem = $fkEmpenhoItemPrestacaoContas->getNumItem();
        $this->exercicio = $fkEmpenhoItemPrestacaoContas->getExercicio();
        $this->codEntidade = $fkEmpenhoItemPrestacaoContas->getCodEntidade();
        $this->codEmpenho = $fkEmpenhoItemPrestacaoContas->getCodEmpenho();
        $this->fkEmpenhoItemPrestacaoContas = $fkEmpenhoItemPrestacaoContas;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoItemPrestacaoContas
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    public function getFkEmpenhoItemPrestacaoContas()
    {
        return $this->fkEmpenhoItemPrestacaoContas;
    }
}
