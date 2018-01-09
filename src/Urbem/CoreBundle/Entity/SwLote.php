<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwLote
 */
class SwLote
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * @var string
     */
    private $nomLote;

    /**
     * @var \DateTime
     */
    private $dtLote;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwLote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwLote
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
     * Set tipo
     *
     * @param string $tipo
     * @return SwLote
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set nomLote
     *
     * @param string $nomLote
     * @return SwLote
     */
    public function setNomLote($nomLote)
    {
        $this->nomLote = $nomLote;
        return $this;
    }

    /**
     * Get nomLote
     *
     * @return string
     */
    public function getNomLote()
    {
        return $this->nomLote;
    }

    /**
     * Set dtLote
     *
     * @param \DateTime $dtLote
     * @return SwLote
     */
    public function setDtLote(\DateTime $dtLote)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return \DateTime
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * OneToMany (owning side)
     * Add SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwLote
     */
    public function addFkSwLancamentos(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        if (false === $this->fkSwLancamentos->contains($fkSwLancamento)) {
            $fkSwLancamento->setFkSwLote($this);
            $this->fkSwLancamentos->add($fkSwLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     */
    public function removeFkSwLancamentos(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        $this->fkSwLancamentos->removeElement($fkSwLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamentos()
    {
        return $this->fkSwLancamentos;
    }
}
