<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * VinculoElencoPlanoContas
 */
class VinculoElencoPlanoContas
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
    private $exercicioPlano;

    /**
     * @var integer
     */
    private $codElenco;

    /**
     * @var string
     */
    private $exercicioElenco;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\ElencoContasTce
     */
    private $fkTceamElencoContasTce;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return VinculoElencoPlanoContas
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
     * Set exercicioPlano
     *
     * @param string $exercicioPlano
     * @return VinculoElencoPlanoContas
     */
    public function setExercicioPlano($exercicioPlano)
    {
        $this->exercicioPlano = $exercicioPlano;
        return $this;
    }

    /**
     * Get exercicioPlano
     *
     * @return string
     */
    public function getExercicioPlano()
    {
        return $this->exercicioPlano;
    }

    /**
     * Set codElenco
     *
     * @param integer $codElenco
     * @return VinculoElencoPlanoContas
     */
    public function setCodElenco($codElenco)
    {
        $this->codElenco = $codElenco;
        return $this;
    }

    /**
     * Get codElenco
     *
     * @return integer
     */
    public function getCodElenco()
    {
        return $this->codElenco;
    }

    /**
     * Set exercicioElenco
     *
     * @param string $exercicioElenco
     * @return VinculoElencoPlanoContas
     */
    public function setExercicioElenco($exercicioElenco)
    {
        $this->exercicioElenco = $exercicioElenco;
        return $this;
    }

    /**
     * Get exercicioElenco
     *
     * @return string
     */
    public function getExercicioElenco()
    {
        return $this->exercicioElenco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamElencoContasTce
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\ElencoContasTce $fkTceamElencoContasTce
     * @return VinculoElencoPlanoContas
     */
    public function setFkTceamElencoContasTce(\Urbem\CoreBundle\Entity\Tceam\ElencoContasTce $fkTceamElencoContasTce)
    {
        $this->codElenco = $fkTceamElencoContasTce->getCodElenco();
        $this->exercicioElenco = $fkTceamElencoContasTce->getExercicio();
        $this->fkTceamElencoContasTce = $fkTceamElencoContasTce;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamElencoContasTce
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\ElencoContasTce
     */
    public function getFkTceamElencoContasTce()
    {
        return $this->fkTceamElencoContasTce;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return VinculoElencoPlanoContas
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicioPlano = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }
}
