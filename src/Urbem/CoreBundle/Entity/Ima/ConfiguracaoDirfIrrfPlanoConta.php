<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoDirfIrrfPlanoConta
 */
class ConfiguracaoDirfIrrfPlanoConta
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
    private $codConta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    private $fkImaConfiguracaoDirf;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoDirfIrrfPlanoConta
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoDirfIrrfPlanoConta
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
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoDirf
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf
     * @return ConfiguracaoDirfIrrfPlanoConta
     */
    public function setFkImaConfiguracaoDirf(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf $fkImaConfiguracaoDirf)
    {
        $this->exercicio = $fkImaConfiguracaoDirf->getExercicio();
        $this->fkImaConfiguracaoDirf = $fkImaConfiguracaoDirf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoDirf
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf
     */
    public function getFkImaConfiguracaoDirf()
    {
        return $this->fkImaConfiguracaoDirf;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return ConfiguracaoDirfIrrfPlanoConta
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }
}
