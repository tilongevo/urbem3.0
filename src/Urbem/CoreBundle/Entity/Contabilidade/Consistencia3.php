<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia3
 */
class Consistencia3
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $dtLote;

    /**
     * @var string
     */
    private $tipo;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia3
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
     * Set codLote
     *
     * @param integer $codLote
     * @return Consistencia3
     */
    public function setCodLote($codLote = null)
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
     * @return Consistencia3
     */
    public function setExercicio($exercicio = null)
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
     * Set dtLote
     *
     * @param string $dtLote
     * @return Consistencia3
     */
    public function setDtLote($dtLote = null)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return string
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Consistencia3
     */
    public function setTipo($tipo = null)
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
}
