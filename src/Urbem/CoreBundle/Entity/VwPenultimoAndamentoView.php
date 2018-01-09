<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * VwPenultimoAndamentoView
 */
class VwPenultimoAndamentoView
{
    /**
     * PK
     * @var integer
     */
    private $codAndamento;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $anoExercicio;


    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwVwPenultimoAndamento
     */
    public function setCodAndamento($codAndamento)
    {
        $this->codAndamento = $codAndamento;
        return $this;
    }

    /**
     * Get codAndamento
     *
     * @return integer
     */
    public function getCodAndamento()
    {
        return $this->codAndamento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwVwPenultimoAndamento
     */
    public function setCodProcesso($codProcesso = null)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwVwPenultimoAndamento
     */
    public function setAnoExercicio($anoExercicio = null)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }
}
