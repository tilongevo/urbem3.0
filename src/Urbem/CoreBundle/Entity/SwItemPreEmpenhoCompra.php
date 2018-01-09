<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwItemPreEmpenhoCompra
 */
class SwItemPreEmpenhoCompra
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
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $codLicitacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    private $fkSwItemPreEmpenho;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwItemPreEmpenhoCompra
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
     * @return SwItemPreEmpenhoCompra
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
     * @return SwItemPreEmpenhoCompra
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
     * Set codItem
     *
     * @param integer $codItem
     * @return SwItemPreEmpenhoCompra
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return SwItemPreEmpenhoCompra
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * OneToOne (owning side)
     * Set SwItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho
     * @return SwItemPreEmpenhoCompra
     */
    public function setFkSwItemPreEmpenho(\Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkSwItemPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwItemPreEmpenho->getExercicio();
        $this->numItem = $fkSwItemPreEmpenho->getNumItem();
        $this->fkSwItemPreEmpenho = $fkSwItemPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwItemPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    public function getFkSwItemPreEmpenho()
    {
        return $this->fkSwItemPreEmpenho;
    }
}
