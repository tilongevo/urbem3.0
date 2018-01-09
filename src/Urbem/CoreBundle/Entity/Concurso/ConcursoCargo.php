<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * ConcursoCargo
 */
class ConcursoCargo
{
    /**
     * PK
     * @var integer
     */
    private $codEdital;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato
     */
    private $fkConcursoConcursoCandidatos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEdital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkConcursoConcursoCandidatos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEdital
     *
     * @param integer $codEdital
     * @return ConcursoCargo
     */
    public function setCodEdital($codEdital)
    {
        $this->codEdital = $codEdital;
        return $this;
    }

    /**
     * Get codEdital
     *
     * @return integer
     */
    public function getCodEdital()
    {
        return $this->codEdital;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ConcursoCargo
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato
     * @return ConcursoCargo
     */
    public function addFkConcursoConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato)
    {
        if (false === $this->fkConcursoConcursoCandidatos->contains($fkConcursoConcursoCandidato)) {
            $fkConcursoConcursoCandidato->setFkConcursoConcursoCargo($this);
            $this->fkConcursoConcursoCandidatos->add($fkConcursoConcursoCandidato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato
     */
    public function removeFkConcursoConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato)
    {
        $this->fkConcursoConcursoCandidatos->removeElement($fkConcursoConcursoCandidato);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoConcursoCandidatos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato
     */
    public function getFkConcursoConcursoCandidatos()
    {
        return $this->fkConcursoConcursoCandidatos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return ConcursoCargo
     */
    public function setFkConcursoEdital(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        $this->codEdital = $fkConcursoEdital->getCodEdital();
        $this->fkConcursoEdital = $fkConcursoEdital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkConcursoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    public function getFkConcursoEdital()
    {
        return $this->fkConcursoEdital;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return ConcursoCargo
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkPessoalCargo;
    }
}
