<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * ArquivoContas
 */
class ArquivoContas
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $mes;

    /**
     * @var integer
     */
    private $codEntidade;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ArquivoContas
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArquivoContas
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
     * Set mes
     *
     * @param string $mes
     * @return ArquivoContas
     */
    public function setMes($mes = null)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ArquivoContas
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
}
