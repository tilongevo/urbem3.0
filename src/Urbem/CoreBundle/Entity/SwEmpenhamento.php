<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwEmpenhamento
 */
class SwEmpenhamento
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwEmpenho
     */
    private $fkSwEmpenho;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwEmpenhamento
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return SwEmpenhamento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return SwEmpenhamento
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwEmpenhamento
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwEmpenhamento
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
     * ManyToOne (inverse side)
     * Set fkSwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     * @return SwEmpenhamento
     */
    public function setFkSwEmpenho(\Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho)
    {
        $this->exercicio = $fkSwEmpenho->getExercicio();
        $this->codEmpenho = $fkSwEmpenho->getCodEmpenho();
        $this->fkSwEmpenho = $fkSwEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwEmpenho
     */
    public function getFkSwEmpenho()
    {
        return $this->fkSwEmpenho;
    }

    /**
     * OneToOne (owning side)
     * Set SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwEmpenhamento
     */
    public function setFkSwLancamento(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        $this->sequencia = $fkSwLancamento->getSequencia();
        $this->codLote = $fkSwLancamento->getCodLote();
        $this->tipo = $fkSwLancamento->getTipo();
        $this->exercicio = $fkSwLancamento->getExercicio();
        $this->fkSwLancamento = $fkSwLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwLancamento
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamento()
    {
        return $this->fkSwLancamento;
    }
}
