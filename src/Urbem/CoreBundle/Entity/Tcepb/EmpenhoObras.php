<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * EmpenhoObras
 */
class EmpenhoObras
{
    /**
     * PK
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicioObras;

    /**
     * @var integer
     */
    private $numObra;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\Obras
     */
    private $fkTcepbObras;


    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return EmpenhoObras
     */
    public function setExercicioEmpenho($exercicioEmpenho)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoObras
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoObras
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicioObras
     *
     * @param string $exercicioObras
     * @return EmpenhoObras
     */
    public function setExercicioObras($exercicioObras)
    {
        $this->exercicioObras = $exercicioObras;
        return $this;
    }

    /**
     * Get exercicioObras
     *
     * @return string
     */
    public function getExercicioObras()
    {
        return $this->exercicioObras;
    }

    /**
     * Set numObra
     *
     * @param integer $numObra
     * @return EmpenhoObras
     */
    public function setNumObra($numObra)
    {
        $this->numObra = $numObra;
        return $this;
    }

    /**
     * Get numObra
     *
     * @return integer
     */
    public function getNumObra()
    {
        return $this->numObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras
     * @return EmpenhoObras
     */
    public function setFkTcepbObras(\Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras)
    {
        $this->exercicioObras = $fkTcepbObras->getExercicio();
        $this->numObra = $fkTcepbObras->getNumObra();
        $this->fkTcepbObras = $fkTcepbObras;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbObras
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\Obras
     */
    public function getFkTcepbObras()
    {
        return $this->fkTcepbObras;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return EmpenhoObras
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
