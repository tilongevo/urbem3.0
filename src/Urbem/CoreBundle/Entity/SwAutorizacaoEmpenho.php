<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAutorizacaoEmpenho
 */
class SwAutorizacaoEmpenho
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
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $codReserva;

    /**
     * @var \DateTime
     */
    private $dtAutorizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwAutorizacaoAnulada
     */
    private $fkSwAutorizacaoAnulada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao
     */
    private $fkSwEmpenhoAutorizacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwEmpenhoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwAutorizacaoEmpenho
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
     * @return SwAutorizacaoEmpenho
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return SwAutorizacaoEmpenho
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return SwAutorizacaoEmpenho
     */
    public function setCodReserva($codReserva)
    {
        $this->codReserva = $codReserva;
        return $this;
    }

    /**
     * Get codReserva
     *
     * @return integer
     */
    public function getCodReserva()
    {
        return $this->codReserva;
    }

    /**
     * Set dtAutorizacao
     *
     * @param \DateTime $dtAutorizacao
     * @return SwAutorizacaoEmpenho
     */
    public function setDtAutorizacao(\DateTime $dtAutorizacao)
    {
        $this->dtAutorizacao = $dtAutorizacao;
        return $this;
    }

    /**
     * Get dtAutorizacao
     *
     * @return \DateTime
     */
    public function getDtAutorizacao()
    {
        return $this->dtAutorizacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao
     * @return SwAutorizacaoEmpenho
     */
    public function addFkSwEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao)
    {
        if (false === $this->fkSwEmpenhoAutorizacoes->contains($fkSwEmpenhoAutorizacao)) {
            $fkSwEmpenhoAutorizacao->setFkSwAutorizacaoEmpenho($this);
            $this->fkSwEmpenhoAutorizacoes->add($fkSwEmpenhoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwEmpenhoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao
     */
    public function removeFkSwEmpenhoAutorizacoes(\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao $fkSwEmpenhoAutorizacao)
    {
        $this->fkSwEmpenhoAutorizacoes->removeElement($fkSwEmpenhoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwEmpenhoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenhoAutorizacao
     */
    public function getFkSwEmpenhoAutorizacoes()
    {
        return $this->fkSwEmpenhoAutorizacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwAutorizacaoEmpenho
     */
    public function setFkSwPreEmpenho(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->codPreEmpenho = $fkSwPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwPreEmpenho->getExercicio();
        $this->fkSwPreEmpenho = $fkSwPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenho()
    {
        return $this->fkSwPreEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set SwAutorizacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\SwAutorizacaoAnulada $fkSwAutorizacaoAnulada
     * @return SwAutorizacaoEmpenho
     */
    public function setFkSwAutorizacaoAnulada(\Urbem\CoreBundle\Entity\SwAutorizacaoAnulada $fkSwAutorizacaoAnulada)
    {
        $fkSwAutorizacaoAnulada->setFkSwAutorizacaoEmpenho($this);
        $this->fkSwAutorizacaoAnulada = $fkSwAutorizacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwAutorizacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\SwAutorizacaoAnulada
     */
    public function getFkSwAutorizacaoAnulada()
    {
        return $this->fkSwAutorizacaoAnulada;
    }
}
