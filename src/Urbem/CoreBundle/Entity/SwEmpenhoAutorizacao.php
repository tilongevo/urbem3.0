<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwEmpenhoAutorizacao
 */
class SwEmpenhoAutorizacao
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwEmpenho
     */
    private $fkSwEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    private $fkSwAutorizacaoEmpenho;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwEmpenhoAutorizacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwEmpenhoAutorizacao
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
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return SwEmpenhoAutorizacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwEmpenhoAutorizacao
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     * @return SwEmpenhoAutorizacao
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
     * ManyToOne (inverse side)
     * Set fkSwAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho
     * @return SwEmpenhoAutorizacao
     */
    public function setFkSwAutorizacaoEmpenho(\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho)
    {
        $this->codPreEmpenho = $fkSwAutorizacaoEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwAutorizacaoEmpenho->getExercicio();
        $this->codAutorizacao = $fkSwAutorizacaoEmpenho->getCodAutorizacao();
        $this->fkSwAutorizacaoEmpenho = $fkSwAutorizacaoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAutorizacaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    public function getFkSwAutorizacaoEmpenho()
    {
        return $this->fkSwAutorizacaoEmpenho;
    }
}
