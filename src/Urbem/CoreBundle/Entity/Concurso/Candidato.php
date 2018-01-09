<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * Candidato
 */
class Candidato
{
    /**
     * PK
     * @var integer
     */
    private $codCandidato;

    /**
     * @var integer
     */
    private $classificacao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $notaProva;

    /**
     * @var integer
     */
    private $notaTitulacao;

    /**
     * @var boolean
     */
    private $reclassificado = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor
     */
    private $fkConcursoAtributoCandidatoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato
     */
    private $fkConcursoConcursoCandidatos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkConcursoAtributoCandidatoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoConcursoCandidatos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCandidato
     *
     * @param integer $codCandidato
     * @return Candidato
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
     * Set classificacao
     *
     * @param integer $classificacao
     * @return Candidato
     */
    public function setClassificacao($classificacao = null)
    {
        $this->classificacao = $classificacao;
        return $this;
    }

    /**
     * Get classificacao
     *
     * @return integer
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Candidato
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set notaProva
     *
     * @param integer $notaProva
     * @return Candidato
     */
    public function setNotaProva($notaProva = null)
    {
        $this->notaProva = $notaProva;
        return $this;
    }

    /**
     * Get notaProva
     *
     * @return integer
     */
    public function getNotaProva()
    {
        return $this->notaProva;
    }

    /**
     * Set notaTitulacao
     *
     * @param integer $notaTitulacao
     * @return Candidato
     */
    public function setNotaTitulacao($notaTitulacao = null)
    {
        $this->notaTitulacao = $notaTitulacao;
        return $this;
    }

    /**
     * Get notaTitulacao
     *
     * @return integer
     */
    public function getNotaTitulacao()
    {
        return $this->notaTitulacao;
    }

    /**
     * Set reclassificado
     *
     * @param boolean $reclassificado
     * @return Candidato
     */
    public function setReclassificado($reclassificado = null)
    {
        $this->reclassificado = $reclassificado;
        return $this;
    }

    /**
     * Get reclassificado
     *
     * @return boolean
     */
    public function getReclassificado()
    {
        return $this->reclassificado;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoAtributoCandidatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor
     * @return Candidato
     */
    public function addFkConcursoAtributoCandidatoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor)
    {
        if (false === $this->fkConcursoAtributoCandidatoValores->contains($fkConcursoAtributoCandidatoValor)) {
            $fkConcursoAtributoCandidatoValor->setFkConcursoCandidato($this);
            $this->fkConcursoAtributoCandidatoValores->add($fkConcursoAtributoCandidatoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoAtributoCandidatoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor
     */
    public function removeFkConcursoAtributoCandidatoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor $fkConcursoAtributoCandidatoValor)
    {
        $this->fkConcursoAtributoCandidatoValores->removeElement($fkConcursoAtributoCandidatoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoAtributoCandidatoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoCandidatoValor
     */
    public function getFkConcursoAtributoCandidatoValores()
    {
        return $this->fkConcursoAtributoCandidatoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato
     * @return Candidato
     */
    public function addFkConcursoConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato)
    {
        if (false === $this->fkConcursoConcursoCandidatos->contains($fkConcursoConcursoCandidato)) {
            $fkConcursoConcursoCandidato->setFkConcursoCandidato($this);
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
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Candidato
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }
}
