<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * PrestacaoContas
 */
class PrestacaoContas
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
     * @var \DateTime
     */
    private $data;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    private $fkEmpenhoItemPrestacaoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoItemPrestacaoContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->data = new \DateTime;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return PrestacaoContas
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
     * @return PrestacaoContas
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
     * @return PrestacaoContas
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
     * Set data
     *
     * @param \DateTime $data
     * @return PrestacaoContas
     */
    public function setData(\DateTime $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     * @return PrestacaoContas
     */
    public function addFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        if (false === $this->fkEmpenhoItemPrestacaoContas->contains($fkEmpenhoItemPrestacaoContas)) {
            $fkEmpenhoItemPrestacaoContas->setFkEmpenhoPrestacaoContas($this);
            $this->fkEmpenhoItemPrestacaoContas->add($fkEmpenhoItemPrestacaoContas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     */
    public function removeFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        $this->fkEmpenhoItemPrestacaoContas->removeElement($fkEmpenhoItemPrestacaoContas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPrestacaoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    public function getFkEmpenhoItemPrestacaoContas()
    {
        return $this->fkEmpenhoItemPrestacaoContas;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return PrestacaoContas
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
     * OneToOne (owning side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
