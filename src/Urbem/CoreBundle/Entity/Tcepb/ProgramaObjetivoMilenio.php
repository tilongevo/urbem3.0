<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * ProgramaObjetivoMilenio
 */
class ProgramaObjetivoMilenio
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipoObjetivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    private $fkOrcamentoPrograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoObjetivoMilenio
     */
    private $fkTcepbTipoObjetivoMilenio;


    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaObjetivoMilenio
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProgramaObjetivoMilenio
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
     * Set codTipoObjetivo
     *
     * @param integer $codTipoObjetivo
     * @return ProgramaObjetivoMilenio
     */
    public function setCodTipoObjetivo($codTipoObjetivo)
    {
        $this->codTipoObjetivo = $codTipoObjetivo;
        return $this;
    }

    /**
     * Get codTipoObjetivo
     *
     * @return integer
     */
    public function getCodTipoObjetivo()
    {
        return $this->codTipoObjetivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoObjetivoMilenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoObjetivoMilenio $fkTcepbTipoObjetivoMilenio
     * @return ProgramaObjetivoMilenio
     */
    public function setFkTcepbTipoObjetivoMilenio(\Urbem\CoreBundle\Entity\Tcepb\TipoObjetivoMilenio $fkTcepbTipoObjetivoMilenio)
    {
        $this->codTipoObjetivo = $fkTcepbTipoObjetivoMilenio->getCodTipoObjetivo();
        $this->fkTcepbTipoObjetivoMilenio = $fkTcepbTipoObjetivoMilenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoObjetivoMilenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoObjetivoMilenio
     */
    public function getFkTcepbTipoObjetivoMilenio()
    {
        return $this->fkTcepbTipoObjetivoMilenio;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma
     * @return ProgramaObjetivoMilenio
     */
    public function setFkOrcamentoPrograma(\Urbem\CoreBundle\Entity\Orcamento\Programa $fkOrcamentoPrograma)
    {
        $this->exercicio = $fkOrcamentoPrograma->getExercicio();
        $this->codPrograma = $fkOrcamentoPrograma->getCodPrograma();
        $this->fkOrcamentoPrograma = $fkOrcamentoPrograma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Programa
     */
    public function getFkOrcamentoPrograma()
    {
        return $this->fkOrcamentoPrograma;
    }
}
