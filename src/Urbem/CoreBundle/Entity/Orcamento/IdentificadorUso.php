<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * IdentificadorUso
 */
class IdentificadorUso
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
    private $codUso;

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
     * @return IdentificadorUso
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
     * Set codUso
     *
     * @param integer $codUso
     * @return IdentificadorUso
     */
    public function setCodUso($codUso)
    {
        $this->codUso = $codUso;
        return $this;
    }

    /**
     * Get codUso
     *
     * @return integer
     */
    public function getCodUso()
    {
        return $this->codUso;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return IdentificadorUso
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
     * @return IdentificadorUso
     */
    public function addFkOrcamentoRecursoDestinacoes(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        if (false === $this->fkOrcamentoRecursoDestinacoes->contains($fkOrcamentoRecursoDestinacao)) {
            $fkOrcamentoRecursoDestinacao->setFkOrcamentoIdentificadorUso($this);
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
}
