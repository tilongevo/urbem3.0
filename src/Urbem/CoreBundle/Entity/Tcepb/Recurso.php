<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * Recurso
 */
class Recurso
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
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    private $fkTcepbTipoOrigemRecurso;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Recurso
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
     * @return Recurso
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Recurso
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoOrigemRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso
     * @return Recurso
     */
    public function setFkTcepbTipoOrigemRecurso(\Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso $fkTcepbTipoOrigemRecurso)
    {
        $this->codTipo = $fkTcepbTipoOrigemRecurso->getCodTipo();
        $this->exercicio = $fkTcepbTipoOrigemRecurso->getExercicio();
        $this->fkTcepbTipoOrigemRecurso = $fkTcepbTipoOrigemRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoOrigemRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoOrigemRecurso
     */
    public function getFkTcepbTipoOrigemRecurso()
    {
        return $this->fkTcepbTipoOrigemRecurso;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return Recurso
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
