<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * RecursoDestinacao
 */
class RecursoDestinacao
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
    private $codRecurso;

    /**
     * @var integer
     */
    private $codUso;

    /**
     * @var integer
     */
    private $codDestinacao;

    /**
     * @var integer
     */
    private $codEspecificacao;

    /**
     * @var integer
     */
    private $codDetalhamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso
     */
    private $fkOrcamentoDetalhamentoDestinacaoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\IdentificadorUso
     */
    private $fkOrcamentoIdentificadorUso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso
     */
    private $fkOrcamentoEspecificacaoDestinacaoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\DestinacaoRecurso
     */
    private $fkOrcamentoDestinacaoRecurso;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RecursoDestinacao
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return RecursoDestinacao
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set codUso
     *
     * @param integer $codUso
     * @return RecursoDestinacao
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
     * Set codDestinacao
     *
     * @param integer $codDestinacao
     * @return RecursoDestinacao
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
     * Set codEspecificacao
     *
     * @param integer $codEspecificacao
     * @return RecursoDestinacao
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
     * Set codDetalhamento
     *
     * @param integer $codDetalhamento
     * @return RecursoDestinacao
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoDetalhamentoDestinacaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso $fkOrcamentoDetalhamentoDestinacaoRecurso
     * @return RecursoDestinacao
     */
    public function setFkOrcamentoDetalhamentoDestinacaoRecurso(\Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso $fkOrcamentoDetalhamentoDestinacaoRecurso)
    {
        $this->exercicio = $fkOrcamentoDetalhamentoDestinacaoRecurso->getExercicio();
        $this->codDetalhamento = $fkOrcamentoDetalhamentoDestinacaoRecurso->getCodDetalhamento();
        $this->fkOrcamentoDetalhamentoDestinacaoRecurso = $fkOrcamentoDetalhamentoDestinacaoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDetalhamentoDestinacaoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\DetalhamentoDestinacaoRecurso
     */
    public function getFkOrcamentoDetalhamentoDestinacaoRecurso()
    {
        return $this->fkOrcamentoDetalhamentoDestinacaoRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoIdentificadorUso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\IdentificadorUso $fkOrcamentoIdentificadorUso
     * @return RecursoDestinacao
     */
    public function setFkOrcamentoIdentificadorUso(\Urbem\CoreBundle\Entity\Orcamento\IdentificadorUso $fkOrcamentoIdentificadorUso)
    {
        $this->exercicio = $fkOrcamentoIdentificadorUso->getExercicio();
        $this->codUso = $fkOrcamentoIdentificadorUso->getCodUso();
        $this->fkOrcamentoIdentificadorUso = $fkOrcamentoIdentificadorUso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoIdentificadorUso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\IdentificadorUso
     */
    public function getFkOrcamentoIdentificadorUso()
    {
        return $this->fkOrcamentoIdentificadorUso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEspecificacaoDestinacaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso
     * @return RecursoDestinacao
     */
    public function setFkOrcamentoEspecificacaoDestinacaoRecurso(\Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso $fkOrcamentoEspecificacaoDestinacaoRecurso)
    {
        $this->exercicio = $fkOrcamentoEspecificacaoDestinacaoRecurso->getExercicio();
        $this->codEspecificacao = $fkOrcamentoEspecificacaoDestinacaoRecurso->getCodEspecificacao();
        $this->fkOrcamentoEspecificacaoDestinacaoRecurso = $fkOrcamentoEspecificacaoDestinacaoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEspecificacaoDestinacaoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\EspecificacaoDestinacaoRecurso
     */
    public function getFkOrcamentoEspecificacaoDestinacaoRecurso()
    {
        return $this->fkOrcamentoEspecificacaoDestinacaoRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDestinacaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DestinacaoRecurso $fkOrcamentoDestinacaoRecurso
     * @return RecursoDestinacao
     */
    public function setFkOrcamentoDestinacaoRecurso(\Urbem\CoreBundle\Entity\Orcamento\DestinacaoRecurso $fkOrcamentoDestinacaoRecurso)
    {
        $this->exercicio = $fkOrcamentoDestinacaoRecurso->getExercicio();
        $this->codDestinacao = $fkOrcamentoDestinacaoRecurso->getCodDestinacao();
        $this->fkOrcamentoDestinacaoRecurso = $fkOrcamentoDestinacaoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDestinacaoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\DestinacaoRecurso
     */
    public function getFkOrcamentoDestinacaoRecurso()
    {
        return $this->fkOrcamentoDestinacaoRecurso;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return RecursoDestinacao
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }
}
