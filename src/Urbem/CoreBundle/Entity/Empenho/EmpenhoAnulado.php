<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * EmpenhoAnulado
 */
class EmpenhoAnulado
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem
     */
    private $fkEmpenhoEmpenhoAnuladoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoEmpenhoAnuladoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmpenhoAnulado
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoAnulado
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoAnulado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EmpenhoAnulado
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return EmpenhoAnulado
     */
    public function setMotivo($motivo = null)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoEmpenhoAnuladoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem
     * @return EmpenhoAnulado
     */
    public function addFkEmpenhoEmpenhoAnuladoItens(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem)
    {
        if (false === $this->fkEmpenhoEmpenhoAnuladoItens->contains($fkEmpenhoEmpenhoAnuladoItem)) {
            $fkEmpenhoEmpenhoAnuladoItem->setFkEmpenhoEmpenhoAnulado($this);
            $this->fkEmpenhoEmpenhoAnuladoItens->add($fkEmpenhoEmpenhoAnuladoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAnuladoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem
     */
    public function removeFkEmpenhoEmpenhoAnuladoItens(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem)
    {
        $this->fkEmpenhoEmpenhoAnuladoItens->removeElement($fkEmpenhoEmpenhoAnuladoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAnuladoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem
     */
    public function getFkEmpenhoEmpenhoAnuladoItens()
    {
        return $this->fkEmpenhoEmpenhoAnuladoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return EmpenhoAnulado
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
