<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * VinculoPlanoContasTcmgo
 */
class VinculoPlanoContasTcmgo
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codPlanoTcmgo;

    /**
     * @var string
     */
    private $exercicioTcmgo;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\PlanoContasTcmgo
     */
    private $fkTcmgoPlanoContasTcmgo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VinculoPlanoContasTcmgo
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
     * Set codPlanoTcmgo
     *
     * @param integer $codPlanoTcmgo
     * @return VinculoPlanoContasTcmgo
     */
    public function setCodPlanoTcmgo($codPlanoTcmgo)
    {
        $this->codPlanoTcmgo = $codPlanoTcmgo;
        return $this;
    }

    /**
     * Get codPlanoTcmgo
     *
     * @return integer
     */
    public function getCodPlanoTcmgo()
    {
        return $this->codPlanoTcmgo;
    }

    /**
     * Set exercicioTcmgo
     *
     * @param string $exercicioTcmgo
     * @return VinculoPlanoContasTcmgo
     */
    public function setExercicioTcmgo($exercicioTcmgo)
    {
        $this->exercicioTcmgo = $exercicioTcmgo;
        return $this;
    }

    /**
     * Get exercicioTcmgo
     *
     * @return string
     */
    public function getExercicioTcmgo()
    {
        return $this->exercicioTcmgo;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return VinculoPlanoContasTcmgo
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
     * Set fkContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return VinculoPlanoContasTcmgo
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoPlanoContasTcmgo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\PlanoContasTcmgo $fkTcmgoPlanoContasTcmgo
     * @return VinculoPlanoContasTcmgo
     */
    public function setFkTcmgoPlanoContasTcmgo(\Urbem\CoreBundle\Entity\Tcmgo\PlanoContasTcmgo $fkTcmgoPlanoContasTcmgo)
    {
        $this->codPlanoTcmgo = $fkTcmgoPlanoContasTcmgo->getCodPlano();
        $this->exercicioTcmgo = $fkTcmgoPlanoContasTcmgo->getExercicio();
        $this->fkTcmgoPlanoContasTcmgo = $fkTcmgoPlanoContasTcmgo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoPlanoContasTcmgo
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\PlanoContasTcmgo
     */
    public function getFkTcmgoPlanoContasTcmgo()
    {
        return $this->fkTcmgoPlanoContasTcmgo;
    }
}
