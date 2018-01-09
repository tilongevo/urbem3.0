<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * ConcursoCandidato
 */
class ConcursoCandidato
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
    private $codCandidato;

    /**
     * @var integer
     */
    private $codCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEdital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    private $fkConcursoConcursoCargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    private $fkConcursoCandidato;


    /**
     * Set codEdital
     *
     * @param integer $codEdital
     * @return ConcursoCandidato
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
     * Set codCandidato
     *
     * @param integer $codCandidato
     * @return ConcursoCandidato
     */
    public function setCodCandidato($codCandidato)
    {
        $this->codCandidato = $codCandidato;
        return $this;
    }

    /**
     * Get codCandidato
     *
     * @return integer
     */
    public function getCodCandidato()
    {
        return $this->codCandidato;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ConcursoCandidato
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
     * ManyToOne (inverse side)
     * Set fkConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return ConcursoCandidato
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
     * Set fkConcursoConcursoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo
     * @return ConcursoCandidato
     */
    public function setFkConcursoConcursoCargo(\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo)
    {
        $this->codEdital = $fkConcursoConcursoCargo->getCodEdital();
        $this->codCargo = $fkConcursoConcursoCargo->getCodCargo();
        $this->fkConcursoConcursoCargo = $fkConcursoConcursoCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkConcursoConcursoCargo
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    public function getFkConcursoConcursoCargo()
    {
        return $this->fkConcursoConcursoCargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato
     * @return ConcursoCandidato
     */
    public function setFkConcursoCandidato(\Urbem\CoreBundle\Entity\Concurso\Candidato $fkConcursoCandidato)
    {
        $this->codCandidato = $fkConcursoCandidato->getCodCandidato();
        $this->fkConcursoCandidato = $fkConcursoCandidato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkConcursoCandidato
     *
     * @return \Urbem\CoreBundle\Entity\Concurso\Candidato
     */
    public function getFkConcursoCandidato()
    {
        return $this->fkConcursoCandidato;
    }
}
