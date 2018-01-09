<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * PlanoBancoTipoContaBanco
 */
class PlanoBancoTipoContaBanco
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
    private $codPlano;

    /**
     * PK
     * @var integer
     */
    private $codTipoContaBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepe\TipoContaBanco
     */
    private $fkTcepeTipoContaBanco;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoBancoTipoContaBanco
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoBancoTipoContaBanco
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
     * Set codTipoContaBanco
     *
     * @param integer $codTipoContaBanco
     * @return PlanoBancoTipoContaBanco
     */
    public function setCodTipoContaBanco($codTipoContaBanco)
    {
        $this->codTipoContaBanco = $codTipoContaBanco;
        return $this;
    }

    /**
     * Get codTipoContaBanco
     *
     * @return integer
     */
    public function getCodTipoContaBanco()
    {
        return $this->codTipoContaBanco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return PlanoBancoTipoContaBanco
     */
    public function setFkContabilidadePlanoBanco(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $this->codPlano = $fkContabilidadePlanoBanco->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoBanco->getExercicio();
        $this->fkContabilidadePlanoBanco = $fkContabilidadePlanoBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBanco()
    {
        return $this->fkContabilidadePlanoBanco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepeTipoContaBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\TipoContaBanco $fkTcepeTipoContaBanco
     * @return PlanoBancoTipoContaBanco
     */
    public function setFkTcepeTipoContaBanco(\Urbem\CoreBundle\Entity\Tcepe\TipoContaBanco $fkTcepeTipoContaBanco)
    {
        $this->codTipoContaBanco = $fkTcepeTipoContaBanco->getCodTipoContaBanco();
        $this->fkTcepeTipoContaBanco = $fkTcepeTipoContaBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepeTipoContaBanco
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\TipoContaBanco
     */
    public function getFkTcepeTipoContaBanco()
    {
        return $this->fkTcepeTipoContaBanco;
    }
}
