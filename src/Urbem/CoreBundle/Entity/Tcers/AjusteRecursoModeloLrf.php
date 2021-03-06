<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * AjusteRecursoModeloLrf
 */
class AjusteRecursoModeloLrf
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
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codQuadro;

    /**
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    private $fkTcersRecursoModeloLrf;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AjusteRecursoModeloLrf
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
     * Set codModelo
     *
     * @param integer $codModelo
     * @return AjusteRecursoModeloLrf
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codQuadro
     *
     * @param integer $codQuadro
     * @return AjusteRecursoModeloLrf
     */
    public function setCodQuadro($codQuadro)
    {
        $this->codQuadro = $codQuadro;
        return $this;
    }

    /**
     * Get codQuadro
     *
     * @return integer
     */
    public function getCodQuadro()
    {
        return $this->codQuadro;
    }

    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return AjusteRecursoModeloLrf
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AjusteRecursoModeloLrf
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return AjusteRecursoModeloLrf
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return AjusteRecursoModeloLrf
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf
     * @return AjusteRecursoModeloLrf
     */
    public function setFkTcersRecursoModeloLrf(\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf)
    {
        $this->exercicio = $fkTcersRecursoModeloLrf->getExercicio();
        $this->codModelo = $fkTcersRecursoModeloLrf->getCodModelo();
        $this->codQuadro = $fkTcersRecursoModeloLrf->getCodQuadro();
        $this->codRecurso = $fkTcersRecursoModeloLrf->getCodRecurso();
        $this->fkTcersRecursoModeloLrf = $fkTcersRecursoModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcersRecursoModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    public function getFkTcersRecursoModeloLrf()
    {
        return $this->fkTcersRecursoModeloLrf;
    }
}
