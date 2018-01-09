<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * DetalhamentoDestinacaoRecurso
 */
class DetalhamentoDestinacaoRecurso
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
    private $codDetalhamento;

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
     * @return DetalhamentoDestinacaoRecurso
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
     * Set codDetalhamento
     *
     * @param integer $codDetalhamento
     * @return DetalhamentoDestinacaoRecurso
     */
    public function setCodDetalhamento($codDetalhamento)
    {
        $this->codDetalhamento = $codDetalhamento;
        return $this;
    }

    /**
     * Get codDetalhamento
     *
     * @return integer
     */
    public function getCodDetalhamento()
    {
        return $this->codDetalhamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return DetalhamentoDestinacaoRecurso
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
     * @return DetalhamentoDestinacaoRecurso
     */
    public function addFkOrcamentoRecursoDestinacoes(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        if (false === $this->fkOrcamentoRecursoDestinacoes->contains($fkOrcamentoRecursoDestinacao)) {
            $fkOrcamentoRecursoDestinacao->setFkOrcamentoDetalhamentoDestinacaoRecurso($this);
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
    public function getCodigoComposto()
    {
        return str_pad($this->codDetalhamento, 6, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodigoComposto(), $this->descricao);
    }
}
