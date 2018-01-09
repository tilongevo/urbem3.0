<?php
 
namespace Urbem\CoreBundle\Entity\Concurso;

/**
 * Edital
 */
class Edital
{
    const PROVA_TEORICA = 1;
    const PROVA_TEORICA_PRATICA = 2;

    /**
     * PK
     * @var integer
     */
    private $codEdital;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtAplicacao;

    /**
     * @var \DateTime
     */
    private $dtProrrogacao;

    /**
     * @var integer
     */
    private $notaMinima;

    /**
     * @var integer
     */
    private $mesesValidade;

    /**
     * @var boolean
     */
    private $avaliaTitulacao;

    /**
     * @var string
     */
    private $tipoProva;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    private $fkConcursoConcursoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor
     */
    private $fkConcursoAtributoConcursoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato
     */
    private $fkConcursoConcursoCandidatos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Homologacao
     */
    private $fkConcursoHomologacoes;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkConcursoConcursoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoAtributoConcursoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoConcursoCandidatos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkConcursoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEdital
     *
     * @param integer $codEdital
     * @return Edital
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Edital
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dtAplicacao
     *
     * @param \DateTime $dtAplicacao
     * @return Edital
     */
    public function setDtAplicacao(\DateTime $dtAplicacao)
    {
        $this->dtAplicacao = $dtAplicacao;
        return $this;
    }

    /**
     * Get dtAplicacao
     *
     * @return \DateTime
     */
    public function getDtAplicacao()
    {
        return $this->dtAplicacao;
    }

    /**
     * Set dtProrrogacao
     *
     * @param \DateTime $dtProrrogacao
     * @return Edital
     */
    public function setDtProrrogacao(\DateTime $dtProrrogacao = null)
    {
        $this->dtProrrogacao = $dtProrrogacao;
        return $this;
    }

    /**
     * Get dtProrrogacao
     *
     * @return \DateTime
     */
    public function getDtProrrogacao()
    {
        return $this->dtProrrogacao;
    }

    /**
     * Set notaMinima
     *
     * @param integer $notaMinima
     * @return Edital
     */
    public function setNotaMinima($notaMinima)
    {
        $this->notaMinima = $notaMinima;
        return $this;
    }

    /**
     * Get notaMinima
     *
     * @return integer
     */
    public function getNotaMinima()
    {
        return $this->notaMinima;
    }

    /**
     * Set mesesValidade
     *
     * @param integer $mesesValidade
     * @return Edital
     */
    public function setMesesValidade($mesesValidade)
    {
        $this->mesesValidade = $mesesValidade;
        return $this;
    }

    /**
     * Get mesesValidade
     *
     * @return integer
     */
    public function getMesesValidade()
    {
        return $this->mesesValidade;
    }

    /**
     * Set avaliaTitulacao
     *
     * @param boolean $avaliaTitulacao
     * @return Edital
     */
    public function setAvaliaTitulacao($avaliaTitulacao)
    {
        $this->avaliaTitulacao = $avaliaTitulacao;
        return $this;
    }

    /**
     * Get avaliaTitulacao
     *
     * @return boolean
     */
    public function getAvaliaTitulacao()
    {
        return $this->avaliaTitulacao;
    }

    /**
     * Set tipoProva
     *
     * @param string $tipoProva
     * @return Edital
     */
    public function setTipoProva($tipoProva)
    {
        $this->tipoProva = $tipoProva;
        return $this;
    }

    /**
     * Get tipoProva
     *
     * @return string
     */
    public function getTipoProva()
    {
        return $this->tipoProva;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoConcursoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo
     * @return Edital
     */
    public function addFkConcursoConcursoCargos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo)
    {
        if (false === $this->fkConcursoConcursoCargos->contains($fkConcursoConcursoCargo)) {
            $fkConcursoConcursoCargo->setFkConcursoEdital($this);
            $this->fkConcursoConcursoCargos->add($fkConcursoConcursoCargo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoConcursoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo
     */
    public function removeFkConcursoConcursoCargos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo $fkConcursoConcursoCargo)
    {
        $this->fkConcursoConcursoCargos->removeElement($fkConcursoConcursoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoConcursoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\ConcursoCargo
     */
    public function getFkConcursoConcursoCargos()
    {
        return $this->fkConcursoConcursoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoAtributoConcursoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor
     * @return Edital
     */
    public function addFkConcursoAtributoConcursoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor)
    {
        if (false === $this->fkConcursoAtributoConcursoValores->contains($fkConcursoAtributoConcursoValor)) {
            $fkConcursoAtributoConcursoValor->setFkConcursoEdital($this);
            $this->fkConcursoAtributoConcursoValores->add($fkConcursoAtributoConcursoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoAtributoConcursoValor
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor
     */
    public function removeFkConcursoAtributoConcursoValores(\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor $fkConcursoAtributoConcursoValor)
    {
        $this->fkConcursoAtributoConcursoValores->removeElement($fkConcursoAtributoConcursoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoAtributoConcursoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\AtributoConcursoValor
     */
    public function getFkConcursoAtributoConcursoValores()
    {
        return $this->fkConcursoAtributoConcursoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoConcursoCandidato
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato
     * @return Edital
     */
    public function addFkConcursoConcursoCandidatos(\Urbem\CoreBundle\Entity\Concurso\ConcursoCandidato $fkConcursoConcursoCandidato)
    {
        if (false === $this->fkConcursoConcursoCandidatos->contains($fkConcursoConcursoCandidato)) {
            $fkConcursoConcursoCandidato->setFkConcursoEdital($this);
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
     * Set fkNormasNorma1
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1
     * @return Edital
     */
    public function setFkNormasNorma1(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1)
    {
        $this->codNorma = $fkNormasNorma1->getCodNorma();
        $this->fkNormasNorma1 = $fkNormasNorma1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma1
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma1()
    {
        return $this->fkNormasNorma1;
    }

    /**
     * OneToOne (owning side)
     * Set NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Edital
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codEdital = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToMany (owning side)
     * Get fkConcursoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Concurso\Homologacao
     */
    public function getFkConcursoHomologacoes()
    {
        return $this->fkConcursoHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Set fkConcursoHomologacoes
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacoes
     * @return Homologacao
     */
    public function setFkConcursoHomologacoes($fkConcursoHomologacoes)
    {
        $this->fkConcursoHomologacoes = $fkConcursoHomologacoes;
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add ConcursoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao
     * @return Edital
     */
    public function addFkConcursoHomologacoes(\Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao)
    {
        if ($fkConcursoHomologacao) {
            $fkConcursoHomologacao->setFkConcursoEdital($this);
            $this->fkConcursoHomologacoes->add($fkConcursoHomologacao);
        }
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ConcursoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao
     */
    public function removeFkConcursoHomologacoes(\Urbem\CoreBundle\Entity\Concurso\Homologacao $fkConcursoHomologacao)
    {
        $this->fkConcursoHomologacoes->removeElement($fkConcursoHomologacao);
    }

    /**
     * @return string
     */
    public function getNormaExercicioDescricao()
    {
        return sprintf('%d/%s - %s', $this->fkNormasNorma->getCodNorma(), $this->fkNormasNorma->getExercicio(), $this->fkNormasNorma->getDescricao());
    }

    /**
     * @return string
     */
    public function getTipoNormaExercicioDescricao()
    {
        return sprintf('%d/%s - %s', $this->fkNormasNorma1->getCodNorma(), $this->fkNormasNorma1->getExercicio(), $this->fkNormasNorma1->getDescricao());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codNorma;
    }
}
