<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoItem
 */
class NotaLiquidacaoItem
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
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * PK
     * @var string
     */
    private $exercicioItem;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado
     */
    private $fkEmpenhoNotaLiquidacaoItemAnulados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoNotaLiquidacaoItemAnulados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoItem
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoItem
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return NotaLiquidacaoItem
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
     * Set exercicioItem
     *
     * @param string $exercicioItem
     * @return NotaLiquidacaoItem
     */
    public function setExercicioItem($exercicioItem)
    {
        $this->exercicioItem = $exercicioItem;
        return $this;
    }

    /**
     * Get exercicioItem
     *
     * @return string
     */
    public function getExercicioItem()
    {
        return $this->exercicioItem;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return NotaLiquidacaoItem
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoItem
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
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return NotaLiquidacaoItem
     */
    public function setVlTotal($vlTotal)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoItemAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado $fkEmpenhoNotaLiquidacaoItemAnulado
     * @return NotaLiquidacaoItem
     */
    public function addFkEmpenhoNotaLiquidacaoItemAnulados(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado $fkEmpenhoNotaLiquidacaoItemAnulado)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoItemAnulados->contains($fkEmpenhoNotaLiquidacaoItemAnulado)) {
            $fkEmpenhoNotaLiquidacaoItemAnulado->setFkEmpenhoNotaLiquidacaoItem($this);
            $this->fkEmpenhoNotaLiquidacaoItemAnulados->add($fkEmpenhoNotaLiquidacaoItemAnulado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoItemAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado $fkEmpenhoNotaLiquidacaoItemAnulado
     */
    public function removeFkEmpenhoNotaLiquidacaoItemAnulados(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado $fkEmpenhoNotaLiquidacaoItemAnulado)
    {
        $this->fkEmpenhoNotaLiquidacaoItemAnulados->removeElement($fkEmpenhoNotaLiquidacaoItemAnulado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoItemAnulados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado
     */
    public function getFkEmpenhoNotaLiquidacaoItemAnulados()
    {
        return $this->fkEmpenhoNotaLiquidacaoItemAnulados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaLiquidacaoItem
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return NotaLiquidacaoItem
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicioItem = $fkEmpenhoItemPreEmpenho->getExercicio();
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
}
