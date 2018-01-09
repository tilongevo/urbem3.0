<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * DestinacaoRecurso
 */
class DestinacaoRecurso
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
    private $codDestinacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao
     */
    private $fkOrcamentoRecursoDestinacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoRecursoDestinacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DestinacaoRecurso
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
     * Set codDestinacao
     *
     * @param integer $codDestinacao
     * @return DestinacaoRecurso
     */
    public function setCodDestinacao($codDestinacao)
    {
        $this->codDestinacao = $codDestinacao;
        return $this;
    }

    /**
     * Get codDestinacao
     *
     * @return integer
     */
    public function getCodDestinacao()
    {
        return $this->codDestinacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return DestinacaoRecurso
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoRecursoDestinacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao
     * @return DestinacaoRecurso
     */
    public function addFkOrcamentoRecursoDestinacoes(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        if (false === $this->fkOrcamentoRecursoDestinacoes->contains($fkOrcamentoRecursoDestinacao)) {
            $fkOrcamentoRecursoDestinacao->setFkOrcamentoDestinacaoRecurso($this);
            $this->fkOrcamentoRecursoDestinacoes->add($fkOrcamentoRecursoDestinacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoRecursoDestinacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao
     */
    public function removeFkOrcamentoRecursoDestinacoes(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        $this->fkOrcamentoRecursoDestinacoes->removeElement($fkOrcamentoRecursoDestinacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoRecursoDestinacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao
     */
    public function getFkOrcamentoRecursoDestinacoes()
    {
        return $this->fkOrcamentoRecursoDestinacoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->descricao);
    }
}
