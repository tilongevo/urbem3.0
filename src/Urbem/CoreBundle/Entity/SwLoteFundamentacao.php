<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwLoteFundamentacao
 */
class SwLoteFundamentacao
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
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * PK
     * @var integer
     */
    private $codFundamentacaoLegal;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwLoteFundamentacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwLoteFundamentacao
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
     * Set tipo
     *
     * @param string $tipo
     * @return SwLoteFundamentacao
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
     * Set codFundamentacaoLegal
     *
     * @param integer $codFundamentacaoLegal
     * @return SwLoteFundamentacao
     */
    public function setCodFundamentacaoLegal($codFundamentacaoLegal)
    {
        $this->codFundamentacaoLegal = $codFundamentacaoLegal;
        return $this;
    }

    /**
     * Get codFundamentacaoLegal
     *
     * @return integer
     */
    public function getCodFundamentacaoLegal()
    {
        return $this->codFundamentacaoLegal;
    }
}
