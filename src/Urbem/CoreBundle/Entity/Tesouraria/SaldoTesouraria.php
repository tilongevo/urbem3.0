<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * SaldoTesouraria
 */
class SaldoTesouraria
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $vlSaldo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return SaldoTesouraria
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SaldoTesouraria
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
     * Set vlSaldo
     *
     * @param integer $vlSaldo
     * @return SaldoTesouraria
     */
    public function setVlSaldo($vlSaldo)
    {
        $this->vlSaldo = $vlSaldo;
        return $this;
    }

    /**
     * Get vlSaldo
     *
     * @return integer
     */
    public function getVlSaldo()
    {
        return $this->vlSaldo;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return SaldoTesouraria
     */
    public function setFkContabilidadePlanoBanco(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $this->codPlano = $fkContabilidadePlanoBanco->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoBanco->getExercicio();
        $this->fkContabilidadePlanoBanco = $fkContabilidadePlanoBanco;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBanco()
    {
        return $this->fkContabilidadePlanoBanco;
    }
}
