<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * EspecificacaoDestinacaoRecurso
 */
class EspecificacaoDestinacaoRecurso
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
    private $codEspecificacao;

    /**
     * @var integer
     */
    private $codFonte;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso
     */
    private $fkOrcamentoFonteRecurso;

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
     * @return EspecificacaoDestinacaoRecurso
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
     * Set codEspecificacao
     *
     * @param integer $codEspecificacao
     * @return EspecificacaoDestinacaoRecurso
     */
    public function setCodEspecificacao($codEspecificacao)
    {
        $this->codEspecificacao = $codEspecificacao;
        return $this;
    }

    /**
     * Get codEspecificacao
     *
     * @return integer
     */
    public function getCodEspecificacao()
    {
        return $this->codEspecificacao;
    }

    /**
     * Set codFonte
     *
     * @param integer $codFonte
     * @return EspecificacaoDestinacaoRecurso
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return EspecificacaoDestinacaoRecurso
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
     * @return EspecificacaoDestinacaoRecurso
     */
    public function addFkOrcamentoRecursoDestinacoes(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        if (false === $this->fkOrcamentoRecursoDestinacoes->contains($fkOrcamentoRecursoDestinacao)) {
            $fkOrcamentoRecursoDestinacao->setFkOrcamentoEspecificacaoDestinacaoRecurso($this);
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso $fkOrcamentoFonteRecurso
     * @return EspecificacaoDestinacaoRecurso
     */
    public function setFkOrcamentoFonteRecurso(\Urbem\CoreBundle\Entity\Orcamento\FonteRecurso $fkOrcamentoFonteRecurso)
    {
        $this->codFonte = $fkOrcamentoFonteRecurso->getCodFonte();
        $this->fkOrcamentoFonteRecurso = $fkOrcamentoFonteRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoFonteRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\FonteRecurso
     */
    public function getFkOrcamentoFonteRecurso()
    {
        return $this->fkOrcamentoFonteRecurso;
    }
}
