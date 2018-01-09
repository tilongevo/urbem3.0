<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * InscricaoAcao
 */
class InscricaoAcao
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var string
     */
    private $exercicio;


    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return InscricaoAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return InscricaoAcao
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
}
