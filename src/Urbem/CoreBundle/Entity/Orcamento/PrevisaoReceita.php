<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * PrevisaoReceita
 */
class PrevisaoReceita
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
    private $codReceita;

    /**
     * PK
     * @var integer
     */
    private $periodo;

    /**
     * @var integer
     */
    private $vlPeriodo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PrevisaoReceita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return PrevisaoReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     * @return PrevisaoReceita
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set vlPeriodo
     *
     * @param integer $vlPeriodo
     * @return PrevisaoReceita
     */
    public function setVlPeriodo($vlPeriodo)
    {
        $this->vlPeriodo = $vlPeriodo;
        return $this;
    }

    /**
     * Get vlPeriodo
     *
     * @return integer
     */
    public function getVlPeriodo()
    {
        return $this->vlPeriodo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return PrevisaoReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
