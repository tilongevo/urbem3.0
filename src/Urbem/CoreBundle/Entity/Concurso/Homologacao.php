<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * Homologacao
 */
class Homologacao
{
    /**
     * PK
     * @var integer
     */
    private $codEdital;

    /**
     * @var integer
     */
    private $codHomologacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Edital
     */
    private $fkConcursoEdital;

    /**
     * Set codEdital
     *
     * @param integer $codEdital
     * @return Homologacao
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
     * Set codHomologacao
     *
     * @param integer $codHomologacao
     * @return Homologacao
     */
    public function setCodHomologacao($codHomologacao)
    {
        $this->codHomologacao = $codHomologacao;
        return $this;
    }

    /**
     * Get codHomologacao
     *
     * @return integer
     */
    public function getCodHomologacao()
    {
        return $this->codHomologacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Homologacao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codHomologacao = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkConcursoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital
     * @return Homologacao
     */
    public function setFkConcursoEdital(\Urbem\CoreBundle\Entity\Concurso\Edital $fkConcursoEdital)
    {
        $this->codEdital = $fkConcursoEdital->getCodEdital();
        $this->fkConcursoEdital = $fkConcursoEdital;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|Edital
     */
    public function getFkConcursoEdital()
    {
        return $this->fkConcursoEdital;
    }
}
