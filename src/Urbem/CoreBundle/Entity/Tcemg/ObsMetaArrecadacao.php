<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ObsMetaArrecadacao
 */
class ObsMetaArrecadacao
{
    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $observacao;


    /**
     * Set mes
     *
     * @param integer $mes
     * @return ObsMetaArrecadacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ObsMetaArrecadacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return ObsMetaArrecadacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }
}
