<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * ManutencaoItem
 */
class ManutencaoItem
{
    /**
     * PK
     * @var integer
     */
    private $codManutencao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    private $fkFrotaManutencao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Item
     */
    private $fkFrotaItem;


    /**
     * Set codManutencao
     *
     * @param integer $codManutencao
     * @return ManutencaoItem
     */
    public function setCodManutencao($codManutencao)
    {
        $this->codManutencao = $codManutencao;
        return $this;
    }

    /**
     * Get codManutencao
     *
     * @return integer
     */
    public function getCodManutencao()
    {
        return $this->codManutencao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return ManutencaoItem
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ManutencaoItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ManutencaoItem
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ManutencaoItem
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaManutencao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao
     * @return ManutencaoItem
     */
    public function setFkFrotaManutencao(\Urbem\CoreBundle\Entity\Frota\Manutencao $fkFrotaManutencao)
    {
        $this->codManutencao = $fkFrotaManutencao->getCodManutencao();
        $this->exercicio = $fkFrotaManutencao->getExercicio();
        $this->fkFrotaManutencao = $fkFrotaManutencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaManutencao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Manutencao
     */
    public function getFkFrotaManutencao()
    {
        return $this->fkFrotaManutencao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return ManutencaoItem
     */
    public function setFkFrotaItem(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        $this->codItem = $fkFrotaItem->getCodItem();
        $this->fkFrotaItem = $fkFrotaItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Item
     */
    public function getFkFrotaItem()
    {
        return $this->fkFrotaItem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s',
            $this->fkFrotaItem
        );
    }
}
