<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * OrgaoPlanoBanco
 */
class OrgaoPlanoBanco
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
    private $numOrgao;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgao;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrgaoPlanoBanco
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return OrgaoPlanoBanco
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return OrgaoPlanoBanco
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
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return OrgaoPlanoBanco
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
     * Set fkTcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return OrgaoPlanoBanco
     */
    public function setFkTcmgoOrgao(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->numOrgao = $fkTcmgoOrgao->getNumOrgao();
        $this->exercicio = $fkTcmgoOrgao->getExercicio();
        $this->fkTcmgoOrgao = $fkTcmgoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgao()
    {
        return $this->fkTcmgoOrgao;
    }
}
