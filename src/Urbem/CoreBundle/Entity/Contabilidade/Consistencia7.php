<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia7
 */
class Consistencia7
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $vlDebito;

    /**
     * @var integer
     */
    private $vlCredito;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Consistencia7
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
     * @return Consistencia7
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia7
     */
    public function setCodEntidade($codEntidade = null)
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Consistencia7
     */
    public function setSequencia($sequencia = null)
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
     * Set tipo
     *
     * @param string $tipo
     * @return Consistencia7
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

    /**
     * Set vlDebito
     *
     * @param integer $vlDebito
     * @return Consistencia7
     */
    public function setVlDebito($vlDebito = null)
    {
        $this->vlDebito = $vlDebito;
        return $this;
    }

    /**
     * Get vlDebito
     *
     * @return integer
     */
    public function getVlDebito()
    {
        return $this->vlDebito;
    }

    /**
     * Set vlCredito
     *
     * @param integer $vlCredito
     * @return Consistencia7
     */
    public function setVlCredito($vlCredito = null)
    {
        $this->vlCredito = $vlCredito;
        return $this;
    }

    /**
     * Get vlCredito
     *
     * @return integer
     */
    public function getVlCredito()
    {
        return $this->vlCredito;
    }
}
