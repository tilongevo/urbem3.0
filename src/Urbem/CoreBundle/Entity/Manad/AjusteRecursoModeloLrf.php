<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

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
     * @var \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    private $fkManadRecursoModeloLrf;


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
     * Set fkManadRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf
     * @return AjusteRecursoModeloLrf
     */
    public function setFkManadRecursoModeloLrf(\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf)
    {
        $this->exercicio = $fkManadRecursoModeloLrf->getExercicio();
        $this->codModelo = $fkManadRecursoModeloLrf->getCodModelo();
        $this->codQuadro = $fkManadRecursoModeloLrf->getCodQuadro();
        $this->codRecurso = $fkManadRecursoModeloLrf->getCodRecurso();
        $this->fkManadRecursoModeloLrf = $fkManadRecursoModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkManadRecursoModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    public function getFkManadRecursoModeloLrf()
    {
        return $this->fkManadRecursoModeloLrf;
    }
}
