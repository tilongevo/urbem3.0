<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PosicaoPlano
 */
class PosicaoPlano
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
    private $codPosicao;

    /**
     * @var string
     */
    private $mascara;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PosicaoPlano
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
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return PosicaoPlano
     */
    public function setCodPosicao($codPosicao)
    {
        $this->codPosicao = $codPosicao;
        return $this;
    }

    /**
     * Get codPosicao
     *
     * @return integer
     */
    public function getCodPosicao()
    {
        return $this->codPosicao;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return PosicaoPlano
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }
}
