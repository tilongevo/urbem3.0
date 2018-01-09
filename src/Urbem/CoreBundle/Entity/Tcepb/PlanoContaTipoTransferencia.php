<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * PlanoContaTipoTransferencia
 */
class PlanoContaTipoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoTransferencia
     */
    private $fkTcepbTipoTransferencia;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return PlanoContaTipoTransferencia
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
     * @return PlanoContaTipoTransferencia
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PlanoContaTipoTransferencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoTransferencia $fkTcepbTipoTransferencia
     * @return PlanoContaTipoTransferencia
     */
    public function setFkTcepbTipoTransferencia(\Urbem\CoreBundle\Entity\Tcepb\TipoTransferencia $fkTcepbTipoTransferencia)
    {
        $this->codTipo = $fkTcepbTipoTransferencia->getCodTipo();
        $this->fkTcepbTipoTransferencia = $fkTcepbTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoTransferencia
     */
    public function getFkTcepbTipoTransferencia()
    {
        return $this->fkTcepbTipoTransferencia;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return PlanoContaTipoTransferencia
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
