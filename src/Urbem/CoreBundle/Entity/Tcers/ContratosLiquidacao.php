<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * ContratosLiquidacao
 */
class ContratosLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codLiquidacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codContratoTce;


    /**
     * Set codLiquidacao
     *
     * @param integer $codLiquidacao
     * @return ContratosLiquidacao
     */
    public function setCodLiquidacao($codLiquidacao)
    {
        $this->codLiquidacao = $codLiquidacao;
        return $this;
    }

    /**
     * Get codLiquidacao
     *
     * @return integer
     */
    public function getCodLiquidacao()
    {
        return $this->codLiquidacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratosLiquidacao
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratosLiquidacao
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codContratoTce
     *
     * @param integer $codContratoTce
     * @return ContratosLiquidacao
     */
    public function setCodContratoTce($codContratoTce)
    {
        $this->codContratoTce = $codContratoTce;
        return $this;
    }

    /**
     * Get codContratoTce
     *
     * @return integer
     */
    public function getCodContratoTce()
    {
        return $this->codContratoTce;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $reflect = new \ReflectionClass($this);
        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);

        $result = true;
        foreach ($props as $prop) {
            $methodName = sprintf("get%s", ucfirst($prop->getName()));

            if (!empty($this->$methodName())) {
                $result = false;
                break;
            }
        }

        return $result;
    }
}
